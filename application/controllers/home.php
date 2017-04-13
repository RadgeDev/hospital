<?php  
class Home extends Ci_Controller
{
	public function index(){ 

	if($this->session->userdata('username')){
       redirect('welcome');
}

	if(isset($_POST['password'])){
	$this->load->model('usuario_model');
	if ($this->usuario_model->login($_POST['username'],md5($_POST['password']))){
		$this->session->set_userdata('username',$_POST['username']);
        redirect('welcome');
   } else {

    redirect('home');
     } 
	
	}
   $this->load->view("home");
	}


  public function logout() {
   $this->session->sess_destroy();
   redirect('home');
   }

 public function ValidarAcceso(){
          /*Campos para validar que no esten vacio los campos*/
          $this->form_validation->set_rules("username", "Usuario", "trim|required|valid_email");
          $this->form_validation->set_rules("password", "Password", "trim|required");   
          /*Campos para validar con la base de datos*/
          $username = $this->input->post('username');
          $password = md5($this->input->post('password'));
          $url      = $this->input->post('url');
           if ($this->form_validation->run() == true)
          {
               /*validamos si trae algun registro la consulta entonces nos logeamos*/
      $user = $this->model_login->LoginBD($username, $password);
               if(count($user) == 1){
                    $session = array(
                         'rut'           => $user->rut,
                         'nombre'       => $user->nombre,
                         'login'    => $user->login,
                         'password'        => $password,
                         'tipousuario'  => $user->tipo_usuario,
                         'is_logged_in' => TRUE,                 
                         );
                    /*Cargamos permisos de usuario y lo guardamos en una sesion*/
//$Menu = $this->model_login->PermisosMenu($user->rut);
                  //  $this->session->set_userdata($session);//Cargamos la sesion de datos del usuario logeado
                   // $this->session->set_userdata($Menu);//cargamos la sesion del menu de acuerdo a los permisos
                    redirect('welcome');//nos vamos al index
               }else{
        //en caso contrario mostramos el error de usuario o contraseña invalido
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Usuario/Contraseña Invalido</div>');
                    $this->MuestraLogin();
               }
          }
          else
          {
               $this->MuestraLogin();
          }
     }
}

}

?>