<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public $form_validation;
    public $db;
    public $session;
    public $menu;
    public $input;

    public function __construct()
    {
       parent ::__construct();
       is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if($this->form_validation->run() == false ) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('menu');
        }
    }

     // Fungsi Edit Menu
    public function edit($id)
    {
        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Menu name cannot be empty!</div>');
            redirect('menu');
        } else {
            $menu = $this->input->post('menu', true);
            $this->db->where('id', $id);
            $this->db->update('user_menu', ['menu' => $menu]);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu has been updated!</div>');
            redirect('menu');
        }
    }

    // Fungsi Hapus Menu
    public function delete($id)
    {
        $this->db->delete('user_menu', ['id' => $id]);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu has been deleted!</div>');
        redirect('menu');
    }



    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getsubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New sub menu added!</div>');
            redirect('menu/submenu');
        }
    }

    // Fungsi Edit Submenu
    public function editsubmenu($id)
    {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">All fields are required!</div>');
            redirect('menu/submenu');
        } else {
            $data = [
                'title' => $this->input->post('title', true),
                'menu_id' => $this->input->post('menu_id', true),
                'url' => $this->input->post('url', true),
                'icon' => $this->input->post('icon', true),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];

            $this->db->where('id', $id);
            $this->db->update('user_sub_menu', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu updated successfully!</div>');
            redirect('menu/submenu');
        }
    }

    // Fungsi Hapus Submenu
    public function deletesubmenu($id)
    {
        $this->db->delete('user_sub_menu', ['id' => $id]);

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Submenu deleted successfully!</div>');
        redirect('menu/submenu');
    }
   
}


