<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tarefa_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

	public function insert($dados)
  {
    $this->db->insert('tarefas', $dados);
    return $this->db->insert_id();
  }

	public function select($id)
  {
    $this->db
      ->select('*')
      ->from('tarefas')
      ->where('id_usuario', $id);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return 0;
    }
  }
}
