<?php  
class Control_proveedor extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model("proveedor_model");
	}

  public function index($nropagina = FALSE){
  //
       $inicio = 0;
		$mostrarpor = 10; 
		$buscador = "";

		if ($nropagina) {
			$inicio = ($nropagina - 1) * $mostrarpor;
		}
$this->load->library('pagination');

		$config['base_url'] = base_url()."control_proveedor/pagina/";
		$config['total_rows'] =  count($this->proveedor_model->buscar($buscador));
		$config['per_page'] = $mostrarpor; 
		$config['uri_segment'] = 3;//segmentos controlproveedo1/pagina2/nrpagina3
		$config['num_links'] = 2;
		$config['use_page_numbers'] = TRUE;
		$config['first_url'] = base_url()."control_proveedor";

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config); 

	$data = array(
			"proveedor" => $this->proveedor_model->buscar("",$inicio,$mostrarpor)
		); 
    $this->load->view('bodega/header');
    $this->load->view('bodega/nav');
    $this->load->view('bodega/vista_proveedor/view_proveedor', $data);
    $this->load->view('bodega/footer2');


  }

	public function mostrar(){
		
	}

	public function busqueda(){
		
	
		
	}

	public function cantidad(){

	}

}

/*
public function __construct(){
		parent::__construct();
		$this->load->model("proveedor_model");
	}

	public function index($nropagina = FALSE)
	{
		$inicio = 0;
		$mostrarpor = 5; 
		$buscador = "";
		if ($this->session->userdata("cantidad")) {
			$mostrarpor =  $this->session->userdata("cantidad");
		}
		if ($this->session->userdata("busqueda")) {
			$buscador = $this->session->userdata("busqueda");
		}
		if ($nropagina) {
			$inicio = ($nropagina - 1) * $mostrarpor;
		}
		$this->load->library('pagination');

		$config['base_url'] = base_url()."control_proveedor/pagina/";
		$config['total_rows'] = count($this->proveedor_model->buscar($buscador));
		$config['per_page'] = $mostrarpor; 
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['use_page_numbers'] = TRUE;
		$config['first_url'] = base_url()."usuarios";

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config); 

		

		$data = array(
			"usuarios" => $this->Usuarios_model->buscar($buscador,$inicio,$mostrarpor)
		); 
    $this->load->view('bodega/header');
    $this->load->view('bodega/nav');
    $this->load->view('bodega/vista_proveedor/view_proveedor', $data);
    $this->load->view('bodega/footer2');
	}

	public function mostrar(){
		$this->session->unset_userdata('busqueda');
		redirect(base_url()."control_proveedor");
	}

	public function busqueda(){
		
			$this->session->set_userdata("busqueda",$this->input->post("busqueda"));
			redirect(base_url()."control_proveedor");
		
	}
	public function cantidad(){
		$this->session->set_userdata("cantidad",$this->input->post("cantidad"));
	}
}
*/
?>




