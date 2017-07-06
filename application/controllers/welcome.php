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
        $this->load->model('Stock_model');
        $datostockcritico = array(
			"totalregistros"=> count($this->Stock_model->get_stockcritico()),	
                  "totalcompra"=> count($this->Stock_model->get_totalcompra()),
                  "stockmaximo"=> count($this->Stock_model->get_stockmaximo()),
                  "totalsalida"=> count($this->Stock_model->get_totalsalidas())	
		);
        $this->load->view('bodega/body',array_merge($datostockcritico));
        $this->load->view('bodega/footer');
}
		
   
	}


function get_totalcompralimit(){
     $this->load->model('Stock_model');
	$data = array(
			"obtener" => $this->Stock_model->get_totalcompralimit()
		);

}



}