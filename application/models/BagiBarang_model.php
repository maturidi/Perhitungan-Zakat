<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BagiBarang_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function total_rows($dtp_awal, $dtp_akhir) {
		if ($dtp_awal && $dtp_akhir) {
			$q = $this->db->query('select * from bagi_zakat as b join mustahiq as m on b.id_mustahiq = m.id_mustahiq join amil as a on b.id_amil = a.id_amil join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang where b.tanggal_bagi >= "'. $dtp_awal .'" and b.tanggal_bagi <= "'. $dtp_akhir .'"');
		} elseif($dtp_awal) {
			$q = $this->db->query('select * from bagi_zakat as b join mustahiq as m on b.id_mustahiq = m.id_mustahiq join amil as a on b.id_amil = a.id_amil join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang where b.tanggal_bagi >= "'. $dtp_awal .'"');
		} elseif($dtp_akhir) {
			$q = $this->db->query('select * from bagi_zakat as b join mustahiq as m on b.id_mustahiq = m.id_mustahiq join amil as a on b.id_amil = a.id_amil join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang where b.tanggal_bagi <= "'. $dtp_akhir .'"');
		} else {
			$q = $this->db->query('select * from bagi_zakat as b join mustahiq as m on b.id_mustahiq = m.id_mustahiq join amil as a on b.id_amil = a.id_amil join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang');
		}
		$num = $q->num_rows();
		return $num;
	}
	
	public function show($dtp_awal, $dtp_akhir, $limit, $per_page) {
		if ($dtp_awal && $dtp_akhir) {
			$q = $this->db->query('select * from bagi_zakat as b join mustahiq as m on b.id_mustahiq = m.id_mustahiq join amil as a on b.id_amil = a.id_amil join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang where b.tanggal_bagi >= "'. $dtp_awal .'" and b.tanggal_bagi <= "'. $dtp_akhir .'" order by b.tanggal_bagi DESC limit '.$limit.' offset '.$per_page);
		} elseif($dtp_awal) {
			$q = $this->db->query('select * from bagi_zakat as b join mustahiq as m on b.id_mustahiq = m.id_mustahiq join amil as a on b.id_amil = a.id_amil join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang where b.tanggal_bagi >= "'. $dtp_awal .'" order by b.tanggal_bagi DESC limit '.$limit.' offset '.$per_page);
		} elseif($dtp_akhir) {
			$q = $this->db->query('select * from bagi_zakat as b join mustahiq as m on b.id_mustahiq = m.id_mustahiq join amil as a on b.id_amil = a.id_amil join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang where b.tanggal_bagi <= "'. $dtp_akhir .'" order by b.tanggal_bagi DESC limit '.$limit.' offset '.$per_page);
		} else {
			$q = $this->db->query('select * from bagi_zakat as b join mustahiq as m on b.id_mustahiq = m.id_mustahiq join amil as a on b.id_amil = a.id_amil join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang order by b.tanggal_bagi DESC limit '.$limit.' offset '.$per_page);
		}
		return $q;
	}
	
	public function total_rows_mustahiq($nama) {
		$q = $this->db->query('select m.*, k.* from mustahiq as m join macam_mustahiq as k on m.id_kategori = k.id_macam where m.nama_mustahiq like "%'. $nama .'%"');
		$num = $q->num_rows();
		return $num;
	}
	
	public function show_mustahiq($nama, $limit, $per_page) {
		$q = $this->db->query('select m.*, k.* from mustahiq as m join macam_mustahiq as k on m.id_kategori = k.id_macam where m.nama_mustahiq like "%'. $nama .'%" limit '.$limit.' offset '.$per_page);
		return $q;
	}
	
	public function first($id) {
		$q = $this->db->query('select * from bagi_zakat as b join mustahiq as m on b.id_mustahiq = m.id_mustahiq join amil as a on b.id_amil = a.id_amil join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang where b.id_bagi = "'. $id .'"');
		$r = $q->row();
		return $r;
	}
	
	public function create($data) {
		$this->db->query('insert into bagi_zakat(id_bagi, id_amil, id_mustahiq, id_jns_barang, tanggal_bagi, bagi)
			values("", "'. $data['id_amil'] .'", "'. $data['id_mustahiq'] .'", "'. $data['id_jns_barang'] .'", "'. $data['tanggal_bagi'] .'", "'. $data['bagi'] .'")');
	}
	
	public function edit($data) {
		$this->db->query('update bagi_zakat set 
			id_amil="'. $data['id_amil'] .'",
			id_mustahiq="'. $data['id_mustahiq'] .'",
			id_jns_barang="'. $data['id_jns_barang'] .'",
			tanggal_bagi="'. $data['tanggal_bagi'] .'",
			bagi="'. $data['bagi'] .'"
			where id_bagi="'. $data['id'] .'"');
	}
	
	public function destroy($id) {
		$this->db->query('delete from bagi_zakat where id_bagi = "'.$id.'"');
	}
	
	public function show_barang() {
		$q = $this->db->query('select * from jenis_barang');
		return $q;
	}
	
	public function total_barang() {
		$q = $this->db->query('select jb.nama_jns_barang as "nama", jb.satuan_jns_barang as "satuan", sum(b.masuk) as "masuk" from barang as b right join jenis_barang as jb on b.id_jns_barang = jb.id_jns_barang GROUP by jb.id_jns_barang ORDER BY `jb`.`nama_jns_barang` ASC');
		return $q;
	}
	
	public function total_bagi_barang() {
		$q = $this->db->query('select jb.nama_jns_barang as "nama", jb.satuan_jns_barang as "satuan", sum(bz.bagi) as "bagi" from bagi_zakat as bz right join jenis_barang as jb on bz.id_jns_barang = jb.id_jns_barang GROUP by jb.id_jns_barang ORDER BY `jb`.`nama_jns_barang` ASC');
		return $q;
	}
}