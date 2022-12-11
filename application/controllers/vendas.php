<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendas extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('vendas_model', 'BDvendas');
		$this->load->model('produto_model', 'BDproduto');
		date_default_timezone_set('america/sao_paulo');
		date_default_timezone_get();
	}

	public function cadastrar(){
		$titulo['titulo'] = "All Tech";

		$dados['produtos'] = $this->BDproduto->select();

		$this->load->view('header', $titulo);
		$this->load->view('menu', $titulo);
		$this->load->view('vendas/cadastrar', $dados);
		$this->load->view('footer');
	}

	public function gravar(){
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

	public function listar(){
		$titulo['titulo'] = "All Tech";
		$dados['dados'] = $this->BDvendas->select();

		if(!is_null($dados)){
			foreach($dados['dados'] as $linha){
				$produto = $this->BDproduto->dados($linha->id_prod);
				$linha->id_prod = $produto->produto;
			}
		}

		$this->load->view('header', $titulo);
		$this->load->view('menu', $titulo);
		$this->load->view('vendas/listar', $dados);
		$this->load->view('footer');
	}

	public function editar($id){
		$dados['dados'] = $this->BDvendas->dados($id);
		$dados['produtos'] = $this->BDproduto->select();

		$titulo['titulo'] = 'All Tech';

		$this->load->view('header', $titulo);
		$this->load->view('menu', $titulo);
		$this->load->view('vendas/editar', $dados);
		$this->load->view('footer');
	}

	public function gravarEdicao(){
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
				$result = $this->BDvendas->dados($this->input->post('id'));
        		//cria vetor para encaminhar informações
        		$dados = array(
					'id' => $this->input->post('id'),
          			'id_prod' => $this->input->post('produto'),
          			'quant' => intval($this->input->post('quantidade')),
          			'valor' => floatval($prod->preco * $this->input->post('quantidade')),
        		);
				if($result->quant < $this->input->post('quantidade')){
					$produto = $this->BDproduto->dados($result->id_prod);

					$atualiza = array(
						'id' => $this->input->post('produto'),
						'estoque' => $produto->estoque - ($this->input->post('quantidade') - $result->quant)
				  	);

					$this->BDproduto->update($atualiza);
				}elseif($result->id_prod != $this->input->post('produto')){
					$produto = $this->BDproduto->dados($result->id_prod);

					$atualiza = array(
						'id' => $produto->id,
						'estoque' => $produto->estoque + $result->quant
				  	);

					$this->BDproduto->update($atualiza);

					$produto = $this->BDproduto->dados($this->input->post('produto'));

					$atualiza = array(
						'id' => $this->input->post('produto'),
						'estoque' => $produto->estoque - $this->input->post('quantidade')
				  	);

					$this->BDproduto->update($atualiza);
				}
        		
        		$this->BDvendas->update($dados);

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

	  public function excluir(){
		verifica_login();

		$id = $this->input->post('id');

		$dados = $this->BDvendas->dados($id);

		$produto = $this->BDproduto->dados($dados->id_prod);

		$update = array(
			'id' => $produto->id,
			'estoque' => intval($produto->estoque) + intval($dados->quant)
		);

		$this->BDproduto->update($update);

		$this->BDvendas->delete($id);
	}
}
