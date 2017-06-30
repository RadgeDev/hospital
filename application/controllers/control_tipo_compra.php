<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_tipo_compra extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("tipo_compra_model");
	}

	public function index(){
		if(!$this->session->userdata("minombre")){
        redirect(base_url('home'));
        }
		$this->load->view('bodega/header');
		$this->load->view("bodega/nav");
		$this->load->view("bodega/vista_tipo_compra/view_tipo_compra");
		$this->load->view("bodega/vista_tipo_compra/footer2");
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
			"tipocompra" => $this->tipo_compra_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->tipo_compra_model->buscar($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}

function validar(){
		if ($this->input->is_ajax_request()) {
			$rutsele = $this->input->post("id");
			if($this->tipo_compra_model->validar($rutsele) == true)
				echo "Codigo existe";
			else
				echo "Codigo no existe";
			
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

			$codigo = $this->input->post("codigo");
			$nombre = $this->input->post("nombre");
		

            $this->form_validation->set_rules('codigo','Codigo','required|min_length[1]|max_length[100]');
			$this->form_validation->set_rules('nombre','Nombre','required|min_length[3]|max_length[50]|alpha');
			

       if ($this->form_validation->run() === TRUE) {
   			$datos = array(
				"cod_tipocompra" => $codigo,
				"nombre" => $nombre
				);

		if($this->tipo_compra_model->guardar($datos)==true)
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

			$codselect = $this->input->post("seleccod");
			$nombres = $this->input->post("selecnombre");
			

			
			$this->form_validation->set_rules('selecnombre','Nombre','required|min_length[3]|max_length[50]');
		
		if ($this->form_validation->run() === TRUE) {
	
			$datos = array(
				"nombre" => $nombres
				);
		
			if($this->tipo_compra_model->actualizar($codselect,$datos) == true)
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
			$codsele = $this->input->post("id");
         $data = array(
			"obtener" => $this->tipo_compra_model->editando($codsele)
         	);
            echo json_encode($data);
		}

     
			
	}


function eliminar() {
		if ($this->input->is_ajax_request()) {

			$mipost = $this->input->post("micod");

			if($this->tipo_compra_model->eliminar($mipost) == true)
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
			->setDescription('Tipo Compra');
		     $data = json_decode($this->input->post('sendData'));
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Tipo Compra');
			$style = array(
                         'alignment' => array(
                          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                           )
                          );

             $sheet->getDefaultStyle()->applyFromArray($style);
			//generrar filas
	            $sheet->getColumnDimension('A')->setWidth(40);
			    $sheet->getColumnDimension('B')->setWidth(50);

			    $sheet->setCellValue('A1','CODIGO TIPO COMPRA');
				$sheet->setCellValue('B1','NOMBRE ');
          
		
//recorrer datos
$i=3;
               foreach ($data->datos as $d){
                $sheet->setCellValue('A'.$i,$d->codigo);
				$sheet->setCellValue('B'.$i,$d->nombre);
                $i++;
                 }
	
 

	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Tipo Compra ".date(" Y-m-d H:i:s");
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
			->setDescription('Departamentos');
			$datos= $this->tipo_compra_model->get_tipo_compra();
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('REPORTE TIPO COMPRA');
			$style = array(
                         'alignment' => array(
                          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                           )
                          );
 
             $sheet->getDefaultStyle()->applyFromArray($style);
			//generrar filas
			    $sheet->getColumnDimension('A')->setWidth(40);
			    $sheet->getColumnDimension('B')->setWidth(50);
			    $sheet->setCellValue('A1','CODIGO TIPO COMPRA');
				$sheet->setCellValue('B1','NOMBRE ');

$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->cod_tipocompra);
				$sheet->setCellValue('B'.$i,$dato->nombre);

                $i++;
 }
	
 

	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Tipo compra ".date(" Y-m-d H:i:s");
	header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
	header("Cache-Control: max-age=0");
	$writer=PHPExcel_IOFactory::createWriter($this->phpexcel,"Excel5");
	$writer->save("php://output");
}


} 