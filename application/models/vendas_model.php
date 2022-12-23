<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendas_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

	public function insert($dados)
  {
    $this->db->insert('vendas', $dados);
    return $this->db->insert_id();
  }

	public function select($data = 0)
  {
    $this->db
      ->select('*')
      ->from('vendas');
    if ($data != 0) {
      $this->db->where('data', $data);
    }

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return null;
    }
  }

	public function dados($id)
  {
    $this->db
      ->select('*')
      ->from('vendas')
    	->where('id_venda', $id);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return null;
    }
  }

	public function update($dados){
		$this->db->where('id_venda', $dados['id']);
		unset($dados['id']);
		$this->db->update('vendas', $dados);
		return $this->db->affected_rows();
	}

	public function count($data)
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

	public function countMensal($data){
		$this->db
      ->select('COUNT(*) AS num')
      ->from('vendas')
      ->where('"' . $data . '-01" <= data AND data <= "' . $data . '-31"');

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
      ->from('vendas')
      ->where('"' . $data . '-01" <= data AND data <= "' . $data . '-31"');

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
      ->from('vendas')
      ->where('"' . $data . '-01" <= data AND data <= "' . $data . '-31"');

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return null;
    }
  }

	public function delete($id){
		$result = $this->db->where('id_venda', (int)$id)
      ->delete('vendas');

    return $result;
	}
}
