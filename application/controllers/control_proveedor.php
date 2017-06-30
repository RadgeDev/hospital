<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_proveedor extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Proveedor_model");
	}

	public function index(){
		if(!$this->session->userdata("minombre")){
        redirect(base_url('home'));
        }
		$this->load->view('bodega/header');
		$this->load->view("bodega/nav");
		$this->load->view("bodega/vista_proveedor/view_proveedor");
		$this->load->view("bodega/vista_proveedor/footer2");
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
			"clientes" => $this->Proveedor_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Proveedor_model->buscar($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}

function validar(){
		if ($this->input->is_ajax_request()) {
			$rutsele = $this->input->post("id");
			if($this->Proveedor_model->validar($rutsele) == true)
				echo "Rut existe";
			else
				echo "rut no existe";
			
		}
		else
		{
			show_404();
		}
	}

function guardar() {
		//El metodo is_ajax_request() de la libreria input permite verificar
		//si se esta accediendo mediante el metodo AJAX 
		if ($this->input->is_ajax_request()) {

			$rut = $this->input->post("rut");
			$nombre = $this->input->post("nombre");
			$razon = $this->input->post("razon");
			$direccion = $this->input->post("direccion");
			$telefono = $this->input->post("telefono");
            $correo = $this->input->post("correo");

            $this->form_validation->set_rules('rut','Rut Proveedor','required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('nombre','Nombre','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('razon','Razon Social','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('direccion','Direccion','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('telefono','Telefono','required|min_length[3]|max_length[50]|numeric');
			$this->form_validation->set_rules('correo','Correo','required|min_length[3]|max_length[50]|valid_email');

       if ($this->form_validation->run() === TRUE) {
   			$datos = array(
				"rut_proveedor" => $rut,
				"nombre_proveedor" => $nombre,
				"razon_social" => $razon,
				"direccion" => $direccion,
				"telefono" => $telefono,
				"correo" => $correo
				);
		if($this->Proveedor_model->guardar($datos)==true)
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

			$rutselect = $this->input->post("selecrut");
			$nombres = $this->input->post("selecnombre");
			$razon = $this->input->post("selecrazon");
			$direccion= $this->input->post("selecdireccion");
			$telefono = $this->input->post("selectelefono");
			$correo = $this->input->post("seleccorreo");

			$this->form_validation->set_rules('selecnombre','Nombre','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('selecrazon','Razon Social','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('selecdireccion','Direccion','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('selectelefono','Telefono','required|min_length[3]|max_length[50]|numeric');
			$this->form_validation->set_rules('seleccorreo','Correo','required|min_length[3]|max_length[50]|valid_email');
		
		if ($this->form_validation->run() === TRUE) {
	
			$datos = array(
				"nombre_proveedor" => $nombres,
				"razon_social" => $razon,
				"direccion" => $direccion,
		        "telefono" => $telefono,
		        "correo" => $correo,
				);
		
			if($this->Proveedor_model->actualizar($rutselect,$datos) == true)
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


function editando() {

		if ($this->input->is_ajax_request()) {
			$rutsele = $this->input->post("id");
         $data = array(
			"obtener" => $this->Proveedor_model->editando($rutsele)
         	);
            echo json_encode($data);
		}

     
			
	}


function eliminar() {
		if ($this->input->is_ajax_request()) {

			$mipost = $this->input->post("mirut");

			if($this->Proveedor_model->eliminar($mipost) == true)
				echo "Registro Eliminado";
			else
				echo "No se pudo eliminar los datos";
			
		}
		else
		{
			show_404();
		}
	}

function excel()
{
$this->phpexcel->getProperties()
            ->setTitle('Excel')
			->setDescription('Proveedor');
		     $data = json_decode($this->input->post('sendData'));
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Reporte Proveedor');
			$style = array(
                         'alignment' => array(
                          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                           )
                          );

             $sheet->getDefaultStyle()->applyFromArray($style);
			//generrar filas
		        $sheet->getColumnDimension('A')->setWidth(30);
			    $sheet->getColumnDimension('B')->setWidth(40);
			    $sheet->getColumnDimension('C')->setWidth(50);
			    $sheet->getColumnDimension('D')->setWidth(60);
			    $sheet->getColumnDimension('E')->setWidth(20);
				$sheet->getColumnDimension('F')->setWidth(50);
			    $sheet->setCellValue('A1','RUT PROVEEDOR');
				$sheet->setCellValue('B1','NOMBRE ');
				$sheet->setCellValue('C1','RAZON SOCIAL');
				$sheet->setCellValue('D1','DIRECCION');
				$sheet->setCellValue('E1','TELEFONO');
				$sheet->setCellValue('F1','CORREO');
		
//recorrer datos
$i=3;
 foreach ($data->datos as $d){
                $sheet->setCellValue('A'.$i,$d->rut);
				$sheet->setCellValue('B'.$i,$d->nombre);
			    $sheet->setCellValue('C'.$i,$d->razon);
				$sheet->setCellValue('D'.$i,$d->direccion);
				$sheet->setCellValue('E'.$i,$d->telefono);
				$sheet->setCellValue('F'.$i,$d->correo);
		
                $i++;
 }
	
 

	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Productos ".date("Y-m-d H:i:s");
	header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
	header("Cache-Control: max-age=0");
	$writer=PHPExcel_IOFactory::createWriter($this->phpexcel,"Excel5");
	ob_start();
	$writer->save("php://output");
   $xlsData = ob_get_contents();
   ob_end_clean();
    $response =  array(
        'op' => 'ok',
        'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
    );

die(json_encode($response));
 
}

function exceltodo()
{
$this->phpexcel->getProperties()
            ->setTitle('Excel')
			->setDescription('Proveedor');
			$datos= $this->Proveedor_model->get_proveedor();
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Reporte proveedor');
			$style = array(
                         'alignment' => array(
                          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                           )
                          );
 
             $sheet->getDefaultStyle()->applyFromArray($style);
			//generrar filas
			    $sheet->getColumnDimension('A')->setWidth(30);
			    $sheet->getColumnDimension('B')->setWidth(40);
			    $sheet->getColumnDimension('C')->setWidth(50);
			    $sheet->getColumnDimension('D')->setWidth(60);
			    $sheet->getColumnDimension('E')->setWidth(20);
				$sheet->getColumnDimension('F')->setWidth(40);
			    $sheet->setCellValue('A1','RUT PROVEEDOR');
				$sheet->setCellValue('B1','NOMBRE ');
				$sheet->setCellValue('C1','RAZON SOCIAL');
				$sheet->setCellValue('D1','DIRECCION');
				$sheet->setCellValue('E1','TELEFONO');
				$sheet->setCellValue('F1','CORREO');
//recorrer datos
$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->rut_proveedor);
				$sheet->setCellValue('B'.$i,$dato->nombre_proveedor);
			    $sheet->setCellValue('C'.$i,$dato->razon_social);
				$sheet->setCellValue('D'.$i,$dato->direccion);
				$sheet->setCellValue('E'.$i,$dato->telefono);
				$sheet->setCellValue('F'.$i,$dato->correo);
                $i++;
 }
	
 

	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte".date("Y-m-d H:i:s");
	header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
	header("Cache-Control: max-age=0");
	$writer=PHPExcel_IOFactory::createWriter($this->phpexcel,"Excel5");
	$writer->save("php://output");
}


} 