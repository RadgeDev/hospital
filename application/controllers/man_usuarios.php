<?php  
class Man_usuarios extends CI_Controller
{

	public function index() {
    $this->load->view('bodega/header');
    $this->load->view('bodega/nav');
    $this->load->model('man_usuarios_model');
    $resultado = $this->man_usuarios_model->getUsuariosmodel();
    $data = array('consulta'=> $resultado);
    $this->load->view('bodega/usuarios', $data);
    $this->load->view('bodega/footer2');


	}

 function mostrar(){
		if($this->input->is_ajax_request()){
			$buscar = $this->input->post("buscar");
			 $this->load->model('man_usuarios_model');
			$datos = $this->man_usuarios_model->mostrar($buscar);
			echo json_encode($datos);
		}else {
			show_404();
		
	}
}
}