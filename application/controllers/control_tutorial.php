<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_tutorial extends CI_Controller {


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
          $tipobody='bodega/vista_tutorial/view_tutorial';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/vista_tutorial/view_tutorial';
         break;
   case "Invitado":
         $tiponav="bodega/nav_invitado";
         $tipobody='bodega/vista_tutorial/view_tutorial';
         break;
   default:
        $tiponav="bodega/nav_invitado";
        $tipobody='bodega/vista_tutorial/view_tutorial';
}
		$this->load->view('bodega/header');
		$this->load->view($tiponav);
		$this->load->view($tipobody);
		$this->load->view("bodega/vista_tutorial/footer2");
	}

	
} 
}

