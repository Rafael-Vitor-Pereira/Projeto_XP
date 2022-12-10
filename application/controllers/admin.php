<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('vendas_model', 'BDvendas');
		$this->load->model('custo_model', 'BDcusto');
		$this->load->model('entrada_model', 'BDentradas');
		$this->load->model('caixa_model', 'BDcaixa');
		$this->load->model('funcionario_model', 'BDfuncionario');
		$this->load->model('produto_model', 'BDproduto');
		$this->load->model('usuario_model', 'BDusuario');
		$this->load->model('tarefa_model', 'BDtarefa');
    date_default_timezone_set('america/sao_paulo');
    date_default_timezone_get();
  }

  public function index()
  {
    verifica_login();

    $somaCapital = $this->BDentradas->countValores(date('Y-m'));
    $somaCusto = $this->BDcusto->countValores(date('Y-m'));

		$info['lucro'] = $somaCapital->valor - $somaCusto->valor;
    $info['teste'] = $this->BDcaixa->select(date('M'));
		
		$retorno = fecha_caixa($info);

		if($retorno['retorno']){
			$this->BDcaixa->insert($retorno['dados']);
		}

    $dados['vendas'] = $this->BDvendas->count(date('Y-m-d'));
    $dados['vendas_mensal'] = $this->BDvendas->countMensal(date('Y-m'));
    $dados['prod'] = $this->BDproduto->count();
    $dados['lucro'] = $info['lucro'];
    $dados['caixa'] = $this->BDcaixa->sum();
    $dados['custo'] = $somaCusto;
    $dados['valor_diario'] = $this->BDcusto->countDiario(date('Y-m-d'));
    $dados['valor_mensal'] = $somaCusto;
    $dados['func'] = $this->BDfuncionario->count();
    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $dados['tarefas'] = $this->BDtarefa->select($this->session->userdata('user_id'));
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

  public function cad_prod()
  {
    verifica_login();

    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/cad_prod', $dados);
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
        $entrada = array(
          'cod' => 2,
          'valor' => floatval($prod->preco * $this->input->post('quantidade'))
        );
        $this->BDvendas->insert($dados);
        $this->BDentradas->insert($entrada);
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

  public function vender()
  {
    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Cadastro de venda de produtos';
    $dados['prod'] = $this->BDproduto->select();
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/vender', $dados);
  }

  public function vendas()
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

    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $dados['h2'] = 'Lista de Vendas Diária';
    $dados['teste'] = 'diario';
    $this->load->view('admin/vendas', $dados);
  }

  public function editar($id)
  {
    $dados['func'] = $this->BDfuncionario->dados($id);
    $dados['titulo'] = 'All tech';
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/editar', $dados);
  }

  public function gravar_editar()
  {
    verifica_login();

    $dados['func'] = $this->BDfuncionario->dados($this->input->post('id'));
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
      $this->BDfuncionario->update($dados);

      $retorno["msg"] = "Cadastro alterado com sucesso!";

      $this->load->view('success_noreset', $retorno);
    }
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

  public function produtos()
  {
    $dados['titulo'] = 'All tech';
    $dados['h2'] = 'Lista de Produtos em estoque';
    $dados['prod'] = $this->BDproduto->select();
    $dados['user'] = $this->session->userdata('user_name');
    $this->load->view('admin/produtos', $dados);
  }

  public function gravar_status()
  {
    verifica_login();

    $id = $this->input->post('id');
    $status = $this->BDusuario->TransacaoStatus($id);
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
}
