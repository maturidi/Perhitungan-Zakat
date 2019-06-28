<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mustahiq extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('mustahiq_model');
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
		
		$data['list'] = $this->mustahiq_model->show($nama, $limit, $per_page);
		$total_rows = $this->mustahiq_model->total_rows($nama);
		
		$config['page_query_string'] 	= TRUE;
		$config['base_url'] 			= base_url().'mustahiq/?nama='.$nama;
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

		$this->load->view('mustaqih/list', $data);
	}
	
	public function create() {
		$data['macam'] = $this->mustahiq_model->macam();
		$this->load->view('mustaqih/create', $data);
	}
	
	public function store() {
		$data['nama'] = $this->input->post('nama');
		$data['alamat'] = $this->input->post('alamat');
		$data['umur'] = $this->input->post('umur');
		$data['jk'] = $this->input->post('jk');
		$data['macam'] = $this->input->post('macam');
		
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('umur', 'Umur', 'required');
		$this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('macam', 'Macam Mustahiq', 'required');
		
		if ($this->form_validation->run()) {
			$this->mustahiq_model->create($data);	
			redirect(base_url('mustahiq'));
		}
		else {
			$data['macam'] = $this->mustahiq_model->macam();
			$this->load->view('mustaqih/create', $data);
		}
	}
	
	public function show() {
		$id = $this->uri->segment(3);
		$data['row'] = $this->mustahiq_model->first($id);
		$data['macam'] = $this->mustahiq_model->macam();
		$this->load->view('mustaqih/show', $data);
	}
	
	public function edit() {
		$data['id'] = $this->uri->segment(3);
		$data['nama'] = $this->input->post('nama');
		$data['alamat'] = $this->input->post('alamat');
		$data['umur'] = $this->input->post('umur');
		$data['jk'] = $this->input->post('jk');
		$data['macam'] = $this->input->post('macam');
		
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('umur', 'Umur', 'required');
		$this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('macam', 'Macam Mustahiq', 'required');
		
		if ($this->form_validation->run()) {
			$this->mustahiq_model->edit($data);
			redirect(base_url('mustahiq'));
		}
		else {
			$data['row'] = FALSE;
			$data['macam'] = $this->mustahiq_model->macam();
			$this->load->view('mustaqih/show', $data);
		}
	}
	
	public function destroy() {
		$id = $this->uri->segment(3);
		$this->mustahiq_model->destroy($id);
		redirect(base_url('mustahiq'));
	}
}
