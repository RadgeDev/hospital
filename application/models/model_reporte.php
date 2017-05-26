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
}