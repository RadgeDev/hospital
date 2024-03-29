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


	Public function eliminarpedido($buscar)
	{

		$sql = "UPDATE pedidos SET estado='Desact' WHERE folio=".$buscar;
        $this->db->query($sql);

	}


	Public function cargarlote($buscar)
	{
$this->db->select('*');
$this->db->from('lotes');
$this->db->where('cod_producto',$buscar)->where("(estado='Activo')");
$query=$this->db->get();
return $query->result();
	}

Public function cargarlotevenc($buscar)
{
$this->db->select('*');
$this->db->from('lotes');
$this->db->where('fecha_vencimiento <= CURDATE()' )->where('cod_producto',$buscar)->where("(estado='Activo')");
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

	function guardarsalida($data) {
		$this->db->insert("salidas",$data);
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
     	$this->db->select('*');
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
	 function get_nombreproveedor($codselec){

    // armamos la consulta
	$this->db->select("nombre_proveedor");
	$this->db->from("lotes");
	$this->db->where('lote',$codselec);
	$q= $this->db->get();
	return $q->result();


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
    $this->db->insert('detalle_salida', $data);
    if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
				$this->db->_error_message(); 
			return false;
		}
}

function get_cantidadlotes($lote,$codprod){
$this->db->select('cantidad');
$this->db->from('lotes');
$this->db->where('lote',$lote)->where("(cod_producto='" .$codprod."')");
$query=$this->db->get();
return $query->result();
}

function actualizarlotes($lote,$codprod,$data){

        $this->db->where('lote',$lote)->where("(cod_producto='" .$codprod."')");
		$this->db->update('lotes', $data); 
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
				$this->db->_error_message(); 
			return $this->db->_error_message(); 
		}
	}


Public function desactivarlote($codped)
	{
    $this->db-> query('UPDATE lotes SET estado="Desact" WHERE cantidad="0"');
	}
  

Public function desactivarpedido($codped,$data)
	{
    $this->db->where('folio',$codped);
	$this->db->update('pedidos', $data); 
	}
}//fin de clase modelo