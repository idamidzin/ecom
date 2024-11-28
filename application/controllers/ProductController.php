<?php

class ProductController extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Model_product');
  }

  public function get_products()
  {
    $keyword = $this->input->post('keyword');
    $kategori = $this->input->post('kategori');
    $products = $this->Model_product->searchProducts($keyword, $kategori);
    echo json_encode($products);
  }
}
