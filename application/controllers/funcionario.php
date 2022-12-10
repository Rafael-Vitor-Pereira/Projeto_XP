<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Funcionario extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('funcionario_model', 'BDfuncionario');
		date_default_timezone_set('america/sao_paulo');
		date_default_timezone_get();
	}

	public function cadastrar(){
		verifica_login();

		$titulo['titulo'] = 'All tech';
		$dados['user'] = $this->session->userdata('user_name');

		$this->load->view('header', $titulo);
		$this->load->view('menu', $titulo);
		$this->load->view('funcionario/cadastrar', $dados);
		$this->load->view('footer');
	}

	public function gravar(){
		verifica_login();

		$regras = array(
			array('field' => 'nome', 'label' => 'Nome', 'rules' => 'trim|required|min_length[3]'),
			array('field' => 'sobrenome', 'label' => 'Sobrenome', 'rules' => 'trim|required|min_length[3]'),
			array('field' => 'telefone', 'label' => 'Telefone', 'rules' => 'trim|required'),
			array('field' => 'cpf', 'label' => 'CPF', 'rules' => 'trim|required'),
			array('field' => 'email', 'label' => 'E-mail', 'rules' => 'trim|required'),
			array('field' => 'cep', 'label' => 'CEP', 'rules' => 'trim|required'),
			array('field' => 'logradouro', 'label' => 'Logradouro', 'rules' => 'trim|required'),
			array('field' => 'numero', 'label' => 'Número', 'rules' => 'trim|required'),
			array('field' => 'bairro', 'label' => 'Bairro', 'rules' => 'trim|required'),
			array('field' => 'cidade', 'label' => 'Cidade', 'rules' => 'trim|required'),
			array('field' => 'estado', 'label' => 'Estado', 'rules' => 'trim|required'),
			array('field' => 'setor', 'label' => 'Setor', 'rules' => 'trim|required')
		);
		$this->form_validation->set_rules($regras);

		if ($this->form_validation->run() == FALSE) {
		$this->load->view('error');
		} else {
			//cria vetor para encaminhar informações
			$dados = array(
				'nome' => strtoupper($this->input->post('nome')),
				'sobrenome' => strtoupper($this->input->post('sobrenome')),
				'cpf' => $this->input->post('cpf'),
				'telefone' => $this->input->post('telefone'),
				'email' => $this->input->post('email'),
				'CEP' => $this->input->post('cep'),
				'logradouro' => $this->input->post('logradouro'),
				'numero' => $this->input->post('numero'),
				'complemento' => $this->input->post('complemento'),
				'bairro' => $this->input->post('bairro'),
				'cidade' => $this->input->post('cidade'),
				'estado' => $this->input->post('estado'),
				'setor' => $this->input->post('setor'),
			);
			$this->BDfuncionario->insert($dados);

			$retorno["msg"] = "Informação gravada com sucesso!";

			$this->load->view('success', $retorno);
		}
	}

	public function editar($id){
			verifica_login();

			$dados['dados'] = $this->BDfuncionario->dados($id);

			$titulo['titulo'] = 'All Tech';

			$this->load->view('header', $titulo);
			$this->load->view('menu', $titulo);
			$this->load->view('funcionario/editar', $dados);
			$this->load->view('footer');
	}

	public function gravarEdicao(){
		verifica_login();

		$regras = array(
			array('field' => 'nome', 'label' => 'Nome', 'rules' => 'trim|required|min_length[3]'),
			array('field' => 'sobrenome', 'label' => 'Sobrenome', 'rules' => 'trim|required|min_length[3]'),
			array('field' => 'telefone', 'label' => 'Telefone', 'rules' => 'trim|required'),
			array('field' => 'cpf', 'label' => 'CPF', 'rules' => 'trim|required'),
			array('field' => 'email', 'label' => 'E-mail', 'rules' => 'trim|required'),
			array('field' => 'cep', 'label' => 'CEP', 'rules' => 'trim|required'),
			array('field' => 'logradouro', 'label' => 'Logradouro', 'rules' => 'trim|required'),
			array('field' => 'numero', 'label' => 'Número', 'rules' => 'trim|required'),
			array('field' => 'bairro', 'label' => 'Bairro', 'rules' => 'trim|required'),
			array('field' => 'cidade', 'label' => 'Cidade', 'rules' => 'trim|required'),
			array('field' => 'estado', 'label' => 'Estado', 'rules' => 'trim|required'),
			array('field' => 'setor', 'label' => 'Setor', 'rules' => 'trim|required')
		);
		$this->form_validation->set_rules($regras);
		if($this->form_validation->run() == false){
			$this->load->view('error');
		}else{
			$dados = array(
				'id' => $this->input->post('id'),
				'nome' => strtoupper($this->input->post('nome')),
				'sobrenome' => strtoupper($this->input->post('sobrenome')),
				'cpf' => $this->input->post('cpf'),
				'telefone' => $this->input->post('telefone'),
				'email' => $this->input->post('email'),
				'CEP' => $this->input->post('cep'),
				'logradouro' => $this->input->post('logradouro'),
				'numero' => $this->input->post('numero'),
				'complemento' => $this->input->post('complemento'),
				'bairro' => $this->input->post('bairro'),
				'cidade' => $this->input->post('cidade'),
				'estado' => $this->input->post('estado'),
				'setor' => $this->input->post('setor'),
			);
			$this->BDfuncionario->update($dados);

			$retorno['msg'] = 'Informação atualizada com sucesso!';
			$this->load->view('success', $retorno);
		}
	}

	public function listar(){
		verifica_login();

		$dados['titulo'] = 'All Tech';
		$dados['h2'] = 'Lista de funcionários';
		$dados['func'] = $this->BDfuncionario->select();
		
		$this->load->view('header', $dados);
		$this->load->view('menu', $dados);
		$this->load->view('funcionario/listar', $dados);
		$this->load->view('footer');
	}

	public function info($id){
		verifica_login();

		$dados['titulo'] = 'All Tech';
		$dados['h2'] = 'Informações do funcionário';
		$dados['dados'] = $this->BDfuncionario->dados($id);
		
		$this->load->view('header', $dados);
		$this->load->view('menu', $dados);
		$this->load->view('funcionario/info', $dados);
		$this->load->view('footer');
	}

	public function excluir(){
			verifica_login();

			$id = $this->input->post('id');

			$this->BDfuncionario->delete($id);
	}
}
