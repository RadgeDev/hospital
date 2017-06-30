<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tipo_ingreso_model extends CI_Model {

	public function buscar($buscar,$inicio = FALSE, $cantidadregistro = FALSE,$valorbuscar=FALSE)
	{
		if ($valorbuscar==""){
			$valorbuscar="cod_ingreso";
		}
		$this->db->like($valorbuscar,$buscar);
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
		}
		$consulta = $this->db->get("tipo_ingreso");
		return $consulta->result();
	}


	function validar( $cod){
		$this->db->where('cod_ingreso', $cod);
		$this->db->get("tipo_ingreso");
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}

	function guardar($data) {
		$this->db->insert("tipo_ingreso",$data);
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}	

	function actualizar($cod,$data){
		$this->db->where('cod_ingreso', $cod);
		$this->db->update('tipo_ingreso', $data); 
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}
 

public function editando($codselec){

		$this->db->where('cod_ingreso',$codselec);
		
		$q= $this->db->get('tipo_ingreso');
		return $q->result();

		}


public function eliminar($cod){
		$this->db->where('cod_ingreso',$cod);
		$this->db->delete('tipo_ingreso'); 
	  if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}

public function get_tipo_ingreso(){
        $this->db->select("*");
		$this->db->from("tipo_ingreso");
		$q= $this->db->get();
		return $q->result();
		}

}//fin de clase