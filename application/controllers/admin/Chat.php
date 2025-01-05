<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Pusher\Pusher;

class Chat extends CI_Controller
{

    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('level') != '1') {
			redirect('welcome');
		}

        $this->load->model('Model_chat');
        $this->load->model('Model_user');
        $this->load->library('session');
        $this->config->load('pusher');
    }

    public function index()
    {
        $data['title'] = 'Chat';
        $user_id = $this->session->userdata('id_user');
        $data['user_id'] = $user_id;
        $data['users'] = $this->Model_chat->getUsers();
        $data['cartItems'] = $this->temp_cart->getCartItems($user_id);
        $data['cartTotalItems'] = $this->temp_cart->getTotalItems($user_id);

        $this->load->view('layout/admin/header', $data);
        $this->load->view('admin/chat/chat', $data);
        $this->load->view('layout/admin/footer');
    }

    public function getMessages() {
        $userId = $this->session->userdata('id_user');
        $friendId = $this->input->post('friend_id');
        $messages = $this->Model_chat->getMessages($userId, $friendId);
        echo json_encode($messages);
    }

    public function sendMessage() {
        $data = [
            'sender_id' => $this->session->userdata('id_user'),
            'receiver_id' => $this->input->post('receiver_id'),
            'message' => $this->input->post('message')
        ];

        $this->Model_chat->sendMessage($data);

        $this->triggerPusher($data['receiver_id'], $data);
        echo json_encode(['status' => 'success']);
    }

    private function triggerPusher($receiverId, $data) {
        $options = array(
            'cluster' => $this->config->item('pusher_cluster'),
            'useTLS' => true
        );

        $pusher = new Pusher(
            $this->config->item('pusher_key'),
            $this->config->item('pusher_secret'),
            $this->config->item('pusher_app_id'),
            $options
        );

        $sender = $this->Model_user->getUserById($data['sender_id']);

        if ($sender) {
            $data['sender_name'] = $sender->nama_user;
        }

        $data['message'] = $data['message'];
        $channel = "chat-channel-$receiverId";
        $event = 'new-message';

        $pusher->trigger($channel, $event, $data);
    }
}
