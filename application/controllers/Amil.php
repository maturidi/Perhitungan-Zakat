<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Amil extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('amil_model');
		$this->load->library(array('form_validation', 'pagination'));
		
		if ($this->session->userdata('username') == FALSE) {
			$this->session->set_flashdata('message', 'Anda harus login');
			redirect(base_url());
		}
	}
	
	public function index()
	{
		$per_page = abs($this->input->get('per_page'));
		$nama = $this->input->get('nama');
		$limit = 2;
		$data['no'] = $per_page + 1;
		
		$data['list'] = $this->amil_model->show($nama, $limit, $per_page);
		$total_rows = $this->amil_model->total_rows($nama);
		
		$config['page_query_string'] 	= TRUE;
		$config['base_url'] 			= base_url().'amil/?nama='.$nama;
		$config['total_rows'] 			= $total_rows;
		$config['per_page'] 			= $limit;
		$config['num_links']			= 10;
		
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="next page">';
		$config['first_tag_close'] = '</li>';
		
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="prev page">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$this->load->view('amil/list', $data);
	}
	
	public function create() {
		$this->load->view('amil/create');
	}
	
	public function store() {
		$data['nama'] = $this->input->post('nama');
		$data['alamat'] = $this->input->post('alamat');
		$data['email'] = $this->input->post('email');
		$data['tlp'] = $this->input->post('tlp');
		$data['username'] = $this->input->post('username');
		$data['password'] = $this->input->post('password');
		$data['retype-password'] = $this->input->post('retype-password');
		
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('tlp', 'No. Telepon', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[retype-password]');
		$this->form_validation->set_rules('retype-password', 'Retype Password', 'required|matches[password]');
		
		if ($this->form_validation->run()) {
			$username = $this->amil_model->username($data['username']);
			$count = $username->num_rows();
			if ($count == 0) {
				$this->amil_model->create($data);	
			} else {
				$this->session->set_flashdata('message', 'Username sudah ada silahkan ulangi lagi');
			}
			
			redirect('amil');
		}
		else {
			$this->load->view('amil/create');
		}
	}
	
	public function show() {
		$id = $this->uri->segment(3);
		$data['row'] = $this->amil_model->first($id)->row();
		$this->load->view('amil/show', $data);
	}
	
	public function edit() {	
		$data['id'] = $this->uri->segment(3);
		$data['nama'] = $this->input->post('nama');
		$data['alamat'] = $this->input->post('alamat');
		$data['email'] = $this->input->post('email');
		$data['tlp'] = $this->input->post('tlp');
		$data['username'] = $this->input->post('username');
		$data['password'] = $this->input->post('password');
		$data['retype-password'] = $this->input->post('retype-password');
		
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('tlp', 'No. Telepon', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[retype-password]');
		$this->form_validation->set_rules('retype-password', 'Retype Password', 'required|matches[password]');
		
		if ($this->form_validation->run()) {
			$username = $this->amil_model->username($data['username']);
			$first = $this->amil_model->first($data['id']);
			$row = $first->row();
			$count = $username->num_rows();
			if ($count == 0) {
				$this->amil_model->edit($data);
			} else {
				if ($row->username == $data['username']) {
					$this->amil_model->edit($data);
				} else {
					$this->session->set_flashdata('message', 'Username sudah ada silahkan ulangi lagi');
				}
			}
			redirect('amil');
		}
		else {
			$data['row'] = FALSE;
			$this->load->view('amil/show', $data);
		}
	}
	
	public function destroy() {
		$id = $this->uri->segment(3);
		$this->amil_model->destroy($id);
		redirect('amil');
	}
}
