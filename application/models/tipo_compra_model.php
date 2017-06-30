<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipo_compra_model extends CI_Model {

	public function buscar($buscar,$inicio = FALSE, $cantidadregistro = FALSE,$valorbuscar=FALSE)
	{
		if ($valorbuscar==""){
			$valorbuscar="cod_tipocompra";
		}
		$this->db->like($valorbuscar,$buscar);
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
		}
		$consulta = $this->db->get("tipo_compra");
		return $consulta->result();
	}


	function validar( $cod){
		$this->db->where('cod_tipocompra', $cod);
		$this->db->get("tipo_compra");
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}

	function guardar($data) {
		$this->db->insert("tipo_compra",$data);
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}	

	function actualizar($cod,$data){
		$this->db->where('cod_tipocompra', $cod);
		$this->db->update('tipo_compra', $data); 
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}
 

public function editando($codselec){

		$this->db->where('cod_tipocompra',$codselec);
		
		$q= $this->db->get('tipo_compra');
		return $q->result();

		}


public function eliminar($cod){
		$this->db->where('cod_tipocompra',$cod);
		$this->db->delete('tipo_compra'); 
	  if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}
public function get_tipo_compra(){
        $this->db->select("*");
		$this->db->from("tipo_compra");
		$q= $this->db->get();
		return $q->result();
		}


}//fin de clase