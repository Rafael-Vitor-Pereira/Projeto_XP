<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model', 'BDusuario');
		date_default_timezone_set('america/sao_paulo');
		date_default_timezone_get();
	}

	public function cadastrar(){
		verifica_login();

		$dados['titulo'] = 'All Tech';

		$this->load->view('header',$dados);
		$this->load->view('menu',$dados);
		$this->load->view('usuario/cadastrar', $dados);
		$this->load->view('footer');
	}

	public function gravar(){
		verifica_login();

		$regras = array(
			array('field' => 'nome', 'label' => 'Nome', 'rules' => 'trim|required|max_length[80]'),
			array('field' => 'sobrenome', 'label' => 'Sobrenome', 'rules' => 'trim|required|max_length[80]'),
			array('field' => 'telefone', 'label' => 'Telefone', 'rules' => 'trim|required'),
			array('field' => 'cpf', 'label' => 'CPF', 'rules' => 'trim|required'),
			array('field' => 'senha', 'label' => 'Senha', 'rules' => 'trim|required|min_length[6]'),
			array('field' => 'login', 'label' => 'Login', 'rules' => 'trim|required|min_length[3]'),
			array('field' => 'email', 'label' => 'E-mail', 'rules' => 'trim|valid_email|required|max_length[255]'),
			array('field' => 'acesso', 'label' => 'Acesso', 'rules' => 'trim|required'),
			array('field' => 'cep', 'label' => 'CEP', 'rules' => 'trim|required'),
			array('field' => 'numero', 'label' => 'Número', 'rules' => 'trim|required')
		);
		$this->form_validation->set_rules($regras);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('error');
		} else {
			//se não existir usuário com esse e-mail, grava
			if (!$this->BDusuario->TestaEmail($this->input->post('email'))) {
				//cria usuario com informações repassadas
				//cria vetor para encaminhar informações
				$dados = array(
					'nome' => mb_strtoupper($this->input->post('nome'), 'UTF-8'), 
					'sobrenome' => mb_strtoupper($this->input->post('sobrenome'), 'UTF-8'),
					'telefone' => $this->input->post('telefone'),
					'CPF' => $this->input->post('cpf'),
					'email'   => $this->input->post('email'),
					'senha' => password_hash($this->input->post('senha'), PASSWORD_DEFAULT),
					'login' => $this->input->post('login'),
					'acesso' => $this->input->post('acesso'),
					'CEP' => $this->input->post('cep'),
					'logradouro' => $this->input->post('logradouro'),
					'numero' => $this->input->post('numero'),
					'complemento' => $this->input->post('complemento'),
					'bairro' => $this->input->post('bairro'),
					'cidade' => $this->input->post('cidade'),
					'estado' => $this->input->post('estado')
				);
				$this->BDusuario->insert($dados);

				$retorno["msg"] = "Cadastro efetuado com sucesso!";

				$this->load->view('success', $retorno);
			} else {
				echo '<div class="alert alert-warning alert-dismissible">';
				echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				echo '<h4><i class="icon fa fa-warning"></i> Aten&ccedil;&atilde;o!</h4>';
				echo "Já existe um usuário com o e-mail informado.";
				echo '</div>';
			}
		}
	}

	public function listar(){
		$dados['dados'] = $this->BDusuario->select();
		$dados['h2'] = "Lista de Usuários";
		$titulo['titulo'] = 'All Tech';

		$this->load->view('header', $titulo);
		$this->load->view('menu', $titulo);
		$this->load->view('usuario/listar', $dados);
		$this->load->view('footer');
	}

	public function status(){
		verifica_login();

    	$id = $this->input->post('id');
    	$status = $this->BDusuario->selectStatus($id);
    	if ($status->status) {
      		$dados['status'] = 0;
      		$dados['id'] = $id;
      		$this->BDusuario->update($dados);
      		echo "<i class='fa fa-toggle-off'></i> Inativo";
    	} else {
      		$dados['status'] = 1;
      		$dados['id'] = $id;
      		$this->BDusuario->update($dados);
      		echo "<i class='fa fa-toggle-on'></i> Ativo";
    	}
	}

	public function info($id){
		$dados['dados'] = $this->BDusuario->dados($id);
		$dados['h2'] = "Dados do funcionário";
		$titulo['titulo'] = 'All Tech';

		print_r($dados['dados']);

		$this->load->view('header', $titulo);
		$this->load->view('menu', $titulo);
		$this->load->view('usuario/info', $dados);
		$this->load->view('footer');
	}

	public function editar($id){
		$dados['dados'] = $this->BDusuario->dados($id);
		$titulo['titulo'] = "All Tech";

		$this->load->view('header', $titulo);
		$this->load->view('menu', $titulo);
		$this->load->view('usuario/editar', $dados);
		$this->load->view('footer');
	}

	public function gravarEdicao(){
		verifica_login();

		$regras = array(
			array('field' => 'nome', 'label' => 'Nome', 'rules' => 'trim|required|max_length[80]'),
			array('field' => 'sobrenome', 'label' => 'Sobrenome', 'rules' => 'trim|required|max_length[80]'),
			array('field' => 'telefone', 'label' => 'Telefone', 'rules' => 'trim|required'),
			array('field' => 'login', 'label' => 'Login', 'rules' => 'trim|required|min_length[3]'),
			array('field' => 'email', 'label' => 'E-mail', 'rules' => 'trim|valid_email|required|max_length[255]'),
			array('field' => 'acesso', 'label' => 'Acesso', 'rules' => 'trim|required'),
			array('field' => 'cep', 'label' => 'CEP', 'rules' => 'trim|required'),
			array('field' => 'numero', 'label' => 'Número', 'rules' => 'trim|required')
		);
		$this->form_validation->set_rules($regras);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('error');
		} else {
			//se não existir usuário com esse e-mail, grava
			$result = $this->BDusuario->TestaEmail($this->input->post('email'));
			if(is_null($result)) {
				if($this->input->post('senha') == ''){
					$dados = array(
						'id' => $this->input->post('id'),
						'nome' => mb_strtoupper($this->input->post('nome'), 'UTF-8'), 
						'sobrenome' => mb_strtoupper($this->input->post('sobrenome'), 'UTF-8'),
						'telefone' => $this->input->post('telefone'),
						'email'   => $this->input->post('email'),
						'login' => $this->input->post('login'),
						'acesso' => $this->input->post('acesso'),
						'CEP' => $this->input->post('cep'),
						'logradouro' => $this->input->post('logradouro'),
						'numero' => $this->input->post('numero'),
						'complemento' => $this->input->post('complemento'),
						'bairro' => $this->input->post('bairro'),
						'cidade' => $this->input->post('cidade'),
						'estado' => $this->input->post('estado')
					);
				} else {
					$dados = array(
						'id' => $this->input->post('id'),
						'nome' => mb_strtoupper($this->input->post('nome'), 'UTF-8'),
						'sobrenome' => mb_strtoupper($this->input->post('sobrenome'), 'UTF-8'),
						'telefone' => $this->input->post('telefone'),
						'email' => $this->input->post('email'),
						'senha' => password_hash($this->input->post('senha'), PASSWORD_DEFAULT),
						'login' => $this->input->post('login'),
						'acesso' => $this->input->post('acesso'),
						'CEP' => $this->input->post('cep'),
						'logradouro' => $this->input->post('logradouro'),
						'numero' => $this->input->post('numero'),
						'complemento' => $this->input->post('complemento'),
						'bairro' => $this->input->post('bairro'),
						'cidade' => $this->input->post('cidade'),
						'estado' => $this->input->post('estado')
					);
				}
				$this->BDusuario->update($dados);

				$retorno["msg"] = "Usuário editado com sucesso!";

				$this->load->view('success', $retorno);
			} else {
				if($result->id == $this->input->post('id')){
					if($this->input->post('senha') == ''){
						$dados = array(
							'id' => $this->input->post('id'),
							'nome' => mb_strtoupper($this->input->post('nome'), 'UTF-8'), 
							'sobrenome' => mb_strtoupper($this->input->post('sobrenome'), 'UTF-8'),
							'telefone' => $this->input->post('telefone'),
							'email'   => $this->input->post('email'),
							'login' => $this->input->post('login'),
							'acesso' => $this->input->post('acesso'),
							'CEP' => $this->input->post('cep'),
							'logradouro' => $this->input->post('logradouro'),
							'numero' => $this->input->post('numero'),
							'complemento' => $this->input->post('complemento'),
							'bairro' => $this->input->post('bairro'),
							'cidade' => $this->input->post('cidade'),
							'estado' => $this->input->post('estado')
						);
					} else {
						$dados = array(
							'id' => $this->input->post('id'),
							'nome' => mb_strtoupper($this->input->post('nome'), 'UTF-8'),
							'sobrenome' => mb_strtoupper($this->input->post('sobrenome'), 'UTF-8'),
							'telefone' => $this->input->post('telefone'),
							'email' => $this->input->post('email'),
							'senha' => password_hash($this->input->post('senha'), PASSWORD_DEFAULT),
							'login' => $this->input->post('login'),
							'acesso' => $this->input->post('acesso'),
							'CEP' => $this->input->post('cep'),
							'logradouro' => $this->input->post('logradouro'),
							'numero' => $this->input->post('numero'),
							'complemento' => $this->input->post('complemento'),
							'bairro' => $this->input->post('bairro'),
							'cidade' => $this->input->post('cidade'),
							'estado' => $this->input->post('estado')
						);
					}
					$this->BDusuario->update($dados);
	
					$retorno["msg"] = "Usuário editado com sucesso!";
	
					$this->load->view('success', $retorno);
				} else {
					echo '<div class="alert alert-warning alert-dismissible">';
					echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					echo '<h4><i class="icon fa fa-warning"></i> Aten&ccedil;&atilde;o!</h4>';
					echo "Já existe um usuário com o e-mail informado.";
					echo '</div>';
				}
			}
		}
	}

	public function excluir(){
		verifica_login();

		$id = $this->input->post('id');

		$this->BDusuario->delete($id);
	}
}
