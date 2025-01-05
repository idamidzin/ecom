<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_address extends CI_Model {
	public function save($data)
  {
    $this->db->insert('addresses', $data);
    return $this->db->insert_id();
	}

  public function getByUserId($user_id) {
    $result = $this->db->where('user_id', $user_id)->limit(1)->get('addresses');
    
    if ($result->num_rows() > 0) {
      return $result->row();
    }

		return null;
	}

  public function getDefault($user_id) {
    $result = $this->db->where('user_id', $user_id)->where('is_default', 1)->limit(1)->get('addresses');
    
    if ($result->num_rows() > 0) {
      return $result->row();
    }

		return null;
	}
}
