<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor_model extends CI_Model {

public function buscar($buscar,$inicio = FALSE, $cantidadregistro = FALSE)
	{
		$this->db->like("nombre_proveedor",$buscar);
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
		}
		$consulta = $this->db->get("proveedor");
		return $consulta->result();
	}
}


