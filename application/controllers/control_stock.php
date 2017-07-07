<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_stock extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Stock_model");
	}

	public function index(){
	if(!$this->session->userdata("minombre")){
    redirect(base_url('home'));
   
    }else{
	$tiponav="";
    $tipobody="";
	$misesion=$this->session->userdata("usuario");

 switch ($misesion) {
   case "Administrador":
         $tiponav= 'bodega/nav'; 
         $tipobody='bodega/vista_stock/view_stock';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/vista_stock/view_stock';
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
		$this->load->view(  $tiponav);
		$datosdepto['arrayBodegas'] = $this->Stock_model->get_bodegas();
		$this->load->view( $tipobody,$datosdepto);
		$this->load->view("bodega/vista_stock/footer2");
	}
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
			"obtener" => $this->Stock_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Stock_model->buscar($buscar)),
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
			"obtener" => $this->Stock_model->buscar2($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Stock_model->buscar2($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}



function excelstockcritico()
{
$this->phpexcel->getProperties()
            ->setTitle('Excel')
			->setDescription('Stock');
			$datos= $this->Stock_model->get_stockcritico();
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Stock Critico');
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
			    $sheet->getColumnDimension('F')->setWidth(30);
			    $sheet->setCellValue('A1','CODIGO PROD');
				$sheet->setCellValue('B1','CODIGO BARRA');
				$sheet->setCellValue('C1','CODIGO BODEGA');
				$sheet->setCellValue('D1','NOMBRE PRODUCTO');
				$sheet->setCellValue('E1','CANTIDAD');
				$sheet->setCellValue('F1','STOCK CRITICO');
	
//recorrer datos
$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->cod_interno_prod);
				$sheet->setCellValue('B'.$i,$dato->codigo_barra);
				$sheet->setCellValue('C'.$i,$dato->codigo_bodega);
			    $sheet->setCellValue('D'.$i,$dato->nombre);
				$sheet->setCellValue('E'.$i,$dato->cantidad);
				$sheet->setCellValue('F'.$i,$dato->stock_critico);
                $i++;
 }
	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Critico ".date("Y-m-d H:i:s");
	header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
	header("Cache-Control: max-age=0");
	$writer=PHPExcel_IOFactory::createWriter($this->phpexcel,"Excel5");
	$writer->save("php://output");
}

function excelstockminimo()
{
$this->phpexcel->getProperties()
            ->setTitle('Stock Minimo')
			->setDescription('Stock');
			$datos= $this->Stock_model->get_stockminimo();
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Stock Minimo');
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
			    $sheet->getColumnDimension('F')->setWidth(30);
			    $sheet->setCellValue('A1','CODIGO PROD');
				$sheet->setCellValue('B1','CODIGO BARRA');
				$sheet->setCellValue('C1','CODIGO BODEGA');
				$sheet->setCellValue('D1','NOMBRE PRODUCTO');
				$sheet->setCellValue('E1','CANTIDAD');
				$sheet->setCellValue('F1','STOCK MINIMO');
	
//recorrer datos
$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->cod_interno_prod);
				$sheet->setCellValue('B'.$i,$dato->codigo_barra);
				$sheet->setCellValue('C'.$i,$dato->codigo_bodega);
			    $sheet->setCellValue('D'.$i,$dato->nombre);
				$sheet->setCellValue('E'.$i,$dato->cantidad);
				$sheet->setCellValue('F'.$i,$dato->stock_minimo);
                $i++;
 }
	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Minimo ".date("Y-m-d H:i:s");
	header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
	header("Cache-Control: max-age=0");
	$writer=PHPExcel_IOFactory::createWriter($this->phpexcel,"Excel5");
	$writer->save("php://output");
}


function excelstockmaximo()
{
            $this->phpexcel->getProperties()
            ->setTitle('Stock Maximo')
			->setDescription('Stock Maximo');
			$datos= $this->Stock_model->get_stockmaximo();
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Stock Maximo');
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
			    $sheet->getColumnDimension('F')->setWidth(30);
			    $sheet->setCellValue('A1','CODIGO PROD');
				$sheet->setCellValue('B1','CODIGO BARRA');
				$sheet->setCellValue('C1','CODIGO BODEGA');
				$sheet->setCellValue('D1','NOMBRE PRODUCTO');
				$sheet->setCellValue('E1','CANTIDAD');
				$sheet->setCellValue('F1','STOCK Maximo');
	
//recorrer datos
$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->cod_interno_prod);
				$sheet->setCellValue('B'.$i,$dato->codigo_barra);
				$sheet->setCellValue('C'.$i,$dato->codigo_bodega);
			    $sheet->setCellValue('D'.$i,$dato->nombre);
				$sheet->setCellValue('E'.$i,$dato->cantidad);
				$sheet->setCellValue('F'.$i,$dato->stock_maximo);
                $i++;
 }
	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Maximo ".date("Y-m-d H:i:s");
	header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
	header("Cache-Control: max-age=0");
	$writer=PHPExcel_IOFactory::createWriter($this->phpexcel,"Excel5");
	$writer->save("php://output");
}


