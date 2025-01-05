<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('level') != '1') {
			redirect('welcome');
		}
	}

	public function index()
	{
		$data['title'] = 'Laporan Transaksi';
		$transactions = $this->model_invoice->get();
		$data['invoice'] = $transactions ? $transactions : [];
		$data['bill'] = $this->model_invoice->getOrderNotification();

		$user_id = $this->session->userdata('id_user');
		$data['user_id'] = $user_id;

		$this->load->view('layout/admin/header', $data);
		$this->load->view('admin/laporan/transaksi', $data);
		$this->load->view('layout/admin/footer');
	}

	public function cetak_pdf()
	{
			$startDate = $this->input->get('start_date');
			$endDate = $this->input->get('end_date');
			$statusFilter = $this->input->get('status_filter');

			$this->load->library('pdf');
			$this->pdf->setPaper('A4', 'potrait');

			$this->db->select('*');
			$this->db->from('transaction');
			
			if ($startDate) {
				$this->db->where('transaction_time >=', $startDate);
			}
		
			if ($endDate) {
				$this->db->where('transaction_time <=', $endDate);
			}

			if ($statusFilter !== 'all') {
				$status_value = $statusFilter === 'pending' ? '0' : '1';
				$this->db->where('status', $status_value);
			}

			$data['start_date'] = $startDate;
			$data['end_date'] = $endDate;
			
			$transactions = $this->db->get()->result();
			
			$data['transactions'] = $transactions;
			$this->pdf->load_view('admin/laporan/transaksi_pdf', $data);
	}

}
