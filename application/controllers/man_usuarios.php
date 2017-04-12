<?php  
class Man_usuarios extends CI_Controller
{

	public function index() {
    $this->load->view('bodega/header');
      $this->load->view('bodega/nav');
        $this->load->view('bodega/usuarios');
        $this->load->view('bodega/footer');
	}

}