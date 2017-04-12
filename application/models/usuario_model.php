<?php  if (! defined('BASEPATH')) exit('No direct script access allowed');
class Usuario_model extends CI_Model
{
	public $variable;
	public function  __construct() 
	{
		parent::__construct();

	}

	public function login($username,$password)
	/*
	nos devuelve una fila es por que existe
	 */
	{   $this->load->database();
		$this->db->where('login',$username);
		$this->db-> where('password',$password);
		$q= $this->db->get('usuarios');
		if($q->num_rows()>0)
		{
			return true;
		}else
		{
			return false;
		}

		}
	}


?>