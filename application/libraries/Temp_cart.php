<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Temp_cart
{
    protected $CI;

    public function __construct()
    {
      $this->CI =& get_instance();
      $this->CI->load->model('Model_cart');
    }

    // Mendapatkan item keranjang untuk user tertentu
    public function getCartItems($user_id)
    {
      return $this->CI->model_cart->getCartItems($user_id);
    }

    // Menambahkan item ke dalam keranjang
    public function addItem($user_id, $product_data)
    {
      return $this->CI->model_cart->addItem($user_id, $product_data);
    }

    // Mengupdate item keranjang
    public function updateItem($cart_id, $qty)
    {
      return $this->CI->model_cart->updateItem($cart_id, $qty);
    }

    // Menghapus item dari keranjang
    public function deleteItem($cart_id)
    {
      return $this->CI->model_cart->deleteItem($cart_id);
    }

    // Menghapus seluruh item keranjang
    public function emptyCart($user_id)
    {
      return $this->CI->model_cart->emptyCart($user_id);
    }

    // Mendapatkan total harga keranjang
    public function getTotalPrice($user_id)
    {
      return $this->CI->model_cart->getTotalPrice($user_id);
    }

    // Mendapatkan total items
    public function getTotalItems($user_id)
    {
      return $this->CI->model_cart->getTotalItems($user_id);
    }

    public function updateItemQuantity($cart_item_id, $quantity)
    {
      return $this->CI->model_cart->updateItemQuantity($cart_item_id, $quantity);
    }

    public function getCartItemById($id)
    {
      return $this->CI->model_cart->getCartItemById($id);
    }
}
