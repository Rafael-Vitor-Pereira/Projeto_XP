<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custo extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
	$this->load->model('custo_model', 'BDcusto');
    date_default_timezone_set('america/sao_paulo');
    date_default_timezone_get();
  }

  public function cadastrar(){
		verifica_login();

		$titulo['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');

		$this->load->view('header', $titulo);
		$this->load->view('menu', $titulo);
    $this->load->view('custos/cadastrar', $dados);
		$this->load->view('footer');
  }

  public function gravar(){
	verifica_login();

    $regras = array(
      array('field' => 'tipo', 'label' => 'Tipo custo', 'rules' => 'trim|required'),
      array('field' => 'valor', 'label' => 'Valor', 'rules' => 'trim|required')
    );
    $this->form_validation->set_rules($regras);

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('error');
    } else {
      //cria vetor para encaminhar informações
      $dados = array(
        'cod' => $this->input->post('tipo'),
        'valor' => floatval($this->input->post('valor'))
      );
      $this->BDcusto->insert($dados);

      $retorno["msg"] = "Informação gravada com sucesso!";

      $this->load->view('success', $retorno);
    }
  }

  public function editar($id){
		verifica_login();

		$dados['dados'] = $this->BDcusto->selectPorId($id);

		$titulo['titulo'] = 'All Tech';

		$this->load->view('header', $titulo);
		$this->load->view('menu', $titulo);
		$this->load->view('custos/editar', $dados);
		$this->load->view('footer');
  }

  public function gravarEdicao(){
		verifica_login();

		$regras = array(
			array('field' => 'tipo', 'label' => 'Tipo do custo', 'rules' => 'trim|required'),
			array('field' => 'valor', 'label' => 'Valor do custo', 'rules' => 'trim|required')
		);
		$this->form_validation->set_rules($regras);

		if($this->form_validation->run() == false){
			$this->load->view('error');
		}else{
			$dados = array(
				'id' => $this->input->post('id'),
				'cod' => $this->input->post('tipo'),
				'data_edicao' => date('Y-m-d'),
				'valor' => floatval($this->input->post('valor'))
			);
			$this->BDcusto->update($dados);

			$retorno['msg'] = 'Informação atualizada com sucesso!';

			$this->load->view('success', $retorno);
		}
  }

  public function listar(){
	verifica_login();

    $dados['titulo'] = 'All Tech';
    $dados['h2'] = 'Custos Diários';
		$dados['mensal'] = false;
    $dados['custo'] = $this->BDcusto->select(date('Y-m-d'));
    $dados['user'] = $this->session->userdata('user_name');
    
		$this->load->view('header', $dados);
  	$this->load->view('menu', $dados);
    $this->load->view('custos/listar', $dados);
		$this->load->view('footer');
  }

  public function listarMensal(){
	verifica_login();

    if ($dados_form = $this->input->post()) {
      $data = $dados_form['ano'] . '-' . $dados_form['mes'];
      $custo = $this->BDcusto->intervalo($data);
    } else {
      $custo = $this->BDcusto->intervalo(date('Y-m'));
    }

    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Custos Mensais';
		$dados['mensal'] = true;
    $dados['custo'] = $custo;
    $dados['user'] = $this->session->userdata('user_name');

		$this->load->view('header', $dados);
  	$this->load->view('menu', $dados);
    $this->load->view('custos/listar', $dados);
		$this->load->view('footer');
  }

  public function excluir(){
		verifica_login();

		$id = $this->input->post('id');

		$this->BDcusto->excluir($id);
  }
}
