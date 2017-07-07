<?php  
class Man_usuarios extends CI_Controller
{
	public function index() {
	if(!$this->session->userdata("minombre")){
    redirect(base_url('home'));
   
    }else{
	$tiponav="";
    $tipobody="";
	$misesion=$this->session->userdata("usuario");

 switch ($misesion) {
   case "Administrador":
         $tiponav= 'bodega/nav'; 
         $tipobody='bodega/usuarios';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/usuarios';
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
    $this->load->model('man_usuarios_model');
    $resultado = $this->man_usuarios_model->getUsuariosmodel();
    $data = array('consulta'=> $resultado);
    $this->load->view( $tipobody, $data);
    $this->load->view('bodega/footer2');
	}
}

 function mostrar(){
		if($this->input->is_ajax_request()){
			$buscar = $this->input->post("buscar");
			$campos = $this->input->post("campos");
			 $this->load->model('man_usuarios_model');
			$datos = $this->man_usuarios_model->mostrar($buscar,$campos);
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
            $this->form_validation->set_rules('rut','Rut','required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('nombre','Nombre','required|min_length[3]|max_length[50]|alpha');
			$this->form_validation->set_rules('login','Login','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('clave','Clave','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('seleccion','Seleccion','required|min_length[3]|max_length[50]');
   if ($this->form_validation->run() === TRUE) {
   	$this->load->library('encrypt');
   	$clave_encriptada =  $this->encrypt->sha1($clave);

   			$datos = array(
				"rut" => $rut,
				"nombre" => $nombre,
				"login" => $login,
				"password" => $clave_encriptada,
				"tipo_usuario" => $cargo
				);
		$this->load->model('man_usuarios_model');
		if($this->man_usuarios_model->guardar($datos)==true)
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

			$rutsele = $this->input->post("selecrut");
			$nombres = $this->input->post("selecnombre");
			$login = $this->input->post("seleclogin");
			$clave = $this->input->post("selecclave");
			$cargo = $this->input->post("seleccion2");

			$this->form_validation->set_rules('selecnombre','Nombre','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('seleclogin','Login','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('selecclave','Clave','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('seleccion2','Tipo Usuario','required|min_length[3]|max_length[50]');
		
		if ($this->form_validation->run() === TRUE) {
			$this->load->library('encrypt');
   	       $clave_encriptada = $this->encrypt->sha1($clave);
			$datos = array(
				"nombre" => $nombres,
				"login" => $login,
				"password" => $clave_encriptada,
		        "tipo_usuario" => $cargo
				);
			$this->load->model('man_usuarios_model');
			if($this->man_usuarios_model->actualizar($rutsele,$datos) == true)
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

function eliminar(){
		if ($this->input->is_ajax_request()) {

			$rutsele = $this->input->post("id");
			$this->load->model('man_usuarios_model');
       
			if($this->man_usuarios_model->eliminar($rutsele) == true)
				echo "Registro Eliminado";
			else
				echo "No se pudo eliminar los datos";
			
		}
		else
		{
			show_404();
		}
	}
function validar(){
		if ($this->input->is_ajax_request()) {
			$rutsele = $this->input->post("id");
			$this->load->model('man_usuarios_model');
			if($this->man_usuarios_model->validar($rutsele) == true)
				echo "Rut existe";
			else
				echo "rut no existe";
			
		}
		else
		{
			show_404();
		}
	}





}