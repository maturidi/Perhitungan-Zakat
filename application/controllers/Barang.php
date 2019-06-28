<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('barang_model');
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
		
		$data['total'] = $this->barang_model->total_barang();
		$data['list'] = $this->barang_model->show($nama, $limit, $per_page);
		$total_rows = $this->barang_model->total_rows($nama);
		
		$config['page_query_string'] 	= TRUE;
		$config['base_url'] 			= base_url().'barang/?nama='.$nama;
		$config['total_rows'] 			= $total_rows;
		$config['per_page'] 			= $limit;
		$config['num_links']			= 10;
		
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		
		$this->load->view('barang/list', $data);
	}
	
	public function choose() {
		$this->session->unset_userdata('id_barang');
		$data['id'] = $this->uri->segment(3);
		if ($data['id'] == FALSE) {
			$data['id'] = $this->input->get('id');
		}
		
		$per_page = abs($this->input->get('per_page'));
		$nama = $this->input->get('nama');
		$limit = 2;
		$data['no'] = $per_page + 1;
		
		$data['list'] = $this->barang_model->show_muzaki($nama, $limit, $per_page);
		$total_rows = $this->barang_model->total_rows_muzaki($nama);
		
		$config['page_query_string'] 	= TRUE;
		$config['base_url'] 			= base_url().'barang/choose?nama='.$nama.'&id='.$data['id'];
		$config['total_rows'] 			= $total_rows;
		$config['per_page'] 			= $limit;
		$config['num_links']			= 10;
		
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		
		$this->load->view('barang/choose', $data);
	}
	
	public function choosed() {
		$id = $this->uri->segment(3);
		$id_barang = $this->uri->segment(4);
		$this->session->set_flashdata('id_muzaki', $id);
		if ($id_barang == TRUE) {
			redirect(base_url('barang/show/'. $id_barang));
		} else {
			redirect(base_url('barang/create'));
		}		
	}
	
	public function create() {
		$data['jenis_zakat'] = $this->barang_model->show_zakat();
		$data['jenis_barang'] = $this->barang_model->show_barang();
		$this->load->view('barang/create', $data);
	}
	
	public function store() {
		$data['id_muzaki'] = $this->input->post('id_muzaki');
		$data['id_amil'] = $this->session->userdata('username');
		$data['id_jenis'] = $this->input->post('id_jenis');
		$data['id_jns_barang'] = $this->input->post('id_jns_barang');
		$data['masuk'] = $this->input->post('masuk');
		$data['tgl_masuk'] = $this->input->post('tgl_masuk');
		
		$this->form_validation->set_rules('id_muzaki', 'ID Muzaki', 'required');
		$this->form_validation->set_rules('masuk', 'Barang Masuk', 'required');
		$this->form_validation->set_rules('tgl_masuk', 'Tanggal Masuk', 'required');
		
		if ($this->form_validation->run()) {
			$this->barang_model->create($data);	
			redirect(base_url('barang'));
		}
		else {
			$data['jenis_zakat'] = $this->barang_model->show_zakat();
			$data['jenis_barang'] = $this->barang_model->show_barang();
			$this->load->view('barang/create', $data);
		}
	}
	
	public function show() {
		$id = $this->uri->segment(3);
		$data['jenis_zakat'] = $this->barang_model->show_zakat();
		$data['jenis_barang'] = $this->barang_model->show_barang();
		$data['row'] = $this->barang_model->first($id);
		$this->load->view('barang/show', $data);
	}
	
	public function edit() {
		$data['id'] = $this->uri->segment(3);
		$data['id_muzaki'] = $this->input->post('id_muzaki');
		$data['id_amil'] = $this->session->userdata('username');
		$data['id_jenis'] = $this->input->post('id_jenis');
		$data['id_jns_barang'] = $this->input->post('id_jns_barang');
		$data['masuk'] = $this->input->post('masuk');
		$data['tgl_masuk'] = $this->input->post('tgl_masuk');
		
		$this->form_validation->set_rules('id_muzaki', 'ID Muzaki', 'required');
		$this->form_validation->set_rules('masuk', 'Barang Masuk', 'required');
		$this->form_validation->set_rules('tgl_masuk', 'Tanggal Masuk', 'required');
		
		if ($this->form_validation->run()) {
			$this->barang_model->edit($data);	
			redirect(base_url('barang'));
		}
		else {
			$id = $this->uri->segment(3);
			$data['jenis_zakat'] = $this->barang_model->show_zakat();
			$data['jenis_barang'] = $this->barang_model->show_barang();
			$data['row'] = FALSE;
			$this->load->view('barang/show', $data);
		}
	}
	
	public function destroy() {
		$id = $this->uri->segment(3);
		$this->barang_model->destroy($id);
		redirect(base_url('barang'));
	}
}
