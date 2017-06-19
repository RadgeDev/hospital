<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_salida extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Compra_ingreso_model");
		$this->load->model("Salida_model");
	    $this->load->model("Producto_model");
		 $this->load->model("Pedidos_model");
	}

	public function index(){
		$this->load->view('bodega/header');
		$this->load->view("bodega/nav");
		$datosdepto['arrayTipodepto'] = $this->Pedidos_model->get_depto();
	  $datoscorrelativo['arrayCorrelativo'] = $this->Producto_model->get_correlativo();
	  
		$this->load->view("bodega/vista_salida/view_salidas",array_merge($datosdepto,$datoscorrelativo));
		$this->load->view("bodega/vista_salida/footer2");
	}

	public function mostrarpedido()
	{	
		//valor a Buscar
		$buscar = $this->input->post("buscar");
		$data = array(
			"obtener" => $this->Salida_model->buscar($buscar)
		);
		echo json_encode($data);
	}

		public function cargartabla()
	{	
		//valor a Buscar
		$buscar = $this->input->post("buscar");
		$data = array(
			"obtener" => $this->Salida_model->cargartabla($buscar)
		);
		echo json_encode($data);
	}
		public function cargarlotes()
	{	
		//valor a Buscar
		$buscar = $this->input->post("buscar");
		$data = array(
			"obtener" => $this->Salida_model->cargarlote($buscar)
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
$datosfolior = array(
			"folio" => $this->Salida_model->obtenerfolio()
			
		);
	echo json_encode($datosfolior);
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

function guardarsalida() {
		//El metodo is_ajax_request() de la libreria input permite verificar
		//si se esta accediendo mediante el metodo AJAX 
	if ($this->input->is_ajax_request()) {

			$nsalida = $this->input->post("minsalida");
			$npedido = $this->input->post("minpedido");
            $tiposalidacod	= $this->input->post("mitiposalidacod");
            $tiposalidanombre= $this->input->post("mitiposalidanombre");
            $tipodeptocod= $this->input->post("mitipodeptocod");
            $tipodeptonombre= $this->input->post("mitipodeptonombre");
            $fecha= $this->input->post("mifecha");
            $usuario= $this->session->userdata('mirut');
			$nombreusuario= $this->session->userdata('minombre');
            $micomentario=$this->input->post("micomentario");

   
   			$datos = array(
   				"cod_salida" => $nsalida,
				"cod_tiposalida" => $tiposalidacod,
				"nombre_salida" => $tiposalidanombre,
				"cod_depto" => $tipodeptocod,
				"nombre_depto" => $tipodeptonombre,
				"num_pedido" => $npedido,
				"fecha" => $fecha,
				"usuario" => $usuario,
				"nombre" => $nombreusuario,
				"comentarios" => $micomentario
				);
   	
		if($this->Salida_model->guardarsalida($datos)==true){
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
            $detalle_salida = array(
            "cod_salida" => $d->nsalida,
            "cod_producto" => $d->codinterno,
            "nombre_prod" => $d->nombre,
            "lote" => $d->lote,
            "fecha_vencimiento" => $d->fechavenc,
            "cantidad" => $d->entrega,
            "valor" => $d->valor
        );
            
       //Call the save method
       $this->Salida_model->guardardetalle($detalle_salida);
    }
/*
foreach($data->datos as $d) {
$micodigo=$d->codinterno;
$cantidadactual= $this->Compra_ingreso_model->get_cantidad($micodigo);
print_r($cantidadactual);
$actual=0;
foreach( $cantidadactual  as $r){
   $actual = $r->cantidad;
}
$micantidadingresar=$d->cantidad;
(int)$totalcantidad=(int)$micantidadingresar+(int)$actual;
$datosactualizar = array(
				"cantidad" =>$totalcantidad
				

			);	
 $this->Compra_ingreso_model->actualizarproducto($micodigo,$datosactualizar);
			}	

    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        echo json_encode("Failed to Save Data");
    } else {
        $this->db->trans_commit();
        echo json_encode("Success!");
    }

*/

	
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