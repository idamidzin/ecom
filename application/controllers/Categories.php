<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends CI_Controller {
	public function elektronik()
	{
		$data['title'] = 'Cartridge Categories';
		$data['menus'] = $this->model_kategori->getMenuByCategory();
		$data['elektronik'] = $this->model_kategori->elektronik()->result();
		$this->load->view('layout/home/header', $data);
		$this->load->view('elektronik', $data);
		$this->load->view('layout/home/footer');
	}

	public function shirt()
	{
		$data['menus'] = $this->model_kategori->getMenuByCategory();
		$data['title'] = 'Merch Categories';
		$data['shirt'] = $this->model_kategori->shirt()->result();
		$this->load->view('layout/home/header', $data);
		$this->load->view('shirt', $data);
		$this->load->view('layout/home/footer');
	}

	public function shoes()
	{
		$data['menus'] = $this->model_kategori->getMenuByCategory();
		$data['title'] = 'Shoes Categories';
		$data['shoes'] = $this->model_kategori->shoes()->result();
		$this->load->view('layout/home/header', $data);
		$this->load->view('shoes', $data);
		$this->load->view('layout/home/footer');
	}

	public function jacket()
	{
		$data['menus'] = $this->model_kategori->getMenuByCategory();
		$data['title'] = 'Device Categories';
		$data['jacket'] = $this->model_kategori->jacket()->result();
		$this->load->view('layout/home/header', $data);
		$this->load->view('jacket', $data);
		$this->load->view('layout/home/footer');
	}

	public function kids()
	{
		$data['menus'] = $this->model_kategori->getMenuByCategory();
		$data['title'] = 'Coil Categories';
		$data['kids'] = $this->model_kategori->kids()->result();
		$this->load->view('layout/home/header', $data);
		$this->load->view('kids', $data);
		$this->load->view('layout/home/footer');
	}

	public function fashion()
	{
		$data['menus'] = $this->model_kategori->getMenuByCategory();
		$data['title'] = 'Others Categories';
		$data['fashion'] = $this->model_kategori->fashion()->result();
		$this->load->view('layout/home/header', $data);
		$this->load->view('fashion', $data);
		$this->load->view('layout/home/footer');
	}

	public function products()
	{
		$kategori = $this->input->get('kategori');

		$data['menus'] = $this->model_kategori->getMenuByCategory();
		$data['title'] = 'Categories';
		$data['products'] = $this->model_kategori->getProductByCategory($kategori)->result();

		$this->load->view('layout/home/header', $data);
		$this->load->view('products', $data);
		$this->load->view('layout/home/footer');
	}
}
