<?php
defined('BASEPATH') or exit('No direct script access allowed');

class auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		}
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
			'valid_email' => 'Email harus valid'
		]);
		$this->form_validation->set_rules('password', 'Password', 'trim|required', [
			'required' => 'Password required'
		]);

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Login';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		if ($user) {
			if (password_verify($password, $user['password'])) {
				$data = [
					'email' => $user['email'],
					'role_id' => $user['role_id']
				];
				$this->session->set_userdata($data);
				if ($user['role_id'] == 1) {
					redirect('tamu');
				} else {
					redirect('tamu');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				  Password Salah	
				</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			<div>
			  Email belum terdaftar	
			</div>');
			redirect('auth');
		}
	}

	public function registration()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		}
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
			'is_unique' => 'Email sudah terisi'
		]);
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8] |matches[password2]', [
			'matches' => 'Password tidak sama',
			'min_length' => 'Password to short'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');


		if ($this->form_validation->run() == false) {
			$data['title'] = 'registration';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/registration');
			$this->load->view('templates/auth_footer');
		} else {
			$data = [
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' => 2,
				'date_created' => time()
			];
			$this->db->insert('user', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			<div>
			  Berhasil registrasi
			</div>
		  ');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			<div>
			  Berhasil logout
			</div>
		  ');
		redirect('tamu');
	}

	public function block()
	{
		$this->load->view('block/blokir');
	}
}
