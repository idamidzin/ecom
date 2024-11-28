<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_invoice extends CI_Model
{
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
}
