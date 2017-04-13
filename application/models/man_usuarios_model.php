<?php 
 class Man_usuarios_model extends CI_Model
 {
 	
 	public function getUsuariosmodel()
 	{
   
    return $this->db->get('usuarios');

 	}

 }

  ?>