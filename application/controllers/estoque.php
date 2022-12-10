<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Estoque extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('vendas_model', 'BDvendas');
		$this->load->model('produto_model', 'BDproduto');
		$this->load->model('funcionario_model', 'BDfuncionario');
		$this->load->model('tarefa_model', 'BDtarefa');
    date_default_timezone_set('america/sao_paulo');
    date_default_timezone_get();
  }

  public function index()
  {
    verifica_login();

    $vendas = $this->BDvendas->count(date('Y-m-d'));
    $prod = $this->BDproduto->count();
    $func = $this->BDfuncionario->count('setor', 'Estoque');
    $vm = $this->BDvendas->intervalo(date('Y-m'));
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
    $dados['titulo'] = 'All tech';
    $dados['id'] = $this->session->userdata('user_id');
    $dados['user'] = $this->session->userdata('user_name');
    $dados['tarefas'] = $this->BDtarefa->select($this->session->userdata('user_id'));
    $dados['h2'] = 'Controle de Estoque';
    $this->load->view('estoque/dashboard', $dados);
  }

  public function cad_prod()
  {
    verifica_login();

    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('estoque/cad_prod', $dados);
  }

  public function vender()
  {
    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Cadastro de venda de produtos';
    $dados['prod'] = $this->BDproduto->select();
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
      $this->BDproduto->insert($dados);

      $retorno["msg"] = "Cadastro efetuado com sucesso!";

      $this->load->view('success', $retorno);
    }
  }

  public function grava_venda()
  {
    verifica_login();

    $prod = $this->BDproduto->dados($this->input->post('produto'));

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
        $this->BDvendas->insert($dados);
        $this->BDproduto->update($atualiza);

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

    $this->BDtarefa->insert($dados);

    redirect('estoque/dashboard');
  }

  public function cadastro()
  {
    verifica_login();

    $dados['titulo'] = 'All tech';
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
      if (!$this->BDfuncionario->TestaEmail($this->input->post('email'))) {
        $dados = array(
						'nome' => mb_strtoupper($this->input->post('nome'), 'UTF-8'), 
						'sobrenome' => mb_strtoupper($this->input->post('sobrenome'), 'UTF-8'), 
						'telefone' => $this->input->post('telefone'), 
						'cpf' => $this->input->post('cpf'), 
						'email' => $this->input->post('email'), 
						'setor' => $this->input->post('setor'), 
						'endereco' => $this->input->post('endereco')
					);

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

  public function vendas_diaria()
  {
    verifica_login();

    $vendas = $this->BDvendas->select(date('Y-m-d'));
    if ($vendas != 0) {
      $x = 0;
      foreach ($vendas as $linha) {
        $produtos = $this->BDproduto->selectPorId($linha->id_prod);
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
    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $dados['h2'] = 'Lista de Vendas Diária';
    $this->load->view('estoque/vendas', $dados);
  }

  public function vendas_mensal()
  {
    verifica_login();

    $vendas = $this->BDvendas->intervalo(date('Y-m'));
    if ($vendas != 0) {
      $x = 0;
      foreach ($vendas as $linha) {
        $produtos = $this->BDproduto->selectPorId($linha->id_prod);
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
    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $dados['h2'] = 'Lista de Vendas Mensal';
    $this->load->view('estoque/vendas', $dados);
  }

  public function produtos()
  {
    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Lista de Produtos em estoque';
    $dados['prod'] = $this->BDproduto->select();
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('estoque/produtos', $dados);
  }

  public function funcionarios()
  {
    verifica_login();

    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Quadro de Funcionários do setor de estoque';
    $dados['func'] = $this->BDfuncionario->select();
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('estoque/funcionarios', $dados);
  }
}
