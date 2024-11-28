<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends CI_Controller
{

	public function elektronik()
	{
		$data['title'] = 'Cartridge Categories';
		$data['elektronik'] = $this->model_kategori->elektronik()->result();
		$this->load->view('layout/home/header', $data);
		$this->load->view('elektronik', $data);
		$this->load->view('layout/home/footer');
	}

	public function shirt()
	{
		$data['title'] = 'Merch Categories';
		$data['shirt'] = $this->model_kategori->shirt()->result();
		$this->load->view('layout/home/header', $data);
		$this->load->view('shirt', $data);
		$this->load->view('layout/home/footer');
	}

	public function shoes()
	{
		$data['title'] = 'Liquid Categories';
		$data['shoes'] = $this->model_kategori->shoes()->result();
		$this->load->view('layout/home/header', $data);
		$this->load->view('shoes', $data);
		$this->load->view('layout/home/footer');
	}

	public function jacket()
	{
		$data['title'] = 'Device Categories';
		$data['jacket'] = $this->model_kategori->jacket()->result();
		$this->load->view('layout/home/header', $data);
		$this->load->view('jacket', $data);
		$this->load->view('layout/home/footer');
	}

	public function kids()
	{
		$data['title'] = 'Coil Categories';
		$data['kids'] = $this->model_kategori->kids()->result();
		$this->load->view('layout/home/header', $data);
		$this->load->view('kids', $data);
		$this->load->view('layout/home/footer');
	}

	public function fashion()
	{
		$data['title'] = 'Others Categories';
		$data['fashion'] = $this->model_kategori->fashion()->result();
		$this->load->view('layout/home/header', $data);
		$this->load->view('fashion', $data);
		$this->load->view('layout/home/footer');
	}
}
