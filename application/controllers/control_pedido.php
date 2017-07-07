<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_pedido extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Compra_ingreso_model");
		$this->load->model("Producto_model");
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
         $tipobody='bodega/vista_pedido/view_pedido';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/vista_pedido/view_pedido';
         break;
   case "Invitado":
         $tiponav="bodega/nav_invitado";
         $tipobody='bodega/vista_pedido/view_pedido';
         break;
   default:
        $tiponav="bodega/nav_invitado";
        $tipobody='bodega/vista_acerca/view_acerca';
}
		$this->load->view('bodega/header');
		$this->load->view($tiponav);
		$datosdepto['arrayTipodepto'] = $this->Pedidos_model->get_depto();
		$datospedido['arrayTipopedido'] = $this->Pedidos_model->get_pedido();
	    $datoscorrelativo['arrayCorrelativo'] = $this->Producto_model->get_correlativo();
		$this->load->view( $tipobody,array_merge($datosdepto, $datospedido,$datoscorrelativo));
		$this->load->view("bodega/vista_pedido/footer2");
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
			"obtener" => $this->Producto_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Producto_model->buscar($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}
function devolverarray() {
$datosproveedor = array(
			"proveedor" => $this->Compra_ingreso_model->get_proveedor()
			
		);
	echo json_encode($datosproveedor);
}
function devolverfolio() {
$datosfolio = array(
			"folio" => $this->Pedidos_model->obtenerfolio()
			
		);
	echo json_encode($datosfolio);
}


function devolverproductos() {
$datosproductos = array(
			"misproductos" => $this->Compra_ingreso_model->get_productos()
			
		);
	echo json_encode($datosproductos);
}


	

function validar(){
		if ($this->input->is_ajax_request()) {
			$rutsele = $this->input->post("id");
			if($this->Producto_model->validar($rutsele) == true)
				echo "Rut existe";
			else
				echo "rut no existe";
			
		}
		else
		{
			show_404();
		}
	}

function obtenercorrelativo(){

			if ($this->input->is_ajax_request()) {
			$codsele = $this->input->post("cod");
         $data = array(
			"obtener" => $this->Producto_model->obtenercorrelativo($codsele)
         	);
            echo json_encode($data);
		}
	}

function hora(){
  date_default_timezone_set("Chile/Continental");
   echo date("H:i:s"); 
}

function fecha(){
   date_default_timezone_set("Chile/Continental");
   echo date("d-m-Y");
}

function guardarpedido() {
		//El metodo is_ajax_request() de la libreria input permite verificar
		//si se esta accediendo mediante el metodo AJAX 
	if ($this->input->is_ajax_request()) {

			$nfolio	= $this->input->post("minfolio");
            $fecha	= $this->input->post("mifecha");
			$mifecha= date('Y-m-d', strtotime($fecha));
            $hora= $this->input->post("mihora");
            $deptocod= $this->input->post("mitipodeptocod");
            $deptonombre= $this->input->post("mideptonombre");
            $tipocompracod= $this->input->post("mitipocompracod");
            $tipocompranombre = $this->input->post("mitipocompranombre");
            $codtiempo = $this->input->post("mitiempocod");
            $nombretiempo= $this->input->post("mitiemponombre");
            $pedidocod= $this->input->post("mipedidocod");
            $pedidonombre= $this->input->post("mipedidonombre");
            $usuario= $this->session->userdata('mirut');
			$nombreusuario= $this->session->userdata('minombre');
            $comentario= $this->input->post("micomentario");
            $estado="activo";
   
   			$datos = array(
   				"folio" => $nfolio,
				"fecha" => $mifecha,
				"hora" => $hora,
				"cod_depto" => $deptocod,
				"depto" => $deptonombre,
				"cod_tipo_pedido" => $pedidocod,
				"tipo_pedido" => $pedidonombre,
				"tiempo_pedido" => $nombretiempo,
				"rut" => $usuario,
				"nombre" => $nombreusuario,
				"comentario"=> $comentario,
				"estado"=>$estado
				);
   	
		if($this->Pedidos_model->guardar($datos)==true){
  $data = array(
			"miresultado" =>"bien"
         	);
		
			}else{
				echo "error";
		

		}
		echo json_encode($data);
}
}

function guardardetalle() {

	
 $data = json_decode($this->input->post('sendData'));
 
          foreach($data->datos as $d) {
            $filter_data = array(
            "folio" => $d->folio,
            "cod_producto" => $d->codinterno,
            "cod_barra" => $d->codbarra,
            "nombre_prod" => $d->nombre,
            "cantidad" => $d->cantidad 
        );
            
       //Call the save method
	   if($this->Pedidos_model->guardardetalle($filter_data)==true){
                $data = array(
			"miresultado" =>"bien"
         	);
		
			}else{
				echo "error";
		

		}
	
       
    }

	echo json_encode($data);
	}

function editando() {

		if ($this->input->is_ajax_request()) {
			$codselec = $this->input->post("id");
         $data = array(
			"obtener" => $this->Producto_model->editando($codselec)
         	);
            echo json_encode($data);
		}

     
			
	}


function eliminar() {
		if ($this->input->is_ajax_request()) {

			$mipost = $this->input->post("micodigo");

			if($this->Producto_model->eliminar($mipost) == true)
				echo "Registro Eliminado";
			else
				echo "No se pudo eliminar los datos";
			
		}
		else
		{
			show_404();
		}
	}






} 