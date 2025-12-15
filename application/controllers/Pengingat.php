<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengingat extends CI_Controller 
{
    public function __construct() {
        parent::__construct();

        // Pastikan user sudah login
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }

        // Pastikan yang boleh hanya admin
        if ($this->session->userdata('role_id') != 1) {
            redirect('auth/blocked');
        }
    }

    public function kirim() {
        // Panggil endpoint Node.js untuk trigger pengiriman pesan
        $url = "http://localhost:3000/kirim-pengingat"; 
        $response = @file_get_contents($url);

        if ($response === FALSE) {
            $this->session->set_flashdata('msg_error', 'Gagal menghubungi server WhatsApp.');
        } else {
            $this->session->set_flashdata('msg_success', 'Pengingat berhasil dikirim!');
        }

        redirect('admin'); // redirect ke dashboard admin
    }
}
