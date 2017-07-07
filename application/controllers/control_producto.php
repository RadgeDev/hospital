<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_producto extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Producto_model");
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
         $tipobody='bodega/vista_producto/view_producto';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/vista_producto/view_producto';
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
		$this->load->view( $tiponav);
		$datoscorrelativo['arrayCorrelativo'] = $this->Producto_model->get_correlativo();
		$this->load->view( $tipobody, $datoscorrelativo);
		$this->load->view("bodega/vista_producto/footer2");
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
			"obtener" => $this->Producto_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Producto_model->buscar($buscar)),
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
		$bodega= $this->input->post("bodega");
		$inicio = ($numeropagina -1)*$cantidad;
		$data = array(
			"obtener" => $this->Producto_model->buscar2($buscar,$inicio,$cantidad,$combobuscar,$bodega),
			"totalregistros" => count($this->Producto_model->buscar($buscar)),
			"cantidad" =>$cantidad		
		);
		echo json_encode($data);
	}
function validar(){
		if ($this->input->is_ajax_request()) {
			$rutsele = $this->input->post("id");
			if($this->Producto_model->validar($rutsele) == true)
				echo "Rut existe";
			else
				echo "rut no existe";
			
		}
		else
		{
			show_404();
		}
	}

function obtenercorrelativo(){

			if ($this->input->is_ajax_request()) {
			$codsele = $this->input->post("cod");
         $data = array(
			"obtener" => $this->Producto_model->obtenercorrelativo($codsele)
         	);
            echo json_encode($data);
		}
	}
	
