<?php  
class Welcome extends CI_Controller
{

	public function index() {
if(!$this->session->userdata("minombre")){
    redirect(base_url('home'));
   
}else{
	$tiponav="";
	$misesion=$this->session->userdata("usuario");
 switch ($misesion) {
   case "Administrador":
         $tiponav= 'bodega/nav'; 
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         break;
   case "Invitado":
         $tiponav="bodega/nav_invitado";
         break;
   default:
        $tiponav="bodega/nav_invitado";
}
        $this->load->view('bodega/header');
        $this->load->view($tiponav);
        $this->load->view('bodega/body');
        $this->load->view('bodega/footer');
}
		
   
	}

}