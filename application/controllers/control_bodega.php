<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_bodega extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Bodega_model");
	}

	public function index(){
		if(!$this->session->userdata("minombre")){
    redirect(base_url('home'));
   
         }else{
 	   $this->load->view('bodega/header');
		$this->load->view("bodega/nav");
		$this->load->view("bodega/vista_bodega/view_bodega");
		$this->load->view("bodega/vista_bodega/footer2"); 
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
			"bodega" => $this->Bodega_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Bodega_model->buscar($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}

function validar(){

		if ($this->input->is_ajax_request()) {
			$rutsele = $this->input->post("id");
			if($this->Bodega_model->validar($rutsele) == true)
				echo "Codigo existe";
			else
				echo "Codigo no existe";
			
		}
		else
		{
			show_404();
		}
	}

	function validarCorrelativo(){

		if ($this->input->is_ajax_request()) {
			$correlativo = $this->input->post("id");
			if($this->Bodega_model->validarCorrelativo($correlativo) == true)
				echo "Codigo existe";
			else
				echo "Codigo no existe";
			
		}
		else
		{
			show_404();
		}
	}
function validarCorrelativo2(){

		if ($this->input->is_ajax_request()) {
			$correlativo = $this->input->post("id");
			if($this->Bodega_model->validarCorrelativo($correlativo) == true)
				echo "Codigo existe";
			else
				echo "Codigo no existe";
			
		}
		else
		{
			show_404();
		}
	}
function guardar() {
		//El metodo is_ajax_request() de la libreria input permite verificar
		//si se esta accediendo mediante el metodo AJAX 
		if ($this->input->is_ajax_request()) {

			$codigo = $this->input->post("codigo");
			$nombre = $this->input->post("nombre");
			$correlativo = $this->input->post("correlativo");
            $pedido = $this->input->post("pedido");
			$entrega = $this->input->post("entrega");
    $this->form_validation->set_rules('codigo','Codigo','required|min_length[1]|max_length[10]');
	$this->form_validation->set_rules('nombre','Nombre','required|min_length[3]|max_length[50]|');
	$this->form_validation->set_rules('pedido','Pedido','required|min_length[3]|max_length[50]|');
	$this->form_validation->set_rules('entrega','Entrega','required|min_length[3]|max_length[50]|');
	$this->form_validation->set_rules('correlativo','Correlativo','required|min_length[2]|max_length[50]|alpha');
			

       if ($this->form_validation->run() === TRUE) {
   			$datos = array(
				"cod_bodegas" => $codigo,
				"nombre" => $nombre,
				"correlativo" => $correlativo,
				"horario_recepcion" => $pedido,
				"horario_entrega" => $entrega
				);

		if($this->Bodega_model->guardar($datos)==true)
				echo "Registro Guardado";
			else
				echo "No se pudo guardar los datos";
	        }
	        else
	        {
				echo validation_errors('<li>','</li>');
	        }
			
		}
		else
		{
			show_404();
		}
}


function actualizar(){
	
		if ($this->input->is_ajax_request()) {

			$codselect = $this->input->post("seleccod");
			$nombres = $this->input->post("selecnombre");
			$correlativo = $this->input->post("seleccorrelativo");
			$pedido = $this->input->post("selecpedido");
			$entrega = $this->input->post("selecentrega");
			$this->form_validation->set_rules('selecnombre','Nombre','required|min_length[3]|max_length[40]');
			$this->form_validation->set_rules('seleccorrelativo','Correlativo','required|min_length[2]|max_length[40]');
		    $this->form_validation->set_rules('selecpedido','Pedido','required|min_length[3]|max_length[50]|');
	        $this->form_validation->set_rules('selecentrega','Entrega','required|min_length[3]|max_length[50]|');
		if ($this->form_validation->run() === TRUE) {
	
			$datos = array(
				"nombre" => $nombres,
                "correlativo" => $correlativo,
				"horario_recepcion" => $pedido,
				"horario_entrega" => $entrega
				);
		
			if($this->Bodega_model->actualizar($codselect,$datos) == true)
				echo "Registro Actualizado";
			else
				echo "Error al Actualizar";
			
			}else
	{
				echo validation_errors('<li>','</li>');
	}
			
		}
		else
		{
			show_404();
		}
}


function editando() {

		if ($this->input->is_ajax_request()) {
			$codsele = $this->input->post("id");
         $data = array(
			"obtener" => $this->Bodega_model->editando($codsele)
         	);
            echo json_encode($data);
		}			
	}


function eliminar() {

		if ($this->input->is_ajax_request()) {

			$mipost = $this->input->post("micod");

			if($this->Bodega_model->eliminar($mipost) == true)
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