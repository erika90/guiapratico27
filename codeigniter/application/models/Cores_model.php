<?php

/**
 * Model to manage the authors from database
 */
class Cores_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getAll() {
		return $this->db->select("id, nome")->from("cores")->order_by("nome", "ASC")->get()->result();
	}

	public function getAllIds() {
		$resultado = $this->db->select("GROUP_CONCAT(id) AS ids")->from("cores")->get()->row_array();
		return $resultado['ids'];
	}
}

?>