function reportebodegaminimo(){    
	$finalnombre="";
	   	if ($this->input->is_ajax_request()) {
			$codselec = $this->input->post("codigo");
           $this->phpexcel->getProperties()
            ->setTitle('Stock Minimo')
			->setDescription('Stock minimo');
			$datos= $this->Stock_model->get_stockbodegamin($codselec);
			$nombrebodega=$this->Stock_model->get_nombrebodega($codselec);
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Stock minimo');
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
			    $sheet->getColumnDimension('F')->setWidth(30);
			    $sheet->setCellValue('A1','CODIGO PROD');
				$sheet->setCellValue('B1','CODIGO BARRA');
				$sheet->setCellValue('C1','BODEGA');
				$sheet->setCellValue('D1','NOMBRE PRODUCTO');
				$sheet->setCellValue('E1','CANTIDAD');
				$sheet->setCellValue('F1','STOCK MINIMO');
	
//recorrer datos
foreach ($nombrebodega as $minombre){
	$finalnombre=$minombre->nombre;
}


$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->cod_interno_prod);
				$sheet->setCellValue('B'.$i,$dato->codigo_barra);
				$sheet->setCellValue('C'.$i,$finalnombre);
			    $sheet->setCellValue('D'.$i,$dato->nombre);
				$sheet->setCellValue('E'.$i,$dato->cantidad);
				$sheet->setCellValue('F'.$i,$dato->stock_minimo);
                $i++;
 }
	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Minimo ".date("Y-m-d H:i:s");
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

function reportebodegacritico()
{    
	$finalnombre="";
	   	if ($this->input->is_ajax_request()) {
			$codselec = $this->input->post("codigo");
           $this->phpexcel->getProperties()
            ->setTitle('Stock critico')
			->setDescription('Stock critico');
			$datos= $this->Stock_model->get_stockbodegacri($codselec);
			$nombrebodega=$this->Stock_model->get_nombrebodega($codselec);
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Stock minimo');
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
			    $sheet->getColumnDimension('F')->setWidth(30);
			    $sheet->setCellValue('A1','CODIGO PROD');
				$sheet->setCellValue('B1','CODIGO BARRA');
				$sheet->setCellValue('C1','BODEGA');
				$sheet->setCellValue('D1','NOMBRE PRODUCTO');
				$sheet->setCellValue('E1','CANTIDAD');
				$sheet->setCellValue('F1','STOCK CRITICO');
	
//recorrer datos
foreach ($nombrebodega as $minombre){
	$finalnombre=$minombre->nombre;
}


$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->cod_interno_prod);
				$sheet->setCellValue('B'.$i,$dato->codigo_barra);
				$sheet->setCellValue('C'.$i,$finalnombre);
			    $sheet->setCellValue('D'.$i,$dato->nombre);
				$sheet->setCellValue('E'.$i,$dato->cantidad);
				$sheet->setCellValue('F'.$i,$dato->stock_critico);
                $i++;
 }
	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Critico ".date("Y-m-d H:i:s");
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

function reportebodegamaximo()
{    
	$finalnombre="";
	   	if ($this->input->is_ajax_request()) {
			$codselec = $this->input->post("codigo");
           $this->phpexcel->getProperties()
            ->setTitle('Stock maximo')
			->setDescription('Stock maximo');
			$datos= $this->Stock_model->get_stockbodegamax($codselec);
			$nombrebodega=$this->Stock_model->get_nombrebodega($codselec);
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Stock maximo');
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
			    $sheet->getColumnDimension('F')->setWidth(30);
			    $sheet->setCellValue('A1','CODIGO PROD');
				$sheet->setCellValue('B1','CODIGO BARRA');
				$sheet->setCellValue('C1','BODEGA');
				$sheet->setCellValue('D1','NOMBRE PRODUCTO');
				$sheet->setCellValue('E1','CANTIDAD');
				$sheet->setCellValue('F1','STOCK MAXIMO');
	
//recorrer datos
foreach ($nombrebodega as $minombre){
	$finalnombre=$minombre->nombre;
}


$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->cod_interno_prod);
				$sheet->setCellValue('B'.$i,$dato->codigo_barra);
				$sheet->setCellValue('C'.$i,$finalnombre);
			    $sheet->setCellValue('D'.$i,$dato->nombre);
				$sheet->setCellValue('E'.$i,$dato->cantidad);
				$sheet->setCellValue('F'.$i,$dato->stock_maximo);
                $i++;
 }
	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Maximo ".date("Y-m-d H:i:s");
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
} 

