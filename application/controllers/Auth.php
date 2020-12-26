<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        Parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('Display/index');
    }

    public function login()
    {

        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $data["title"] = "Login Page";
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');


        if ($this->form_validation->run() == FALSE) {

            $this->load->view('templates/auth_header', $data);
            $this->load->view('Auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            //validasi success
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // validasi email 

        if ($user) {

            //apakah akunnya actif ?
            if ($user["is_active"] == 1) {

                //apakah passwordnya sama 
                if (password_verify($password, $user["password"])) {

                    $data = [
                        'email' => $user["email"],
                        'role_id' => $user["role_id"]

                    ];

                    $this->session->set_userdata($data);

                    //lihat role_id 
                    if ($user["role_id"] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('flash', 'your password is wrong');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('flash', 'your account has not been activated');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('flash', 'email doesnt exist');
            redirect('auth/login');
        }
    }

    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $data["title"] = "Form Registration";

        $this->form_validation->set_rules('name', 'Name', 'required|trim'); // tanda | untuk menambah rules
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'your email already exist on database'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'min_length' => "passsword too short",
            'matches' => 'password didnt match'

        ]);
        $this->form_validation->set_rules('password2', 'Password2', 'required|trim');


        if ($this->form_validation->run() == FALSE) {

            $this->load->view('templates/auth_header', $data);
            $this->load->view('Auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = array(
                'name' => $this->input->post('name', true), // sama seperti $_POST
                'email' => $this->input->post('email', true),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1', true), PASSWORD_DEFAULT),
                'role_id' => '2',
                'is_active' => '0',
                'date_created' => time() // memannggil detik saat ini 
            );



            $token = base64_encode(random_bytes(32));

            $user_token = [
                'email' => $this->input->post('email'),
                'token' => $token,
                'data_created' => time()
            ];


            $this->db->insert('user_token', $user_token);

            $this->db->insert('user', $data);

            $this->_sendEmail($token, 'VERIFY');



            $this->session->set_flashdata('flash', 'yipii, finally you got a account');
            redirect('auth/login');
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'wiwagus15@gmail.com',
            'smtp_pass' => 'denpasar_2001',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"

        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('wiwagus15@gmail.com', 'dwik 2 lagi');
        $this->email->to($this->input->post('email'));


        if ($type === 'VERIFY') {
            $this->email->subject('User Activation');
            $this->email->message('please activate your account before you login. <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '" >Activated </a> ');
        } else {
            $this->email->subject('Forgot Password');
            $this->email->message('please, click this link to create a new Password. <a href="' . base_url() . 'auth/forgot?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '" >Create Password </a> ');
        }

        $this->email->send();
    }

    public function verify()
    {

        $email = $this->input->get('email');
        $token = $this->input->get('token');


        $user = $this->db->get_where('user_token', ['email' => $email])->row_array();

        if ($user) {

            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {

                if (time() - $user_token['data_created'] < 60 * 60 * 24) {

                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('flash', 'yeay, your account has been activated');
                    redirect('auth/login');
                } else {
                    $this->session->set_flashdata('flash', 'your time to activated is expired');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('flash', 'your emaill activated is wrong');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('flash', 'your email activated is wrong');
            redirect('auth/login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('flash', 'you have been logout');
        redirect('auth/login');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }



    public function forgotPassword()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $data["title"] = "Forgot Password";
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');


        if ($this->form_validation->run() == FALSE) {

            $this->load->view('templates/auth_header', $data);
            $this->load->view('Auth/forgotPassword');
            $this->load->view('templates/auth_footer');
        } else {

            $user = $this->db->get_where('user', ['email' => $this->input->post('email')])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));

                $user_token = [
                    'email' => $this->input->post('email'),
                    'token' => $token,
                    'data_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');
                $this->session->set_flashdata('flash', 'check your email and click the link');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('flash', 'you dont have an account');
                redirect('auth/forgotPassword');
            }
        }
    }
    public function forgot()
    {

        $email = $this->input->get('email');
        $token = $this->input->get('token');


        $user = $this->db->get_where('user_token', ['email' => $email])->row_array();

        if ($user) {

            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {

                if (time() - $user_token['data_created'] < 60 * 60 * 24) {

                    $this->session->set_userdata('reset_Pass', $email);
                    $this->reset_Pass();
                } else {
                    $this->session->set_flashdata('flash', 'your time to reset Password is expired');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('flash', 'your token reset is wrong');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('flash', 'your email resetPass is wrong');
            redirect('auth/login');
        }
    }

    public function reset_Pass()
    {

        if (!$this->session->userdata('reset_Pass')) {
            redirect('auth/login');
        }


        $data["title"] = "Change Password";

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'min_length' => "passsword too short",
            'matches' => 'password didnt match'

        ]);
        $this->form_validation->set_rules('password2', 'Password2', 'required|trim');


        if ($this->form_validation->run() == FALSE) {

            $this->load->view('templates/auth_header', $data);
            $this->load->view('Auth/changePassword');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1', true), PASSWORD_DEFAULT);
            $this->db->set('password', $password);
            $this->db->where('email', $this->session->userdata('reset_Pass'));
            $this->db->update('user');

            $this->db->delete('user_token', ['email' => $this->session->userdata('reset_Pass')]);

            $this->session->set_flashdata('flash', 'yipii, your password already changed');
            redirect('auth/login');
        }
    }
}
