<?php

class CartController extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('temp_cart');
  }

  public function getCarts() {
    $user_id = $this->session->userdata('id_user');
    $cartItems = $this->temp_cart->getCartItems($user_id);

    $data = [];
    $total_price = [];
    foreach ($cartItems as $item) {
        $options = json_decode($item->options);
        $subtotal = $item->price * $item->quantity;
        $total_price[] = $subtotal;
        $data[] = [
            'id' => $item->id,
            'name' => $item->name,
            'price' => $item->price,
            'quantity' => $item->quantity,
            'subtotal' => $subtotal,
            'image' => base_url() . 'uploads/' . $options->gambar
        ];
    }

    echo json_encode((object) [
      'status' => 'success',
      'totalPrice' => array_sum($total_price),
      'cartItems' => $data,
    ]);
  }

  public function updateQuantity($itemId) {
    $quantity = $this->input->post('quantity');
    $item = $this->temp_cart->getCartItemById($itemId);

    $item->quantity = $quantity;
    $subtotal = $item->price * $item->quantity;

    // Update quantity item di database
    $this->temp_cart->updateItemQuantity($itemId, $item->quantity);

    $user_id = $this->session->userdata('id_user');
    $cartItems = $this->temp_cart->getCartItems($user_id);

    $total_price = [];
    foreach ($cartItems as $item) {
      $total_price[] = $item->price * $item->quantity;
    }

    // Kirim response JSON dengan subtotal item yang diperbarui dan total harga
    echo json_encode((object) [
      'status' => 'success',
      'newSubtotal' => $subtotal,
      'newTotalPrice' => array_sum($total_price),
    ]);
  }

  public function deleteItem()
  {
      $itemId = $this->input->post('id');
      if ($this->temp_cart->deleteItem($itemId)) {
          echo json_encode((object) [
            "status" => "success",
            "message" => "Item berhasil dihapus"
          ]);
      } else {
          echo json_encode((object) [
            "status" => "error",
            "message" => "Gagal menghapus item"
          ]);
      }
  }
}
