<?php 
 class Man_usuarios_model extends CI_Model
 {
 	
 	public function getUsuariosmodel()
 	{
   
    return $this->db->get('usuarios');

 	}

function mostrar($valor){
$this->db->like("rut",$valor);
$consulta = $this->db->get("usuarios");
return $consulta->result();
}
 }

  ?>