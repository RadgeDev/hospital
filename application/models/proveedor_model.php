<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor_model extends CI_Model {

	public function buscar($buscar,$inicio = FALSE, $cantidadregistro = FALSE,$valorbuscar=FALSE)
	{
		if ($valorbuscar==""){
			$valorbuscar="rut_proveedor";
		}
		$this->db->like($valorbuscar,$buscar);
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
		}
		$consulta = $this->db->get("proveedor");
		return $consulta->result();
	}


	function validar( $rutsele){
		$this->db->where('rut_proveedor', $rutsele);
		$this->db->get("proveedor");
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
 
}