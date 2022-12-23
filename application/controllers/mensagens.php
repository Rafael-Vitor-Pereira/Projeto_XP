<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mensagens extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('mensagem_model', 'BDmensagem');
		date_default_timezone_set('america/sao_paulo');
		date_default_timezone_get();
	}

	public function index()
	{
		verifica_login();

		$dados_msg = $this->BDmensagem->listar($this->session->userdata('user_id'));
		if (!is_null($dados_msg)) {
			$x = 0;
			foreach ($dados_msg as $linha) {
				$dados_remetente = $this->BDusuario->dados($linha->remetente);
				$dados_destinatario = $this->BDusuario->dados($linha->destinatario);
				if($linha->tipo == 'enviada'){
					$msg[$x] = array(
						'nome_remet' => $dados_remetente->acesso,
						'email_remet' => $dados_remetente->email,
						'nome_dest' => $dados_destinatario->nome,
						'email_dest' => $dados_destinatario->email,
						'destinatario' => $linha->destinatario,
						'titulo' => $linha->titulo,
						'conteudo' => $linha->conteudo,
						'data' => $linha->data,
						'hora' => $linha->hora,
						'id' => $linha->id
					);
				}
				$x++;
			}
		} else {
			$msg = 0;
		}

		$titulo['titulo'] = 'All tech - Sistema de mensagens';
		
		$dados['msg'] = $msg;

		$this->load->view('header', $titulo);
		$this->load->view('menu');
		$this->load->view('mensagens', $dados);
		$this->load->view('footer');
	}
}
