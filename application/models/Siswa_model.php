<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model
{
    private $tableSiswa = 'm_siswa';
    private $tableUser = 'user';
    private $tableKelas = 'm_kelas';
    private $tableJurusan = 'm_jurusan';

    public function __construct()
    {
        parent::__construct();
    }

    public function create($data)
    {
        return $this->db->insert($this->tableSiswa, $data); // perbaikan table
    }

    // Ambil semua data siswa lengkap (join user, kelas, jurusan)
    public function getAll()
    {
        $this->db->select('
            m_siswa.id,
            m_siswa.nama_siswa,
            m_siswa.tanggal_lahir,
            m_kelas.nama AS nama_kelas,
            m_jurusan.nama AS nama_jurusan,
            user.email,
            user.password
        ');
        $this->db->from($this->tableSiswa);
        $this->db->join($this->tableUser, 'm_siswa.id_user = user.id');
        $this->db->join($this->tableKelas, 'm_siswa.id_kelas = m_kelas.id');
        $this->db->join($this->tableJurusan, 'm_kelas.id_jurusan = m_jurusan.id');
        $query = $this->db->get();

        return $query->result();
    }

    // Ambil siswa berdasarkan id
    public function getById($id)
    {
        $this->db->select('
            m_siswa.*,
            user.email,
            m_kelas.nama AS nama_kelas,
            m_jurusan.nama AS nama_jurusan
        ');
        $this->db->from($this->tableSiswa);
        $this->db->join($this->tableUser, 'm_siswa.id_user = user.id');
        $this->db->join($this->tableKelas, 'm_siswa.id_kelas = m_kelas.id');
        $this->db->join($this->tableJurusan, 'm_kelas.id_jurusan = m_jurusan.id');
        $this->db->where('m_siswa.id', $id);

        return $this->db->get()->row();
    }

    // Insert data siswa dan user (userData sudah berisi email dan password_hash)
    public function insert($siswaData, $userData)
    {
        $this->db->trans_start();

        $this->db->insert($this->tableUser, $userData);
        $id_user = $this->db->insert_id();

        $siswaData['id_user'] = $id_user;
        $this->db->insert($this->tableSiswa, $siswaData);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // Update siswa dan user (userData bisa null jika tidak update user)
    public function update($id, $siswaData, $userData = null)
    {
        $this->db->trans_start();

        $this->db->where('id', $id);
        $this->db->update($this->tableSiswa, $siswaData);

        if ($userData !== null) {
            // Cari id_user siswa
            $this->db->select('id_user');
            $this->db->where('id', $id);
            $id_user = $this->db->get($this->tableSiswa)->row()->id_user;

            $this->db->where('id', $id_user);
            $this->db->update($this->tableUser, $userData);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // Hapus siswa dan user terkait
    public function delete($id)
    {
        $this->db->trans_start();

        $this->db->select('id_user');
        $this->db->where('id', $id);
        $user = $this->db->get($this->tableSiswa)->row();

        if (!$user) {
            $this->db->trans_complete();
            return false;
        }

        $this->db->where('id', $id);
        $this->db->delete($this->tableSiswa);

        $this->db->where('id', $user->id_user);
        $this->db->delete($this->tableUser);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function getFilteredSiswa($id_kelas = null, $id_jurusan = null)
    {
        $this->db->select('m_siswa.*, m_kelas.nama AS nama_kelas, m_jurusan.nama AS nama_jurusan, user.email, user.password');
        $this->db->from($this->tableSiswa);
        $this->db->join($this->tableKelas, 'm_kelas.id = m_siswa.id_kelas');
        $this->db->join($this->tableJurusan, 'm_kelas.id_jurusan = m_jurusan.id');
        $this->db->join($this->tableUser, 'user.id = m_siswa.id_user');

        if (!empty($id_kelas)) {
            $this->db->where('m_siswa.id_kelas', $id_kelas);
        }

        if (!empty($id_jurusan)) {
            $this->db->where('m_kelas.id_jurusan', $id_jurusan);
        }

        return $this->db->get()->result();
    }

    public function getSiswa($id) {
        return $this->db->get_where($this->tableSiswa, ['id' => $id])->row_array(); // perbaikan table
    }
}
