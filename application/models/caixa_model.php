<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Caixa_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

	public function insert($dados)
  {
    $this->db->insert('caixa', $dados);
    return $this->db->insert_id();
  }

	public function select($mes)
  {
    $this->db
      ->select('*')
      ->from('caixa')
			->where('mes', $mes);

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
    $this->db->update('caixa', $dados);
    return $this->db->affected_rows();
  }

	public function sum(){
		$this->db->select('SUM(valor) as valor')
			->from('caixa');

		$result = $this->db->get();

		if($result->num_rows() > 0){
			return $result->row();
		}else{
			return 0;
		}
	}
}
