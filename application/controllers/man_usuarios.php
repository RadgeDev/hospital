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

function guardar() {

		//El metodo is_ajax_request() de la libreria input permite verificar
		//si se esta accediendo mediante el metodo AJAX 
		if ($this->input->is_ajax_request()) {
			$rut = $this->input->post("rut");
			$nombre = $this->input->post("nombre");
			$login = $this->input->post("login");
			$clave = $this->input->post("clave");
			$cargo = $this->input->post("seleccion");

			$datos = array(
				"rut" => $rut,
				"nombre" => $nombre,
				"login" => $login,
				"password" => $clave,
				"tipo_usuario" => $cargo
				);
		$this->load->model('man_usuarios_model');
		if($this->man_usuarios_model->guardar($datos)==true)
				echo "Registro Guardado";
			else
				echo "No se pudo guardar los datos";
		}
		else
		{
			show_404();
		}

}

	}
