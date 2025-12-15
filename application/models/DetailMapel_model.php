<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DetailMapel_model extends CI_Model
{
    protected $table_mapel = 'm_mapel';
    protected $table_user  = 'user';
    protected $table_kelas = 'm_kelas';

    public function getMapelById($id)
    {
        $this->db->select("{$this->table_mapel}.*, {$this->table_kelas}.nama AS nama_kelas");
        $this->db->from($this->table_mapel);
        $this->db->join($this->table_kelas, "{$this->table_kelas}.id = {$this->table_mapel}.id_kelas", 'left');
        $this->db->where("{$this->table_mapel}.id", $id);
        return $this->db->get()->row_array();
    }

    public function getUserByEmail($email)
    {
        return $this->db->get_where($this->table_user, ['email' => $email])->row_array();
    }

    public function getDetailByMapel($id_mapel)
    {
        return $this->db->get_where('m_mapeldetail', ['id_mapel' => $id_mapel])->result_array();
    }
}
