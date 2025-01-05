<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_chat extends CI_Model {
    
    public function getMessages($userId, $friendId) {
        $this->db->where("(sender_id = $userId AND receiver_id = $friendId) OR (sender_id = $friendId AND receiver_id = $userId)");
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get('messages')->result();
    }

    public function sendMessage($data) {
        $this->db->insert('messages', $data);
        return $this->db->insert_id();
    }

    public function getUsers() {
        return $this->db->get('user')->result();
    }

    public function existUnread($userId, $friendId) {
        $this->db->where("(sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)", [
            $userId, $friendId, $friendId, $userId
        ]);
        $this->db->where('is_read', 0);
        $query = $this->db->get('messages');
    
        return $query->num_rows() > 0; // Mengembalikan TRUE jika ada pesan yang belum dibaca
    }    
}
