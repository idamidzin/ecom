<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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
		$data['title'] = 'Laporan Transaksi';
		$transactions = $this->model_invoice->get();
		$data['invoice'] = $transactions ? $transactions : [];
		$data['bill'] = $this->model_invoice->getOrderNotification();

		$user_id = $this->session->userdata('id_user');
		$data['user_id'] = $user_id;

		$this->load->view('layout/pemilik/header', $data);
		$this->load->view('pemilik/laporan/transaksi', $data);
		$this->load->view('layout/pemilik/footer');
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
			$this->pdf->load_view('pemilik/laporan/transaksi_pdf', $data);
	}

	public function ajaxList()
	{
		$search_query = $this->input->post('search_query');
		$status_filter = $this->input->post('status_filter');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$list = $this->model_invoice->get_filtered($search_query, $status_filter, $start_date, $end_date);
		$data = [];
		$no = $_POST['start'];

		foreach ($list as $invoice) {
			$no++;
			$row = [];
			$row['order_id'] = '<a href="' . site_url('admin/invoice/detail/' . $invoice->order_id) . '" class="underline decoration-dotted">#' . $invoice->order_id . '</a>';
			$row['name'] = '<a href="#" class="font-medium">' . $invoice->name . '</a>';
			$row['transaction_time'] = date('d-m-Y H:i', strtotime($invoice->transaction_time));
			$row['proof_of_payment'] = empty($invoice->gambar)
					? '<div class="text-danger"><i class="w-4 h-4 mr-2" data-lucide="alert-circle"></i>Belum upload bukti</div>'
					: '<a target="_blank" href="' . base_url('/uploads/' . $invoice->gambar) . '" class="text-primary"><i class="w-4 h-4 mr-2" data-lucide="link"></i>Lihat Bukti</a>';
			$row['status'] = $invoice->status == '0'
					? '<div class="text-pending"><b>PENDING</b></div>'
					: '<div class="text-success"><b>SELESAI</b></div>';
			$row['subtotal'] = number_format($invoice->subtotal, 0, ',', '.');
			$row['ekspedisi'] = Ucwords($invoice->ekspedisi);
			$row['total_ongkir'] = number_format($invoice->total_ongkir, 0, ',', '.');
			$row['total'] = number_format($invoice->total_bayar, 0, ',', '.');
			$row['actions'] = $invoice->status == '0'
					? '<a class="text-primary" href="' . site_url('admin/invoice/confirm/' . $invoice->order_id) . '"><i data-lucide="arrow-left-right"></i> Change Status</a>'
					: '<button class="btn btn-sm btn-success text-white">Payment Successfully</button>';

			$data[] = $row;
		}

		$output = [
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->model_invoice->count_all(),
				"recordsFiltered" => $this->model_invoice->count_filtered($search_query, $status_filter),
				"data" => $data,
		];

		echo json_encode($output);
	}

}
