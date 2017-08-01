<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_consumo extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Consumo_model");
		$this->load->model("Pedidos_model");
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
         $tipobody='bodega/vista_consumo/view_consumo';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/vista_consumo/view_consumo';
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
		$datosdepto['arrayTipodepto'] = $this->Pedidos_model->get_depto();
		$datospedido['arrayTipopedido'] = $this->Pedidos_model->get_pedido();
		$this->load->view($tipobody,array_merge($datosdepto, $datospedido));
		$this->load->view("bodega/vista_consumo/footer2");
	}
}



public function mostrar()
	{	
		//valor a Buscar
		$bodega = $this->input->post("mibodega");
		$numeropagina = $this->input->post("mipagina");
		$cantidad = $this->input->post("micantidad");
		$miinicio= $this->input->post("miinicio");
		$mifin= $this->input->post("mifin");
		$inicio = ($numeropagina -1)*$cantidad;
		$data = array(
			"obtener" => $this->Consumo_model->buscar($miinicio,$inicio,$cantidad,$mifin,$bodega),
			"totalregistros" => count($this->Consumo_model->buscar($miinicio,$inicio,$cantidad,$mifin,$bodega)),
			"cantidad" =>$cantidad
		);
		echo json_encode($data);
	}


	
} 

