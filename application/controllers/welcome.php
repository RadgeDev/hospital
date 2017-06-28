<?php  
class Welcome extends CI_Controller
{

	public function index() {
if(!$this->session->userdata("minombre")){
    redirect(base_url('home'));
   
}else{
   $this->load->view('bodega/header');
      $this->load->view('bodega/nav');
        $this->load->view('bodega/body');
        $this->load->view('bodega/footer');
}
		
   
	}

}