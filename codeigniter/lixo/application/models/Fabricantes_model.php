<?php

/**
 * Model to manage the authors from database
 */
class Fabricantes_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getAll() {
		return $this->db->select("id, nome")->from("fabricantes")->order_by("nome", "ASC")->get()->result();
	}


}

?>