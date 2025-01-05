<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Address extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('level') != '2') {
            redirect('welcome');
        }

        $this->load->model('Model_address');
    }

    public function save()
    {
        $user_id            = $this->input->post('id_user');
        $city_id            = $this->input->post('city_id');
        $province_id        = $this->input->post('province_id');
        $address            = $this->input->post('address');
        $post_code          = $this->input->post('post_code');

        if (empty($user_id) || empty($city_id) || empty($province_id) || empty($address) || empty($post_code)) {
            $this->session->set_flashdata('error', 'Semua data wajib diisi.');
            redirect('profile');
            return;
        }

        $exist_address = $this->model_address->getByUserId($user_id);

        $data = [
            'user_id' => $user_id,
            'city_id' => $city_id,
            'province_id' => $province_id,
            'address' => $address,
            'post_code' => $post_code,
            'is_default' => $exist_address && $exist_address->is_default ? false : true,
        ];


        $this->model_address->save($data);

        $this->session->set_flashdata('success', 'Alamat berhasil disimpan.');
        redirect('profile');
    }

    public function switch_address()
    {
        $data = json_decode($this->input->raw_input_stream, true);
        $address_id = $data['address_id'] ?? null;

        if ($address_id) {
            // Set all addresses for the user to non-default
            $this->db->where('user_id', $this->session->userdata('id_user'))
                    ->update('addresses', ['is_default' => 0]);

            // Set the selected address as default
            $this->db->where('id', $address_id)
                    ->update('addresses', ['is_default' => 1]);

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid address ID']);
        }
    }

}
