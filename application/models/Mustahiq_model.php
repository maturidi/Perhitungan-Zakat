<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mustahiq_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function total_rows($nama) {
		$q = $this->db->query('select m.*, k.* from mustahiq as m join macam_mustahiq as k on m.id_kategori = k.id_macam where m.nama_mustahiq like "%'. $nama .'%"');
		$num = $q->num_rows();
		return $num;
	}
	
	public function show($nama, $limit, $per_page) {
		$q = $this->db->query('select m.*, k.* from mustahiq as m join macam_mustahiq as k on m.id_kategori = k.id_macam where m.nama_mustahiq like "%'. $nama .'%" limit '.$limit.' offset '.$per_page);
		return $q;
	}
	
	public function macam() {
		$q = $this->db->query('select * from macam_mustahiq');
		return $q;
	}
	
	public function first($id) {
		$q = $this->db->query('select * from mustahiq where id_mustahiq = "'. $id .'"');
		$r = $q->row();
		return $r;
	}
	
	public function create($data) {
		$this->db->query('insert into mustahiq(id_mustahiq, id_kategori, nama_mustahiq, umur_mustahiq, jk_mustahiq, alamat_mustahiq)
			values("", "'. $data['macam'] .'", "'. $data['nama'] .'", "'. $data['umur'] .'", "'. $data['jk'] .'", "'. $data['alamat'] .'")');
	}
	
	public function edit($data) {
		$this->db->query('update mustahiq set 
			id_kategori="'. $data['macam'] .'",
			nama_mustahiq="'. $data['nama'] .'",
			umur_mustahiq="'. $data['umur'] .'",
			jk_mustahiq="'. $data['jk'] .'",
			alamat_mustahiq="'. $data['alamat'] .'"
			where id_mustahiq="'. $data['id'] .'"');
	}
	
	public function destroy($id) {
		$this->db->query('delete from mustahiq where id_mustahiq = "'.$id.'"');
	}
}