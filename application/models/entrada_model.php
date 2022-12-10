<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Entrada_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

	public function insert($dados)
  {
    $this->db->insert('entradas', $dados);
    return $this->db->insert_id();
  }

	public function countValores($data){
		$this->db
      ->select('SUM(valor) AS valor')
      ->from('entradas')
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
      ->from('entradas')
      ->where('"' . $data . '-01" <= data AND data <= "' . $data . '-31"');

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      return $result->result();
    } else {
      return 0;
    }
  }
}
