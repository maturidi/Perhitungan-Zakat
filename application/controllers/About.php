<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

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
		
		
		$this->load->view('About', $data);
	}
	
	
}
