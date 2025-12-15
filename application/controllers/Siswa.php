<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    public $input;
    public $db;
    public $session;
    public $form_validation;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kelas_model');
        $this->load->model('Jurusan_model');
        $this->load->model('Siswa_model', 'siswa'); // alias agar $this->siswa valid
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation'); // pastikan form_validation di-load
        $this->load->database(); // pastikan db di-load
    }

    // Tampilkan daftar siswa
    public function index()
    {
        $data['title'] = 'Data Siswa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['siswa'] = $this->siswa->getAll(); // gunakan alias $this->siswa
        $data['kelas'] = $this->Kelas_model->getAllKelas(); // dropdown kelas
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('masterdata/siswa', $data);
        $this->load->view('templates/footer');
    }

    // Simpan data siswa baru
        public function store()
    {
        $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('id_kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('nomor_whatsapp', 'Nomor Whatsapp', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 
                '<div class="alert alert-danger">'.validation_errors().'</div>');
            redirect('siswa');
        }

        // SIMPAN KE TABEL USER
        $userData = [
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role_id' => 3, // siswa
            'is_active' => 1
        ];

        $this->db->insert('user', $userData);
        $id_user = $this->db->insert_id();

        // SIMPAN KE TABEL m_siswa
        $siswaData = [
            'id_user' => $id_user,
            'nama_siswa' => $this->input->post('nama_siswa'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'id_kelas' => $this->input->post('id_kelas'),
            'nomor_whatsapp' => $this->input->post('nomor_whatsapp')
        ];

        $this->db->insert('m_siswa', $siswaData);

        $this->session->set_flashdata('message', 
            '<div class="alert alert-success">Siswa berhasil ditambahkan!</div>');
        redirect('siswa');
    }



    // Form edit siswa
    public function edit($id)
    {
        $data['siswa'] = $this->siswa->getById($id); // gunakan alias
        $data['kelas'] = $this->Kelas_model->getAllKelas(); // gunakan method getAllKelas

        if (!$data['siswa']) {
            show_404();
        }

        $this->load->view('siswa/edit', $data);
    }

    // Update data siswa
    public function update($id)
    {
        $id_user = $this->input->post('id_user');

        // Update m_siswa
        $siswaUpdate = [
            'nama_siswa' => $this->input->post('nama_siswa'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'id_kelas' => $this->input->post('id_kelas'),
            'nomor_whatsapp' => $this->input->post('nomor_whatsapp')
        ];
        $this->db->update('m_siswa', $siswaUpdate, ['id' => $id]);

        // Update user
        $userUpdate = [
            'email' => $this->input->post('email')
        ];

        $password = $this->input->post('password');
        if (!empty($password)) {
            $userUpdate['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->update('user', $userUpdate, ['id' => $id_user]);

        $this->session->set_flashdata('message', 
            '<div class="alert alert-success">Data siswa berhasil diperbarui!</div>');
        redirect('siswa');
    }


    // Hapus siswa
    public function delete($id)
    {
        if ($this->siswa->delete($id)) {
            redirect('siswa');
        } else {
            echo "Gagal menghapus siswa.";
        }
    }

    private function format_wa($nomor)
    {
        $nomor = preg_replace('/[^0-9]/', '', $nomor);

        if (substr($nomor, 0, 1) == '0') {
            return '+62' . substr($nomor, 1);
        }

        if (substr($nomor, 0, 2) == '62') {
            return '+' . $nomor;
        }

        return '+62' . $nomor;
    }


    public function filter()
    {
        $data['title'] = 'Filter Siswa Berdasarkan Kelas dan Jurusan';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $data['kelas'] = $this->Kelas_model->getAllKelas();
        $data['jurusan'] = $this->Jurusan_model->getAllJurusan();
        $data['siswa'] = [];
        $data['selected_kelas'] = null;
        $data['selected_jurusan'] = null;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('masterdata/siswa', $data);
        $this->load->view('templates/footer');
    }

    public function filter_result()
    {
        $id_kelas   = $this->input->post('id_kelas', true);
        $id_jurusan = $this->input->post('id_jurusan', true);

        $data['title'] = 'Hasil Filter Siswa';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $data['kelas'] = $this->Kelas_model->getAllKelas();
        $data['jurusan'] = $this->Jurusan_model->getAllJurusan();
        $data['siswa'] = $this->siswa->getFilteredSiswa($id_kelas, $id_jurusan); // gunakan alias

        $data['selected_kelas'] = $id_kelas;
        $data['selected_jurusan'] = $id_jurusan;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('masterdata/siswa', $data);
        $this->load->view('templates/footer');
    }
}
