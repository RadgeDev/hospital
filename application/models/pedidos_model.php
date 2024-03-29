<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos_model extends CI_Model {

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
		$this->db->insert("pedidos",$data);
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
				$this->db->_error_message(); 
			return false;
		}
	}	

	function actualizarproducto($codigo,$data){
		$this->db->where('cod_interno_prod', $codigo);
		$this->db->update('producto', $data); 
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

	public function obtenerfolio(){

               $query = $this->db-> query('SELECT max(folio) AS folio FROM pedidos');
               if ($query->num_rows() > 0) {
               return $query->result();
                }else
                       {
	             return "error";
                        }
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

function get_depto(){

    // armamos la consulta
    $query = $this->db-> query('SELECT cod_depto,nombre_depto FROM depto');

    // si hay resultados
    if ($query->num_rows() > 0) {
        // almacenamos en una matriz bidimensional
        foreach($query->result() as $row)
           $arrDatos[htmlspecialchars($row->cod_depto, ENT_QUOTES)] = 
      htmlspecialchars($row->nombre_depto, ENT_QUOTES);

        $query->free_result();
        return $arrDatos;
     }
}

function get_pedido(){

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

function get_proveedor(){

    // armamos la consulta
    $query = $this->db-> query('SELECT rut_proveedor,nombre_proveedor FROM proveedor');

   return $query->result();

   
     }

function get_productos()
{
    // armamos la consulta
    $query = $this->db-> query('SELECT cod_interno_prod,codigo_barra,nombre FROM producto');

   return $query->result();

   
     }
function get_cantidad($micod){
$this->db->select('cantidad');

$this->db->from('producto');

$this->db->where('cod_interno_prod',$micod);

$query=$this->db->get();

   return $query->result();
     }


public function guardardetalle($data) {
    $this->db->insert('detalle_pedido', $data);
    if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
				$this->db->_error_message(); 
			return false;
		}
}
}//fin de clase modelo