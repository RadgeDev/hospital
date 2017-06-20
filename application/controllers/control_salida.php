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
 $micodigo=0;
 $obtenerstock=0;
 $stockactual=0;
 $stockactualote=0;
 
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
	
  	        $stockactual=0;
			$stockactualote=0;
			$totalcantidad=0;
			$totalcantidadlote=0;
			$mientrega= $d->entrega;
			$milote= $d->lote;
			echo json_encode($milote);
		    $micodigo=$d->codinterno;

		    $obtenerstock= $this->Compra_ingreso_model->get_cantidad($micodigo);
	        foreach( $obtenerstock  as $r){
            $stockactual = $r->cantidad;
            }
			(int)$totalcantidad=(int)$stockactual-(int)$mientrega;
              $datosactualizar = array(
				"cantidad" =>$totalcantidad
			);	
			
		    $stockactualote=0;
			$totalcantidadlote=0;
            $obtenerstocklote= $this->Salida_model->get_cantidadlotes($milote,$micodigo);
	        foreach( $obtenerstocklote  as $r){
            $stockactualote = $r->cantidad;
            } 
			
			(int)$totalcantidadlote=(int)$stockactualote-(int)$mientrega;
            $datosactualizarlote = array(
				"cantidad" =>$totalcantidadlote
			);	
	
           //Call the save method
		   	$this->Salida_model->actualizarlotes($milote,$micodigo,$datosactualizarlote);
           $this->Salida_model->guardardetalle($detalle_salida);
		   $this->Compra_ingreso_model->actualizarproducto($micodigo,$datosactualizar);
		  	$this->Salida_model->desactivarlote();
		  
    }

	}

function lotes() {

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