<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('amil_model');
	}

	public function index()
	{
		if ($this->session->userdata('username')) {
			$this->home();
		} else {
			$this->login();
		}
	}
	
	private function login() {
		$this->load->view('login');
	}
	
	private function home() {
		$this->load->view('home');
	}
	
	public function auth() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
			
		$auth = $this->amil_model->login($username, $password);
		
		if ($auth) {
			$this->session->set_userdata('username', $auth->id_amil);
			$this->session->set_userdata('nama', $auth->nama_amil);
		} else {
			$this->session->set_flashdata('message', 'Username dan Password salah');
		}
		
		redirect(base_url());
	}
	
	public function logout() {
		if ($this->session->userdata('id_barang') == TRUE) {
			$this->session->unset_userdata('id_barang');
		}
		
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('nama');
		redirect(base_url());
	}
}