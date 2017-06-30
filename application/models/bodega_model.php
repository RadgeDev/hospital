<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bodega_model extends CI_Model {

	public function buscar($buscar,$inicio = FALSE, $cantidadregistro = FALSE,$valorbuscar=FALSE)
	{
		if ($valorbuscar==""){
			$valorbuscar="cod_bodegas";
		}
		$this->db->like($valorbuscar,$buscar);
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
		}
		$consulta = $this->db->get("bodegas");
		return $consulta->result();
	}


	function validar( $cod){
		$this->db->where('cod_bodegas', $cod);
		$this->db->get("bodegas");
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}


	function validarCorrelativo( $cod){
		$this->db->where('correlativo', $cod);
		$this->db->get("bodegas");
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}


	function guardar($data) {
		$this->db->insert("bodegas",$data);
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}	

	function actualizar($rut,$data){
		$this->db->where('cod_bodegas', $rut);
		$this->db->update('bodegas', $data); 
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}
 

public function editando($codselec){

		$this->db->where('cod_bodegas',$codselec);
		
		$q= $this->db->get('bodegas');
		return $q->result();

		}


public function eliminar($cod){
		$this->db->where('cod_bodegas',$cod);
		$this->db->delete('bodegas'); 
	  if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}

public function get_bodega(){
        $this->db->select("*");
		$this->db->from("bodegas");
		$q= $this->db->get();
		return $q->result();
		}

}//fin de clase