function guardar() {
		//El metodo is_ajax_request() de la libreria input permite verificar
		//si se esta accediendo mediante el metodo AJAX 
		if ($this->input->is_ajax_request()) {

			$codigo = $this->input->post("codigo");
			$ultimocorrelativo = $this->input->post("ultimocorrelativo");
			$codbarra = $this->input->post("codigobarra");
			$codbodega = $this->input->post("combocorrelativo");
			$nombre = $this->input->post("nombre");
			$cantidad = $this->input->post("cantidad");
			$precio = $this->input->post("precio");
            $unidad = $this->input->post("seleccion");
            $stockcri = $this->input->post("stockcri");
            $stockmin = $this->input->post("stockmin");
            $stockmax = $this->input->post("stockmax");

            $this->form_validation->set_rules('codigo','Codigo','required|min_length[1]|max_length[10]');
			$this->form_validation->set_rules('codigobarra','Codigo Barra','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('combocorrelativo','Correlativo','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('nombre','Nombre','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('cantidad','Cantidad','required|min_length[1]|max_length[50]|numeric');
			$this->form_validation->set_rules('precio','Precio','required|min_length[1]|max_length[50]|numeric');
			$this->form_validation->set_rules('seleccion','Unidad','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('stockcri','Stock Critico','required|min_length[1]|max_length[50]|numeric');
			$this->form_validation->set_rules('stockmin','Stock Minimo','required|min_length[1]|max_length[50]|numeric');
			$this->form_validation->set_rules('stockmax','Stock Maximo','required|min_length[1]|max_length[50]|numeric');

       if ($this->form_validation->run() === TRUE) {
   			$datos = array(
				"cod_interno_prod" => $codigo,
				"codigo_barra" => $codbarra,
				"cod_bodega" => $codbodega,
				"nombre" => $nombre,
				"cantidad" => $cantidad,
				"precio" => $precio,
				"unidad_medida" => $unidad,
				"stock_critico" => $stockcri,
				"stock_minimo" => $stockmin,
				"stock_maximo" => $stockmax
				);
   			$datosactualizar = array(
				"ultimo_codigo" => $ultimocorrelativo
				
				);
		if($this->Producto_model->guardar($datos)==true){
         $this->Producto_model->actualizarcorrelativo($codbodega,$datosactualizar);
				echo "Registro Guardado";
			}else{
				echo "No se pudo guardar los datos";
			}
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
			$codigo = $this->input->post("editcodigo");
			$codbarra = $this->input->post("editcodigobarra");
			$nombre = $this->input->post("editnombre");
			$cantidad = $this->input->post("editcantidad");
			$precio = $this->input->post("editprecio");
            $unidad = $this->input->post("seleccion2");
            $stockcri = $this->input->post("editstockcri");
            $stockmin = $this->input->post("editstockmin");
            $stockmax = $this->input->post("editstockmax");

            $this->form_validation->set_rules('editcodigo','Codigo','required|min_length[1]|max_length[10]');
			$this->form_validation->set_rules('editcodigobarra','Codigo Barra','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('editnombre','Nombre','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('editcantidad','Cantidad','required|min_length[1]|max_length[50]|numeric');
			$this->form_validation->set_rules('editprecio','Precio','required|min_length[1]|max_length[50]|numeric');
			$this->form_validation->set_rules('seleccion2','Unidad','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('editstockcri','Stock Critico','required|min_length[1]|max_length[50]|numeric');
			$this->form_validation->set_rules('editstockmin','Stock Minimo','required|min_length[1]|max_length[50]|numeric');
			$this->form_validation->set_rules('editstockmax','Stock Maximo','required|min_length[1]|max_length[50]|numeric');

		if ($this->form_validation->run() === TRUE) {

			$datos = array(
				"codigo_barra" => $codbarra,
				"nombre" => $nombre,
				"cantidad" => $cantidad,
				"precio" => $precio,
				"unidad_medida" => $unidad,
				"stock_critico" => $stockcri,
				"stock_minimo" => $stockmin,
				"stock_maximo" => $stockmax
				);

	if($this->Producto_model->actualizar($codigo,$datos)==true)
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

function editando() {

		if ($this->input->is_ajax_request()) {
			$codselec = $this->input->post("id");
         $data = array(
			"obtener" => $this->Producto_model->editando($codselec)
         	);
            echo json_encode($data);
		}

     
			
	}


function eliminar() {
		if ($this->input->is_ajax_request()) {

			$mipost = $this->input->post("micodigo");

			if($this->Producto_model->eliminar($mipost) == true)
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
			->setDescription('Productos');
		     $data = json_decode($this->input->post('sendData'));
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('titulto del reporte');
			$style = array(
                         'alignment' => array(
                          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                           )
                          );

             $sheet->getDefaultStyle()->applyFromArray($style);
			//generrar filas
			    $sheet->getColumnDimension('A')->setWidth(30);
			    $sheet->getColumnDimension('B')->setWidth(30);
			    $sheet->getColumnDimension('C')->setWidth(50);
			    $sheet->getColumnDimension('D')->setWidth(20);
			    $sheet->getColumnDimension('E')->setWidth(20);
				$sheet->getColumnDimension('F')->setWidth(20);
			    $sheet->getColumnDimension('G')->setWidth(30);
			    $sheet->setCellValue('A1','CODIGO INTERNO');
				$sheet->setCellValue('B1','CODIGO BARRA');
				$sheet->setCellValue('C1','NOMBRE PRODUCTO');
				$sheet->setCellValue('D1','CANTIDAD');
				$sheet->setCellValue('E1','PRECIO');
				$sheet->setCellValue('F1','CODIGO BODEGA');
				$sheet->setCellValue('G1','UNIDAD DE MEDIDA');
//recorrer datos
$i=3;

 foreach ($data->datos as $d){
                $sheet->setCellValue('A'.$i,$d->cod_interno_prod);
				$sheet->setCellValue('B'.$i,$d->codigo_barra);
			    $sheet->setCellValue('C'.$i,$d->nombre);
				$sheet->setCellValue('D'.$i,$d->cantidad);
				$sheet->setCellValue('E'.$i,$d->precio);
				$sheet->setCellValue('F'.$i,$d->cod_bodega);
				$sheet->setCellValue('G'.$i,$d->unidad_medida);
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
			->setDescription('Productos');
			$datos= $this->Producto_model->get_productos();
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('titulto del reporte');
			$style = array(
                         'alignment' => array(
                          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                           )
                          );
 
             $sheet->getDefaultStyle()->applyFromArray($style);
			//generrar filas
			    $sheet->getColumnDimension('A')->setWidth(30);
			    $sheet->getColumnDimension('B')->setWidth(30);
			    $sheet->getColumnDimension('C')->setWidth(50);
			    $sheet->getColumnDimension('D')->setWidth(20);
			    $sheet->getColumnDimension('E')->setWidth(20);
			    $sheet->setCellValue('A1','CODIGO INTERNO');
				$sheet->setCellValue('B1','CODIGO BARRA');
				$sheet->setCellValue('C1','NOMBRE PRODUCTO');
				$sheet->setCellValue('D1','CANTIDAD');
				$sheet->setCellValue('E1','PRECIO');
//recorrer datos
$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->cod_interno_prod);
				$sheet->setCellValue('B'.$i,$dato->codigo_barra);
			    $sheet->setCellValue('C'.$i,$dato->nombre);
				$sheet->setCellValue('D'.$i,$dato->cantidad);
				$sheet->setCellValue('E'.$i,$dato->precio);
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

