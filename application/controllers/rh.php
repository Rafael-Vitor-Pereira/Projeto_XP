<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rh extends CI_Controller
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

    $func = $this->model->count('funcionarios');
    $dados['func'] = $func->num;
    $dados['titulo'] = 'Nome da Empresa';
    $dados['user'] = $this->session->userdata('user_name');
    $dados['tarefas'] = $this->model->get_tarefa($this->session->userdata('user_id'));
    $dados['h2'] = 'Setor de RH';
    $this->load->view('rh/dashboard', $dados);
  }

  public function inserirTarefa()
  {
    verifica_login();

    $dados_input = $this->input->post();

    $dados['descricao'] = $dados_input['descricao'];
    $dados['id_usuario'] = $this->session->userdata('user_id');
    $dados['data'] = $dados_input['data'];

    $this->model->insert($dados, 'tarefas');

    redirect('rh/dashboard');
  }

  public function cadastro()
  {
    verifica_login();

    $dados['titulo'] = 'Nome do site';
    $dados['h2'] = 'Funcinarios de RH';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('rh/cadastro', $dados);
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

  public function funcionarios()
  {
    verifica_login();

    $dados['titulo'] = 'Nome do site';
    $dados['h2'] = 'Quadro de Funcionários';
    $dados['func'] = $this->model->select('funcionarios');
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('rh/funcionarios', $dados);
  }

  public function excluir()
  {
    verifica_login();

    $id = $this->input->post('id');

    $this->model->delete($id);
  }

  public function editar($id)
  {
    $dados['func'] = $this->model->dados('funcionarios', $id);
    $dados['titulo'] = 'Nome do site';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('rh/editar', $dados);
  }

  public function gravar_editar()
  {
    verifica_login();

    $dados['func'] = $this->model->dados('funcionarios', $this->input->post('id'));
    //VERIFICAR REGRAS QUE SERAO UTILIZADAS
    $regras = array(
      array('field' => 'nome', 'label' => 'Nome', 'rules' => 'trim|required|min_length[3]|max_length[80]'),
      array('field' => 'sobrenome', 'label' => 'Sobrenome', 'rules' => 'trim|required|min_length[3]'),
      array('field' => 'email', 'label' => 'E-mail', 'rules' => 'trim|valid_email|required|max_length[255]'),
      array('field' => 'telefone', 'label' => 'Telefone', 'rules' => 'trim|required|min_length[16]|max_length[16]'),
      array('field' => 'endereco', 'label' => 'Endereço', 'rules' => 'trim|required|min_length[10]'),
      array('field' => 'setor', 'label' => 'Setor', 'rules' => 'trim|required|min_length[2]|max_length[15]')
    );
    $this->form_validation->set_rules($regras);

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('error');
    } else {
      //cria vetor para encaminhar informações
      $dados = array(
        'nome'   => mb_strtoupper($this->input->post('nome'), 'UTF-8'),
        'sobrenome'  => mb_strtoupper($this->input->post('sobrenome'), 'UTF-8'),
        'email'  => $this->input->post('email'),
        'telefone' => $this->input->post('telefone'),
        'endereco' => $this->input->post('endereco'),
        'setor' => $this->input->post('setor'),
        'id' => $this->input->post('id')
      );
      $this->model->update('funcionarios', $dados);

      $retorno["msg"] = "Cadastro alterado com sucesso!";

      $this->load->view('success_noreset', $retorno);
    }
  }
}
