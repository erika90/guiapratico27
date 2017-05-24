<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frota extends CI_Controller {

	private static $termos_pesquisa = array('Modelo', 'Matrícula', 'Fabricante'); 

	public function __construct(){
		parent::__construct();
		$this->load->model('frota_model');
		$this->load->model('modelos_model');
		$this->load->model('cores_model');
	}
	
	public function index(){
    	$this->load->helper('form');

		$offset = $this->input->get('offset') ?? 0;
		// Criterios de pesquisa
		$pesquisa = array();
		$modelo  = $this->input->get('modelo')  ?? '';
		if ($modelo <> '') {
			$pesquisa['modelo'] = $modelo;
		}
		$matricula = $this->input->get('matricula') ?? '';
		if ($matricula <> '') {
			$pesquisa['matricula'] = $matricula;
		}
		$fabricante = $this->input->get('fabricante') ?? '';
		if ($fabricante <> '') {
			$pesquisa['fabricante'] = $fabricante;
		}
		$resultado_pesquisa = $this->frota_model->getListaFrota($pesquisa, $offset);
		// var_dump($resultado_pesquisa);
		$data['fabricante'] = $fabricante;
		$data['modelo']  	= $modelo;
		$data['matricula']  = $matricula;
		$data['resultado_pesquisa'] = $resultado_pesquisa;
		$data['resultado_pesquisa_total'] = $this->frota_model->getListaFrotaTotal($pesquisa);

		// Pagination
		$this->load->library('pagination');

		$form_url = "frota/index";
		if (count($pesquisa) > 0) {
			$form_url .= '?' . http_build_query($pesquisa, '', '&');
		}
		$config['enable_query_strings'] = TRUE;
		$config['page_query_string'] 	= TRUE;
		$config['base_url'] = base_url($form_url);
		// $config['base_url'] = base_url("frota/index/");
		$config['total_rows'] = $data['resultado_pesquisa_total'];
		$config['per_page'] = ITEMS_POR_PAGINA;

		$this->pagination->initialize($config);
		$data['pesquisa_pagination'] = $this->pagination->create_links();

		// First and last record
		if ($data['resultado_pesquisa_total'] > 0) {
			$data['first_record'] = $offset + 1;
		} else {
			$data['first_record'] = 0;
		}
		$last_record = $offset + $config['per_page'];
		if ($last_record > $data['resultado_pesquisa_total']) {
			$last_record = $data['resultado_pesquisa_total'];
		}
		$data['last_record'] = $last_record;

/*
		// Carregar view
		$data_modal = array();
   		$data_modal['modelos']    	= $this->modelo_model->getAll();
    	$data_modal['cores']    	= $this->cores_model->getAll();
		$data_modal['active_menu'] 	= 'frota';
		$data_modal['content']     	= 'frota/create';
		$data['create_modal'] = $this->load->view('frota/create', $data_modal, TRUE);
*/

		$data['active_menu'] 	= 'frota';
		$data['content']     	= 'frota/index';
		$this->load->view('init', $data);
	}



	/**
	 * Endpoint for creating new frota
	 * @return [type] [description]
	 */
	/*
	public function createAjax(){
    	$this->load->helper('form');
    	$this->load->library('form_validation');

    	// $this->form_validation->set_error_delimiters('<div class="alert alert-success alert-dismissable">
  		//	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');

    	// $this->form_validation->set_rules('title', 'Title', 'required');
    	// $this->form_validation->set_rules('isbn',  'ISBN', 'required');
    	$config = array(
    		array(
    			'field' => 'title',
    			'label' => 'Titulo',
    			'rules' => 'required|alpha_numeric_spaces',
    			'errors' => array(
    				'required' => 'É obrigatório indicar o %s.',
    				'alpha_numeric_spaces' => 'O %s contém caracteres inválidos.'
    				)
    			),
    		array(
    			'field' => 'isbn',
    			'label' => 'ISBN',
    			'rules' => 'required|numeric|exact_length[13]|is_unique[livros.isbn]',
    			'errors' => array(
    				'required' => 'É obrigatório indicar o %s.',
    				'numeric'  => 'O %s só pode ter números.',
    				'exact_length' => 'O %s tem que ter 13 dígitos.',
    				'is_unique' => 'O %s indicado já foi associado a um livro existente.'
    				)
    			),
    		array(
    			'field' => 'pubDate',
    			'label' => 'data de publicação',
    			'rules' => 'regex_match[/^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$/]',
    			'errors' => array(
    				'regex_match' => 'A %s não tem o formato correcto dd/mm/aaaa.'
    				)
    			),
    		array(
    			'field' => 'editor',
    			'label' => 'editora',
    			// 'rules' => 'required|numeric',
    			'rules' => 'required|numeric|in_list[' . $this->editors_model->getAllId() . ']',
    			'errors' => array(
    				'required' => 'É obrigatório indicar a %s.',
    				'numeric'  => 'A %s só pode ter números.',
    				'in_list'  => 'Tem que indicar um dos seguintes valores: {param}'
    				)
    			),
    		array(
    			'field' => 'autores[]',
    			'label' => 'autor',
    			'rules' => 'required|numeric',
    			'errors' => array(
    				'required' => 'É obrigatório indicar o(s) %s(es).',
    				'numeric'  => 'O %s só pode ter números.'
    				)
    			)
    		);
    	$this->form_validation->set_rules($config);


		if($this->form_validation->run() === FALSE){
			//Show create view
			//	$data = array();
			$data['autores']  = $this->authors_model->getAll();
			$data['editoras'] = $this->editors_model->getAll();
			$form_status = false;
			$html_result = $this->load->view('frota/create',$data,TRUE);
		}else{
			//Add book to databse
			$form_status = true;
			$livro_id = $this->frota_model->create($this->input->post());
			$data['livro_id'] = $livro_id;
			$html_result = $this->load->view('frota/create_success',$data,TRUE);
		}

		$output = new stdClass();
		$output->success = $form_status;
		$output->html = $html_result;
		$this->output->set_content_type('application/json')
		->set_output(json_encode($output));

	}
	*/
}