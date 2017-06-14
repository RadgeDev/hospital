<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salida_model extends CI_Model {

	Public function buscar($buscar)
	{
$this->db->select('*');
$this->db->from('pedidos');
$this->db->where('cod_depto',$buscar)->where("(estado='Activo')");
$query=$this->db->get();
return $query->result();
	}

Public function cargartabla($buscar)
	{
$this->db->select('*');
$this->db->from('detalle_pedido');
$this->db->where('folio',$buscar);
$query=$this->db->get();
return $query->result();
	}
	Public function cargarlote($buscar)
	{
$this->db->select('*');
$this->db->from('lotes');
$this->db->where('cod_producto',$buscar)->where("(estado='Activo')");
$query=$this->db->get();
return $query->result();
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
		$this->db->insert("compra",$data);
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

               $query = $this->db-> query('SELECT max(cod_salida) AS codsalida FROM salidas');
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

function get_tipoingreso(){

    // armamos la consulta
    $query = $this->db-> query('SELECT cod_ingreso,nombre FROM tipo_ingreso');

    // si hay resultados
    if ($query->num_rows() > 0) {
        // almacenamos en una matriz bidimensional
        foreach($query->result() as $row)
           $arrDatos[htmlspecialchars($row->cod_ingreso, ENT_QUOTES)] = 
      htmlspecialchars($row->nombre, ENT_QUOTES);

        $query->free_result();
        return $arrDatos;
     }
}

function get_tipocompra(){

    // armamos la consulta
    $query = $this->db-> query('SELECT cod_tipocompra,nombre FROM tipo_compra');

    // si hay resultados
    if ($query->num_rows() > 0) {
        // almacenamos en una matriz bidimensional
        foreach($query->result() as $row)
           $arrDatos[htmlspecialchars($row->cod_tipocompra, ENT_QUOTES)] = 
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
    $this->db->insert('detalle_compra', $data);
    if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
				$this->db->_error_message(); 
			return false;
		}
}
}//fin de clase modelo