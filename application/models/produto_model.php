<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produto_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

	public function insert($dados)
  {
    $this->db->insert('produtos', $dados);
    return $this->db->insert_id();
  }

	public function select()
  {
    $this->db
      ->select('*')
      ->from('produtos');

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return 0;
    }
  }

	public function selectPorId($id)
  {
    $this->db
      ->select('*')
      ->from('produtos')
      ->where('id', $id);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
  }

	public function count($campo = 0, $valor = 0)
  {
    $this->db
      ->select('COUNT(*) AS num')
      ->from('produtos');
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
      ->from('produtos')
      ->where('id', $id);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
  }

	public function update($dados)
  {
    $this->db->where('id = ' . $dados['id']);
    unset($dados['id']);
    $this->db->update('produtos', $dados);
    return $this->db->affected_rows();
  }
}
