<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mensagem_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

	public function insert($dados){
		$this->db->insert('mensagens', $dados);
		return $this->db->affected_rows();
	}

	public function listar($id)
  {
    $this->db
      ->select('*')
      ->from('mensagens')
      ->where("remetente = ".$id." OR destinatario = ".$id);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return 0;
    }
  }

	public function select($id)
  {
    $this->db
      ->select('*')
      ->from('mensagens')
      ->where("id", $id);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return 0;
    }
  }
}
