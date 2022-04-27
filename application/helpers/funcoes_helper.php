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
	//verifica se o usuário está logado, caso negativo redireciona para outra pagina
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
	//gera um texto parcial a partir do conteudo de um post
	function resumo_msg($string = NULL, $tamanho = 40)
	{
		$string = to_html($string);
		$string = strip_tags($string);
		$string = substr($string, 0, $tamanho);
		return $string;
	}
}
