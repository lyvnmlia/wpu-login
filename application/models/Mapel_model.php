<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel_model extends CI_Model
{
    public function getAll()
    {
        // Mengambil semua data dari tabel mata_pelajaran
        $query = $this->db->get('m_mapel');
        return $query->result(); // Mengembalikan hasil sebagai array objek
    }


    public function getAllMapel()
    {
        // JOIN agar bisa tampil nama kelas
        $this->db->select('m_mapel.*, m_kelas.nama');
        $this->db->from('m_mapel');
        $this->db->join('m_kelas', 'm_kelas.id = m_mapel.id_kelas');
        return $this->db->get()->result_array();
    }

    public function getMapelByKelas($id_kelas = null)
    {
        $this->db->select('m_mapel.*, m_kelas.nama');
        $this->db->from('m_mapel');
        $this->db->join('m_kelas', 'm_kelas.id = m_mapel.id_kelas');

        if (!empty($id_kelas) && $id_kelas !== 'all') {
            $this->db->where('m_mapel.id_kelas', $id_kelas);
        }

        return $this->db->get()->result_array();
    }

    public function getMapelById($id)
    {
        $this->db->select('m_mapel.*, m_kelas.nama');
        $this->db->from('m_mapel');
        $this->db->join('m_kelas', 'm_kelas.id = m_mapel.id_kelas');
        $this->db->where('m_mapel.id', $id);
        return $this->db->get()->row_array();
    }
}
