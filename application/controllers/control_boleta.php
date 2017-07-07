<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_boleta extends CI_Controller {
	public function __construct(){
		parent::__construct();
		    $this->load->model("Compra_ingreso_model");
			$this->load->model("Producto_model");
			$this->load->model("Boleta_model");
		
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
         $tipobody='bodega/vista_boleta/view_boleta';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/vista_boleta/view_boleta';
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
	    $datoscorrelativo['arrayCorrelativo'] = $this->Producto_model->get_correlativo();
		$this->load->view($tipobody,array_merge($datoscorrelativo));
		$this->load->view("bodega/vista_boleta/footer2");
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
$datosfolior = array(
			"folio" => $this->Boleta_model->obtenerfolio()
			
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

function guardaringreso() {
		//El metodo is_ajax_request() de la libreria input permite verificar
		//si se esta accediendo mediante el metodo AJAX 
	if ($this->input->is_ajax_request()) {

			$nfolio	= $this->input->post("minfolio");
            $tipoingresocod	= $this->input->post("mitipoingresocod");
            $tipoingresonombre= $this->input->post("mitipoingresonombre");
            $ndocumento= $this->input->post("mindocumento");
            $nfolio= $this->input->post("minfolio");
            $tipocompracod= $this->input->post("mitipocompracod");
            $tipocompranombre = $this->input->post("mitipocompranombre");
            $nombreproveedor = $this->input->post("minombreproveedor");
            $rutproveedor= $this->input->post("mirutproveedor");
            $fecha= $this->input->post("mifecha");
			$mifecha= date('Y-m-d', strtotime($fecha));
            $nombreproduct= $this->input->post("minombreproduct");
            $codbarraproduct= $this->input->post("micodbarraproduct");
            $correlativoprod= $this->input->post("micorrelativoprod");
            $comentarios= $this->input->post("micomentarios");
            $descuento= $this->input->post("midescuento");
			if ( $tipoingresocod ==="1"){
            $neto= $this->input->post("subtotal");
		    }else{
            $neto= $this->input->post("mineto");
		    }
            $iva = $this->input->post("miiva");
            $total= $this->input->post("mitotal");
            $usuario= $this->session->userdata('mirut');
			$nombreusuario= $this->session->userdata('minombre');
     

   
   			$datos = array(
   				"cod_compra" => $nfolio,
				"tipo_documento" => $tipoingresonombre,
				"numero_documento" => $ndocumento,
				"tipo_compra" => $tipocompracod,
				"tipo_compra_nombre" => $tipocompranombre,
				"rut_proveedor" => $rutproveedor,
				"nombre_proveedor" => $nombreproveedor,
				"fecha" => $mifecha,
				"neto" => $neto,
				"iva" => $iva,
				"total_compra" => $total,
				"descuento" => $descuento,
				"usuario" => $usuario,
				"nombre_usuario" => $nombreusuario,
				"comentarios" => $comentarios
				);
   	
		if($this->Boleta_model->guardar($datos)==true){
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
			$fecha= $d->fechavenc;
			$fechavenc= date('Y-m-d', strtotime($fecha));
            $array_detalle = array(
            "cod_compra" => $d->folio,
            "cod_producto" => $d->codinterno,
            "cod_barra" => $d->codbarra,
             "nombre_prod" => $d->nombre,
            "numero_lote" => $d->lote,
             "fecha_vencimiento" => $fechavenc,
             "cantidad" => $d->cantidad,
             "precio" => $d->valor,
             "total" => $d->total
        );
	
            
       //Call the save method  
    if( $this->Boleta_model->guardardetalle($array_detalle)==true){
  $data = array(
			"miresultado" =>"bien"
         	);
		
			}else{
				echo "error";
		

		}
		echo json_encode($data);
}
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