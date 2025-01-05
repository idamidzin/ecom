<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pay extends CI_Controller
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
        $data['title'] = 'Order Selesai';
        $user_id = $this->session->userdata('id_user');
		$data['user_id'] = $user_id;

        $data['bill'] = $this->db->query("SELECT * FROM transaction WHERE transaction.id_user='$user_id' AND status='1'")->result();
        $data['cartItems'] = $this->temp_cart->getCartItems($user_id);
        $data['cartTotalItems'] = $this->temp_cart->getTotalItems($user_id);

        $this->load->view('layout/user/header', $data);
        $this->load->view('pay', $data);
        $this->load->view('layout/user/footer');
    }

    public function detail($id_invoice)
    {
        $data['title'] = 'Detail Checkout';
        $data['invoice'] = $this->model_invoice->get_id_invoice($id_invoice);
        $data['pesanan'] = $this->model_invoice->get_id_pesanan($id_invoice);

        $user_id = $this->session->userdata('id_user');
		$data['user_id'] = $user_id;

        $data['cartItems'] = $this->temp_cart->getCartItems($user_id);
        $data['cartTotalItems'] = $this->temp_cart->getTotalItems($user_id);

        $this->load->view('layout/user/header', $data);
        $this->load->view('invoice', $data);
        $this->load->view('layout/user/footer');
    }
}
