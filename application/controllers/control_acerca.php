<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_acerca extends CI_Controller {


	public function index(){
	if(!$this->session->userdata("minombre")){
    redirect(base_url('home'));
   
    }else{
	$tiponav="";
    $tipobody="";
	$misesion=$this->session->userdata("usuario");

 switch ($misesion) {
   case "Administrador":
         $tiponav= 'bodega/nav'; 
          $tipobody='bodega/vista_acerca/view_acerca';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/vista_acerca/view_acerca';
         break;
   case "Invitado":
         $tiponav="bodega/nav_invitado";
         $tipobody='bodega/vista_acerca/view_acerca';
         break;
   default:
        $tiponav="bodega/nav_invitado";
        $tipobody='bodega/vista_acerca/view_acerca';
}
		$this->load->view('bodega/header');
		$this->load->view($tiponav);
		$this->load->view($tipobody);
		$this->load->view("bodega/vista_acerca/footer2");
	}

	
} 
}

