<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('set_msg')) {
	//seta uma mensagem via session para ser lida posteriormente
	function set_msg($msg = NULL)
	{
		$ci = &get_instance();
		$ci->session->set_userdata('aviso', $msg);
	}
}

if (!function_exists('get_msg')) {
	//retorna uma mensagem definida pela função set_msg
	function get_msg($destroy = TRUE)
	{
		$ci = &get_instance();
		$retorno = $ci->session->userdata('aviso');
		if ($destroy) $ci->session->unset_userdata('aviso');
		return $retorno;
	}
}

if (!function_exists('verifica_login')) {
	//verifica se o usuário está logado, caso negativo redireciona para outra pagina
	function verifica_login()
	{
		$ci = &get_instance();
		if ($ci->session->userdata('logged') != TRUE) {
			set_msg('<p>Acesso restrito! Faça login para continuar.</p>');
			redirect(base_url(), 'refresh');
		}
	}
}

if (!function_exists('config_upload')) {
	function config_upload($path = './uploads', $types = 'jpg|png', $size = 512)
	{
		$config['upload_path'] = $path;
		$config['allowed_types'] = $types;
		$config['max_size'] = $size;
		return $config;
	}
}

if (!function_exists('to_bd')) {
	//codifica o HTML para salvar no banco de dados
	function to_bd($string = NULL)
	{
		return htmlentities($string);
	}
}

if (!function_exists('to_html')) {
	//decodifica o HTML e remove barras invertidas do conteudo
	function to_html($string = NULL)
	{
		return html_entity_decode($string);
	}
}

if (!function_exists('resumo_msg')) {
	//gera um texto parcial a partir do conteudo de uma mensagem
	function resumo_msg($string = NULL, $tamanho = 40)
	{
		$string = to_html($string);
		$string = strip_tags($string);
		$string = substr($string, 0, $tamanho);
		return $string;
	}
}

if (!function_exists('soma_valores')) {
	function soma_valores($dados)
	{
		$soma = 0;
		if(($dados != 0) && (!is_null($dados))){
			foreach ($dados as $linha) {
				$soma = $soma + floatval($linha->valor);
			}
		}

		return $soma;
	}
}

if (!function_exists('fecha_caixa')) {
	function fecha_caixa($dados)
	{
		$mes = date('m');
		if($mes == 2){
			$num = 28;
		}elseif(($mes == 4) || ($mes == 6) || ($mes == 9) || ($mes == 11)){
			$num = 30;
		}else{
			$num = 31;
		}

		$dia = date('d');
    	if (($dia == $num) && ($dados['teste'] == 0)) {
       		$caixa['valor'] = $dados['lucro'];
       		$caixa['mes'] = date('M');
			$dados_retorno['dados'] = $caixa;      		
			$dados_retorno['retorno'] = true;
			return $dados_retorno;
    	}else{
			$dados_retorno['retorno'] = false;
			return $dados_retorno;
		}
	}
}

if (!function_exists('logar')) {
	function logar($dados)
	{
		$ci = &get_instance();

		$ci->session->set_userdata('logged', TRUE);
		$ci->session->set_userdata('user_login', $dados['login']['login']);
		$ci->session->set_userdata('user_name', $dados['dados']->nome);
		$ci->session->set_userdata('user_id', $dados['dados']->id);
		$ci->session->set_userdata('user_acess', $dados['dados']->acesso);

		if ($dados['login']['remember'] == 'on' && empty($_COOKIE['login'])) {
			$cad = serialize($ci->session->userdata());

			setcookie("login", $cad, time() + 604800);
		}
	}
}
