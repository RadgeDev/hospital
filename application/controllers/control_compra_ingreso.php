<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_compra_ingreso extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Compra_ingreso_model");
			$this->load->model("Producto_model");
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
         $tipobody='bodega/vista_compra/view_ingreso_compra';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/vista_compra/view_ingreso_compra';
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
		$datostipoingreso['arrayTipoingreso'] = $this->Compra_ingreso_model->get_tipoingreso();
		$datostipocompra['arrayTipocompra'] = $this->Compra_ingreso_model->get_tipocompra();
	  $datoscorrelativo['arrayCorrelativo'] = $this->Producto_model->get_correlativo();
	  
		$this->load->view($tipobody,array_merge($datostipoingreso, $datostipocompra,$datoscorrelativo));
		$this->load->view("bodega/vista_compra/footer2");
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
			"folio" => $this->Compra_ingreso_model->obtenerfolio()
			
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
			$subtotal= $this->input->post("subtotal");
			$mifecha= date('Y-m-d', strtotime($fecha));
            $nombreproduct= $this->input->post("minombreproduct");
            $codbarraproduct= $this->input->post("micodbarraproduct");
            $correlativoprod= $this->input->post("micorrelativoprod");
            $comentarios= $this->input->post("micomentarios");
            $descuento= $this->input->post("midescuento");
            $neto= $this->input->post("mineto");
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
				"subtotal" => $subtotal,
				"neto" => $neto,
				"iva" => $iva,
				"total_compra" => $total,
				"descuento" => $descuento,
				"usuario" => $usuario,
				"nombre_usuario" => $nombreusuario,
				"comentarios" => $comentarios
				);
   	
		if($this->Compra_ingreso_model->guardar($datos)==true){
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

	 	$estado="Activo"; 
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
		$lote_array = array(
			"lote" => $d->lote,
            "cod_producto" => $d->codinterno,
             "nombre" => $d->nombre,
             "fecha_vencimiento" => $fechavenc,
             "cantidad" => $d->cantidad,
             "precio" => $d->valor,
			 "rut_proveedor" => $d->rutproveedor,
			 "nombre_proveedor" => $d->proveedor,
             "estado" =>$estado
        );
            
       //Call the save method
       $this->Compra_ingreso_model->guardardetalle($array_detalle);   
       $this->Compra_ingreso_model->guardarlote($lote_array);
    }


foreach($data->datos as $d) {
$micodigo=$d->codinterno;
$cantidadactual= $this->Compra_ingreso_model->get_cantidad($micodigo);
$actual=0;
foreach( $cantidadactual  as $r){
   $actual = $r->cantidad;
}
$micantidadingresar=$d->cantidad;
(int)$totalcantidad=(int)$micantidadingresar+(int)$actual;

			$fecha= $d->fecha;
			$fechact= date('Y-m-d', strtotime($fecha));
            
			$datosactualizar = array(
				"cantidad" =>$totalcantidad
			                         );	
			$datosbincard = array(
                "cod_producto" => $d->codinterno,
				"nombre"  => $d->nombre,
				"cod_depto" =>"0",
				"seccion" =>"N/N",
				"proveedor"=> $d->proveedor,
				"entrada"=> $d->cantidad,
			    "salida" =>"0",
				"saldo" =>$totalcantidad,
			    "fecha" => $fechact,
                "cod_compra"=> $d->folio,
                "cod_salida" =>"0"
                 );	
				  //Call the save method
    $this->Compra_ingreso_model->guardarbincard($datosbincard);   
    $this->Compra_ingreso_model->actualizarproducto($micodigo,$datosactualizar);
			}	

    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        echo json_encode("Failed to Save Data");
    } else {
        $this->db->trans_commit();
        echo json_encode("Success!");
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