<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Financeiro extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('vendas_model', 'BDvendas');
		$this->load->model('custo_model', 'BDcusto');
		$this->load->model('entrada_model', 'BDentrada');
    date_default_timezone_set('america/sao_paulo');
    date_default_timezone_get();
  }

  public function index()
  {
    verifica_login();

    $vendas = $this->BDvendas->count(date('Y-m-d'));
    
    $somaCapital = soma_valores($this->BDentrada->select());
    $somaCusto = soma_valores($this->BDcusto->select());
    $somaValor = soma_valores($this->BDcusto->select(date('Y-m-d')));

    $lucro = $somaCapital - $somaCusto;
    $func = $this->BDfuncionario->count('setor', 'Financeiro');
    $dados['vendas'] = $vendas->num;
    $dados['lucro'] = $lucro;
    $dados['custo'] = $somaCusto;
    $dados['valor'] = $somaValor;
    $dados['func'] = $func->num;
    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $dados['tarefas'] = $this->BDtarefa->select($this->session->userdata('user_id'));
    $dados['h2'] = "Setor Financeiro";
    $this->load->view('financas/dashboard', $dados);
  }

  public function inserirTarefa()
  {
    verifica_login();

    $dados_input = $this->input->post();

    $dados['descricao'] = $dados_input['descricao'];
    $dados['id_usuario'] = $this->session->userdata('user_id');
    $dados['data'] = $dados_input['data'];

    $this->BDtarefa->insert($dados);

    redirect('financeiro/dashboard');
  }

  public function cadastro()
  {
    verifica_login();

    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Funcinarios de Estoque';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('financas/cadastro', $dados);
  }

  public function cad_custo()
  {
    verifica_login();

    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('financas/cad_custo', $dados);
  }

  public function gravar()
  {
    verifica_login();

    $regras = array(
      array('field' => 'nome', 'label' => 'Nome', 'rules' => 'trim|required|max_length[80]'),
      array('field' => 'sobrenome', 'label' => 'Sobrenome', 'rules' => 'trim|required|max_length[80]'),
      array('field' => 'telefone', 'label' => 'Telefone', 'rules' => 'trim|required'),
      array('field' => 'cpf', 'label' => 'CPF', 'rules' => 'trim|required'),
      array('field' => 'endereco', 'label' => 'Endereço', 'rules' => 'trim|required'),
      array('field' => 'email', 'label' => 'E-mail', 'rules' => 'trim|valid_email|required|max_length[255]')
    );
    $this->form_validation->set_rules($regras);
    if ($this->form_validation->run() == FALSE) {
      $this->load->view('error');
    } else {
      //se não existir usuário com esse e-mail, grava
      if (!$this->BDfuncionario->TestaEmail($this->input->post('email'))) {
        //cria usuario com informações repassadas
        //cria vetor para encaminhar informações
        $dados = array('nome' => mb_strtoupper($this->input->post('nome'), 'UTF-8'), 'sobrenome' => mb_strtoupper($this->input->post('sobrenome'), 'UTF-8'), 'telefone' => $this->input->post('telefone'), 'cpf' => $this->input->post('cpf'), 'email' => $this->input->post('email'), 'setor' => $this->input->post('setor'), 'endereco' => $this->input->post('endereco'));

        $this->BDfuncionario->insert($dados);
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

  public function grava_custo()
  {
    verifica_login();

    $regras = array(
      array('field' => 'cod', 'label' => 'Tipo custo', 'rules' => 'trim|required'),
      array('field' => 'valor', 'label' => 'Valor', 'rules' => 'trim|required'),
    );
    $this->form_validation->set_rules($regras);
    if ($this->form_validation->run() == FALSE) {
      $this->load->view('error');
    } else {
      //cria vetor para encaminhar informações
      $dados = array(
        'cod' => intval($this->input->post('cod')),
        'valor' => floatval($this->input->post('valor'))
      );
      $this->BDcusto->insert($dados);

      $retorno["msg"] = "Cadastro efetuado com sucesso!";

      $this->load->view('success', $retorno);
    }
  }

  public function custos_diario()
  {
    verifica_login();

    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Custos Diários';
    $dados['custo'] = $this->BDcusto->select(date('Y-m-d'));
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('financas/custos', $dados);
  }

  public function custos_mensal()
  {
    verifica_login();

    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Custos Mensal';
    $dados['custo'] = $this->BDcusto->intervalo(date('Y-m'));
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('financas/custos', $dados);
  }

  public function balanco()
  {
    verifica_login();

    $custo = $this->BDcusto->intervalo(date('Y-m'));
    $capital = $this->BDentrada->intervalo(date('Y-m'));
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
    $this->load->view('financas/balanco', $dados);
  }

  public function funcionarios()
  {
    verifica_login();

    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Quadro de Funcionários do setor de finanças';
    $dados['func'] = $this->BDfuncionario->select();
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('financas/funcionarios', $dados);
  }
}
