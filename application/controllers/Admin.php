<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{ 
    public function __construct()
    {
        parent::__construct();
        is_logged_in(); // pastikan user login
    }

    public function index()
    {
        $data['title'] = 'Tombol untuk Mengirim Pengingat Pesan';
        $data['user'] = $this->db->get_where('user', 
            ['email' => $this->session->userdata('email')]
        )->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);

        // Dashboard utama admin → view yang benar
        $this->load->view('admin/admin', $data);

        $this->load->view('templates/footer');
    }


    public function role()  
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();  

        $data['role'] = $this->db->get('user_role')->result_array();

        // Validasi form tambah role
        $this->form_validation->set_rules('role', 'Role', 'required|trim');

        if ($this->form_validation->run() == false) {
            // Load halaman role jika belum submit atau validasi gagal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);  
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            // Jika validasi sukses, masukkan data baru ke tabel user_role
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New role added!</div>');
            redirect('admin/role');
        }
    }


    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }


    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Access Changed!</div>');
    }

     // Function to edit a role
    public function editrole($id)
    {
        $this->form_validation->set_rules('role', 'Role', 'required|trim');

        if ($this->form_validation->run() == false) {
            // Jika validasi gagal, redirect ke halaman role dengan pesan error (bisa Anda tambahkan)
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to update role. Please enter a role name.</div>');
            redirect('admin/role');
        } else {
            $role = $this->input->post('role');
            $this->db->set('role', $role);
            $this->db->where('id', $id);
            $this->db->update('user_role');

            $this->session->set_flashdata('message', '<div class="alert alert-success">Role updated successfully!</div>');
            redirect('admin/role');
        }
    }

    // Function to delete a role
    public function deleterole($id)
    {
        // Optional: jangan hapus role dengan id 1 (admin)
        if ($id == 1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Admin role cannot be deleted!</div>');
            redirect('admin/role');
        }

        $this->db->delete('user_role', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Role deleted successfully!</div>');
        redirect('admin/role');
    }

    public function admin()
    {
        $data['title'] = 'Tombol untuk Mengirim Pengingat Pesan';
        $data['user'] = $this->db->get_where('user', 
            ['email' => $this->session->userdata('email')]
        )->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);

        // Dashboard utama admin → tampilkan halaman ini
        $this->load->view('/admin', $data);

        $this->load->view('templates/footer');
    }
}