<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_invoice extends CI_Model
{
	private $table = 'transaction';
	private $column_search = ['order_id', 'name', 'transaction_time', 'status'];
	private $order = ['transaction_time' => 'desc'];

	public function index()
	{
		date_default_timezone_set('Asia/Jakarta');
		$order_id = $this->input->post('order_id');
		$id_user = $this->input->post('id_user');
		$name = $this->input->post('name');
		$alamat = $this->input->post('alamat');
		$city = $this->input->post('kota');
		$kode_pos = $this->input->post('kode_pos');
		$payment_method = $this->input->post('payment_method');
		$ekspedisi = $this->input->post('ekspedisi');
		$mobile_phone = $this->input->post('mobile_phone');
		$tracking_id = $this->input->post('tracking_id');
		$email = $this->input->post('email');
		$status = $this->input->post('status');

		$invoice = array (
			'order_id' 			=> $order_id,
			'id_user' 			=> $id_user,
			'name' 				=> $name,
			'alamat' 			=> $alamat,
			'city' 				=> $city,
			'kode_pos' 			=> $kode_pos,
			'payment_method' 	=> $payment_method,
			'ekspedisi' 		=> $ekspedisi,
			'mobile_phone' 		=> $mobile_phone,
			'tracking_id' 		=> $tracking_id,
			'email' 			=> $email,
			'status' 			=> $status,
			'transaction_time' 	=> date('Y-m-d H:i:s'),
			'payment_limit' 	=> date('Y-m-d H:i:s', mktime( date('H'), date('i'), date('s'), date('m'), date('d') + 1, date('Y'))),
		);

		$this->db->insert('transaction', $invoice);
		$id_invoice = $this->db->insert_id();

		foreach ($this->cart->contents() as $item) {
			$data = array (
				'id_invoice' 	=> $order_id,
				'id_user' 		=> $id_user,
				'id_brg' 		=> $item['id'],
				'nama_brg' 		=> $item['name'],
				'jumlah' 		=> $item['qty'],
				'harga' 		=> $item['price'],
			);

			$this->db->insert('cart', $data);
		}

		return TRUE;
	}

	public function get() {
		$result = $this->db->get('transaction');
		if($result->num_rows() > 0){
			return $result->result();
		}

		return [];
	}

	public function get_id_invoice($id_invoice) {
		$result = $this->db->where('order_id', $id_invoice)->limit(1)->get('transaction');
		if ($result->num_rows() > 0){
			return $result->row();
		}

		return [];
	}

	public function get_id_pesanan($id_invoice) {
		$result = $this->db->where('id_invoice', $id_invoice)->get('cart');
		if ($result->num_rows() > 0){
			return $result->result();
		}

		return [];
	}

	public function getExist($order_id)
	{
		$query = $this->db->where('order_id', $order_id)->limit(1)->get('transaction');
		return $query->num_rows() > 0; // Mengembalikan true jika data ditemukan, false jika tidak
	}

	public function store($items) {
    date_default_timezone_set('Asia/Jakarta');

    $order_id = $this->input->post('order_id');

		$is_exist = $this->getExist($order_id);
		
		if ($is_exist) {
			return true;
		}
		
		// Ambil data dari input
    $id_user = $this->input->post('id_user');
    $name = $this->input->post('name');
    $alamat = $this->input->post('alamat');
    $city = $this->input->post('kota');
    $kode_pos = $this->input->post('kode_pos');
    $payment_method = $this->input->post('payment_method');
    $ekspedisi = $this->input->post('ekspedisi');
    $mobile_phone = $this->input->post('mobile_phone');
    $tracking_id = $this->input->post('tracking_id');
    $email = $this->input->post('email');
    $status = $this->input->post('status');
    $total_ongkir = $this->input->post('ongkir');
    $subtotal = $this->input->post('subtotal');
    $total_bayar = $this->input->post('total');

    // Siapkan data untuk invoice
    $invoice = [
			'order_id'          => $order_id,
			'id_user'           => $id_user,
			'name'              => $name,
			'alamat'            => $alamat,
			'city'              => $city,
			'kode_pos'          => $kode_pos,
			'payment_method'    => $payment_method,
			'ekspedisi'         => $ekspedisi,
			'mobile_phone'      => $mobile_phone,
			'tracking_id'       => $tracking_id,
			'email'             => $email,
			'status'            => $status,
			'transaction_time'  => date('Y-m-d H:i:s'),
			'payment_limit'     => date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d') + 1, date('Y'))),
			'total_ongkir'     	=> $total_ongkir,
			'subtotal'  		   	=> $subtotal,
			'total_bayar'				=> $total_bayar,
		];

    // Mulai transaksi
    $this->db->trans_begin();

    try {
			// Masukkan invoice ke dalam tabel transaksi
			$this->db->insert('transaction', $invoice);

			// Masukkan item ke tabel keranjang
			foreach ($items as $item) {
				$data = array(
					'id_invoice'    => $order_id,
					'id_user'       => $id_user,
					'id_brg'        => $item->product_id,
					'nama_brg'      => $item->name,
					'jumlah'        => $item->quantity,
					'harga'         => $item->price,
				);

				$this->db->insert('cart', $data);
			}

			// Jika semuanya berhasil, commit transaksi
			$this->db->trans_commit();

			return true;
    } catch (Exception $e) {
			// Jika terjadi kesalahan, rollback transaksi
			$this->db->trans_rollback();
			log_message('error', 'Transaksi gagal: ' . $e->getMessage());
			return false;
    }
	}

	public function getAjax()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query()
	{
		$this->db->from('transaction');

		// Filter berdasarkan status jika dipilih
		if (!empty($_POST['status_filter'])) {
				$this->db->where('status', $_POST['status_filter']);
		}

		// Pencarian global
		$i = 0;
		foreach ($this->column_search as $item) {
			if (!empty($_POST['search']['value'])) { // Jika terdapat pencarian
				$filter = $_POST['search']['value'];

				if ($i === 0) {
					$this->db->group_start(); // Awal grup query OR
					$this->db->like($item, $filter);
				} else {
					$this->db->or_like($item, $filter);
				}

				if (count($this->column_search) - 1 == $i) {
					$this->db->group_end(); // Akhir grup query OR
				}
			}
			$i++;
		}

		// Pengurutan
		if (!empty($_POST['order'])) { // Order berdasarkan permintaan DataTables
			$this->db->order_by(
				$this->column_search[$_POST['order']['0']['column']],
				$_POST['order']['0']['dir']
			);
		} else if (isset($this->order)) { // Default order
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function count_all()
	{
		$this->db->from('transaction');
		return $this->db->count_all_results();
	}

	public function get_filtered($search_query = '', $status_filter = 'all', $start_date = null, $end_date = null)
	{
		$this->db->from('transaction');

		if ($start_date && $end_date) {
			$this->db->where('transaction_time >=', $start_date);
			$this->db->where('transaction_time <=', $end_date);
		}

		if (!empty($search_query)) {
			$this->db->group_start();
			$this->db->like('order_id', $search_query);
			$this->db->or_like('name', $search_query);
			$this->db->or_like('transaction_time', $search_query);
			$this->db->or_like('status', $search_query);
			$this->db->group_end();
		}

		if ($status_filter !== 'all') {
			$status_value = $status_filter === 'pending' ? '0' : '1';
			$this->db->where('status', $status_value);
		}

		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}

		return $this->db->get()->result();
	}

	public function count_filtered($search_query = '', $status_filter = 'all')
	{
		$this->db->from('transaction');

		if (!empty($search_query)) {
			$this->db->group_start();
			$this->db->like('order_id', $search_query);
			$this->db->or_like('name', $search_query);
			$this->db->or_like('transaction_time', $search_query);
			$this->db->or_like('status', $search_query);
			$this->db->group_end();
		}

		if ($status_filter !== 'all') {
			$status_value = $status_filter === 'pending' ? '0' : '1';
			$this->db->where('status', $status_value);
		}

		return $this->db->count_all_results();
	}

	public function getOrderNotification() {
    $orders = $this->db->select('order_id, name, transaction_time')
			->from('transaction')
			->where('status', '0')
			->order_by('order_id', 'ASC')
			->get()
			->result();

		foreach ($orders as &$order) {
			$order->type = 'order';
		}

		$user_id = $this->session->userdata('id_user');

		$messages = [];
		if ($user_id) {
			$messages = $this->db->select('message.id as message_id, message.receiver_id, message.created_at, message.message, u.nama_user')
				->from('messages message')
				->join('user u', 'message.sender_id = u.id_user', 'left')
				->where('message.is_read', '0')
				->where('message.receiver_id', $user_id)
				->get()
				->result();

			foreach ($messages as &$message) {
				$message->type = 'message';
			}
		}

		$notifications = array_merge($orders, $messages);

    return $notifications;
	}
}
