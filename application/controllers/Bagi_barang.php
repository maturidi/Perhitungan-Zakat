<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bagi_barang extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('bagibarang_model');
		$this->load->library(array('form_validation', 'pagination'));
		if ($this->session->userdata('username') == FALSE) {
			$this->session->set_flashdata('message', 'Anda harus login');
			redirect(base_url());
		}
	}
	
	public function index()
	{
		$per_page = abs($this->input->get('per_page'));
		$dtp_awal = $this->input->get('awal');
		$dtp_akhir = $this->input->get('akhir');
		$limit = 2;
		$data['no'] = $per_page + 1;
		
		$data['list'] = $this->bagibarang_model->show($dtp_awal, $dtp_akhir, $limit, $per_page);
		$total_rows = $this->bagibarang_model->total_rows($dtp_awal, $dtp_akhir);
		
		$config['page_query_string'] 	= TRUE;
		$config['base_url'] 			= base_url().'bagi_barang/?awal='.$dtp_awal.'&akhir='.$dtp_akhir;
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
		
		$data['barang'] = $this->bagibarang_model->total_barang();
		$data['bagi_barang'] = $this->bagibarang_model->total_bagi_barang();
		foreach($data['barang']->result() as $row) {
			$t[] = $row->masuk;
		}
		foreach($data['bagi_barang']->result() as $row) {
			$b[] = $row->bagi;
		}
		$data['total'] = $t;
		$data['bagi'] = $b;
		
		
		$this->load->view('bagibarang/list', $data);
	}
	
	public function choose() {
		$this->session->unset_userdata('id_bagi');
		$data['id'] = $this->uri->segment(3);
		if ($data['id'] == FALSE) {
			$data['id'] = $this->input->get('id');
		}
		
		$per_page = abs($this->input->get('per_page'));
		$nama = $this->input->get('nama');
		$limit = 2;
		$data['no'] = $per_page + 1;
		
		$data['list'] = $this->bagibarang_model->show_mustahiq($nama, $limit, $per_page);
		$total_rows = $this->bagibarang_model->total_rows_mustahiq($nama);
		
		$config['page_query_string'] 	= TRUE;
		$config['base_url'] 			= base_url().'bagi_barang/choose?nama='.$nama.'&id='.$data['id'];
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
		
		$this->load->view('bagibarang/choose', $data);
	}
	
	public function choosed() {
		$id = $this->uri->segment(3);
		$id_bagibarang = $this->uri->segment(4);
		$this->session->set_flashdata('id_mustahiq', $id);
		if ($id_bagibarang == TRUE) {
			redirect(base_url('bagi_barang/show/'. $id_bagibarang));
		} else {
			redirect(base_url('bagi_barang/create'));
		}		
	}
	
	public function create() {
		$data['jenis_barang'] = $this->bagibarang_model->show_barang();
		$this->load->view('bagibarang/create', $data);
	}
	
	public function store() {
		$data['id_amil'] = $this->session->userdata('username');
		$data['id_mustahiq'] = $this->input->post('id_mustahiq');
		$data['id_jns_barang'] = $this->input->post('id_jns_barang');
		$data['tanggal_bagi'] = $this->input->post('tanggal_bagi');
		$data['bagi'] = $this->input->post('bagi');
		
		$this->form_validation->set_rules('id_mustahiq', 'ID Mustahiq', 'required');
		$this->form_validation->set_rules('tanggal_bagi', 'Tanggal Keluar', 'required');
		$this->form_validation->set_rules('bagi', 'Barang Keluar', 'required');
		
		if ($this->form_validation->run()) {
			$this->bagibarang_model->create($data);	
			redirect(base_url('bagi_barang'));
		}
		else {
			$data['jenis_barang'] = $this->bagibarang_model->show_barang();
			$this->load->view('bagibarang/create', $data);
		}
	}
	
	public function show() {
		$id = $this->uri->segment(3);
		$data['jenis_barang'] = $this->bagibarang_model->show_barang();
		$data['row'] = $this->bagibarang_model->first($id);
		$this->load->view('bagibarang/show', $data);
	}
	
	public function edit() {
		$data['id'] = $this->uri->segment(3);
		$data['id_amil'] = $this->session->userdata('username');
		$data['id_mustahiq'] = $this->input->post('id_mustahiq');
		$data['id_jns_barang'] = $this->input->post('id_jns_barang');
		$data['tanggal_bagi'] = $this->input->post('tanggal_bagi');
		$data['bagi'] = $this->input->post('bagi');
		
		$this->form_validation->set_rules('id_mustahiq', 'ID Mustahiq', 'required');
		$this->form_validation->set_rules('tanggal_bagi', 'Tanggal Keluar', 'required');
		$this->form_validation->set_rules('bagi', 'Barang Keluar', 'required');
		
		if ($this->form_validation->run()) {
			$this->bagibarang_model->edit($data);	
			redirect(base_url('bagi_barang'));
		}
		else {
			$data['jenis_barang'] = $this->bagibarang_model->show_barang();
			$data['row'] = FALSE;
			$this->load->view('bagibarang/show', $data);
		}
	}
	
	
	public function destroy() {
		$id = $this->uri->segment(3);
		$this->bagibarang_model->destroy($id);
		redirect(base_url('bagi_barang'));
	}
}
