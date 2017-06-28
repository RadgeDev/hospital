<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_tipo_ingreso extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("tipo_ingreso_model");
	}

	public function index(){
		if(!$this->session->userdata("minombre")){
        redirect(base_url('home'));
        }
		$this->load->view('bodega/header');
		$this->load->view("bodega/nav");
		$this->load->view("bodega/vista_tipo_ingreso/view_tipo_ingreso");
		$this->load->view("bodega/vista_tipo_ingreso/footer2");
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
			"mostrar" => $this->tipo_ingreso_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->tipo_ingreso_model->buscar($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}

function validar(){
		if ($this->input->is_ajax_request()) {
			$rutsele = $this->input->post("id");
			if($this->tipo_ingreso_model->validar($rutsele) == true)
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
		

            $this->form_validation->set_rules('codigo','Codigo','required|min_length[1]|max_length[100]');
			$this->form_validation->set_rules('nombre','Nombre','required|min_length[3]|max_length[50]|');
			

       if ($this->form_validation->run() === TRUE) {
   			$datos = array(
				"cod_ingreso" => $codigo,
				"nombre" => $nombre
				);

		if($this->tipo_ingreso_model->guardar($datos)==true)
				echo "Registro Guardado";
			else
				echo "No se pudo guardar los datos";
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

function actualizar(){
	
		if ($this->input->is_ajax_request()) {

			$codselect = $this->input->post("seleccod");
			$nombres = $this->input->post("selecnombre");
			

			
			$this->form_validation->set_rules('selecnombre','Nombre','required|min_length[3]|max_length[50]');
		
		if ($this->form_validation->run() === TRUE) {
	
			$datos = array(
				"nombre" => $nombres
				);
		
			if($this->tipo_ingreso_model->actualizar($codselect,$datos) == true)
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
			"obtener" => $this->tipo_ingreso_model->editando($codsele)
         	);
            echo json_encode($data);
		}

     
			
	}


function eliminar() {
		if ($this->input->is_ajax_request()) {

			$mipost = $this->input->post("micod");

			if($this->tipo_ingreso_model->eliminar($mipost) == true)
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