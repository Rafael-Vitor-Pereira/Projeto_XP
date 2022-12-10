<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

	public function login($login)
  {
    $this->db
      ->select('*')
      ->from('usuario')
			->where('login', $login);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
  }

	public function insert($dados)
  {
    $this->db->insert('usuario', $dados);
    return $this->db->insert_id();
  }

	public function select()
  {
    $this->db
      ->select('*')
      ->from('usuario');

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return 0;
    }
  }

	public function update($dados)
  {
    $this->db->where('id = ' . $dados['id']);
    unset($dados['id']);
    $this->db->update('usuario', $dados);
    return $this->db->affected_rows();
  }

  public function TestaEmail($email)
  {
    $this->db
      ->select('id')
      ->from('usuario')
      ->where('email', $email);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return NULL;
    }
  }

	public function count($campo = 0, $valor = 0)
  {
    $this->db
      ->select('COUNT(*) AS num')
      ->from('usuario');
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

	public function selectStatus($id)
  {
    $this->db
      ->select('status')
      ->from('usuario')
      ->where('id', (int)$id);
    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return false;
    }
  }

	public function dados($id)
  {
    $this->db
      ->select('*')
      ->from('usuario')
      ->where('id', $id);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
  }

	public function selectid($campo, $valor)
  {
    $this->db
      ->select('id')
      ->from('usuario')
      ->where($campo, $valor);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
  }
}
