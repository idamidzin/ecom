<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('level') != '1') {
			redirect('welcome');
		}

		$this->load->model('Model_chat');
	}

	public function index()
	{
		$type = isset($_GET['type']) ? $_GET['type'] : null;
		$message_id = isset($_GET['message_id']) ? $_GET['message_id'] : null;
		$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;
	

		if ($type == 'order') {
			redirect('admin/invoice/detail/'.$order_id);
		}

		if ($type == 'message') {
			$message = $this->Model_chat->getById($message_id);
			
			if ($message) {
				// $this->Model_chat->markAsRead($message_id);
			}

			redirect('admin/chat?sender_id='.$message->sender_id);
		}

		redirect('');
	}
}
