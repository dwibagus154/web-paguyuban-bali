<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function __construct()
	{
		Parent::__construct();
		// jika langsung masuk tanpa login
		// if (!$this->session->userdata['email']){
		// 	redirect('auth');
		// cara diatas boleh , atau menggunakan helper 
		// }
		is_logged_in();
	}

	public function index()
	{
		//ambil session 
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata["email"]])->row_array();

		$data["title"] = "Dashboard";
		// echo "selamat datang " . $data['user']['name'];
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/footer', $data);
	}

	public function role()
	{
		//ambil session 
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata["email"]])->row_array();

		$query = $this->db->get('user_role');
		$data["role"] = $query->result_array();

		$data["title"] = "Role";
		// $this->load->library('form_validation'); 
		// yang diatas bisa autoload di library
		$this->form_validation->set_rules('role', 'Role', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/role', $data);
			$this->load->view('templates/footer', $data);
		} else {
			$data = array(
				'role' => $this->input->post('role', true), // sama seperti $_POST
			);

			$this->db->insert('user_role', $data);

			$this->session->set_flashdata('flash', 'ditambahkan');
			redirect('admin/role');
		}



		// echo "selamat datang " . $data['user']['name'];


	}
	public function access($role_id)
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata["email"]])->row_array();

		$data["role"] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();


		//ambil menu
		$query = $this->db->where('id !=', 1);
		$query = $this->db->get('user_menu');
		$data["menu"] = $query->result_array();


		$data["title"] = "user access";

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/access', $data);
		$this->load->view('templates/footer', $data);
	}

	public function changeaccess()
	{

		$menuId = $this->input->post('menuId');
		$roleId = $this->input->post('roleId');

		$data = [
			'role_id' => $roleId,
			'menu_id' => $menuId

		];
		// var_dump($roleId);die;

		$result = $this->db->get_where('user_access_menu', $data);

		if ($result->num_rows() < 1) {
			$this->db->insert('user_access_menu', $data);
		} else {
			$this->db->delete('user_access_menu', $data);
		}
	}
}
