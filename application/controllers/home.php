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

}

?>