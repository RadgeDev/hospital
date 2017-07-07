<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_historial_pedido extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Historial_pedido_model");
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
         $tipobody='bodega/vista_historial_pedido/view_historial_pedido';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/vista_historial_pedido/view_historial_pedido';
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
		$this->load->view("bodega/vista_historial_pedido/footer2");
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
			"obtener" => $this->Historial_pedido_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Historial_pedido_model->buscar($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}


} 

