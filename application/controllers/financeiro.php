<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Financeiro extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('db_model', 'model');
    date_default_timezone_set('america/sao_paulo');
    date_default_timezone_get();
  }

  public function index()
  {
    verifica_login();

    $vendas = $this->model->count_vendas(date('Y-m-d'));
    $custo = $this->model->select('custos');
    $valor = $this->model->select('custos', date('Y-m-d'));
    $capital = $this->model->select('entradas');
    $x = 0;
    $somaCapital = 0;
    if ($capital != 0) {
      foreach ($capital as $linha) {
        $somaCapital = $somaCapital + floatval($linha->valor);
      }
    }
    $somaCusto = 0;
    if ($custo != 0) {
      foreach ($custo as $linha) {
        $somaCusto = $somaCusto + $linha->valor;
      }
    }
    $somaValor = 0;
    if ($valor != 0) {
      foreach ($valor as $linha) {
        $somaValor = $somaValor + $linha->valor;
      }
    }
    $lucro = $somaCapital - $somaCusto;
    $func = $this->model->count('funcionarios', 'setor', 'Financeiro');
    $dados['vendas'] = $vendas->num;
    $dados['lucro'] = $lucro;
    $dados['custo'] = $somaCusto;
    $dados['valor'] = $somaValor;
    $dados['func'] = $func->num;
    $dados['titulo'] = 'Nome da Empresa';
    $dados['user'] = $this->session->userdata('user_name');
    $dados['tarefas'] = $this->model->get_tarefa($this->session->userdata('user_id'));
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

    $this->model->insert($dados, 'tarefas');

    redirect('financeiro/dashboard');
  }

  public function cadastro()
  {
    verifica_login();

    $dados['titulo'] = 'Nome do site';
    $dados['h2'] = 'Funcinarios de Estoque';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('financas/cadastro', $dados);
  }

  public function cad_custo()
  {
    verifica_login();

    $dados['titulo'] = 'Nome do site';
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
      if (!$this->model->TestaEmail($this->input->post('email'), 'funcionarios')) {
        //cria usuario com informações repassadas
        //cria vetor para encaminhar informações
        $dados = array('nome' => mb_strtoupper($this->input->post('nome'), 'UTF-8'), 'sobrenome' => mb_strtoupper($this->input->post('sobrenome'), 'UTF-8'), 'telefone' => $this->input->post('telefone'), 'cpf' => $this->input->post('cpf'), 'email' => $this->input->post('email'), 'setor' => $this->input->post('setor'), 'endereco' => $this->input->post('endereco'));

        $this->model->insert($dados, 'funcionarios');
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
      $this->model->insert($dados, 'custos');

      $retorno["msg"] = "Cadastro efetuado com sucesso!";

      $this->load->view('success', $retorno);
    }
  }

  public function custos_diario()
  {
    verifica_login();

    $custo = $this->model->select('custos', date('Y-m-d'));

    $dados['titulo'] = 'Nome do site';
    $dados['h2'] = 'Custos Diários';
    $dados['custo'] = $custo;
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('financas/custos', $dados);
  }

  public function custos_mensal()
  {
    verifica_login();

    $custo = $this->model->intervalo('custos', date('Y-m'));

    $dados['titulo'] = 'Nome do site';
    $dados['h2'] = 'Custos Mensal';
    $dados['custo'] = $custo;
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('financas/custos', $dados);
  }

  public function balanco()
  {
    verifica_login();

    $custo = $this->model->intervalo('custos', date('Y-m'));
    $capital = $this->model->intervalo('entradas', date('Y-m'));
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

    $dados['titulo'] = 'Nome do site';
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

    $dados['titulo'] = 'Nome do site';
    $dados['h2'] = 'Quadro de Funcionários do setor de finanças';
    $dados['func'] = $this->model->select('funcionarios');
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('financas/funcionarios', $dados);
  }
}
