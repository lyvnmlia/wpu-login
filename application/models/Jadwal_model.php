<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_model extends CI_Model {

    // ===============================
    // GET LIST JADWAL GROUP (UNTUK INDEX)
    // ===============================
    public function getJadwalGroup()
    {
        return $this->db->select('j.id_kelas, k.nama AS nama_kelas, jrs.nama AS nama_jurusan, j.semester, j.tahun_ajaran')
                        ->from('jadwal_pelajaran j')
                        ->join('m_kelas k', 'k.id = j.id_kelas')
                        ->join('m_jurusan jrs', 'jrs.id = k.id_jurusan')
                        ->group_by(['j.id_kelas', 'j.semester', 'j.tahun_ajaran'])
                        ->order_by('k.nama', 'ASC')
                        ->get()->result();
    }

    // ===============================
    // GET DETAIL JADWAL PER KELAS
    // ===============================
    public function getJadwalDetail($id_kelas, $semester, $tahun_ajaran,$hari, $id_jam)
    {
        return $this->db->select('j.*, jp.waktu_mulai, jp.waktu_selesai, mp.name_mapel')
                        ->from('jadwal_pelajaran j')
                        ->join('jam_pelajaran jp', 'jp.id_jam = j.id_jam')
                        ->join('m_mapel mp', 'mp.id = j.id_mapel')
                        ->where([
                            'j.id_kelas'       => $id_kelas,
                            'j.semester'       => $semester,
                            'j.tahun_ajaran'   => $tahun_ajaran,
                            'j.hari' => $hari,
                            'j.id_jam'=>$id_jam
                        ])
                        ->order_by('j.id_jam', 'ASC')
                        ->get()->row_array();
    }

    // ===============================
    // GET JADWAL SISWA (BERDASARKAN KELAS)
    // ===============================
    public function getJadwalSiswa($id_kelas)
    {
        return $this->db->select('j.*, jp.jam_ke, jp.waktu_mulai, jp.waktu_selesai, mp.name_mapel')
                        ->from('jadwal_pelajaran j')
                        ->join('jam_pelajaran jp', 'jp.id_jam = j.id_jam')
                        ->join('m_mapel mp', 'mp.id = j.id_mapel')
                        ->where('j.id_kelas', $id_kelas)
                        ->order_by('jp.jam_ke', 'ASC')
                        ->get()->result();
    }

    // ===============================
    // INSERT DATA JADWAL
    // ===============================
    public function insertJadwal($data)
    {
        return $this->db->insert('jadwal_pelajaran', $data);
    }

    // ===============================
    // UPDATE DATA JADWAL
    // ===============================
    public function updateJadwal($id, $data)
    {
        return $this->db->update('jadwal_pelajaran', $data, ['id' => $id]);
    }

    // ===============================
    // DELETE JADWAL
    // ===============================
    public function deleteJadwal($id)
    {
        return $this->db->delete('jadwal_pelajaran', ['id' => $id]);
    }

    // ===============================
    // GET SEMUA KELAS (UNTUK DROPDOWN)
    // ===============================
    public function getKelas()
    {
        return $this->db->select('k.*, j.nama AS nama_jurusan')
                        ->from('m_kelas k')
                        ->join('m_jurusan j', 'j.id = k.id_jurusan')
                        ->order_by('k.nama', 'ASC')
                        ->get()->result();
    }

    // ===============================
    // GET MAPEL PER KELAS (UNTUK AJAX)
    // ===============================
    public function getMapelByKelas($id_kelas)
    {
        $mapel = $this->db->select('*')
                    ->from('m_mapel')
                    ->where('id_kelas', $id_kelas)
                    ->order_by('name_mapel', 'ASC')
                    ->get()
                    ->result();

        // fallback: jika tidak ada, ambil semua mapel
        if(empty($mapel)){
            $mapel = $this->db->order_by('name_mapel', 'ASC')->get('m_mapel')->result();
        }

        return $mapel;
    }



    // ===============================
    // GET SEMUA JAM PELAJARAN
    // ===============================
    public function getJam()
    {
        return $this->db->order_by('jam_ke', 'ASC')
                        ->get('jam_pelajaran')
                        ->result();
    }

    public function getJadwalHariIni($id_kelas, $hari)
    {
    return $this->db->select('jp.jam_ke, jp.waktu_mulai, jp.waktu_selesai, mp.name_mapel')
                    ->from('jadwal_pelajaran j')
                    ->join('jam_pelajaran jp','jp.id_jam = j.id_jam')
                    ->join('m_mapel mp','mp.id = j.id_mapel')
                    ->where('j.id_kelas', $id_kelas)
                    ->where('j.hari', $hari)
                    ->order_by('jp.jam_ke','ASC')
                    ->get()->result_array();
    }

}
