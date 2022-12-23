<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('vendas_model', 'BDvendas');
		$this->load->model('custo_model', 'BDcusto');
		$this->load->model('caixa_model', 'BDcaixa');
		$this->load->model('funcionario_model', 'BDfuncionario');
		$this->load->model('produto_model', 'BDproduto');
		$this->load->model('usuario_model', 'BDusuario');
		$this->load->model('tarefa_model', 'BDtarefa');
    date_default_timezone_set('america/sao_paulo');
    date_default_timezone_get();
  }

  public function inserirTarefa()
  {
    verifica_login();

    $regras = array(
      array('field' => 'descricao', 'label' => 'Descrição', 'rules' => 'trim|required|min_length[10]|max_length[80]'),
      array('field' => 'setor', 'label' => 'Setor', 'rules' => 'trim|required'),
      array('field' => 'data', 'label' => 'Data', 'rules' => 'trim|required')
    );
    $this->form_validation->set_rules($regras);

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('error');
    } else {
      if ($this->input->post('setor') != 0) {
        //cria vetor para encaminhar informações
        $dados = array(
          'descricao' => $this->input->post('descricao'),
          'id_usuario' => $this->input->post('setor'),
          'data' => $this->input->post('data'),
        );

        $this->BDtarefa->insert($dados);

        $retorno["msg"] = "Cadastro efetuado com sucesso!";

        $this->load->view('success', $retorno);
      } else {
        echo '<div class="alert alert-warning alert-dismissible">';
        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        echo '<h4><i class="icon fa fa-warning"></i> Aten&ccedil;&atilde;o!</h4>';
        echo "Opção de setor inválida.";
        echo '</div>';
      }
    }
  }

  public function balanco()
  {
    verifica_login();

    if ($dados_form = $this->input->post()) {
      $data = $dados_form['ano'] . '-' . $dados_form['mes'];
      $custo = $this->BDcusto->intervalo($data);
      $capital = $this->BDentradas->intervalo($data);
    } else {
      $custo = $this->BDcusto->intervalo(date('Y-m'));
      $capital = $this->BDentradas->intervalo(date('Y-m'));
    }
    $x = 0;
    if ($custo != 0) {
      foreach ($custo as $linha) {
        $x++;
      }
    }
    $y = 0;
    if ($capital != 0) {
      foreach ($capital as $linha) {
        $y++;
      }
    }
    if ($x >= $y) {
      $num = $x;
    } else {
      $num = $y;
    }
    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Balanço Mensal';
    $dados['quant'] = $num;
    $dados['custo'] = $custo;
    $dados['capital'] = $capital;
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/balanco', $dados);
  }
}
