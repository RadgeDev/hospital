<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

	function login($rut, $password){
		$this->db->where("login", $rut);
		$this->db->where("password", $password);
		$resultados = $this->db->get("usuarios");
		if ($resultados->num_rows()>0) {
			return $resultados->row();
		}
		else{
			return false;
		}
	}
}