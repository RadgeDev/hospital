<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_consumo extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Consumo_model");
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
         $tipobody='bodega/vista_consumo/view_consumo';
         break;
   case "Bodeguero":
         $tiponav="bodega/nav_bodega";
         $tipobody='bodega/vista_consumo/view_consumo';
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
		$this->load->view("bodega/vista_consumo/footer2");
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
			"obtener" => $this->Consumo_model->buscar($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Consumo_model->buscar($buscar)),
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
		$codproducto= $this->input->post("codigoprod");
		$fechaini= date('Y-m-d', strtotime($buscar));
		$fechafin= date('Y-m-d', strtotime($combobuscar));
		$inicio = ($numeropagina -1)*$cantidad;
		$data = array(
			"obtener" => $this->Consumo_model->buscarfecha($fechaini,$inicio,$cantidad,$fechafin,$codproducto),
			"totalregistros" => count($this->Consumo_model->buscarfecha($fechaini,$inicio,$cantidad,$fechafin,$codproducto)),
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
			"obtener" => $this->Consumo_model->buscar2($buscar,$inicio,$cantidad,$combobuscar),
			"totalregistros" => count($this->Consumo_model->buscar2($buscar)),
			"cantidad" =>$cantidad
			
		);
		echo json_encode($data);
	}






function reportefechas()
{   
    	if ($this->input->is_ajax_request()) {
			$fecha = $this->input->post("fechainicio");
			$fecha2 = $this->input->post("fechafin");
			$codproducto = $this->input->post("codproducto");
		    $fechaini= date('Y-m-d', strtotime($fecha));
		    $fechafin= date('Y-m-d', strtotime($fecha2));
           $this->phpexcel->getProperties()
            ->setTitle('Productos Bincard')
			->setDescription('Bincard');
			$datos= $this->Consumo_model->get_fechasvencimiento($fechaini,$fechafin,$codproducto);
			$sheet=$this->phpexcel->getActiveSheet();
			$sheet->setTitle('Bincard');
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
			    $sheet->setCellValue('A1','BINCARD ');
				$sheet->setCellValue('B1','FECHA');
				$sheet->setCellValue('C1','CODIGO PRODUCTO');
				$sheet->setCellValue('D1','NOMBRE PRODUCTO');
				$sheet->setCellValue('E1','PROVEEDOR');
				$sheet->setCellValue('F1','INGRESO');
				$sheet->setCellValue('G1','EGRESO');
				$sheet->setCellValue('H1','SALDO');
			

$i=3;
 foreach ($datos as $dato){
                $sheet->setCellValue('A'.$i, $dato->idbincard);
				$sheet->setCellValue('B'.$i,$dato->fecha);
				$sheet->setCellValue('C'.$i,$dato->cod_producto);
			    $sheet->setCellValue('D'.$i,$dato->nombre);
				$sheet->setCellValue('E'.$i,$dato->proveedor);
				$sheet->setCellValue('F'.$i,$dato->entrada);
				$sheet->setCellValue('G'.$i,$dato->salida);
				$sheet->setCellValue('H'.$i,$dato->saldo);
                $i++;
 }
	//generar renderizacion
	header("Content-Type: application/vnd.ms-excel");
	$nombre="Reporte Bincard ".date("Y-m-d H:i:s");
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

