<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusan_model extends CI_Model
{
    protected $table = 'm_jurusan';

    public function getAllJurusan()
    {
        return $this->db->get('m_jurusan')->result_array();
    }


    public function getJurusanById($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }
}

