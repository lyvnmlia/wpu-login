<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jam_pelajaran extends CI_Controller 
{
    public $db;
    public $input;
    public $session;

    public function __construct() {
        parent::__construct();
        $this->load->model('Jam_pelajaran_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
        $this->load->database();
    }

    public function index() {
        $data['title'] = 'Data Jam Pelajaran';
        $data['jam'] = $this->Jam_pelajaran_model->getAll();

        // Ambil user login (jika ada)
        $email = $this->session->userdata('email');
        $data['user'] = $email ? $this->db->get_where('user', ['email' => $email])->row_array() : null;

        // Tampilkan tampilan tabel
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('masterdata/jam_pelajaran', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        if ($this->input->post()) {
            $data = [
                'jam_ke'        => $this->input->post('jam_ke'),
                'waktu_mulai'   => $this->input->post('waktu_mulai'),
                'waktu_selesai' => $this->input->post('waktu_selesai'),
            ];
            $this->Jam_pelajaran_model->insert($data);
            redirect('jam_pelajaran');
        } else {
            $this->load->view('jam_pelajaran/form');
        }
    }

    public function edit($id) {
        $data['jam'] = $this->Jam_pelajaran_model->getById($id);

        if ($this->input->post()) {
            $update = [
                'jam_ke'        => $this->input->post('jam_ke'),
                'waktu_mulai'   => $this->input->post('waktu_mulai'),
                'waktu_selesai' => $this->input->post('waktu_selesai'),
            ];
            $this->Jam_pelajaran_model->update($id, $update);
            redirect('jam_pelajaran');
        } else {
            $this->load->view('jam_pelajaran/form', $data);
        }
    }

    public function hapus($id) {
        $this->Jam_pelajaran_model->delete($id);
        redirect('jam_pelajaran');
    }
}
