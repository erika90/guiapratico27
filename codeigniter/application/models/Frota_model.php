<?php

/**
 * Model to manage the frota lists from database
 */
class Frota_model extends CI_Model{

	private $pdo;

	public function __construct(){
		parent::__construct();
		$this->load->database();
		// var_dump($this->db);
		$this->pdo = $this->db->conn_id;
	}


	/**
	 * Obtem o total de registos da lista da frota resultado da pesquisa
	 * @param  array  $pesquisa  pesquisa
	 * @return int           	 total de registos da pesquisa
	 */
	public function getListaFrotaTotal(array $pesquisa = array()): int {
		$this->db->select("a.id, f.nome AS fabricante, m.nome AS modelo, c.nome AS cor, a.matricula, a.disponibilidade")
				 ->from("automoveis AS a")
				 ->join("cores c", "a.cor_id = c.id", "left")
				 ->join("modelos m", "a.modelo_id = m.id", "left")
				 ->join("fabricantes f", "m.fabricante_id = f.id", "left");
	
		if($pesquisa['fabricante'] ?? false) {
			$this->db->like("fabricante",  $pesquisa['fabricante']);
		}
	
		if($pesquisa['matricula'] ?? false) {
			$this->db->like("matricula",  $pesquisa['matricula']);
		}

		if($pesquisa['modelo'] ?? false) {
			$this->db->like("modelo",  $pesquisa['modelo']);
		}

		return $this->db->count_all_results();
	}


	/**
	 * Get frota list 
	 * @param  array  $pesquisa  pesquisa
	 * @return array             lista com os automoveis da frota
	 */
	public function getListaFrota(array $pesquisa = array(), int $offset = 0, int $limit = ITEMS_POR_PAGINA): array {
		$this->db->select("a.id, f.nome AS fabricante, m.nome AS modelo, c.nome AS cor, a.matricula, a.disponibilidade")
				 ->from("automoveis AS a")
				 ->join("cores c", "a.cor_id = c.id", "left")
				 ->join("modelos m", "a.modelo_id = m.id", "left")
				 ->join("fabricantes f", "m.fabricante_id = f.id", "left")
				 ->limit($limit, $offset);

	
		if($pesquisa['fabricante'] ?? false) {
			$this->db->like("fabricante",  $pesquisa['fabricante']);
		}
	
		if($pesquisa['matricula'] ?? false) {
			$this->db->like("matricula",  $pesquisa['matricula']);
		}

		if($pesquisa['modelo'] ?? false) {
			$this->db->like("modelo",  $pesquisa['modelo']);
		}

		return $this->db->get()->result();
	}

}

?>