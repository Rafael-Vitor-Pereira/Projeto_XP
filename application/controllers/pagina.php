<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pagina extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('caixa_model', 'BDcaixa');
		$this->load->model('custo_model', 'BDcusto');
		$this->load->model('vendas_model', 'BDvendas');
		$this->load->model('tarefa_model', 'BDtarefa');
		$this->load->model('usuario_model', 'BDusuario');
		$this->load->model('produto_model', 'BDproduto');
		$this->load->model('mensagem_model', 'BDmensagem');
		$this->load->model('funcionario_model', 'BDfuncionario');
		date_default_timezone_set('america/sao_paulo');
		date_default_timezone_get();
	}

	public function index()
	{
		//regras de validação
		$this->form_validation->set_rules('login', 'Usuário', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('senha', 'Senha', 'trim|required|min_length[6]');

		//verifica validação
		if ($this->form_validation->run() == FALSE) {
			if (validation_errors()) {
				set_msg(validation_errors());
			}
		} else {
			$dados_form = $this->input->post();
			if ($result = $this->BDusuario->login($dados_form['login'])) {
				if ($result->status == 1) {
					//usuário existe
					if (password_verify($dados_form['senha'], $result->senha)) {
						//senha ok, fazer login
						$dados['dados'] = $result; 
						$dados['login'] = $dados_form;
						logar($dados);
						//fazer redirect para dashboard do sistema
						redirect('pagina/dashboard', 'refresh');
					} else {
						//senha incorreta
						set_msg('<p>Usuário ou Senha incorreto!</p>');
					}
				} else {
					set_msg('Usuário não existe ou está bloqueado');
				}
			} else {
				//usuario não existe
				set_msg('<p>Usuário ou Senha incorreto!</p>');
			}
		}
		if (!empty($_COOKIE['login'])) {
			$cookie = unserialize($_COOKIE['login']);
			$result = $this->BDusuario->login($cookie['user_login']);
			if ($result->status == 1) {
				$dados['dados'] = $result; 
				$dados['login'] = $cookie;
				logar($dados);
				redirect('pagina/dashboard', 'refresh');
			}
		} else {
			//Carrega view
			$dados_login['titulo'] = 'All tech';
			$dados_login['h2'] = 'Acesso ao sistema';
			$this->load->view('home', $dados_login);
		}
	}

	public function dashboard(){
		verifica_login();

    	$somaCapital = $this->BDvendas->countValores(date('Y-m'));
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

		$titulo['titulo'] = 'All Tech - Dashboard';

		$this->load->view('header', $titulo);
		$this->load->view('menu');
    	$this->load->view('dashboard', $dados);
		$this->load->view('footer');
	}

	public function ler_msg()
	{
		verifica_login();

		$id = $this->uri->segment(3);
		$dados_msg = $this->BDmensagem->select($id);
		if ($dados_msg != 0) {
			$x = 0;
			foreach ($dados_msg as $linha) {
				$dados_remet = $this->BDusuario->dados($linha->remetente);
				$dados_dest = $this->BDusuario->dados($linha->destinatario);
				$msg = array(
					'nome_remet' => $dados_remet->acesso,
					'email_remet' => $dados_remet->email,
					'nome_dest' => $dados_dest->nome,
					'email_dest' => $dados_dest->email,
					'destinatario' => $linha->destinatario,
					'titulo' => $linha->titulo,
					'conteudo' => $linha->conteudo,
					'excluida' => $linha->excluido,
					'data' => $linha->data,
					'hora' => $linha->hora,
					'id' => $id
				);
				$x++;
			}
		} else {
			$msg = 0;
		}

		$dados['titulo'] = 'All tech';
		$dados['logado'] = $this->session->userdata('user_acess');
		$dados['user'] = $this->session->userdata('user_name');
		$dados['id'] = $this->session->userdata('user_id');
		$dados['msg'] = $msg;

		$this->load->view('header', $dados);
		$this->load->view('menu', $dados);
		$this->load->view('ler_msg', $dados);
		$this->load->view('footer');
	}

	public function ler_rasc()
	{
		verifica_login();

		$id = $this->uri->segment(2);
		$dados_msg = $this->BDmensagem->select($id);
		if ($dados_msg != 0) {
			$x = 0;
			foreach ($dados_msg as $linha) {
				$dados_remet = $this->BDusuario->dados($linha->remetente);
				$dados_dest = $this->BDusuario->dados($linha->destinatario);
				$msg = array(
					'nome_remet' => $dados_remet->acesso,
					'email_remet' => $dados_remet->email,
					'nome_dest' => $dados_dest->nome,
					'email_dest' => $dados_dest->email,
					'destinatario' => $linha->destinatario,
					'titulo' => $linha->titulo,
					'conteudo' => $linha->conteudo,
					'excluida' => $linha->excluido,
					'data' => $linha->data,
					'hora' => $linha->hora,
					'id' => $id
				);
				$x++;
			}
		} else {
			$msg = 0;
		}
		if ($this->session->userdata('user_acess') == 'admin') {
			$page = 'admin/ler_msg';
		} else if ($this->session->userdata('user_acess') == 'estoque') {
			$page = 'estoque/ler_msg';
		} else if ($this->session->userdata('user_acess') == 'rh') {
			$page = 'rh/ler_msg';
		} else if ($this->session->userdata('user_acess') == 'financeiro') {
			$page = 'financeiro/ler_msg';
		}

		$dados['titulo'] = 'All tech';
		$dados['user'] = $this->session->userdata('user_name');
		$dados['id'] = $this->session->userdata('user_id');
		$dados['msg'] = $msg;

		$this->load->view('header', $dados);
		$this->load->view('menu', $dados);
		$this->load->view($page, $dados);
		$this->load->view('footer');
	}

	public function lixeira()
	{
		verifica_login();

		$dados_msg = $this->BDmensagem->listar($this->session->userdata('user_id'));
		if ($dados_msg != 0) {
			$x = 0;
			foreach ($dados_msg as $linha) {
				$dados_remet = $this->BDusuario->dados($linha->remetente);
				$dados_dest = $this->BDusuario->dados($linha->destinatario);
				$msg[$x] = array(
					'nome_remet' => $dados_remet->acesso,
					'email_remet' => $dados_remet->email,
					'nome_dest' => $dados_dest->acesso,
					'email_dest' => $dados_dest->email,
					'destinatario' => $linha->destinatario,
					'remetente' => $linha->remetente,
					'titulo' => $linha->titulo,
					'excluido' => $linha->excluido,
					'conteudo' => $linha->conteudo,
					'data' => $linha->data,
					'hora' => $linha->hora,
					'id' => $linha->id
				);
				$x++;
			}
		} else {
			$msg = 0;
		}

		$dados['titulo'] = 'All tech';
		$dados['h2'] = 'Lixeira';
		$dados['logado'] = $this->session->userdata('user_acess');
		$dados['user'] = $this->session->userdata('user_name');
		$dados['id'] = $this->session->userdata('user_id');
		$dados['msg'] = $msg;

		$this->load->view('header', $dados);
		$this->load->view('menu', $dados);
		$this->load->view('lixeira', $dados);
		$this->load->view('footer');
	}

	public function enviadas()
	{
		verifica_login();

		$dados_msg = $this->BDmensagem->listar($this->session->userdata('user_id'));
		if ($dados_msg != 0) {
			$x = 0;
			foreach ($dados_msg as $linha) {
				$dados_remet = $this->BDusuario->dados($linha->remetente);
				$dados_dest = $this->BDusuario->dados($linha->destinatario);
				$msg[$x] = array(
					'nome_remet' => $dados_remet->acesso,
					'email_remet' => $dados_remet->email,
					'nome_dest' => $dados_dest->nome,
					'email_dest' => $dados_dest->email,
					'remetente' => $linha->remetente,
					'titulo' => $linha->titulo,
					'conteudo' => $linha->conteudo,
					'excluido' => $linha->excluido,
					'data' => $linha->data,
					'hora' => $linha->hora,
					'id' => $linha->id
				);
				$x++;
			}
		} else {
			$msg = 0;
		}

		$dados['titulo'] = 'All tech';
		$dados['h2'] = 'Mensagens enviadas';
		$dados['logado'] = $this->session->userdata('user_acess');
		$dados['user'] = $this->session->userdata('user_name');
		$dados['id'] = $this->session->userdata('user_id');
		$dados['msg'] = $msg;

		$this->load->view('header', $dados);
		$this->load->view('menu', $dados);
		$this->load->view('enviadas', $dados);
		$this->load->view('footer');
	}

	public function escrever()
	{
		verifica_login();

		if ($this->input->post('dest')) {
			$dados['dest'] = $this->input->post('dest');
		}
		//regras de validação
		$this->form_validation->set_rules('dest', 'Destinatário', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('titulo', 'Titulo', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('conteudo', 'Conteúdo', 'trim|required|min_length[6]');

		//verifica validação
		if ($this->form_validation->run() == FALSE) {
			if (validation_errors()) {
				set_msg(validation_errors());
			}
		} else {
			$dados_form = $this->input->post();

			$id_dest = $this->BDusuario->selectId('email', $dados_form['dest']);

			$dados = array(
				'remetente' => $this->session->userdata('user_id'),
				'destinatario' => $id_dest->id,
				'titulo' => $dados_form['titulo'],
				'conteudo' => to_bd($dados_form['conteudo'])
			);

			if (isset($dados_form['rascunho'])) {
				$dados['tipo'] = 'rascunho';
				if ($this->BDmensagem->insert($dados)) {
					set_msg('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button><p>Rascunho salvo com sucesso</p></div>');
				} else {
					set_msg('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button><p>Falha ao salvar rascunho</p></div>');
				}
			} else {
				$dados['tipo'] = 'enviada';
				if ($this->BDmensagem->insert($dados)) {
					set_msg('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button><p>Mensagem enviada com sucesso</p></div>');
				} else {
					set_msg('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button><p>Falha ao enviar a mensagem</p></div>');
				}
			}
		}

		$dados['titulo'] = 'All tech';
		$dados['h2'] = 'Escrever';
		$dados['logado'] = $this->session->userdata('user_acess');
		$dados['user'] = $this->session->userdata('user_name');
		$dados['id'] = $this->session->userdata('user_id');

		$this->load->view('header', $dados);
		$this->load->view('menu', $dados);
		$this->load->view('escrever', $dados);
		$this->load->view('footer');
	}

	public function rascunhos()
	{
		verifica_login();

		$dados_msg = $this->BDmensagem->listar($this->session->userdata('user_id'), 'rascunho');
		if ($dados_msg != 0) {
			$x = 0;
			foreach ($dados_msg as $linha) {
				$dados_dest = $this->BDusuario->dados($linha->destinatario);
				$msg[$x] = array(
					'remetente' => $linha->remetente,
					'acesso' => $dados_dest->acesso,
					'titulo' => $linha->titulo,
					'conteudo' => $linha->conteudo,
					'data' => $linha->data,
					'hora' => $linha->hora,
					'id' => $linha->id
				);
				$x++;
			}
		} else {
			$msg = 0;
		}

		$dados['titulo'] = 'All tech';
		$dados['h2'] = 'Rascunhos';
		$dados['logado'] = $this->session->userdata('user_acess');
		$dados['user'] = $this->session->userdata('user_name');
		$dados['id'] = $this->session->userdata('user_id');
		$dados['msg'] = $msg;

		$this->load->view('header', $dados);
		$this->load->view('menu', $dados);
		$this->load->view('rascunho', $dados);
		$this->load->view('footer');
	}

	public function contatos()
	{
		verifica_login();

		$dados['titulo'] = 'All tech';
		$dados['h2'] = 'Lista de Contatos';
		$dados['logado'] = $this->session->userdata('user_login');
		$dados['lista'] = $this->BDusuario->select();
		$dados['user'] = $this->session->userdata('user_name');

		$this->load->view('header', $dados);
		$this->load->view('menu', $dados);
		$this->load->view('contatos', $dados);
		$this->load->view('footer');
	}

	public function excluir()
	{
		verifica_login();

		$dados['id'] = $this->input->post('id');
		$dados['excluido'] = 'sim';
		$pag = $this->input->post('pag');

		if ($this->BDmensagem->update($dados)) {
			set_msg('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button><p>Mensagem excluida com sucesso</p></div>');

			redirect($pag, 'refresh');
		} else {
			set_msg('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button><p>Falha ao excluir mensagem</p></div>');
		}
	}

	public function credenciais()
	{
		verifica_login();

		$result = $this->BDusuario->dados($this->session->userdata('user_id'));
		if (isset($result)) {
			$dados['telefone'] = $result->telefone;
			$dados['email'] = $result->email;
			$dados['user_name'] = $result->login;
		}
		$dados['h2'] = 'Informações do Usuário';
		$dados['titulo'] = 'All tech';
		$dados['access'] = $this->session->userdata('user_acess');
		$dados['user'] = $this->session->userdata('user_name');

		$this->load->view('header', $dados);
		$this->load->view('menu', $dados);
		$this->load->view('credenciais', $dados);
		$this->load->view('footer');
	}

	public function editar()
	{
		verifica_login();

		$result = $this->BDusuario->dados($this->session->userdata('user_id'));
		if (isset($result)) {
			$dados['telefone'] = $result->telefone;
			$dados['email'] = $result->email;
			$dados['user_name'] = $result->login;
			$dados['user'] = $result->nome;
		}
		$dados['h2'] = 'Informações do Usuário';
		$dados['titulo'] = 'All tech';
		$dados['access'] = $this->session->userdata('user_acess');

		$this->load->view('header', $dados);
		$this->load->view('menu', $dados);
		$this->load->view('editar', $dados);
		$this->load->view('footer');
	}

	public function gravar_editar()
	{
		verifica_login();

		if ($this->input->post('pass_ant') != '') {
			$regras = array(
				array('field' => 'nome', 'label' => 'Nome', 'rules' => 'trim|required|min_length[3]'),
				array('field' => 'telefone', 'label' => 'Telefone', 'rules' => 'trim|required'),
				array('field' => 'user', 'label' => 'Usuario', 'rules' => 'trim|required|min_length[3]'),
				array('field' => 'email', 'label' => 'E-mail', 'rules' => 'trim|valid_email|required|max_length[255]'),
				array('field' => 'confirme', 'label' => 'Confirme a senha', 'rules' => 'min_length[6]|matches[pass]')
			);
			$this->form_validation->set_rules($regras);
		} else {
			$regras = array(
				array('field' => 'nome', 'label' => 'Nome', 'rules' => 'trim|required|min_length[3]'),
				array('field' => 'telefone', 'label' => 'Telefone', 'rules' => 'trim|required'),
				array('field' => 'user', 'label' => 'Usuario', 'rules' => 'trim|required|min_length[3]'),
				array('field' => 'email', 'label' => 'E-mail', 'rules' => 'trim|valid_email|required|max_length[255]'),
			);
			$this->form_validation->set_rules($regras);
		}
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('error');
		} else {
			$result = $this->BDusuario->dados($this->session->userdata('user_id'));
			if ($this->input->post('pass_ant') != '') {
				if (password_verify($this->input->post('pass_ant'), $result->senha)) {
					//cria usuario com informações repassadas
					//cria vetor para encaminhar informações
					$dados = array(
						'nome' => mb_strtoupper($this->input->post('nome'), 'UTF-8'),
						'telefone' => $this->input->post('telefone'),
						'email'   => $this->input->post('email'),
						'senha' => password_hash($this->input->post('pass'), PASSWORD_DEFAULT),
						'login' => $this->input->post('user'),
						'id' => $this->session->userdata('user_id')
					);
					$this->BDusuario->update($dados);

					$retorno["msg"] = "Cadastro alterado com sucesso!";

					$this->load->view('success_noreset', $retorno);
				}
			} else {
				$dados = array(
					'nome' => mb_strtoupper($this->input->post('nome'), 'UTF-8'),
					'telefone' => $this->input->post('telefone'),
					'email'   => $this->input->post('email'),
					'login' => $this->input->post('user'),
					'id' => $this->session->userdata('user_id')
				);
				$this->BDusuario->update($dados);

				$retorno["msg"] = "Cadastro alterado com sucesso!";

				$this->load->view('success_noreset', $retorno);
			}
		}
	}

	public function logout()
	{
		//destroi dados da sessão
		$this->session->set_userdata('logged', FALSE);
		$this->session->set_userdata('user_login', '');
		$this->session->set_userdata('user_name', '');
		$this->session->set_userdata('user_id', '');
		$this->session->set_userdata('user_acess', '');
		setcookie("login", '', time() - 60);
		set_msg('<p>Você saiu do sistema</p>');
		redirect(base_url(), 'refresh');
	}
}
