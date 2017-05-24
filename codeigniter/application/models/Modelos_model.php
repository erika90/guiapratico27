<?php

/**
 * Model to manage the authors from database
 */
class Modelos_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getAll() {
		return $this->db->select("id, nome")->from("modelos")->order_by("nome", "ASC")->get()->result();
	}

	public function getAllIds() {
		$result = $this->db->select("GROUP_CONCAT(id) AS ids")->from("modelos")->get()->row_array();
		// var_dump($result);
		return $result['ids'];
	}

}
