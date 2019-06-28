<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function total_rows($nama) {
		$q = $this->db->query('select * from barang as b join muzaki as m on b.id_muzaki = m.id_muzaki join amil as a on b.id_amil = a.id_amil join jenis_zakat as jz on b.id_jenis = jz.id_jenis join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang where m.nama_muzaki like "%'. $nama .'%" order by b.tgl_masuk DESC');
		$num = $q->num_rows();
		return $num;
	}
	
	public function show($nama, $limit, $per_page) {
		$q = $this->db->query('select * from barang as b join muzaki as m on b.id_muzaki = m.id_muzaki join amil as a on b.id_amil = a.id_amil join jenis_zakat as jz on b.id_jenis = jz.id_jenis join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang where m.nama_muzaki like "%'. $nama .'%" order by b.tgl_masuk DESC limit '.$limit.' offset '.$per_page);
		return $q;
	}
	
	public function first($id) {
		$q = $this->db->query('select * from barang where id_barang = "'. $id .'"');
		$r = $q->row();
		return $r;
	}
	
	public function create($data) {
		$this->db->query('insert into barang(id_barang, id_muzaki, id_amil, id_jenis, id_jns_barang, masuk, tgl_masuk)
			values("", "'. $data['id_muzaki'] .'", "'. $data['id_amil'] .'", "'. $data['id_jenis'] .'", "'. $data['id_jns_barang'] .'", "'. $data['masuk'] .'", "'. $data['tgl_masuk'] .'")');
	}
	
	public function edit($data) {
		$this->db->query('update barang set 
			id_muzaki="'. $data['id_muzaki'] .'",
			id_amil="'. $data['id_amil'] .'",
			id_jenis="'. $data['id_jenis'] .'",
			id_jns_barang="'. $data['id_jns_barang'] .'",
			masuk="'. $data['masuk'] .'",
			tgl_masuk="'. $data['tgl_masuk'] .'"
			where id_barang="'. $data['id'] .'"');
	}
	
	public function destroy($id) {
		$this->db->query('delete from barang where id_barang = "'.$id.'"');
	}
	
	public function show_zakat() {
		$q = $this->db->query('select * from jenis_zakat');
		return $q;
	}
	
	public function show_barang() {
		$q = $this->db->query('select * from jenis_barang');
		return $q;
	}
	
	public function total_rows_muzaki($nama) {
		$q = $this->db->query('select * from muzaki where nama_muzaki like "%'. $nama .'%"');
		$num = $q->num_rows();
		return $num;
	}
	
	public function show_muzaki($nama, $limit, $per_page) {
		$q = $this->db->query('select * from muzaki where nama_muzaki like "%'. $nama .'%" limit '.$limit.' offset '.$per_page);
		return $q;
	}
	
	public function total_barang() {
		$q = $this->db->query('select jb.nama_jns_barang as "nama", jb.satuan_jns_barang as "satuan", sum(b.masuk) as "total" from barang as b join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang GROUP by jb.id_jns_barang ORDER BY `jb`.`nama_jns_barang` ASC');
		return $q;
	}
}