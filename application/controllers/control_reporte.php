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
    
 
</head>
<body>
<div id="wrapper">

<div class="right"> 
    <img src="http://localhost/hospital/plantilla2/reporte/logo.jpg">
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
         
    <div id="content">
         
        <div id="invoice_body">
            <table>
            <tr style="background:#eee;">
                <td style="width:8%;"><b>Cod Int.</b></td>
                <td style="padding-left:10px;"><b>Producto</b></td>
                <td style="width:15%;"><b>Lote</b></td>
                  <td style="width:10%;"><b>A.Vencer</b></td>
                <td style="width:5%;"><b>Cant</b></td>
                <td style="width:10%;"><b>Unitario</b></td>
                <td style="width:10%;"><b>Total</b></td>
            </tr>
            </table>
             
           <table cellpadding=" 0" cellspacing="0" WORD-BREAK:BREAK-ALL  >
           ';
  foreach ($detalle as $misdetalle) {
$html.='
            <tr>
                <td style="width:8%;"><h5 class="letralegible">'.$misdetalle->cod_producto.'</h5></td>
                <td style="text-align:left; padding-left:10px;"><h5 class="letralegible2">'.$misdetalle->nombre_prod.'</h5></td>
                <td  style="width:15%;"><h5 class="letralegible">'.$misdetalle->numero_lote.'</h5></td>
                <td  style="width:10%;"><h5 class="letralegible">'.$misdetalle->fecha_vencimiento.'</h5></td>
                <td  style="width:5%;"><h5 class="letralegible">'.$misdetalle->cantidad.'</h5></td>
                <td style="width:10%;" ><h5 class="letralegible">'.$misdetalle->precio.'</h5></td>
                <td style="width:10%;" ><h5 class="letralegible">'.$misdetalle->total.'</h5></td>

            </tr> 
               ';    }
$html.='        
            <tr>
                <td colspan="5"></td>
                <td></td>
                <td></td>
            </tr>
              ';
  foreach ($datos as $misdatos) {
 $html.='
            <tr>
                <td colspan="5"></td>
                <td style="font-weight:bold; font-size:8pt;background:#eee;">NETO </td>
                <td ><h5 class="letralegible">'.$misdatos->neto.'</h5></td>

            </tr>
             <tr>
               
              <td colspan="5"></td>
              <td style="font-weight:bold; font-size:8pt;background:#eee;">IVA </td>
                <td ><h5 class="letralegible">'.$misdatos->iva.'</h5></td>
            </tr>
              <tr>
               <td colspan="5"></td>
              <td style="font-weight:bold; font-size:8pt;background:#eee;">DESC </td>
                <td ><h5 class="letralegible">'.$misdatos->descuento.'</h5></td>
            </tr>
              <tr>
                <td colspan="5"></td>
             <td style="font-weight:bold; font-size:8pt;background:#eee;">TOTAL </td>
                <td ><h5 class="letralegible">'.$misdatos->total_compra.'</h5></td>
                
            </tr>
       ';    }
$html.='   
        </table>
         <br >

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


  
</body>
</html>' ;

   

 
    $estilos3=file_get_contents("http://localhost/hospital/plantilla2/reporte/reporte.css");
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
    <img src="http://localhost/hospital/plantilla2/reporte/logo.jpg">
    </div>
    '; 
  foreach ($datos as $misdatos) {
 $html.='
<div  class="left"><p style="text-align:right;padding-top:0mm;font-weight:bold;" >Folio:'.$misdatos->folio.'</p> 
  <p style="text-align:right;padding-top:0mm;font-weight:bold;" >Fecha:  '.$misdatos->fecha.'</p> </div>
        </div>

    <h3 style="text-align:center;padding-top:0mm;font-weight:bold;">INGRESO BODEGA  HOSPITAL CHIMBARONGO</h3>


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
         
    <div id="content">
         
        <div id="invoice_body">
            <table>
            <tr style="background:#eee;">
                <td style="width:25%;"><b>Cod Producto.</b></td>
                <td style="width:50%;"><b>Nombre</b></td>
                <td style="width:25%;"><b>Cantidad</b></td>
       
            </tr>
            </table>
             
           <table cellpadding=" 0" cellspacing="0" WORD-BREAK:BREAK-ALL  >
           ';
  foreach ($detalle as $misdetalle) {
$html.='
            <tr>
                <td style="width:25%;"><h5 class="letralegible">'.$misdetalle->cod_producto.'</h5></td>
                <td  style="width:50%;text-align:left;font-weight:bold;"><h5 class="letralegible">'.$misdetalle->nombre_prod.'</h5></td>
                 <td  style="width:25%;"><h5 class="letralegible">'.$misdetalle->cantidad.'</h5></td>
            </tr> 
               ';    }
$html.='        
            <tr>
                <td colspan="5"></td>
                <td></td>
                <td></td>
            </tr>
              ';
  
$html.='   
        </table>
         <br >

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


  
</body>
</html>' ;

   

 
    $estilos3=file_get_contents("http://localhost/hospital/plantilla2/reporte/reporte.css");
    $this->mpdf->setDisplayMode('fullpage');
    $this->mpdf->WriteHTML($estilos3,1);
    $this->mpdf->WriteHTML($html,2);

  
    $this->mpdf->Output();
     exit;

 }  



}
?>