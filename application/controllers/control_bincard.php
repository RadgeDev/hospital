<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_lote extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Lote_model");
	}

	public function index(){
		if(!$this->session->userdata("minombre")){
        redirect(base_url('home'));
        }
		$this->load->view('bodega/header');
		$this->load->view("bodega/nav");
		$datosdepto['arrayBodegas'] = $this->Lote_model->get_bodegas();
		$this->load->view("bodega/vista_lote/view_lote",$datosdepto);
		$this->load->view("bodega/vista_lote/footer2");
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
			"obtener" => $this->Lote_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Lote_model->buscar($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}
public function mostrarfecha()
	{	
		//valor a Buscar
		$buscar = $this->input->post("buscar");
		$numeropagina = $this->input->post("nropagina");
		$cantidad = $this->input->post("cantidad");
		$combobuscar= $this->input->post("valorcombos");
		$fechaini= date('Y-m-d', strtotime($buscar));
		$fechafin= date('Y-m-d', strtotime($combobuscar));
		$inicio = ($numeropagina -1)*$cantidad;
		$data = array(
			"obtener" => $this->Lote_model->buscarfecha($fechaini,$inicio,$cantidad,$fechafin),
			"totalregistros" => count($this->Lote_model->buscarfecha($fechaini,$fechafin)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}

	public function mostrar2()
	{	
		//valor a Buscar
		$buscar = $this->input->post("buscar");
		$numeropagina = $this->input->post("nropagina");
		$cantidad = $this->input->post("cantidad");
		$combobuscar= $this->input->post("valorcombos");
		$inicio = ($numeropagina -1)*$cantidad;
		$data = array(
			"obtener" => $this->Lote_model->buscar2($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Lote_model->buscar2($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}






function reportefechas()
{    
	   	if ($this->input->is_ajax_request()) {
			$fecha = $this->input->post("fechainicio");
			$fecha2 = $this->input->post("fechafin");
		    $fechaini= date('Y-m-d', strtotime($fecha));
		    $fechafin= date('Y-m-d', strtotime($fecha2));
           $this->phpexcel->getProperties()
            ->setTitle('Productos Venimiento')
			->setDescription('Vencimientos');
			$datos= $this->Lote_model->get_fechasvencimiento($fechaini,$fechafin);
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Productos por vencer');
			$style = array(
                         'alignment' => array(
                          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                           )
                          );
 
             $sheet->getDefaultStyle()->applyFromArray($style);
			//generrar filas
			    $sheet->getColumnDimension('A')->setWidth(30);
			    $sheet->getColumnDimension('B')->setWidth(30);
			    $sheet->getColumnDimension('C')->setWidth(30);
			    $sheet->getColumnDimension('D')->setWidth(50);
			    $sheet->getColumnDimension('E')->setWidth(30);
			    $sheet->getColumnDimension('F')->setWidth(20);
				$sheet->getColumnDimension('G')->setWidth(20);
				$sheet->getColumnDimension('H')->setWidth(20);
				$sheet->getColumnDimension('I')->setWidth(20);
				$sheet->getColumnDimension('J')->setWidth(20);
			    $sheet->setCellValue('A1','CODIGO ');
				$sheet->setCellValue('B1','LOTE');
				$sheet->setCellValue('C1','CODIGO PRODUCTO');
				$sheet->setCellValue('D1','NOMBRE PRODUCTO');
				$sheet->setCellValue('E1','VENCIMIENTO');
				$sheet->setCellValue('F1','CANTIDAD');
				$sheet->setCellValue('G1','PRECIO');
				$sheet->setCellValue('H1','RUT PROVEEDOR');
				$sheet->setCellValue('I1','NOMBRE PROVEEDOR');
	            $sheet->setCellValue('J1','ESTADO');

$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->id);
				$sheet->setCellValue('B'.$i,$dato->lote);
				$sheet->setCellValue('C'.$i,$dato->cod_producto);
			    $sheet->setCellValue('D'.$i,$dato->nombre);
				$sheet->setCellValue('E'.$i,$dato->fecha_vencimiento);
				$sheet->setCellValue('F'.$i,$dato->cantidad);
				$sheet->setCellValue('G'.$i,$dato->precio);
				$sheet->setCellValue('H'.$i,$dato->rut_proveedor);
				$sheet->setCellValue('I'.$i,$dato->nombre_proveedor);
				$sheet->setCellValue('J'.$i,$dato->estado);
                $i++;
 }
	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Vencimientos ".date("Y-m-d H:i:s");
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

}


function reportefechascritico()
{    
            $this->phpexcel->getProperties()
            ->setTitle('Productos Venimiento')
			->setDescription('Vencimientos');
			$datos= $this->Lote_model->porvencercritico();
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Productos por vencer');
			$style = array(
                         'alignment' => array(
                          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                           )
                          );
 
             $sheet->getDefaultStyle()->applyFromArray($style);
			//generrar filas
			    $sheet->getColumnDimension('A')->setWidth(30);
			    $sheet->getColumnDimension('B')->setWidth(30);
			    $sheet->getColumnDimension('C')->setWidth(30);
			    $sheet->getColumnDimension('D')->setWidth(50);
			    $sheet->getColumnDimension('E')->setWidth(20);
			    $sheet->getColumnDimension('F')->setWidth(20);
				$sheet->getColumnDimension('G')->setWidth(20);
				$sheet->getColumnDimension('H')->setWidth(20);
				$sheet->getColumnDimension('I')->setWidth(20);
				$sheet->getColumnDimension('J')->setWidth(20);
			    $sheet->setCellValue('A1','CODIGO ');
				$sheet->setCellValue('B1','LOTE');
				$sheet->setCellValue('C1','CODIGO PRODUCTO');
				$sheet->setCellValue('D1','NOMBRE PRODUCTO');
				$sheet->setCellValue('E1','VENCIMIENTO');
				$sheet->setCellValue('F1','CANTIDAD');
				$sheet->setCellValue('G1','PRECIO');
				$sheet->setCellValue('H1','RUT PROVEEDOR');
				$sheet->setCellValue('I1','NOMBRE PROVEEDOR');
	            $sheet->setCellValue('J1','ESTADO');

$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->id);
				$sheet->setCellValue('B'.$i,$dato->lote);
				$sheet->setCellValue('C'.$i,$dato->cod_producto);
			    $sheet->setCellValue('D'.$i,$dato->nombre);
				$sheet->setCellValue('E'.$i,$dato->fecha_vencimiento);
				$sheet->setCellValue('F'.$i,$dato->cantidad);
				$sheet->setCellValue('G'.$i,$dato->precio);
				$sheet->setCellValue('H'.$i,$dato->rut_proveedor);
				$sheet->setCellValue('I'.$i,$dato->nombre_proveedor);
				$sheet->setCellValue('J'.$i,$dato->estado);
                $i++;
 }
	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Vencimientos Critico 15 dias ".date("Y-m-d H:i:s");
	header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
	header("Cache-Control: max-age=0");
	$writer=PHPExcel_IOFactory::createWriter($this->phpexcel,"Excel5");
	$writer->save("php://output");


}

function reportefechasminimo()
{    
            $this->phpexcel->getProperties()
            ->setTitle('Productos Venimiento')
			->setDescription('Vencimientos');
			$datos= $this->Lote_model->porvencerminimo();
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Productos por vencer');
			$style = array(
                         'alignment' => array(
                          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                           )
                          );
 
             $sheet->getDefaultStyle()->applyFromArray($style);
			//generrar filas
			    $sheet->getColumnDimension('A')->setWidth(30);
			    $sheet->getColumnDimension('B')->setWidth(30);
			    $sheet->getColumnDimension('C')->setWidth(30);
			    $sheet->getColumnDimension('D')->setWidth(50);
			    $sheet->getColumnDimension('E')->setWidth(20);
			    $sheet->getColumnDimension('F')->setWidth(20);
				$sheet->getColumnDimension('G')->setWidth(20);
				$sheet->getColumnDimension('H')->setWidth(20);
				$sheet->getColumnDimension('I')->setWidth(20);
				$sheet->getColumnDimension('J')->setWidth(20);
			    $sheet->setCellValue('A1','CODIGO ');
				$sheet->setCellValue('B1','LOTE');
				$sheet->setCellValue('C1','CODIGO PRODUCTO');
				$sheet->setCellValue('D1','NOMBRE PRODUCTO');
				$sheet->setCellValue('E1','VENCIMIENTO');
				$sheet->setCellValue('F1','CANTIDAD');
				$sheet->setCellValue('G1','PRECIO');
				$sheet->setCellValue('H1','RUT PROVEEDOR');
				$sheet->setCellValue('I1','NOMBRE PROVEEDOR');
	            $sheet->setCellValue('J1','ESTADO');

$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->id);
				$sheet->setCellValue('B'.$i,$dato->lote);
				$sheet->setCellValue('C'.$i,$dato->cod_producto);
			    $sheet->setCellValue('D'.$i,$dato->nombre);
				$sheet->setCellValue('E'.$i,$dato->fecha_vencimiento);
				$sheet->setCellValue('F'.$i,$dato->cantidad);
				$sheet->setCellValue('G'.$i,$dato->precio);
				$sheet->setCellValue('H'.$i,$dato->rut_proveedor);
				$sheet->setCellValue('I'.$i,$dato->nombre_proveedor);
				$sheet->setCellValue('J'.$i,$dato->estado);
                $i++;
 }
	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Vencimientos 30 dias ".date("Y-m-d H:i:s");
	header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
	header("Cache-Control: max-age=0");
	$writer=PHPExcel_IOFactory::createWriter($this->phpexcel,"Excel5");
	$writer->save("php://output");


}

function reportefechasmaximo()
{    
            $this->phpexcel->getProperties()
            ->setTitle('Productos Venimiento')
			->setDescription('Vencimientos');
			$datos= $this->Lote_model->porvencermaximo();
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Productos por vencer');
			$style = array(
                         'alignment' => array(
                          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                           )
                          );
 
             $sheet->getDefaultStyle()->applyFromArray($style);
			//generrar filas
			    $sheet->getColumnDimension('A')->setWidth(30);
			    $sheet->getColumnDimension('B')->setWidth(30);
			    $sheet->getColumnDimension('C')->setWidth(30);
			    $sheet->getColumnDimension('D')->setWidth(50);
			    $sheet->getColumnDimension('E')->setWidth(20);
			    $sheet->getColumnDimension('F')->setWidth(20);
				$sheet->getColumnDimension('G')->setWidth(20);
				$sheet->getColumnDimension('H')->setWidth(20);
				$sheet->getColumnDimension('I')->setWidth(20);
				$sheet->getColumnDimension('J')->setWidth(20);
			    $sheet->setCellValue('A1','CODIGO ');
				$sheet->setCellValue('B1','LOTE');
				$sheet->setCellValue('C1','CODIGO PRODUCTO');
				$sheet->setCellValue('D1','NOMBRE PRODUCTO');
				$sheet->setCellValue('E1','VENCIMIENTO');
				$sheet->setCellValue('F1','CANTIDAD');
				$sheet->setCellValue('G1','PRECIO');
				$sheet->setCellValue('H1','RUT PROVEEDOR');
				$sheet->setCellValue('I1','NOMBRE PROVEEDOR');
	            $sheet->setCellValue('J1','ESTADO');

$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->id);
				$sheet->setCellValue('B'.$i,$dato->lote);
				$sheet->setCellValue('C'.$i,$dato->cod_producto);
			    $sheet->setCellValue('D'.$i,$dato->nombre);
				$sheet->setCellValue('E'.$i,$dato->fecha_vencimiento);
				$sheet->setCellValue('F'.$i,$dato->cantidad);
				$sheet->setCellValue('G'.$i,$dato->precio);
				$sheet->setCellValue('H'.$i,$dato->rut_proveedor);
				$sheet->setCellValue('I'.$i,$dato->nombre_proveedor);
				$sheet->setCellValue('J'.$i,$dato->estado);
                $i++;
 }
	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Vencimientos 60 dias ".date("Y-m-d H:i:s");
	header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
	header("Cache-Control: max-age=0");
	$writer=PHPExcel_IOFactory::createWriter($this->phpexcel,"Excel5");
	$writer->save("php://output");


}


} 

