<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
	public function __construct(){
		Parent::__construct();
		// jika langsung masuk tanpa login
		// if (!$this->session->userdata['email']){
		// 	redirect('auth');
		// cara diatas boleh , atau menggunakan helper 
		// }
		is_logged_in();
		
	}

	public function index(){
		//ambil session 
		$data['user'] = $this->db->get_where('user',['email' => $this->session->userdata["email"]])->row_array();

		$query = $this->db->get('user_menu');
		$data["menu"] = $query->result_array();

		$data["title"] = "Menu Management";
		// $this->load->library('form_validation'); 
		// yang diatas bisa autoload di library
		$this->form_validation->set_rules('menu', 'Menu', 'required');

		if ($this->form_validation->run() == FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('menu/index', $data);
			$this->load->view('templates/footer', $data);
		}else {
			$data = array(
	        'menu' => $this->input->post('menu', true), // sama seperti $_POST
			);

			$this->db->insert('user_menu', $data);

			$this->session->set_flashdata('flash','ditambahkan');
			redirect('menu');
		}



		// echo "selamat datang " . $data['user']['name'];
		

	}

	public function submenu (){
		$data['user'] = $this->db->get_where('user',['email' => $this->session->userdata["email"]])->row_array();

		$this->load->model('Submenu_model', 'submenu');



		// $query = $this->db->get('user_sub_menu');
		$data["submenu"] = $this->submenu->addSubMenu();
		
		$query = $this->db->get('user_menu');
		$data["menu"] = $query->result_array();

		$data["title"] = "Submenu Management";
		// $this->load->library('form_validation'); 
		// yang diatas bisa autoload di library
		$this->form_validation->set_rules('menu_id', 'MenuId', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('url', 'Url', 'required');
		$this->form_validation->set_rules('icon', 'Icon', 'required');
		

		if ($this->form_validation->run() == FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('menu/submenu', $data);
			$this->load->view('templates/footer', $data);
		}else {
			$data = array(
	        'menu_id' => $this->input->post('menu_id', true),
	        'title' => $this->input->post('title', true),
	        'url' => $this->input->post('url', true),
	        'icon' => $this->input->post('icon', true),
	        'is_active' => $this->input->post('is_active', true),
			);

			$this->db->insert('user_sub_menu', $data);

			$this->session->set_flashdata('flash');
			redirect('menu/submenu');
		}

	}

}