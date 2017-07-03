<?php

/**
* 
*/
class Model_reporte extends CI_Model
{
	
function getcompra($micod)

{
$this->db->select('*');
$this->db->from('compra');
$this->db->where('cod_compra',$micod);
$query=$this->db->get();
return $query->result();
}


function getcompradetalle($micod)
{

$this->db->select('*');
$this->db->from('detalle_compra');
$this->db->where('cod_compra',$micod);
$query=$this->db->get();
return $query->result();
}

function getnombre($mirut)
{

$this->db->select('nombre');
$this->db->from('usuarios');
$this->db->where('rut',$mirut);
$query=$this->db->get();
return $query->result();
}

function getpedido($micod)

{
$this->db->select('*');
$this->db->from('pedidos');
$this->db->where('folio',$micod);
$query=$this->db->get();
return $query->result();
}


function getpedidodetalle($micod)
{

$this->db->select('*');
$this->db->from('detalle_pedido');
$this->db->where('folio',$micod);
$query=$this->db->get();
return $query->result();

}


function getsalida($micod)
{
$this->db->select('*');
$this->db->from('salidas');
$this->db->where('cod_salida',$micod);
$query=$this->db->get();
return $query->result();

}


function getsalidadetalle($micod)
{

$this->db->select('*');
$this->db->from('detalle_salida');
$this->db->where('cod_salida',$micod);
$query=$this->db->get();
return $query->result();

}

function getboleta($micod)
{
$this->db->select('*');
$this->db->from('compra_directa');
$this->db->where('cod_compra',$micod);
$query=$this->db->get();
return $query->result();

}


function getboletadetalle($micod)
{

$this->db->select('*');
$this->db->from('detalle_compra_directa');
$this->db->where('cod_compra',$micod);
$query=$this->db->get();
return $query->result();

}



}