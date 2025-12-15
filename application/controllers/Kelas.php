<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller 
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
        $this->load->model('Kelas_model');
        $this->load->model('Jurusan_model'); // opsional, bisa langsung pakai $this->db
        if (!$this->session->userdata('email')) {
            redirect('auth'); // redirect ke login jika belum login
        }
    }

    public function index()
    {
        
        $data['title'] = 'Data Kelas';
        $data['jurusan'] = $this->Jurusan_model->getAllJurusan();

        
        // Ambil user dari session
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        
        $data['jurusan'] = $this->db->get('m_jurusan')->result_array(); 

        // Rules validasi tambah jurusan
        $this->form_validation->set_rules('nama', 'Nama Jurusan', 'required|trim');
        $this->form_validation->set_rules('id_jurusan', 'Jurusan', 'required|trim');
        $this->form_validation->set_rules('code_kelas', 'Code Kelas', 'required|trim|is_unique[m_kelas.code_kelas]', [
            'is_unique' => 'Kode Kelas sudah digunakan!'
        ]);

        if ($this->form_validation->run() == false) {
            $m_jurusan = $this->input->get('m_jurusan', true);
        if ($m_jurusan && $m_jurusan !== 'all') {
            $data['kelas'] = $this->Kelas_model->getKelasByJurusan($m_jurusan);
        } else {
            // Jika pilih "Semua Jurusan"
            $data['kelas'] = $this->Kelas_model->getAllKelas();
        }
            // Tampilkan form dengan error
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('masterdata/kelas', $data);
            $this->load->view('templates/footer');
        } else {
            // Tambah data baru
            $dataInput = [
                'nama' => $this->input->post('nama', true),
                'id_jurusan' => $this->input->post('id_jurusan', true),
                'code_kelas' => $this->input->post('code_kelas', true)
            ];
            $this->db->insert('m_kelas', $dataInput);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Kelas baru berhasil ditambahkan!</div>');
            redirect('kelas');
        }
    }

    public function edit($id)
    {
        // Validasi input
        $this->form_validation->set_rules('nama', 'Nama Kelas', 'required|trim');
        $this->form_validation->set_rules('id_jurusan', 'Jurusan', 'required|trim');
        $this->form_validation->set_rules('code_kelas', 'Code Kelas', 'required|trim');

        if ($this->form_validation->run() == false) {
            // Ambil data jurusan untuk form edit
            $kelas_row = $this->db->get_where('m_kelas', ['id' => $id])->row_array();
            if (!$kelas_row) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Data jurusan tidak ditemukan.</div>');
                redirect('kelas');
            }

            // Bungkus menjadi array supaya foreach di view bisa jalan
            $data['kelas'] = [$kelas_row];

            // Load view
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('masterdata/kelas', $data);
            $this->load->view('templates/footer');
        } else {
            $dataUpdate = [
                'nama'          => $this->input->post('nama', true),
                'id_jurusan'    => $this->input->post('id_jurusan', true),
                'code_kelas'    => $this->input->post('code_kelas', true)
            ];

            $this->db->where('id', $id);
            $this->db->update('m_kelas', $dataUpdate);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Kelas berhasil diupdate!</div>');
            redirect('kelas');
        }
    }


    public function delete($id)
    {
        // Cek apakah data jurusan ada
        $kelas = $this->db->get_where('m_kelas', ['id' => $id])->row_array();
        if (!$kelas) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data kelas tidak ditemukan.</div>');
            redirect('kelas');
        }

        // Hapus data
        $this->db->delete('m_kelas', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Kelas berhasil dihapus!</div>');
        redirect('kelas');
    }

    public function filter()
    {
        $data['title'] = 'Filter Kelas Berdasarkan Jurusan';
        $data['jurusan'] = $this->Jurusan_model->getAllJurusan();

        $this->load->view('templates/header', $data);
        $this->load->view('masterdata/kelas', $data);
        $this->load->view('templates/footer');
    }

    // Proses filter dan tampilkan hasil
    public function filter_result()
    {
        
        $data['title'] = 'Hasil Filter Kelas';
        $data['jurusan'] = null;
        $m_jurusan = $this->input->post('m_jurusan', true);
        if ($m_jurusan && $m_jurusan !== 'all') {
            $data['jurusan'] = $this->Jurusan_model->getJurusanById($m_jurusan);
            $data['kelas'] = $this->Kelas_model->getKelasByJurusan($m_jurusan);
        } else {
            // Jika pilih "Semua Jurusan"
            $data['kelas'] = $this->Kelas_model->getAllKelas();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('masterdata/kelas', $data);
        $this->load->view('templates/footer');
    }
}