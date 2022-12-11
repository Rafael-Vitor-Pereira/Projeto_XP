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
}
