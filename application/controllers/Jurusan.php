<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusan extends CI_Controller 
{
    public $db;
    public $session;
    public $form_validation;
    public $input;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('Jurusan_model'); // opsional, bisa langsung pakai $this->db
        if (!$this->session->userdata('email')) {
            redirect('auth'); // redirect ke login jika belum login
        }
    }

    public function index()
    {
        $data['title'] = 'Data Jurusan';

        // Ambil user dari session
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        // Ambil semua data jurusan
        $data['jurusan'] = $this->db->get('m_jurusan')->result_array();

        // Rules validasi tambah jurusan
        $this->form_validation->set_rules('nama', 'Nama Jurusan', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('code_jurusan', 'Code Jurusan', 'required|trim|is_unique[m_jurusan.code_jurusan]', [
            'is_unique' => 'Kode Jurusan sudah digunakan!'
        ]);

        if ($this->form_validation->run() == false) {
            // Tampilkan form dengan error
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('masterdata/jurusan', $data);
            $this->load->view('templates/footer');
        } else {
            // Tambah data baru
            $dataInput = [
                'nama' => $this->input->post('nama', true),
                'deskripsi' => $this->input->post('deskripsi', true),
                'code_jurusan' => $this->input->post('code_jurusan', true)
            ];
            $this->db->insert('m_jurusan', $dataInput);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Jurusan baru berhasil ditambahkan!</div>');
            redirect('jurusan');
        }
    }

    public function edit($id)
    {
        // Validasi input
        $this->form_validation->set_rules('nama', 'Nama Jurusan', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('code_jurusan', 'Code Jurusan', 'required|trim'); // gunakan 'kode_jurusan' jika itu nama kolom di DB

        if ($this->form_validation->run() == false) {
            // Ambil data jurusan untuk form edit
            $data['jurusan'] = $this->db->get_where('m_jurusan', ['id' => $id])->row_array();
            if (!$data['jurusan']) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Data jurusan tidak ditemukan.</div>');
                redirect('jurusan');
            }

            // Load view form edit (pastikan file view-nya ada)
            $this->load->view('jurusan', $data);
        } else {
            $data = [
                'nama'          => $this->input->post('nama', true),
                'deskripsi'     => $this->input->post('deskripsi', true),
                'code_jurusan'  => $this->input->post('code_jurusan', true)
            ];

            $this->db->where('id', $id);
            $this->db->update('m_jurusan', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Jurusan berhasil diupdate!</div>');
            redirect('jurusan');
        }
    }

    public function delete($id)
    {
        // Cek apakah data jurusan ada
        $jurusan = $this->db->get_where('m_jurusan', ['id' => $id])->row_array();
        if (!$jurusan) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data jurusan tidak ditemukan.</div>');
            redirect('jurusan');
        }

        // Hapus data
        $this->db->delete('m_jurusan', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Jurusan berhasil dihapus!</div>');
        redirect('jurusan');
    }
}

