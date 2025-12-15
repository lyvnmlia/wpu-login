<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller 
{
    public $db;
    public $input;
    public $session;


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jadwal_model');
        $this->load->model('Kelas_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    // -------------------------
    // LIST JADWAL GROUP
    // -------------------------
    public function index()
    {
        $data['title'] = "Daftar Jadwal Pelajaran";
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['kelas'] = $this->Jadwal_model->getKelas();

        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('managementJadwal/daftar_kelas', $data);
        $this->load->view('templates/footer');
    }

    // -------------------------
    // LIHAT DETAIL PER KELAS
    // -------------------------
    public function lihat($id_kelas, $semester, $tahun)
    {
        $data['title'] = "Lihat Jadwal";

        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $hari = ['Senin','Selasa','Rabu','Kamis','Jumat'];

        // ambil list jam pelajaran
        $jam = $this->Jadwal_model->getJam();

        $datajadwal = [];

        foreach ($jam as $jm) {

            // PERBAIKAN: object harus pakai -> bukan ['id_jam']
            $id_jam = $jm->id_jam;

            foreach ($hari as $h) {

                $detail = $this->Jadwal_model->getJadwalDetail(
                    $id_kelas,
                    $semester,
                    $tahun,
                    $h,
                    $id_jam
                );

                // ubah object jadi array agar aman dipakai di view
                if (!empty($detail)) {
                    $detail = (array) $detail;
                }

                $datajadwal[$id_jam][] = [
                    'hari'   => $h,
                    'jadwal' => !empty($detail) ? $detail : null
                ];
            }
        }

        $data['jadwal'] = $datajadwal;

        // Info kelas
        $data['info'] = $this->db->select('m_kelas.nama AS nama_kelas, m_jurusan.nama AS nama_jurusan')
                            ->from('m_kelas')
                            ->join('m_jurusan', 'm_jurusan.id = m_kelas.id_jurusan')
                            ->where('m_kelas.id', $id_kelas)
                            ->get()->row();

        $data['semester'] = $semester;
        $data['tahun']    = $tahun;

        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('managementJadwal/lihat', $data);
        $this->load->view('templates/footer');
    }



    // -------------------------
    // FORM TAMBAH JADWAL
    // -------------------------
    public function tambah()
    {
        $data['title'] = "Tambah Jadwal";

        // Ambil data kelas dan jam dari model
        $data['kelas'] = $this->Kelas_model->getAllKelas(); // pastikan model ada method getAllKelas()
        $data['jam_pelajaran'] = $this->Jadwal_model->getJam();       // pastikan model ada method getJam()
        $data['mapel'] = $this->Jadwal_model->getMapelByKelas(0);

        // Load view tambah jadwal
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('tambahJadwal/tambah', $data);
        $this->load->view('templates/footer');
    }

    // -------------------------
    // AJAX – GET MAPEL BY KELAS
    // -------------------------
    public function getMapelKelas()
    {
        $id = $this->input->post('id_kelas');
        $mapel = $this->Jadwal_model->getMapelByKelas($id);
        echo json_encode($mapel);
    }

    // -------------------------
    // SIMPAN JADWAL
    // -------------------------
    public function simpan()
    {
        // var_dump($this->input->post());
        // die();
        $data = [
            'id_kelas' => $this->input->post('id_kelas'),
            'semester' => $this->input->post('semester'),
            'tahun_ajaran' => $this->input->post('tahun_ajaran'),
            'hari' => $this->input->post('hari'),
            'id_jam' => $this->input->post('jam_ke'),
            'id_mapel' => $this->input->post('id_mapel')
        ];

        if($this->Jadwal_model->insertJadwal($data)){
            $this->session->set_flashdata('success', 'Jadwal berhasil ditambahkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan jadwal.');
        }

        redirect('jadwal');
    }


    // -------------------------
    // DELETE
    // -------------------------
    public function delete($id)
    {
        $this->Jadwal_model->deleteJadwal($id);
        redirect('jadwal');
    }

    // -------------------------
    // EDIT
    // -------------------------
    public function edit($id)
    {
        $data['jadwal'] = $this->db->get_where('jadwal_pelajaran', ['id' => $id])->row();
        $data['kelas'] = $this->Jadwal_model->getKelas();
        $data['jam'] = $this->Jadwal_model->getJam();
        $data['mapel'] = $this->Jadwal_model->getMapelByKelas($data['jadwal']->id_kelas);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('managementJadwal/jadwal/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update($id)
    {
        $data = [
            'id_kelas' => $this->input->post('id_kelas'),
            'semester' => $this->input->post('semester'),
            'tahun_ajaran' => $this->input->post('tahun_ajaran'),
            'hari' => $this->input->post('hari'),
            'id_jam' => $this->input->post('id_jam'),
            'id_mapel' => $this->input->post('id_mapel')
        ];

        $this->Jadwal_model->updateJadwal($id, $data);
        redirect('jadwal');
    }

    // -------------------------
    // VIEW UNTUK SISWA
    // -------------------------
    public function siswa()
    {
        // ambil id_user dari session, bukan parameter
        $id_user = $this->session->userdata('id_user');

        if(!$id_user){
            redirect('auth/login'); // jika belum login
        }

        $siswa = $this->db->get_where('m_siswa', ['id_user' => $id_user])->row();

        if (!$siswa) {
            show_error("Data siswa tidak ditemukan. Pastikan user terhubung ke m_siswa.", 404);
        }


        $id_kelas = $siswa->id_kelas;

        $data['jadwal'] = $this->Jadwal_model->getJadwalSiswa($id_kelas);

        $data['info'] = $this->db->select('m_kelas.nama AS nama_kelas, m_jurusan.nama AS nama_jurusan')
                                ->from('m_kelas')
                                ->join('m_jurusan', 'm_jurusan.id = m_kelas.id_jurusan')
                                ->where('m_kelas.id', $id_kelas)
                                ->get()->row();

        $data['title'] = "Jadwal Siswa";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('managementJadwal/jadwalsaya', $data);
        $this->load->view('templates/footer');
    }

}
