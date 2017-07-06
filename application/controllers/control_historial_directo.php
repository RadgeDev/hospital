<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_historial_directo extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Historial_directo_model");
	}

	public function index(){
		if(!$this->session->userdata("minombre")){
        redirect(base_url('home'));
        }
		$this->load->view('bodega/header');
		$this->load->view("bodega/nav");
		$this->load->view("bodega/vista_historial_directo/view_historial_directo");
		$this->load->view("bodega/vista_historial_directo/footer2");
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
			"obtener" => $this->Historial_directo_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Historial_directo_model->buscar($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}


} 

