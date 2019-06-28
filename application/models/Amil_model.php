<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Amil_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function login($username, $password)	{
		$q = $this->db->query('select * from amil where username = "'. $username .'" and password = "'. $password .'"');
		$count = $q->num_rows();
		$r = $q->row();
		if ($count > 0) {
			return $r;
		} else {
			return false;
		}
	}
	
	public function total_rows($nama) {
		$q = $this->db->query('select * from amil where nama_amil like "%'. $nama .'%"');
		$num = $q->num_rows();
		return $num;
	}
	
	public function show($nama, $limit, $per_page) {
		$q = $this->db->query('select * from amil where nama_amil like "%'. $nama .'%" limit '.$limit.' offset '.$per_page);
		return $q;
	}
	
	public function first($id) {
		$q = $this->db->query('select * from amil where id_amil = "'. $id .'"');
		return $q;
	}
	
	public function username($id) {
		$q = $this->db->query('select * from amil where username = "'. $id .'"');
		return $q;
	}
	
	public function create($data) {
		$this->db->query('insert into amil(id_amil, nama_amil, alamat_amil, email_amil, tlp_amil, username, password)
			values("", "'. $data['nama'] .'", "'. $data['alamat'] .'", "'. $data['email'] .'", "'. $data['tlp'] .'", "'. $data['username'] .'", "'. $data['password'] .'")');
	}
	
	public function edit($data) {
		$this->db->query('update amil set 
			nama_amil="'. $data['nama'] .'",
			alamat_amil="'. $data['alamat'] .'",
			email_amil="'. $data['email'] .'",
			tlp_amil="'. $data['tlp'] .'",
			username="'. $data['username'] .'",
			password="'. $data['password'] .'"
			where id_amil="'. $data['id'] .'"');
	}
	
	public function destroy($id) {
		$this->db->query('delete from amil where id_amil = "'.$id.'"');
	}
}