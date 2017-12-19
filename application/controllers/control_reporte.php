<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_reporte extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model("Model_reporte");
    }




function report()
{
    $cod=  $this->uri->segment(3);


    $datos= $this->Model_reporte->getcompra($cod);
    $detalle= $this->Model_reporte->getcompradetalle($cod);

    $html="";

  $html.='   <!DOCTYPE html>
<html>
<head>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">   
 
</head>
<body>
<div id="wrapper">

<div class="right"> 
    <img src="http://bodegachimbarongo.tk/hospital/plantilla2/reporte/logo.jpg">
    </div>
    '; 
  foreach ($datos as $misdatos) {
 $html.='
<div  class="left"><p style="text-align:right;padding-top:0mm;font-weight:bold;" >Folio:'.$misdatos->cod_compra.'</p> 
  <p style="text-align:right;padding-top:0mm;font-weight:bold;" >Fecha:  '.$misdatos->fecha.'</p> </div>
        </div>

    <h3 style="text-align:center;padding-top:0mm;font-weight:bold;">INGRESO BODEGA  HOSPITAL CHIMBARONGO</h3>


  <table style="width:100%"> 
  <tr>
    <td style="width:20%;font-weight:bold;background:#eee;">N°Documento</td>
    <td style="width:30%">'.$misdatos->numero_documento.'</td>
    <td style="width:20%;font-weight:bold;background:#eee;">Tipo Ingreso</td>
     <td style="width:30%">'.$misdatos->tipo_documento.'</td>
  </tr>
  <tr>
   <td style="width:20%;font-weight:bold;background:#eee;">Proveedor:</td>
    <td COLSPAN="3" style="width:30%">'.$misdatos->rut_proveedor.' '.$misdatos->nombre_proveedor.'</td>
    
  </tr>
  <tr>
  <td style="width:20%;font-weight:bold;background:#eee;">Tipo Compra</td>
     <td COLSPAN="3" style="width:30%">'.$misdatos->tipo_compra_nombre.'</td>
  </tr>
   <tr>
   <td style="width:20%;font-weight:bold;background:#eee;">Observacion:</td>
    <td COLSPAN="3" style="width:30%">'.$misdatos->comentarios.'</td>
   
  </tr>';
}
      $html.='
</table>          
        <br></br>
     <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    	
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Cod.Int.</strong></td>
        							<td class="text-center"><strong>Product.</strong></td>
                                    <td class="text-center"><strong>Lote</strong></td>
                                    <td class="text-center"><strong>A vencer</strong></td>
        							<td class="text-center"><strong>Cant.</strong></td>
        							<td class="text-right"><strong>Unit.</strong></td>
                                    <td class="text-right"><strong>Total</strong></td>
                                </tr>
    						</thead>
    						<tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                
                                ';
                                foreach ($detalle as $misdetalle) {
                              $html.='   
    							<tr>
    							
    								<td class="text-center">'.$misdetalle->cod_producto.'</td>
                                    <td class="text-center">'.$misdetalle->nombre_prod.'</td>
                                    <td class="text-center">'.$misdetalle->numero_lote.'</td>
    								<td class="text-center">'.$misdetalle->fecha_vencimiento.'</td>
                                    <td class="text-right">'.$misdetalle->cantidad.'</td>
                                    <td class="text-right">'.$misdetalle->precio.'</td>
                                    <td class="text-right">'.$misdetalle->total.'</td>
    							</tr>
                                ';    }
                                $html.='   

                                ';
                                foreach ($datos as $misdatos) {
                               $html.='
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">'.$misdatos->subtotal.'</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
                                    	<td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="thick-line"></td>
    								<td class="no-line text-center"><strong>Desc.</strong></td>
    								<td class="no-line text-right">'.$misdatos->descuento.'</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="thick-line"></td>
    								<td class="no-line text-center"><strong>Neto</strong></td>
    								<td class="no-line text-right">'.$misdatos->neto.'</td>
                                </tr>
                                <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line"></td>
                                <td class="no-line text-center"><strong>IVA</strong></td>
                                <td class="no-line text-right">'.$misdatos->iva.'</td>
                            </tr>
                            <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="thick-line"></td>
                            <td class="no-line text-center"><strong>Total</strong></td>
                            <td class="no-line text-right">'.$misdatos->total_compra.'</td>
                        </tr>

                        ';    }
                        $html.='
    						</tbody>
                        </table>
                        

<div id="cajon1" class="right">  <hr style="color: black; background-color: black; height: 2px;text-align:left;
width: 50%;"/>
 <p style=text-align:left;font-weight:bold;>Firma y Timbre</p></div>
';
foreach ($datos as $misdatos) {
$html.='    
<div id="cajon2" class="left"><h4>Recibido por: '.$misdatos->nombre_usuario.'</h4></div>
</div>
   ';    }
$html.='
</div>

    				</div>
    			</div>
    		</div>
    	</div>
    </div>


  
</body>
</html>' ;

   

 
    $estilos3=file_get_contents("http://bodegachimbarongo.tk/hospital/plantilla2/reporte/reporte.css");
    $this->mpdf->setDisplayMode('fullpage');
    
  
    $this->mpdf->WriteHTML($estilos3,1);
    $this->mpdf->WriteHTML($html,2);

  
    $this->mpdf->Output();
     exit;

 }  


function report_pedidos()
{
    $cod=  $this->uri->segment(3);
    $datos= $this->Model_reporte->getpedido($cod);
    $detalle= $this->Model_reporte->getpedidodetalle($cod);

    $html="";

  $html.='   <!DOCTYPE html>
<html>
<head>
    
 
</head>
<body>
<div id="wrapper">

<div class="right"> 
    <img src="http://bodegachimbarongo.tk/hospital/plantilla2/reporte/logo.jpg">
    </div>
    '; 
  foreach ($datos as $misdatos) {
 $html.='
<div  class="left"><p style="text-align:right;padding-top:0mm;font-weight:bold;" >Folio:'.$misdatos->folio.'</p> 
  <p style="text-align:right;padding-top:0mm;font-weight:bold;" >Fecha:  '.$misdatos->fecha.'</p> </div>
        </div>

    <h3 style="text-align:center;padding-top:0mm;font-weight:bold;">PEDIDOS BODEGA  HOSPITAL CHIMBARONGO</h3>


  <table style="width:100%"> 
  <tr>
    <td style="width:20%;font-weight:bold;background:#eee;">Cod Depto</td>
    <td style="width:30%">'.$misdatos->cod_depto.'</td>
    <td style="width:20%;font-weight:bold;background:#eee;">Departamento</td>
     <td style="width:30%">'.$misdatos->depto.'</td>
  </tr>
  <tr>
   <td style="width:20%;font-weight:bold;background:#eee;">Pedidos:</td>
    <td COLSPAN="3" style="width:30%">'.$misdatos->cod_tipo_pedido.' '.$misdatos->tipo_pedido.'</td>
    
  </tr>
  <tr>
  <td style="width:20%;font-weight:bold;background:#eee;">Tiempo de pedido</td>
     <td COLSPAN="3" style="width:30%">'.$misdatos->tiempo_pedido.'</td>
  </tr>
   <tr>
   <td style="width:20%;font-weight:bold;background:#eee;">Observacion:</td>
    <td COLSPAN="3" style="width:30%">'.$misdatos->comentario.'</td>
   
  </tr>';
}
$html.='
</table>          
        <br></br>
     <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    	
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Cod.Producto.</strong></td>
        							<td class="text-center"><strong> Nom.Product.</strong></td>
        							<td class="text-center"><strong>Cant.</strong></td>
        						
                                </tr>
    						</thead>
    						<tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                
                                ';
                                foreach ($detalle as $misdetalle) {
                              $html.='   
    							<tr>
    							
    								<td class="text-center">'.$misdetalle->cod_producto.'</td>
                                    <td class="text-center">'.$misdetalle->nombre_prod.'</td>
                                    <td class="text-right">'.$misdetalle->cantidad.'</td>
                         
    							</tr>
                                ';    }
                                $html.='   

                     
                                
    						</tbody>
                        </table>
                        
<p></p>
<div id="cajon1" class="right">  <hr style="color: black; background-color: black; height: 2px;text-align:left;
width: 50%;"/>
 <p style=text-align:left;font-weight:bold;>Firma y Timbre</p></div>
';
foreach ($datos as $misdatos) {
$html.='    
<div id="cajon2" class="left"><h4>Pedido realizado por: '.$misdatos->nombre.'</h4></div>
</div>
   ';    }
$html.='
</div>

    				</div>
    			</div>
    		</div>
    	</div>
    </div>


  
</body>
</html>' ;

   

 
    $estilos3=file_get_contents("http://bodegachimbarongo.tk/hospital/plantilla2/reporte/reporte.css");
    $this->mpdf->setDisplayMode('fullpage');
    
  
    $this->mpdf->WriteHTML($estilos3,1);
    $this->mpdf->WriteHTML($html,2);

  
    $this->mpdf->Output();
     exit;

 }  


function report_salidas()
{
    $cod=  $this->uri->segment(3);


    $datos= $this->Model_reporte->getsalida($cod);
    $detalle= $this->Model_reporte->getsalidadetalle($cod);

    $html="";

  $html.='   <!DOCTYPE html>
<html>
<head>
    
 
</head>
<body>
<div id="wrapper">

<div class="right"> 
    <img src="http://bodegachimbarongo.tk/hospital/plantilla2/reporte/logo.jpg">
    </div>
    '; 
  foreach ($datos as $misdatos) {
 $html.='
<div  class="left"><p style="text-align:right;padding-top:0mm;font-weight:bold;" >Folio:'.$misdatos->cod_salida.'</p> 
  <p style="text-align:right;padding-top:0mm;font-weight:bold;" >Fecha:  '.$misdatos->fecha.'</p> </div>
        </div>

    <h3 style="text-align:center;padding-top:0mm;font-weight:bold;">EGRESO BODEGA  HOSPITAL CHIMBARONGO</h3>


  <table style="width:100%"> 
  <tr>
    <td style="width:20%;font-weight:bold;background:#eee;">Tipo Salida</td>
    <td style="width:30%">'.$misdatos->nombre_salida.'</td>
    <td style="width:20%;font-weight:bold;background:#eee;">Depto/Servicio</td>
     <td style="width:30%">'.$misdatos->nombre_depto.'</td>
  </tr>
  <tr>
   <td style="width:20%;font-weight:bold;background:#eee;">N° Pedido:</td>
    <td COLSPAN="3" style="width:30%">'.$misdatos->num_pedido.' </td>
    
  </tr>
  <tr>
   <tr>
   <td style="width:20%;font-weight:bold;background:#eee;">Observacion:</td>
    <td COLSPAN="3" style="width:30%">'.$misdatos->comentarios.'</td>
   
  </tr>'
;
}
      $html.='
</table>          
        <br></br>
     <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    	
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
                                    <td class="text-center"><strong>Cod.Prod.</strong></td>
                                    <td class="text-center"><strong>Producto</strong></td>
                                    <td class="text-center"><strong>Lote</strong></td>
                                    <td class="text-center"><strong>A vencer</strong></td>
        							<td class="text-center"><strong>Cant.</strong></td>
        							<td class="text-right"><strong>Unit.</strong></td>
                                </tr>
    						</thead>
    						<tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                
                                ';
                                foreach ($detalle as $misdetalle) {
                              $html.='   
    							<tr>
    							
    								<td class="text-center">'.$misdetalle->cod_producto.'</td>
                                    <td class="text-center">'.$misdetalle->nombre_prod.'</td>
                                    <td class="text-center">'.$misdetalle->lote.'</td>
    								<td class="text-center">'.$misdetalle->fecha_vencimiento.'</td>
                                    <td class="text-right">'.$misdetalle->cantidad.'</td>
                                    <td class="text-right">'.$misdetalle->valor.'</td>
                              
    						

                        ';   }
                        $html.='
    						</tbody>
                        </table>
                        

<div id="cajon1" class="right">  <hr style="color: black; background-color: black; height: 2px;text-align:left;
width: 50%;"/>
 <p style=text-align:left;font-weight:bold;>Firma y Timbre</p></div>
';
foreach ($datos as $misdatos) {
$html.='    
<div id="cajon2" class="left"><h4>Recibido por: '.$misdatos->nombre.'</h4></div>
</div>
   ';    }
$html.='
</div>

    				</div>
    			</div>
    		</div>
    	</div>
    </div>


  
</body>
</html>' ;

   

 
    $estilos3=file_get_contents("http://bodegachimbarongo.tk/hospital/plantilla2/reporte/reporte.css");
    $this->mpdf->setDisplayMode('fullpage');
    
  
    $this->mpdf->WriteHTML($estilos3,1);
    $this->mpdf->WriteHTML($html,2);

  
    $this->mpdf->Output();
     exit;



 }  



function reportboletas()
{
    $cod=  $this->uri->segment(3);


    $datos= $this->Model_reporte->getboleta($cod);
    $detalle= $this->Model_reporte->getboletadetalle($cod);

    $html="";

  $html.='   <!DOCTYPE html>
<html>
<head>
    
 
</head>
<body>
<div id="wrapper">

<div class="right"> 
    <img src="http://bodegachimbarongo.tk/hospital/plantilla2/reporte/logo.jpg">
    </div>
    '; 
  foreach ($datos as $misdatos) {
 $html.='
<div  class="left"><p style="text-align:right;padding-top:0mm;font-weight:bold;" >Folio:'.$misdatos->cod_compra.'</p> 
  <p style="text-align:right;padding-top:0mm;font-weight:bold;" >Fecha:  '.$misdatos->fecha.'</p> </div>
        </div>

    <h3 style="text-align:center;padding-top:0mm;font-weight:bold;">COMPRA DIRECTA BODEGA  HOSPITAL CHIMBARONGO</h3>


  <table style="width:100%"> 
  <tr>
    <td style="width:20%;font-weight:bold;background:#eee;">N°Documento</td>
    <td style="width:30%">'.$misdatos->numero_documento.'</td>
    <td style="width:20%;font-weight:bold;background:#eee;">Tipo Ingreso</td>
     <td style="width:30%">'.$misdatos->tipo_documento.'</td>
  </tr>
  <tr>
   <td style="width:20%;font-weight:bold;background:#eee;">Proveedor:</td>
    <td COLSPAN="3" style="width:30%">'.$misdatos->rut_proveedor.' '.$misdatos->nombre_proveedor.'</td>
    
  </tr>
  <tr>
  <td style="width:20%;font-weight:bold;background:#eee;">Tipo Compra</td>
     <td COLSPAN="3" style="width:30%">'.$misdatos->tipo_compra_nombre.'</td>
  </tr>
   <tr>
   <td style="width:20%;font-weight:bold;background:#eee;">Observacion:</td>
    <td COLSPAN="3" style="width:30%">'.$misdatos->comentarios.'</td>
   
  </tr>';
}
      $html.='
</table>          
        <br></br>
     <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    	
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Cod.Int.</strong></td>
        							<td class="text-center"><strong>Product.</strong></td>
                                    <td class="text-center"><strong>Lote</strong></td>
                                    <td class="text-center"><strong>A vencer</strong></td>
        							<td class="text-center"><strong>Cant.</strong></td>
        							<td class="text-right"><strong>Unit.</strong></td>
                                    <td class="text-right"><strong>Total</strong></td>
                                </tr>
    						</thead>
    						<tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                
                                ';
                                foreach ($detalle as $misdetalle) {
                              $html.='   
    							<tr>
    							
    								<td class="text-center">'.$misdetalle->cod_producto.'</td>
                                    <td class="text-center">'.$misdetalle->nombre_prod.'</td>
                                    <td class="text-center">'.$misdetalle->numero_lote.'</td>
    								<td class="text-center">'.$misdetalle->fecha_vencimiento.'</td>
                                    <td class="text-right">'.$misdetalle->cantidad.'</td>
                                    <td class="text-right">'.$misdetalle->precio.'</td>
                                    <td class="text-right">'.$misdetalle->total.'</td>
    							</tr>
                                ';    }
                                $html.='   

                                ';
                                foreach ($datos as $misdatos) {
                               $html.='
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">'.$misdatos->subtotal.'</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
                                    	<td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="thick-line"></td>
    								<td class="no-line text-center"><strong>Desc.</strong></td>
    								<td class="no-line text-right">'.$misdatos->descuento.'</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="thick-line"></td>
    								<td class="no-line text-center"><strong>Neto</strong></td>
    								<td class="no-line text-right">'.$misdatos->neto.'</td>
                                </tr>
                                <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line"></td>
                                <td class="no-line text-center"><strong>IVA</strong></td>
                                <td class="no-line text-right">'.$misdatos->iva.'</td>
                            </tr>
                            <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="thick-line"></td>
                            <td class="no-line text-center"><strong>Total</strong></td>
                            <td class="no-line text-right">'.$misdatos->total_compra.'</td>
                        </tr>

                        ';    }
                        $html.='
    						</tbody>
                        </table>
                        

<div id="cajon1" class="right">  <hr style="color: black; background-color: black; height: 2px;text-align:left;
width: 50%;"/>
 <p style=text-align:left;font-weight:bold;>Firma y Timbre</p></div>
';
foreach ($datos as $misdatos) {
$html.='    
<div id="cajon2" class="left"><h4>Recibido por: '.$misdatos->nombre_usuario.'</h4></div>
</div>
   ';    }
$html.='
</div>

    				</div>
    			</div>
    		</div>
    	</div>
    </div>


  
</body>
</html>' ;

   

 
    $estilos3=file_get_contents("http://bodegachimbarongo.tk/hospital/plantilla2/reporte/reporte.css");
    $this->mpdf->setDisplayMode('fullpage');
    
  
    $this->mpdf->WriteHTML($estilos3,1);
    $this->mpdf->WriteHTML($html,2);

  
    $this->mpdf->Output();
     exit;

 }  


}
?>