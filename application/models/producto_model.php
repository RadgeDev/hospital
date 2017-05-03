<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto_model extends CI_Model {

	public function buscar($buscar,$inicio = FALSE, $cantidadregistro = FALSE,$valorbuscar=FALSE)
	{
		if ($valorbuscar==""){
			$valorbuscar="cod_interno_prod";
		}
		$this->db->like($valorbuscar,$buscar);
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
		}
		$consulta = $this->db->get("producto");
		return $consulta->result();
	}


	function validar( $rutsele){
		$this->db->where('cod_interno_prod', $rutsele);
		$this->db->get("producto");
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}

	function guardar($data) {
		$this->db->insert("producto",$data);
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}	

	function actualizarcorrelativo($codigo,$data){
		$this->db->where('cod_bodegas', $codigo);
		$this->db->update('bodegas', $data); 
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}
 	function actualizar($codigo,$data){
		$this->db->where('cod_interno_prod', $codigo);
		$this->db->update('producto', $data); 
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}
 

public function editando($codselec){
		$this->db->where('cod_interno_prod',$codselec);
		$q= $this->db->get('producto');
		return $q->result();
		}

	public function obtenercorrelativo($codselec){

		$this->db->where('cod_bodegas',$codselec);
		
		$q= $this->db->get('bodegas');
		return $q->result();

		}


public function eliminar($rutas){
		$this->db->where('cod_interno_prod',$rutas);
		$this->db->delete('producto'); 
	  if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}

function get_correlativo(){

    // armamos la consulta
    $query = $this->db-> query('SELECT cod_bodegas,nombre FROM bodegas');

    // si hay resultados
    if ($query->num_rows() > 0) {
        // almacenamos en una matriz bidimensional
        foreach($query->result() as $row)
           $arrDatos[htmlspecialchars($row->cod_bodegas, ENT_QUOTES)] = 
      htmlspecialchars($row->nombre, ENT_QUOTES);

        $query->free_result();
        return $arrDatos;
     }
}

}//fin de clase