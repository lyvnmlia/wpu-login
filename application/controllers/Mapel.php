<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel extends CI_Controller
{
    public $db;
    public $session;
    public $input;
    public $form_validation;

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation']);
        $this->load->helper(['url']);
        $this->load->model('Mapel_model');
        $this->load->model('Kelas_model'); 
        $this->load->model('DetailMapel_model');
        $this->check_login();
    }


    /*** Cek apakah user sudah login*/
    private function check_login()
    {
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
    }

    /** * Halaman utama: daftar mapel & form tambah mapel*/
    public function index()
    {
        $data['title'] = 'Data Mapel';
        $email = $this->session->userdata('email');
        $data['user'] = $this->DetailMapel_model->getUserByEmail($email);
        $data['kelas'] = $this->db->get('m_kelas')->result_array();

        $m_kelas = $this->input->get('m_kelas', true); // ambil dari GET

        if ($m_kelas && $m_kelas !== 'all') {
            $data['mapel'] = $this->Mapel_model->getMapelByKelas($m_kelas);
            $data['selected_kelas_id'] = $m_kelas;
        } else {
            $data['mapel'] = $this->Mapel_model->getAllMapel();
            $data['selected_kelas_id'] = 'all';
        }

        // Validasi tambah
        $this->form_validation->set_rules('id_kelas', 'Kelas', 'required|trim');
        $this->form_validation->set_rules('name_mapel', 'Name Mapel', 'required|trim');
        $this->form_validation->set_rules('code_mapel', 'Code Mapel', 'required|trim|is_unique[m_mapel.code_mapel]', [
            'is_unique' => 'Kode Mapel sudah digunakan!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('masterdata/mapel', $data);
            $this->load->view('templates/footer');
        } else {
            // Simpan mapel baru
            $this->db->insert('m_mapel', [
                'id_kelas' => $this->input->post('id_kelas', true),
                'name_mapel' => $this->input->post('name_mapel', true),
                'code_mapel' => $this->input->post('code_mapel', true)
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Mapel baru berhasil ditambahkan!</div>');
            redirect('mapel');
        }
    }


    /*** Edit data mapel*/
    public function edit($id)
    {
        $data['title'] = 'Edit Mapel';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $mapel = $this->db->get_where('m_mapel', ['id' => $id])->row_array();
        if (!$mapel) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data mapel tidak ditemukan.</div>');
            redirect('mapel');
        }

        // Validasi input edit
        $this->form_validation->set_rules('id_kelas', 'Kelas', 'required|trim');
        $this->form_validation->set_rules('name_mapel', 'Name Mapel', 'required|trim');
        $this->form_validation->set_rules('code_mapel', 'Code Mapel', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Validasi gagal. Pastikan semua kolom terisi.</div>');
            redirect('mapel');
        } else {
            $update = [
                'id_kelas'    => $this->input->post('id_kelas', true),
                'name_mapel'  => $this->input->post('name_mapel', true),
                'code_mapel'  => $this->input->post('code_mapel', true),

            ];

            $this->db->where('id', $id);
            $this->db->update('m_mapel', $update);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Data mapel berhasil diperbarui.</div>');
            redirect('mapel');
        }
    }

    /*** Hapus mapel*/
    public function delete($id)
    {
        $mapel = $this->db->get_where('m_mapel', ['id' => $id])->row_array();

        if (!$mapel) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data mapel tidak ditemukan.</div>');
            redirect('mapel');
        }

        $this->db->delete('m_mapel', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Mapel berhasil dihapus!</div>');
        redirect('mapel');
    }

    /*** Detail mapel (opsional)*/
    public function detail($id)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->DetailMapel_model->getUserByEmail($email);
        // $data['user'] = $this->DetailMapel_model->getAllMapel($this->session->userdata('email'));
        $data['mapel'] = $this->DetailMapel_model->getMapelById($id);
        $data['detail'] = $this->DetailMapel_model->getDetailByMapel($id);
        $data['title'] = 'Detail Mapel '. $data['mapel']['name_mapel']; 

        if (!$data['mapel']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data mapel tidak ditemukan.</div>');
            redirect('mapel');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('masterdata/detail_mapel', $data);
        $this->load->view('templates/footer');
    }

    public function savedetail()
    {
        $dataInput = [
            'id_mapel' => $this->input->post('id_mapel', true),
            'materi' => $this->input->post('materi', true),
        ];
        $this->db->insert('m_mapeldetail', $dataInput);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Detail  baru berhasil ditambahkan!</div>');
            redirect('mapel/detail/'.$dataInput['id_mapel']);
    }

     public function editdetail($id)
    {
        $dataInput = [
            'id_mapel' => $this->input->post('id_mapel', true),
            'materi' => $this->input->post('materi', true),
            ];
            $this->db->where('id', $id);
            $this->db->update('m_mapeldetail', $dataInput);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Detail  baru berhasil ditambahkan!</div>');
            redirect('mapel/detail/'.$dataInput['id_mapel']
        );
    }

      public function hapusdetail($id)
    {
        $mapel = $this->db->get_where('m_mapeldetail', ['id' => $id])->row_array();
        $id_mapel = $mapel['id_mapel'];

        if (!$mapel) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data mapel tidak ditemukan.</div>');
            redirect('mapel/detail/' . $id_mapel);
        }

        $this->db->delete('m_mapeldetail', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Detail berhasil dihapus!</div>');
        redirect('mapel/detail/' . $id_mapel);
    }
    
    public function filter()
    {
        $data['title'] = 'Filter Mapel Berdasarkan Kelas';
        $data['kelas'] = $this->Kelas_model->getAllKelas();

        $this->load->view('templates/header', $data);
        $this->load->view('masterdata/mapel', $data);
        $this->load->view('templates/footer');
    }

    // Proses filter dan tampilkan hasil
    public function filter_result()
    {
        $data['title'] = 'Data Mapel (Hasil Filter)';
        $email = $this->session->userdata('email');
        $data['user'] = $this->DetailMapel_model->getUserByEmail($email);
        $data['kelas'] = $this->Kelas_model->getAllKelas();

        $m_kelas = $this->input->post('m_kelas', true); // Ambil ID kelas dari form

        if ($m_kelas && $m_kelas !== 'all') {
            $data['mapel'] = $this->Mapel_model->getMapelByKelas($m_kelas);
            $data['selected_kelas'] = $this->Kelas_model->getKelasById($m_kelas); // untuk ditampilkan jika ingin
        } else {
            $data['mapel'] = $this->Mapel_model->getAllMapel();
            $data['selected_kelas'] = null;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('masterdata/mapel', $data);
        $this->load->view('templates/footer');
    }

}
