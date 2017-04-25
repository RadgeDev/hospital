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
		$this->db->insert("proveedor",$data);
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}	

	function actualizar($rut,$data){
		$this->db->where('rut_proveedor', $rut);
		$this->db->update('proveedor', $data); 
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}
 

public function editando($rutselec){

		$this->db->where('rut_proveedor',$rutselec);
		
		$q= $this->db->get('proveedor');
		return $q->result();

		}


public function eliminar($rutas){
		$this->db->where('rut_proveedor',$rutas);
		$this->db->delete('proveedor'); 
	  if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}



}//fin de clase