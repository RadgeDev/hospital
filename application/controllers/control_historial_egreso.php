<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_historial_egreso extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Historial_egreso_model");
	}

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
         $tipobody='bodega/vista_historial_egreso/view_historial_egreso';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/vista_historial_egreso/view_historial_egreso';
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
		$this->load->view( $tiponav);
		$datosdepto['arrayBodegas'] = $this->Historial_egreso_model->get_bodegas();
		$this->load->view( $tipobody,$datosdepto);
		$this->load->view("bodega/vista_historial_egreso/footer2");
	}
}
	public function mostrar()
	{	
		//valor a Buscar
		$buscar = $this->input->post("buscar");
		$numeropagina = $this->input->post("nropagina");
		$cantidad = $this->input->post("cantidad");
		$combobuscar= $this->input->post("valorcombos");
		$inicio = ($numeropagina -1)*$cantidad;
		$data = array(
			"obtener" => $this->Historial_egreso_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Historial_egreso_model->buscar($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}


} 

