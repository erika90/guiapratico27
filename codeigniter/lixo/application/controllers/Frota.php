<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frota extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('frota_model');
		$this->load->model('modelos_model');
		$this->load->model('fabricantes_model');
	}
	
	public function index(){
		// var_dump($this->Books_model);
		// die;
		// $livros = $this->books_model->getBooksPDO();
		// $livros = $this->books_model->getBooksActiveRecord();
	
		/*
		$livros = $this->books_model->getBooksARQuery();
		var_dump($livros);
		foreach ($livros as $livro) {
			var_dump($livro);
		}
		*/
	
		/*
		if ($this->books_model->getBooksARSimpleQuery()) {
			echo "Simple query, Update-DONE!<br>";
		}
	 	*/
	
		// $livro = $this->books_model->getBooksByIdARBuilder(2);
		// $livro = $this->books_model->getBooksByIdARBuilder2(2);
		// var_dump($livro);
		/*
		$livros = $this->books_model->getBooksEditors();
		var_dump($livros);

		$autores = $this->authors_model->getAuthorByCountry(2);
		var_dump($autores);

		$autores2 = $this->authors_model->getAuthorByCountryName("Portugal");
		var_dump($autores2);
		*/
		/*
		if ($this->authors_model->create("Mário de Sá-Carneiro", "1890-5-19", 1)) {
			echo "Create-DONE!<br>";
		}
		*/
	
		/*
		$data = array(
		  array(
			'nome' => "Silva Abreu",
			'datanascimento' => "1988-04-05",
			'paises_id' => 1),
		  array(
			'nome' => "Maria Silva",
			'datanascimento' => "1978-04-03",
			'paises_id' => 1)
		  );
		
		echo $this->authors_model->createBatch($data) . "<br>";
		*/
		/*
		if ($this->authors_model->createBatch($data)) {
			echo "Create Batch-DONE!<br>";
		}
		*/
	
		/*
		$new_data = array('datanascimento' => '1986-03-08');
		echo 'updateAuthor:' . $this->authors_model->updateAuthor(2, $new_data) . "<br>";

		$data = array(
		  array(
			'nome' => "Silva Abreu",
			'datanascimento' => "1988-03-08"),
		  array(
			'nome' => "Maria Silva",
			'datanascimento' => "1978-03-08")
		  );

		echo 'updateAuthors:' . $this->authors_model->updateAuthors('nome', $data) . "<br>";

		echo 'deleteAuthor:' . $this->authors_model->deleteAuthor(8) . "<br>";
		die;
		*/
		// 2017-05-17
    	$this->load->helper('form');

		$offset = $this->input->get('offset') ?? 0;
		// Search criteria
		$search_criteria = array();
		$title  = $this->input->get('title')  ?? '';
		if ($title <> '') {
			$search_criteria['title'] = $title;
		}
		$author = $this->input->get('author') ?? '';
		if ($author <> '') {
			$search_criteria['author'] = $author;
		}
		// $search_criteria = array('title' => $title, 'author' => $author);
		// var_dump($search_criteria);
		// $search_criteria = array();
		// $search_criteria = array('author' => 'Pessoa');
		// $search_criteria = array('title' => 'Mensagem', 'author' => 'Pessoa');
		$search_result = $this->books_model->getBooksList($search_criteria, $offset);
		// var_dump($search_result);
		$data['title']  = $title;
		$data['author'] = $author;
		$data['search_results'] = $search_result;
		$data['search_results_count'] = $this->books_model->getBooksListCount($search_criteria);

		// Pagination
		$this->load->library('pagination');

		$form_url = "books/index";
		if (count($search_criteria) > 0) {
			$form_url .= '?' . http_build_query($search_criteria, '', '&');
		}
		$config['enable_query_strings'] = TRUE;
		$config['page_query_string'] 	= TRUE;
		$config['base_url'] = base_url($form_url);
		// $config['base_url'] = base_url("books/index/");
		$config['total_rows'] = $data['search_results_count'];
		$config['per_page'] = ITEMS_PER_PAGE;

		$this->pagination->initialize($config);
		$data['search_pagination'] = $this->pagination->create_links();

		// First and last record
		if ($data['search_results_count'] > 0) {
			$data['first_record'] = $offset + 1;
		} else {
			$data['first_record'] = 0;
		}
		$last_record = $offset + $config['per_page'];
		if ($last_record > $data['search_results_count']) {
			$last_record = $data['search_results_count'];
		}
		$data['last_record'] = $last_record;

		// Carregar view
		$data_modal = array();
   		$data_modal['editoras']    	= $this->editors_model->getAll();
    	$data_modal['autores']    	= $this->authors_model->getAll();
		$data_modal['active_menu'] 	= 'books';
		$data_modal['content']     	= 'books/create';
		$data['create_modal'] = $this->load->view('books/create', $data_modal, TRUE);


		$data['active_menu'] 	= 'books';
		$data['content']     	= 'books/index';
		$this->load->view('init', $data);
	}


	public function create(){
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
    		