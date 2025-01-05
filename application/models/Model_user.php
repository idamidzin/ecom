<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_user extends CI_Model {
	public function getUserById($id) {
    $result = $this->db->where('id_user', $id)->limit(1)->get('user');
    
    if ($result->num_rows() > 0) {
      return $result->row();
    }

		return null;
	}
}
