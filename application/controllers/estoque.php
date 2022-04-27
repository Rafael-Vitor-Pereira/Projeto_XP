<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Estoque extends CI_Controller
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
    $prod = $this->model->count('produtos');
    $func = $this->model->count('funcionarios', 'setor', 'Estoque');
    $vm = $this->model->intervalo('vendas', date('Y-m'));
    $x = 0;
    if ($vm != 0) {
      foreach ($vm as $linha) {
        $x++;
      }
    }
    $dados['prod'] = $prod->num;
    $dados['vendas'] = $vendas->num;
    $dados['vendas_mensal'] = $x;
    $dados['func'] = $func->num;
    $dados['titulo'] = 'Nome da Empresa';
    $dados['id'] = $this->session->userdata('user_id');
    $dados['user'] = $this->session->userdata('user_name');
    $dados['tarefas'] = $this->model->get_tarefa($this->session->userdata('user_id'));
    $dados['h2'] = 'Controle de Estoque';
    $this->load->view('estoque/dashboard', $dados);
  }

  public function cad_prod()
  {
    verifica_login();

    $dados['titulo'] = 'Nome do Site';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('estoque/cad_prod', $dados);
  }

  public function vender()
  {
    $dados['titulo'] = 'Nome do site';
    $dados['h2'] = 'Cadastro de venda de produtos';
    $dados['prod'] = $this->model->select('produtos');
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('estoque/vender', $dados);
  }

  public function grava_prod()
  {
    verifica_login();

    $regras = array(
      array('field' => 'produto', 'label' => 'Produto', 'rules' => 'trim|required|max_length[80]'),
      array('field' => 'estoque', 'label' => 'Estoque', 'rules' => 'trim|required|min_length[1]'),
      array('field' => 'preco', 'label' => 'Preço', 'rules' => 'trim|required|min_length[2]'),
    );
    $this->form_validation->set_rules($regras);

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('error');
    } else {
      //cria vetor para encaminhar informações
      $dados = array(
        'produto' => $this->input->post('produto'),
        'estoque' => intval($this->input->post('estoque')),
        'preco' => floatval($this->input->post('preco')),
      );
      $this->model->insert($dados, 'produtos');

      $retorno["msg"] = "Cadastro efetuado com sucesso!";

      $this->load->view('success', $retorno);
    }
  }

  public function grava_venda()
  {
    verifica_login();

    $prod = $this->model->dados('produtos', $this->input->post('produto'));

    $regras = array(
      array('field' => 'produto', 'label' => 'Produto', 'rules' => 'trim|required'),
      array('field' => 'quantidade', 'label' => 'Quantidade', 'rules' => 'trim|required|min_length[2]')
    );
    $this->form_validation->set_rules($regras);

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('error');
    } else {
      if ($prod->estoque >= $this->input->post('quantidade')) {
        //cria vetor para encaminhar informações
        $dados = array(
          'id_prod' => $this->input->post('produto'),
          'quant' => intval($this->input->post('quantidade')),
          'valor' => floatval($prod->preco * $this->input->post('quantidade')),
        );
        $atualiza = array(
          'id' => $this->input->post('produto'),
          'estoque' => $prod->estoque - $this->input->post('quantidade')
        );
        $this->model->insert($dados, 'vendas');
        $this->model->update('produtos', $atualiza);

        $retorno["msg"] = "Cadastro efetuado com sucesso!";

        $this->load->view('success', $retorno);
      } else {
        echo '<div class="alert alert-warning alert-dismissible">';
        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        echo '<h4><i class="icon fa fa-warning"></i> Aten&ccedil;&atilde;o!</h4>';
        echo "Estoque do produto insuficiente para esta venda";
        echo '</div>';
      }
    }
  }

  public function inserirTarefa()
  {
    verifica_login();

    $dados_input = $this->input->post();

    $dados['descricao'] = $dados_input['descricao'];
    $dados['id_usuario'] = $this->session->userdata('user_id');
    $dados['data'] = $dados_input['data'];

    $this->model->insert($dados, 'tarefas');

    redirect('estoque/dashboard');
  }

  public function cadastro()
  {
    verifica_login();

    $dados['titulo'] = 'Nome do site';
    $dados['h2'] = 'Funcinarios de Estoque';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('estoque/cadastro', $dados);
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

  public function vendas_diaria()
  {
    verifica_login();

    $vendas = $this->model->select('vendas', date('Y-m-d'));
    if ($vendas != 0) {
      $x = 0;
      foreach ($vendas as $linha) {
        $produtos = $this->model->getprod($linha->id_prod);
        $lista = array(
          'produto' => $produtos->produto,
          'valor_unit' => floatval($produtos->preco),
          'codigo' => intval($vendas[$x]->id_venda),
          'quant' => intval($vendas[$x]->quant),
          'total' => floatval($vendas[$x]->valor),
          'data' => $vendas[$x]->data
        );
        $dados['lista'][$x] = $lista;
        $x++;
      }
    } else {
      $dados['lista'] = '';
    }
    $dados['periodo'] = 'Diário';
    $dados['titulo'] = 'Nome da Empresa';
    $dados['user'] = $this->session->userdata('user_name');
    $dados['h2'] = 'Lista de Vendas Diária';
    $this->load->view('estoque/vendas', $dados);
  }

  public function vendas_mensal()
  {
    verifica_login();

    $vendas = $this->model->intervalo('vendas', date('Y-m'));
    if ($vendas != 0) {
      $x = 0;
      foreach ($vendas as $linha) {
        $produtos = $this->model->getprod($linha->id_prod);
        $lista = array(
          'produto' => $produtos->produto,
          'valor_unit' => floatval($produtos->preco),
          'codigo' => intval($vendas[$x]->id_venda),
          'quant' => intval($vendas[$x]->quant),
          'total' => floatval($vendas[$x]->valor),
          'data' => $vendas[$x]->data
        );
        $dados['lista'][$x] = $lista;
        $x++;
      }
    } else {
      $dados['lista'] = '';
    }
    $dados['periodo'] = 'Mensal';
    $dados['titulo'] = 'Nome da Empresa';
    $dados['user'] = $this->session->userdata('user_name');
    $dados['h2'] = 'Lista de Vendas Mensal';
    $this->load->view('estoque/vendas', $dados);
  }

  public function produtos()
  {
    $dados['titulo'] = 'Nome do site';
    $dados['h2'] = 'Lista de Produtos em estoque';
    $dados['prod'] = $this->model->select('produtos');
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('estoque/produtos', $dados);
  }

  public function funcionarios()
  {
    verifica_login();

    $dados['titulo'] = 'Nome do site';
    $dados['h2'] = 'Quadro de Funcionários do setor de estoque';
    $dados['func'] = $this->model->select('funcionarios');
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('estoque/funcionarios', $dados);
  }
}
