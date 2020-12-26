<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller

{
	public function __construct()
	{
		Parent::__construct();
		// if ($this->session->userdata['email']){
		// 	redirect('auth');
		// }
		is_logged_in(); // helper
	}

	public function index()
	{
		//ambil session 
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata["email"]])->row_array();

		$data["title"] = "My Profile";
		// echo "selamat datang " . $data['user']['name'];
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('user/index', $data);
		$this->load->view('templates/footer', $data);
	}

	public function edit()
	{

		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata["email"]])->row_array();

		$data["title"] = "Edit Profile";
		// echo "selamat datang " . $data['user']['name'];
		$this->form_validation->set_rules('name', 'Name', 'required|trim');



		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('user/edit', $data);
			$this->load->view('templates/footer', $data);
		} else {

			$uploadImage = $_FILES["image"]["name"];

			if ($uploadImage) {
				$config['upload_path'] = './assets/img/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']     = '2048';

				$this->load->library('upload', $config);
				if ($this->upload->do_upload('image')) {
					$oldImage = $data["user"]["image"];

					//jika dia file sebelumnya default, jangan dihapus
					if ($oldImage != 'default.jpg') {
						unlink(FCPATH . "assets/img/" . $oldImage);
						//karena tidak bisa menggunakan base_url, gunakan fcpath
					}

					// ambil namanya
					$imageName = $this->upload->data('file_name');
					$this->db->set('image', $imageName);
				} else {
					echo $this->upload->display_errors;
				}
			}


			$name = $this->input->post('name');
			$email = $this->input->post('email');

			$this->db->set('name', $name);
			$this->db->where('email', $email);
			$this->db->update('user');

			$this->session->set_flashdata('flash', 'yipii, finally you update your account');
			redirect('user');
		}
	}

	public function change_pass()
	{
		//ambil session 
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata["email"]])->row_array();

		$data["title"] = "Change Password";

		$this->form_validation->set_rules('currentPass', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('newPass', 'New Password', 'required|trim|min_length[3]|matches[newPass2]', [
			'min_length' => "password too short",
			'matches' => "password didn't match"

		]);
		$this->form_validation->set_rules('newPass2', 'Confirm Password', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('user/change_pass', $data);
			$this->load->view('templates/footer', $data);
		} else {
			$currentPass = $this->input->post('currentPass');
			$newPassword = $this->input->post('newPass');
			$confirmPassword = $this->input->post('newPass2');

			if (!password_verify($currentPass, $data["user"]["password"])) {
				$this->session->set_flashdata('flash', 'youR current password is wrong');
				redirect('user/change_pass');
			} else {
				if ($currentPass == $newPassword) {
					$this->session->set_flashdata('flash', 'you can not fill the same password');
					redirect('user/change_pass');
				} else {

					$this->db->set('password', password_hash($newPassword, PASSWORD_DEFAULT));
					$this->db->where('email', $data['user']['email']);
					$this->db->update('user');

					$this->session->set_flashdata('flash', 'yipii, finally you update your password');
					redirect('user');
				}
			}
		}
	}
}
