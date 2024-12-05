<?php

class Model_cart extends CI_Model {
  // Mendapatkan item keranjang untuk user tertentu
  public function getCartItems($user_id)
  {
    $this->db->where('user_id', $user_id);
    $query = $this->db->get('temp_cart');
    return $query->result();
  }

  // Fungsi untuk mendapatkan item berdasarkan ID
  public function getCartItemById($itemId) {
    // Ambil data dari tabel cart_item berdasarkan item ID
    $this->db->where('id', $itemId);
    $query = $this->db->get('temp_cart');
    
    if ($query->num_rows() > 0) {
        return $query->row();  // Mengembalikan satu baris data item
    } else {
        return null;  // Jika item tidak ditemukan
    }
  }

  // Menambahkan item baru ke dalam keranjang
  public function addItem($user_id, $product_data)
  {
    // Cek apakah produk sudah ada di keranjang
    $this->db->where('user_id', $user_id);
    $this->db->where('product_id', $product_data['product_id']);
    $query = $this->db->get('temp_cart');
    
    if ($query->num_rows() > 0) {
      // Jika item sudah ada, update quantity
      $this->db->where('user_id', $user_id);
      $this->db->where('product_id', $product_data['product_id']);
      $this->db->update('temp_cart', [
        'quantity' => $product_data['quantity'] + $query->row()->quantity
      ]);
    } else {
      // Jika item belum ada, insert baru
      $this->db->insert('temp_cart', [
        'user_id'    => $user_id,
        'product_id' => $product_data['product_id'],
        'quantity'   => $product_data['quantity'],
        'price'      => $product_data['price'],
        'name'       => $product_data['name'],
        'options'    => $product_data['options'],
      ]);
    }
  }

  public function updateItem($cart_id, $data)
  {
    $this->db->where('id', $cart_id);
    return $this->db->update('temp_cart', $data);
  }

  // Mengupdate jumlah kuantitas item
  public function updateItemQuantity($cart_id, $quantity)
  {
    $this->db->where('id', $cart_id);
    return $this->db->update('temp_cart', ['quantity' => $quantity]);
  }

  // Menghapus item dari keranjang
  public function deleteItem($cart_id)
  {
    $this->db->where('id', $cart_id);
    return $this->db->delete('temp_cart');
  }

  // Menghapus seluruh item keranjang untuk user tertentu
  public function emptyCart($user_id)
  {
    $this->db->where('user_id', $user_id);
    return $this->db->delete('temp_cart');
  }

  // Mendapatkan total harga keranjang
  public function getTotalPrice($user_id)
  {
    // Correct the query to sum the total price * quantity
    $this->db->select_sum('price * quantity', 'total');
    $this->db->where('user_id', $user_id);
    $query = $this->db->get('temp_cart');
    
    // Check if the query returned any rows and return the total
    if ($query->num_rows() > 0) {
        return $query->row()->total;
    }

    return 0; // Return 0 if no data is found
  }

  // Fungsi untuk mendapatkan total jumlah barang dalam keranjang
  public function getTotalItems($user_id)
  {
      $this->db->select_sum('quantity');  // Mengambil jumlah (sum) dari kolom qty
      $this->db->where('user_id', $user_id);  // Filter berdasarkan user_id
      $query = $this->db->get('temp_cart');  // Menjalankan query pada tabel temp_cart

      if ($query->num_rows() > 0) {
          return $query->row()->quantity;  // Mengembalikan jumlah total
      } else {
          return 0;  // Jika tidak ada item, return 0
      }
  }
}
