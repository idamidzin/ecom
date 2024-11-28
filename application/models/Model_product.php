<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_product extends CI_Model {
	public function searchProducts($keyword = null, $kategori = null) {
		if ($kategori) {
			if ($keyword) {
				$this->db->where('kategori', $kategori);
				$this->db->like('nama_brg', $keyword);
				$this->db->or_like('harga', $keyword);
			} else {
				$this->db->where('kategori', $kategori);
			}
		} else {
			$this->db->or_like('kategori', $keyword);
			$this->db->or_like('harga', $keyword);
			$this->db->or_like('nama_brg', $keyword);
		}

		return $this->db->get('product')->result();
	}

	public function getProduct($id) {
    $result = $this->db->where('id_brg', $id)->limit(1)->get('product');
    
    if ($result->num_rows() > 0) {
      return $result->row();
    }

		return null;
	}
}
