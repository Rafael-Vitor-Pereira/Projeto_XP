<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Funcionario_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

	public function insert($dados)
  {
    $this->db->insert('funcionarios', $dados);
    return $this->db->insert_id();
  }

	public function select()
  {
    $this->db
      ->select('*')
      ->from('funcionarios');

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return 0;
    }
  }

	public function count($campo = 0, $valor = 0)
  {
    $this->db
      ->select('COUNT(*) AS num')
      ->from('funcionarios');
    if (isset($campo)) {
      $this->db->where($campo . " = '" . $valor . "'");
    }

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
  }

	public function dados($id)
  {
    $this->db
      ->select('*')
      ->from('funcionarios')
      ->where('id', $id);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
  }

	public function TestaEmail($email)
  {
    $this->db
      ->select('id')
      ->from('funcionarios')
      ->where('email', $email);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return NULL;
    }
  }

	public function update($dados)
  {
    $this->db->where('id', $dados['id']);
    unset($dados['id']);
    $this->db->update('funcionarios', $dados);
    return $this->db->affected_rows();
  }

	public function delete($id)
  {
    $result = $this->db->where('id', (int)$id)
      ->delete('funcionarios');

    return $result;
  }
}
