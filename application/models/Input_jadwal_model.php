<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input_jadwal_model extends CI_Model {

    public function getKelas()
    {
        return $this->db->get('m_kelas')->result();
    }

    public function getMapel()
    {
        return $this->db->get('m_mapel')->result();
    }

    public function getJamPelajaran()
    {
        return $this->db->get('jam_pelajaran')->result();
    }

    public function getJamById($id_jam)
    {
        return $this->db->get_where('jam_pelajaran', ['id' => $id_jam])->row();
    }

    public function insertPilihKelas($data)
    {
        // karena fieldnya di DB bernama id_kelas
        $insert = [
            'id_kelas'     => $data['kelas_id'],
            'semester'     => $data['semester'],
            'tahun_ajaran' => $data['tahun_ajaran']
        ];

        $this->db->insert('pilih_kelas', $insert);
        return $this->db->insert_id();
    }

    

    // Simpan ke tabel detail_jadwal
    public function insertDetailJadwal($data)
    {
        $this->db->insert('detail_jadwal', $data);
    }

    public function getJadwalByKelas($id_kelas)
    {
        $this->db->select("
            detail_jadwal.*,
            m_kelas.nama_kelas,
            pilih_kelas.semester,
            pilih_kelas.tahun_ajaran,
            m_mapel.name_mapel
        ");

        $this->db->from('detail_jadwal');
        $this->db->join('pilih_kelas', 'detail_jadwal.pilih_kelas_id = pilih_kelas.id');
        $this->db->join('m_kelas', 'pilih_kelas.id_kelas = m_kelas.id');
        $this->db->join('m_mapel', 'detail_jadwal.mapel_id = m_mapel.id');

        $this->db->where('m_kelas.id', $id_kelas);

        return $this->db->get()->result();
    }


}
