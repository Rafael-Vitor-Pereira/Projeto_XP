<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Db_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get($login)
  {
    $this->db
      ->select('*')
      ->from('usuario')
      ->where('login', $login);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return NULL;
    }
  }

  public function insert($dados, $table)
  {
    $this->db->insert($table, $dados);
    return $this->db->insert_id();
  }

  public function TestaEmail($email, $table)
  {
    $this->db
      ->select('id')
      ->from($table)
      ->where('email', $email);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return NULL;
    }
  }

  public function count($table, $campo = 0, $valor = 0)
  {
    $this->db
      ->select('COUNT(*) AS num')
      ->from($table);
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

  public function get_tarefa($id)
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

  public function count_vendas($data)
  {
    $this->db
      ->select('COUNT(*) as num')
      ->from('vendas')
      ->where('data', $data);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
  }

  public function select($table, $data = 0)
  {
    $this->db
      ->select('*')
      ->from($table);
    if ($data != 0) {
      $this->db->where('data', $data);
    }

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return 0;
    }
  }

  public function intervalo($table, $data)
  {
    $this->db
      ->select('*')
      ->from($table)
      ->where('"' . $data . '-01" <= data AND data <= "' . $data . '-31"');

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return 0;
    }
  }

  public function getprod($id)
  {
    $this->db
      ->select('preco, produto')
      ->from('produtos')
      ->where('id', $id);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
  }

  public function getmsg($table, $id, $sit)
  {
    $this->db
      ->select('*')
      ->from($table);
    if ($sit == 'listar') {
      $this->db->where("remetente = " . $id . " or destinatario = " . $id);
    } else if ($sit == 'ler') {
      $this->db->where("id", $id);
    }

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return 0;
    }
  }

  public function dados($table, $id)
  {
    $this->db
      ->select('*')
      ->from($table)
      ->where('id', $id);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
  }

  public function getid($table, $campo, $valor)
  {
    $this->db
      ->select('id')
      ->from($table)
      ->where($campo, $valor);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
  }

  public function update($table, $dados)
  {
    $this->db->where('id', $dados['id']);
    unset($dados['id']);
    $this->db->update($table, $dados);
    return $this->db->affected_rows();
  }

  public function TransacaoStatus($id)
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

  public function delete($id)
  {
    $result = $this->db->where('id', (int)$id)
      ->delete('funcionarios');

    return $result;
  }
}
