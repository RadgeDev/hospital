<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historial_egreso_model extends CI_Model {

	public function buscar($buscar,$inicio = FALSE, $cantidadregistro = FALSE,$valorbuscar=FALSE)
	{
		if ($valorbuscar==""){
			$valorbuscar="nombre_salida";
		}
		$this->db->like($valorbuscar,$buscar);
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
		}
		$consulta = $this->db->get("salidas");
		return $consulta->result();
	}
	public function buscar2($buscar,$inicio = FALSE, $cantidadregistro = FALSE,$valorbuscar=FALSE,$bodega=FALSE)
	{   
		
		if($buscar==="1"){
		
		$this->db->select('*');
        $this->db->from('producto');
        $this->db->where('cantidad <= stock_critico');
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
		}
	    $consulta = $this->db->get();
		return $consulta->result();

		}else if($buscar==="2"){

        $this->db->select('*');
        $this->db->from('producto');
        $this->db->where('cantidad <= stock_minimo');
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
		}
	    $consulta = $this->db->get();
		return $consulta->result();

		}else if($buscar==="3"){

        $this->db->select('*');
        $this->db->from('producto');
        $this->db->where('cantidad >= stock_maximo');
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
		}
	    $consulta = $this->db->get();
		return $consulta->result();

		}else{


		}
	}

function get_bodegas(){

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


function get_productos()
{
    // armamos la consulta
    $query = $this->db-> query('SELECT * FROM producto');

   return $query->result();

   
     }
function get_stockminimo()
{
    // armamos la consulta
        $this->db->select('*');
        $this->db->from('producto');
        $this->db->where('cantidad <= stock_minimo');
        $consulta = $this->db->get();
		return $consulta->result();
   
     }
	 function get_stockcritico()
{
    // armamos la consulta
        $this->db->select('*');
        $this->db->from('producto');
        $this->db->where('cantidad <= stock_critico');
        $consulta = $this->db->get();
		return $consulta->result();
   
     }

function get_stockmaximo()
{
    // armamos la consulta
        $this->db->select('*');
        $this->db->from('producto');
        $this->db->where('cantidad >= stock_maximo');
        $consulta = $this->db->get();
		return $consulta->result();
   
     }


function get_stockbodegamin($micod)
{
    // armamos la consulta
        $this->db->select('*');
        $this->db->from('producto');
		$this->db->where('cod_bodega',$micod)->where("(cantidad <= stock_minimo)");
        $consulta = $this->db->get();
		return $consulta->result();
   
     }

	 function get_stockbodegacri($micod)
{
    // armamos la consulta
        $this->db->select('*');
        $this->db->from('producto');
		$this->db->where('cod_bodega',$micod)->where("(cantidad <= stock_critico)");
        $consulta = $this->db->get();
		return $consulta->result();
   
     }
	 
	 function get_stockbodegamax($micod)
{
    // armamos la consulta
        $this->db->select('*');
        $this->db->from('producto');
		$this->db->where('cod_bodega',$micod)->where("(cantidad >= stock_maximo)");
        $consulta = $this->db->get();
		return $consulta->result();
   
     }

function get_nombrebodega($micod)
{
    // armamos la consulta
        $this->db->select('nombre');
        $this->db->from('bodegas');
        $this->db->where('cod_bodegas',$micod);
        $consulta = $this->db->get();
		return $consulta->result();
   
     }
}//fin de clase