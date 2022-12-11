<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produtos extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('produto_model', 'BDproduto');
		date_default_timezone_set('america/sao_paulo');
		date_default_timezone_get();
	}

	public function cadastrar(){
		$titulo['titulo'] = "All Tech";

		$this->load->view('header', $titulo);
		$this->load->view('menu', $titulo);
		$this->load->view('produtos/cadastrar');
		$this->load->view('footer');
	}

	public function gravar(){
		verifica_login();

		$regras = array(
			array('field' => 'nome', 'label' => 'Nome do Produto', 'rules' => 'trim|required|max_length[80]'),
			array('field' => 'quantidade', 'label' => 'Quantidade', 'rules' => 'trim|required|min_length[1]'),
			array('field' => 'preco', 'label' => 'Preço', 'rules' => 'trim|required|min_length[2]')
		);

		$this->form_validation->set_rules($regras);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('error');
		} else {
			//cria vetor para encaminhar informações
			$dados = array(
				'produto' => mb_strtoupper($this->input->post('nome')),
				'estoque' => intval($this->input->post('quantidade')),
				'preco' => floatval($this->input->post('preco')),
			);
			
			$this->BDproduto->insert($dados);

			$retorno["msg"] = "Cadastro efetuado com sucesso!";

			$this->load->view('success', $retorno);
		}
	}

	public function listar(){
		$dados['dados'] = $this->BDproduto->select();
		$dados['h2'] = "Lista de produtos";

		$titulo['titulo'] = "All Tech";

		$this->load->view('header', $titulo);
		$this->load->view('menu', $titulo);
		$this->load->view('produtos/listar', $dados);
		$this->load->view('footer');
	}

	public function editar($id){
		$dados['dados'] = $this->BDproduto->dados($id);
		$titulo['titulo'] = "All Tech";

		$this->load->view('header', $titulo);
		$this->load->view('menu', $titulo);
		$this->load->view('produtos/editar', $dados);
		$this->load->view('footer');
	}

	public function gravarEdicao(){
		verifica_login();

		$regras = array(
			array('field' => 'nome', 'label' => 'Nome do Produto', 'rules' => 'trim|required|max_length[80]'),
			array('field' => 'quantidade', 'label' => 'Quantidade', 'rules' => 'trim|required|min_length[1]'),
			array('field' => 'preco', 'label' => 'Preço', 'rules' => 'trim|required|min_length[2]')
		);

		$this->form_validation->set_rules($regras);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('error');
		} else {
			//cria vetor para encaminhar informações
			$dados = array(
				'id' => $this->input->post('id'),
				'produto' => mb_strtoupper($this->input->post('nome')),
				'estoque' => intval($this->input->post('quantidade')),
				'preco' => floatval($this->input->post('preco')),
			);
			
			$this->BDproduto->update($dados);

			$retorno["msg"] = "Cadastro efetuado com sucesso!";

			$this->load->view('success', $retorno);
		}
	}

	public function excluir(){
		verifica_login();

		$id = $this->input->post('id');

		$this->BDproduto->delete($id);
	}
}
