<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('level') != '2') {
			redirect('welcome');
		}
	}

	public function index()
	{
		$user_id = $this->session->userdata('id_user');
		$data['user_id'] = $user_id;
    $data['cartItems'] = $this->temp_cart->getCartItems($user_id);
    $data['cartTotalItems'] = $this->temp_cart->getTotalItems($user_id);

		$data['title'] = 'Daftar Produk';
		$data['product'] = $this->model_pembayaran->get('product')->result();
		$this->load->view('layout/user/header', $data);
		$this->load->view('dashboard', $data);
		$this->load->view('layout/user/footer');
	}

	public function cart($id)
	{
		$product = $this->model_product->getProduct($id);

		$data = [
			'user_id' => $this->session->userdata('id_user'),
			'product_id' => $product->id_brg,
			'quantity'   => 1,
			'price'      => $product->harga,
			'name'       => $product->nama_brg,
			'options'    => json_encode([
				'keterangan' => $product->keterangan,
				'kategori'   => $product->kategori,
				'gambar'     => $product->gambar
			]),
	];

		$this->temp_cart->addItem($this->session->userdata('id_user'), $data);
		$_SESSION["sukses"] = 'Pesanan telah disimpan di keranjang';
		redirect('dashboard');
	}

	public function detail_cart()
	{
		$user_id = $this->session->userdata('id_user');
		$data['user_id'] = $user_id;
    $data['cartItems'] = $this->temp_cart->getCartItems($user_id);
    $data['cartTotalItems'] = $this->temp_cart->getTotalItems($user_id);
		$data['title'] = 'Daftar Keranjang';

		$this->load->view('layout/user/header', $data);
		$this->load->view('cart', $data);
		$this->load->view('layout/user/footer');
	}

	public function checkout()
	{
		$user_id = $this->session->userdata('id_user');
		$data['user_id'] = $user_id;
    $data['cartItems'] = $this->temp_cart->getCartItems($user_id);
    $data['cartTotalItems'] = $this->temp_cart->getTotalItems($user_id);
		$data['title'] = 'Checkout Product';

		$this->load->view('layout/user/header', $data);
		$this->load->view('checkout', $data);
		$this->load->view('layout/user/footer');
	}

	public function checkout_proccess()
	{
		$user_id = $this->session->userdata('id_user');
		$data['user_id'] = $user_id;
    $cartItems = $this->temp_cart->getCartItems($user_id);
		$data['title'] = 'Payment Notification';
		
		$is_processed = $this->model_invoice->store($cartItems);

		if ($is_processed) {
			$data['cartItems'] = $this->temp_cart->getCartItems($user_id);
			$data['cartTotalItems'] = $this->temp_cart->getTotalItems($user_id);

			// $this->cart->destroy();
			$this->load->view('layout/user/header', $data);
			$this->load->view('success_pay', $data);
			$this->load->view('layout/user/footer');
		} else {
			echo "Maaf, Pesanan Anda Gagal Di Proses!";
		}
	}

	public function clear()
	{
		$this->cart->destroy();
		$_SESSION["sukses"] = 'Pesanan berhasil di hapus';
		redirect('dashboard');
	}
}
