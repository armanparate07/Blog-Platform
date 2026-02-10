<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login()
    {
        // FIX 1: If already logged in, redirect based on role
        if ($this->session->userdata('user_id')) {
            if ($this->session->userdata('role') === 'admin') {
                redirect('admin');
            } else {
                redirect('posts');
            }
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == TRUE) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $user = $this->User_model->login($email, $password);

                if ($user) {
                    $session_data = array(
                        'user_id'   => $user->id,
                        'username'  => $user->username,
                        'email'     => $user->email,
                        'role'      => $user->role,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($session_data);

                    $this->session->set_flashdata('success', 'Welcome back, ' . $user->username . '!');

                    // FIX 2: After login, redirect based on role
                    if ($user->role === 'admin') {
                        redirect('admin');
                    } else {
                        redirect('posts');
                    }

                } else {
                    $this->session->set_flashdata('error', 'Invalid email or password');
                }
            }
        }

        $this->load->view('auth/login');
    }

    public function register()
    {
        if ($this->session->userdata('user_id')) {
            if ($this->session->userdata('role') === 'admin') {
                redirect('admin');
            } else {
                redirect('posts');
            }
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[50]|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'username' => $this->input->post('username'),
                    'email'    => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'role'     => 'user'
                );

                if ($this->User_model->register($data)) {
                    $this->session->set_flashdata('success', 'Registration successful! Please login.');
                    redirect('login');
                } else {
                    $this->session->set_flashdata('error', 'Registration failed. Please try again.');
                }
            }
        }

        $this->load->view('auth/register');
    }

    public function logout()
    {
        $this->session->unset_userdata(array('user_id', 'username', 'email', 'role', 'logged_in'));
        $this->session->set_flashdata('success', 'You have been logged out successfully.');
        redirect('login');
    }
}
