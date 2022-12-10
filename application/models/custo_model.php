<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custo_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

	public function insert($dados)
  {
    $this->db->insert('custos', $dados);
    return $this->db->insert_id();
  }

	public function update($dados){
		$this->db->where('id', $dados['id']);
		unset($dados['id']);
		$this->db->update('custos', $dados);
		return $this->db->affected_rows();
	}

	public function select($data = 0)
  {
    $this->db
      ->select('*')
      ->from('custos');
    if ($data != 0) {
      $this->db->where('data_cadastro', $data);
    }

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
      ->from('custos')
      ->where('id', $id);
  
    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
  }

	public function countValores($data){
		$this->db
      ->select('SUM(valor) AS valor')
      ->from('custos')
      ->where('"' . $data . '-01" <= data_cadastro AND data_cadastro <= "' . $data . '-31"');

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
	}

	public function countDiario($data){
		$this->db
      ->select('SUM(valor) AS valor')
      ->from('custos')
      ->where('data_cadastro', $data);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return 0;
    }
	}

	public function intervalo($data)
  {
    $this->db
      ->select('*')
      ->from('custos')
      ->where('"' . $data . '-01" <= data_cadastro AND data_cadastro <= "' . $data . '-31"');

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return 0;
    }
  }

	public function excluir($id){
		$result = $this->db->where('id', $id)
								->delete('custos');

		return $result;
	}
}
