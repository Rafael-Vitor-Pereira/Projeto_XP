<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
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
    $vendas_mensais = $this->model->intervalo('vendas', date('Y-m'));
    $valor_diario = $this->model->select('custos', date('Y-m-d'));
    $valor_mensal = $this->model->intervalo('custos', date('Y-m'));
    $capital = $this->model->intervalo('entradas', date('Y-m'));
    $somaCapital = 0;
    if ($capital != 0) {
      foreach ($capital as $linha) {
        $somaCapital = $somaCapital + floatval($linha->valor);
      }
    }
    $somaCusto = 0;
    if ($valor_mensal != 0) {
      foreach ($valor_mensal as $linha) {
        $somaCusto = $somaCusto + $linha->valor;
      }
    }
    $somaValor = 0;
    if ($valor_diario != 0) {
      foreach ($valor_diario as $linha) {
        $somaValor = $somaValor + floatval($linha->valor);
      }
    }
    $somaValorMensal = 0;
    if ($valor_mensal != 0) {
      foreach ($valor_mensal as $linha) {
        $somaValorMensal = $somaValorMensal + floatval($linha->valor);
      }
    }
    $x = 0;
    if ($vendas_mensais != 0) {
      foreach ($vendas_mensais as $linha) {
        $x++;
      }
    }
    $lucro = $somaCapital - $somaCusto;
    $testa = $this->model->select('caixa');
    $dia = date('d');
    if ($dia == 31) {
      if ($testa != 0) {
        $caixa['valor'] = $lucro;
        $caixa['mes'] = date('M');
        $this->model->insert($caixa, 'caixa');
      } else {
        $testa->valor = $lucro;
        $this->model->update('caixa', $testa);
      }
    }
    $somaCaixa = 0;
    if ($testa != 0) {
      foreach ($testa as $linha) {
        $somaCaixa = $somaCaixa + floatval($linha->valor);
      }
    }
    $func = $this->model->count('funcionarios');
    $prod = $this->model->count('produtos');
    $dados['vendas'] = $vendas->num;
    $dados['vendas_mensal'] = $x;
    $dados['prod'] = $prod->num;
    $dados['lucro'] = $lucro;
    $dados['caixa'] = $somaCaixa;
    $dados['custo'] = $somaCusto;
    $dados['valor_diario'] = $somaValor;
    $dados['valor_mensal'] = $somaValorMensal;
    $dados['func'] = $func->num;
    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $dados['tarefas'] = $this->model->get_tarefa($this->session->userdata('user_id'));
    $dados['h2'] = 'Setor Administrativo';
    $this->load->view('admin/dashboard', $dados);
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

        $this->model->insert($dados, 'tarefas');

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

  public function cadastro()
  {
    verifica_login();

    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/cadastrar', $dados);
  }

  public function cad_prod()
  {
    verifica_login();

    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/cad_prod', $dados);
  }

  public function cad_func()
  {
    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/cad_func', $dados);
  }

  public function cad_custo()
  {
    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/cad_custo', $dados);
  }

  public function gravar()
  {
    verifica_login();

    $regras = array(
      array('field' => 'nome', 'label' => 'Nome', 'rules' => 'trim|required|max_length[80]'),
      array('field' => 'sobrenome', 'label' => 'Sobrenome', 'rules' => 'trim|required|max_length[80]'),
      array('field' => 'telefone', 'label' => 'Telefone', 'rules' => 'trim|required'),
      array('field' => 'cpf', 'label' => 'CPF', 'rules' => 'trim|required'),
      array('field' => 'pass', 'label' => 'Senha', 'rules' => 'trim|required|min_length[6]'),
      array('field' => 'user', 'label' => 'Usuario', 'rules' => 'trim|required|min_length[3]'),
      array('field' => 'email', 'label' => 'E-mail', 'rules' => 'trim|valid_email|required|max_length[255]'),
      array('field' => 'setor', 'label' => 'Setor', 'rules' => 'trim|required')
    );
    $this->form_validation->set_rules($regras);

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('error');
    } else {
      //se não existir usuário com esse e-mail, grava
      if (!$this->model->TestaEmail($this->input->post('email'), 'usuario')) {
        //cria usuario com informações repassadas
        //cria vetor para encaminhar informações
        $dados = array(
          'nome' => mb_strtoupper($this->input->post('nome'), 'UTF-8') . ' ' . mb_strtoupper($this->input->post('sobrenome'), 'UTF-8'),
          'telefone' => $this->input->post('telefone'),
          'cpf' => $this->input->post('cpf'),
          'email'   => $this->input->post('email'),
          'senha' => password_hash($this->input->post('pass'), PASSWORD_DEFAULT),
          'login' => $this->input->post('user'),
          'acesso' => $this->input->post('setor')
        );
        $this->model->insert($dados, 'usuario');

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

  public function grava_func()
  {
    verifica_login();

    $regras = array(
      array('field' => 'nome', 'label' => 'Nome', 'rules' => 'trim|required|max_length[80]'),
      array('field' => 'sobrenome', 'label' => 'Sobrenome', 'rules' => 'trim|required|max_length[80]'),
      array('field' => 'telefone', 'label' => 'Telefone', 'rules' => 'trim|required'),
      array('field' => 'cpf', 'label' => 'CPF', 'rules' => 'trim|required'),
      array('field' => 'endereco', 'label' => 'Endereço', 'rules' => 'trim|required|min_length[10]'),
      array('field' => 'setor', 'label' => 'Setor', 'rules' => 'trim|required|min_length[2]'),
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
        $dados = array(
          'nome' => mb_strtoupper($this->input->post('nome'), 'UTF-8'),
          'sobrenome' => mb_strtoupper($this->input->post('sobrenome'), 'UTF-8'),
          'telefone' => $this->input->post('telefone'),
          'cpf' => $this->input->post('cpf'),
          'email'   => $this->input->post('email'),
          'endereco' => $this->input->post('endereco'),
          'setor' => $this->input->post('setor')
        );
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

  public function grava_custo()
  {
    verifica_login();

    $regras = array(
      array('field' => 'cod', 'label' => 'Tipo custo', 'rules' => 'trim|required'),
      array('field' => 'valor', 'label' => 'Valor', 'rules' => 'trim|required')
    );
    $this->form_validation->set_rules($regras);

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('error');
    } else {
      //cria vetor para encaminhar informações
      $dados = array(
        'cod' => $this->input->post('cod'),
        'valor' => floatval($this->input->post('valor'))
      );
      $this->model->insert($dados, 'custos');

      $retorno["msg"] = "Informação gravada com sucesso!";

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
        $entrada = array(
          'cod' => 2,
          'valor' => floatval($prod->preco * $this->input->post('quantidade'))
        );
        $this->model->insert($dados, 'vendas');
        $this->model->insert($entrada, 'entradas');
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

  public function vender()
  {
    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Cadastro de venda de produtos';
    $dados['prod'] = $this->model->select('produtos');
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/vender', $dados);
  }

  public function vendas()
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

    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $dados['h2'] = 'Lista de Vendas Diária';
    $dados['teste'] = 'diario';
    $this->load->view('admin/vendas', $dados);
  }

  public function editar($id)
  {
    $dados['func'] = $this->model->dados('funcionarios', $id);
    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/editar', $dados);
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
          'codigo' => intval($linha->id_venda),
          'quant' => intval($linha->quant),
          'total' => floatval($linha->valor),
          'data' => $linha->data
        );
        $dados['lista'][$x] = $lista;
        $x++;
      }
    } else {
      $dados['lista'] = '';
    }

    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $dados['h2'] = 'Lista de Vendas Mensal';
    $dados['teste'] = 'mensal';
    $this->load->view('admin/vendas', $dados);
  }

  public function balanco()
  {
    verifica_login();

    if ($dados_form = $this->input->post()) {
      $data = $dados_form['ano'] . '-' . $dados_form['mes'];
      $custo = $this->model->intervalo('custos', $data);
      $capital = $this->model->intervalo('entradas', $data);
    } else {
      $custo = $this->model->intervalo('custos', date('Y-m'));
      $capital = $this->model->intervalo('entradas', date('Y-m'));
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

  public function funcionarios()
  {
    verifica_login();

    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Quadro de Funcionários';
    $dados['func'] = $this->model->select('funcionarios');
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/funcionarios', $dados);
  }

  public function custos()
  {
    verifica_login();

    $custo = $this->model->select('custos', date('Y-m-d'));

    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Custos Diários';
    $dados['custo'] = $custo;
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/custos', $dados);
  }

  public function custos_mensal()
  {
    verifica_login();

    if ($dados_form = $this->input->post()) {
      $data = $dados_form['ano'] . '-' . $dados_form['mes'];
      $custo = $this->model->intervalo('custos', $data);
    } else {
      $custo = $this->model->intervalo('custos', date('Y-m'));
    }

    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Custos Mensais';
    $dados['custo'] = $custo;
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/custos', $dados);
  }

  public function produtos()
  {
    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Lista de Produtos em estoque';
    $dados['prod'] = $this->model->select('produtos');
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/produtos', $dados);
  }

  public function bloquear()
  {
    verifica_login();

    $num = $this->model->count('usuario');
    $dados['usuario'] = $this->model->select('usuario');
    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Lista de Bloqueio';
    $dados['id'] = $this->session->userdata('user_id');
    $dados['num'] = intval($num->num);
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/bloquear', $dados);
  }

  public function gravar_status()
  {
    verifica_login();

    $id = $this->input->post('id');
    $status = $this->model->TransacaoStatus($id);
    if ($status->status == 1) {
      $dados['status'] = 0;
      $dados['id'] = $id;
      $this->model->update('usuario', $dados);
      echo "<i class='fa fa-toggle-off'></i> Inativo";
    } else {
      $dados['status'] = 1;
      $dados['id'] = $id;
      $this->model->update('usuario', $dados);
      echo "<i class='fa fa-toggle-on'></i> Ativo";
    }
  }

  public function excluir()
  {
    verifica_login();

    $id = $this->input->post('id');

    $this->model->delete($id);
  }
}
