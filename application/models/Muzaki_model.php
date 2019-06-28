<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muzaki_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function total_rows($nama) {
		$q = $this->db->query('select * from muzaki where nama_muzaki like "%'. $nama .'%"');
		$num = $q->num_rows();
		return $num;
	}
	
	public function show($nama, $limit, $per_page) {
		$q = $this->db->query('select * from muzaki where nama_muzaki like "%'. $nama .'%" limit '.$limit.' offset '.$per_page);
		return $q;
	}
	
	public function first($id) {
		$q = $this->db->query('select * from muzaki where id_muzaki = "'. $id .'"');
		$r = $q->row();
		return $r;
	}
	
	public function create($data) {
		$this->db->query('insert into muzaki(id_muzaki, nama_muzaki, alamat_muzaki, tlp_muzaki, jk_muzaki)
			values("", "'. $data['nama'] .'", "'. $data['alamat'] .'", "'. $data['tlp'] .'", "'. $data['jk'] .'")');
	}
	
	public function edit($data) {
		$this->db->query('update muzaki set 
			nama_muzaki="'. $data['nama'] .'",
			alamat_muzaki="'. $data['alamat'] .'",
			tlp_muzaki="'. $data['tlp'] .'",
			jk_muzaki="'. $data['jk'] .'"
			where id_muzaki="'. $data['id'] .'"');
	}
	
	public function destroy($id) {
		$this->db->query('delete from muzaki where id_muzaki = "'.$id.'"');
	}
}