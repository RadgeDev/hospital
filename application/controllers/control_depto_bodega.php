<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_depto_bodega extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Bodega_depto_model");
		$this->load->model("Pedidos_model");
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
         $tipobody='bodega/vista_bodega_depto/view_bodega_depto';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/vista_bodega_depto/view_bodega_depto';
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
		$this->load->view($tiponav);
		$datosdepto['arrayTipodepto'] = $this->Pedidos_model->get_depto();
		$datospedido['arrayTipopedido'] = $this->Pedidos_model->get_pedido();
		$this->load->view($tipobody,array_merge($datosdepto, $datospedido));
		$this->load->view("bodega/vista_bodega_depto/footer2");
	}
}



public function mostrar()
	{	
		//valor a Buscar
		$bodega = $this->input->post("mibodega");
		$depto = $this->input->post("midepto");
		$numeropagina = $this->input->post("mipagina");
		$cantidad = $this->input->post("micantidad");
		$miinicio= $this->input->post("miinicio");
		$mifin= $this->input->post("mifin");
		$inicio = ($numeropagina -1)*$cantidad;
		$data = array(
			"obtener" => $this->Bodega_depto_model->buscar($miinicio,$inicio,$cantidad,$mifin,$bodega,$depto),
			"totalregistros" => count($this->Bodega_depto_model->buscar($miinicio,$inicio,$cantidad,$mifin,$bodega,$depto)),
			"cantidad" =>$cantidad
		);
		echo json_encode($data);
	}


	


function reportefechas()
{    
	   	if ($this->input->is_ajax_request()) {
		$bodega = $this->input->post("mibodega");
		$depto = $this->input->post("midepto");
	    $miinicio= $this->input->post("fechainicio");
		$mifin= $this->input->post("fechafin");
           $this->phpexcel->getProperties()
            ->setTitle('Consumo bodega')
			->setDescription('bodega');
			$datos= $this->Bodega_depto_model->exportar($miinicio,$mifin,$bodega,$depto);
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Consumo bodega');
			$style = array(
                         'alignment' => array(
                          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                           )
                          );
 
             $sheet->getDefaultStyle()->applyFromArray($style);
			//generrar filas
			    $sheet->getColumnDimension('A')->setWidth(20);
			    $sheet->getColumnDimension('C')->setWidth(20);
			    $sheet->getColumnDimension('D')->setWidth(50);
			    $sheet->getColumnDimension('E')->setWidth(30);
			    $sheet->getColumnDimension('F')->setWidth(20);
			    $sheet->getColumnDimension('G')->setWidth(20);
			    $sheet->setCellValue('A1','AÑO ');
				$sheet->setCellValue('B1','MES');
				$sheet->setCellValue('C1','CODIGO PRODUCTO');
				$sheet->setCellValue('D1','NOMBRE PRODUCTO');
				$sheet->setCellValue('E1','BODEGA');
				$sheet->setCellValue('F1','DEPTO');
            	$sheet->setCellValue('G1','CONSUMO');
$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->ano);
				$sheet->setCellValue('B'.$i,$dato->mes);
				$sheet->setCellValue('C'.$i,$dato->cod_producto);
			    $sheet->setCellValue('D'.$i,$dato->nombre);
				$sheet->setCellValue('E'.$i,$dato->nombrebodega);
				$sheet->setCellValue('F'.$i,$dato->seccion);
				$sheet->setCellValue('G'.$i,$dato->totales);
                $i++;
 }
	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="'Consumo bodega depto".date("Y-m-d H:i:s");
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


}//fin controlador
