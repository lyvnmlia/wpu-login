<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends CI_Model
{
    protected $table = 'm_kelas';

    public function getKelasByJurusan($m_jurusan)
    {
        // Pastikan $id_jurusan tidak kosong agar query tidak error
        if (empty($m_jurusan)) {
            return [];
        }
         $this->db->select('m_kelas.*, m_jurusan.nama as nama_jurusan');
        $this->db->from('m_kelas');
        $this->db->join('m_jurusan', 'm_jurusan.id = m_kelas.id_jurusan');
        $this->db->where('m_kelas.id_jurusan', $m_jurusan);
        return $this->db->get()->result_array();
    }

    public function getAllKelas()
    {
        $this->db->select('m_kelas.id, m_kelas.nama AS kelas, m_jurusan.nama AS nama_jurusan');
        $this->db->from($this->table);
        $this->db->join('m_jurusan', 'm_kelas.id_jurusan = m_jurusan.id');
        return $this->db->get()->result_array();
    }

    public function getAllKelasWithJurusan() {
        $this->db->select('m_kelas.id, m_kelas.nama AS kelas, m_jurusan.nama AS jurusan');
        $this->db->from('m_kelas');
        $this->db->join('m_jurusan', 'm_kelas.id_jurusan = m_jurusan.id');
        return $this->db->get()->result_array();
    }

    public function getKelasById($id)
    {
        return $this->db->get_where('m_kelas', ['id' => $id])->row_array();
    }



}



