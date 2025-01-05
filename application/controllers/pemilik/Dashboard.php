<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('level') != '3') {
			redirect('welcome');
		}
	}

	public function index()
	{
		$data['title'] = 'Dashboard Pemilik';
		$data['bill'] = $this->model_invoice->getOrderNotification();
		$data['count'] = $this->model_pembayaran->count_order();
		$data['pending'] = $this->model_pembayaran->count_pending();
		$data['sukses'] = $this->model_pembayaran->count_success();

		$user_id = $this->session->userdata('id_user');
		$data['user_id'] = $user_id;

		$this->load->view('layout/pemilik/header', $data);
		$this->load->view('pemilik/dashboard/dashboard', $data);
		$this->load->view('layout/pemilik/footer');
	}
}
