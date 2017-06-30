<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Depto_model extends CI_Model {

	public function buscar($buscar,$inicio = FALSE, $cantidadregistro = FALSE,$valorbuscar=FALSE)
	{
		if ($valorbuscar==""){
			$valorbuscar="cod_depto";
		}
		$this->db->like($valorbuscar,$buscar);
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
		}
		$consulta = $this->db->get("depto");
		return $consulta->result();
	}


	function validar( $depto){
		$this->db->where('cod_depto', $depto);
		$this->db->get("depto");
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}

	function guardar($data) {
		$this->db->insert("depto",$data);
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}	

	function actualizar($rut,$data){
		$this->db->where('cod_depto', $rut);
		$this->db->update('depto', $data); 
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}
 

public function editando($codselec){

		$this->db->where('cod_depto',$codselec);
		
		$q= $this->db->get('depto');
		return $q->result();

		}


public function eliminar($cod){
		$this->db->where('cod_depto',$cod);
		$this->db->delete('depto'); 
	  if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}

public function get_depto(){
        $this->db->select("*");
		$this->db->from("depto");
		$q= $this->db->get();
		return $q->result();
		}

}//fin de clase