<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_depto extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Depto_model");
	}

	public function index(){
		$this->load->view('bodega/header');
		$this->load->view("bodega/nav");
		$this->load->view("bodega/vista_depto/view_depto");
		$this->load->view("bodega/vista_depto/footer2");
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
			"depto" => $this->Depto_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Depto_model->buscar($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}

function validar(){
		if ($this->input->is_ajax_request()) {
			$rutsele = $this->input->post("id");
			if($this->Depto_model->validar($rutsele) == true)
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

			$rut = $this->input->post("rut");
			$nombre = $this->input->post("nombre");
			$razon = $this->input->post("razon");
			$direccion = $this->input->post("direccion");
			$telefono = $this->input->post("telefono");
            $correo = $this->input->post("correo");

            $this->form_validation->set_rules('rut','Rut Proveedor','required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('nombre','Nombre','required|min_length[3]|max_length[50]|alpha');
			$this->form_validation->set_rules('razon','Razon Social','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('direccion','Direccion','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('telefono','Telefono','required|min_length[3]|max_length[50]|numeric');
			$this->form_validation->set_rules('correo','Correo','required|min_length[3]|max_length[50]|valid_email');

       if ($this->form_validation->run() === TRUE) {
   			$datos = array(
				"rut_proveedor" => $rut,
				"nombre_proveedor" => $nombre,
				"razon_social" => $razon,
				"direccion" => $direccion,
				"telefono" => $telefono,
				"correo" => $correo
				);
		if($this->Depto_model->guardar($datos)==true)
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

			$rutselect = $this->input->post("selecrut");
			$nombres = $this->input->post("selecnombre");
			$razon = $this->input->post("selecrazon");
			$direccion= $this->input->post("selecdireccion");
			$telefono = $this->input->post("selectelefono");
			$correo = $this->input->post("seleccorreo");

			$this->form_validation->set_rules('selecnombre','Nombre','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('selecrazon','Razon Social','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('selecdireccion','Direccion','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('selectelefono','Telefono','required|min_length[3]|max_length[50]|numeric');
			$this->form_validation->set_rules('seleccorreo','Correo','required|min_length[3]|max_length[50]|valid_email');
		
		if ($this->form_validation->run() === TRUE) {
	
			$datos = array(
				"nombre_proveedor" => $nombres,
				"razon_social" => $razon,
				"direccion" => $direccion,
		        "telefono" => $telefono,
		        "correo" => $correo,
				);
		
			if($this->Depto_model->actualizar($rutselect,$datos) == true)
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
			$rutsele = $this->input->post("id");
         $data = array(
			"obtener" => $this->Depto_model->editando($rutsele)
         	);
            echo json_encode($data);
		}

     
			
	}


function eliminar() {
		if ($this->input->is_ajax_request()) {

			$mipost = $this->input->post("mirut");

			if($this->Depto_model->eliminar($mipost) == true)
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