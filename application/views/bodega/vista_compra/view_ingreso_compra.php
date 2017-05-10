 <div id="page-wrapper">

           

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h2 >
                 Ingresos
                        </h2>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Inicio</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Ingresos
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- /.row -->

 
  <!-- Row start -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-primary">
        <div class="panel-heading clearfix">
          <i class="icon-calendar"></i>
          <h3 class="panel-title">Encabezado de Ingreso</h3>
        </div>
        
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-4 col-sm-4">
          <label>Tipo Ingreso</label>
               <select name='combo_tipoingreso' id ='combo_tipoingreso'  class='form-control' >
             <?php
                 $elige="Elige una opcion";
                   echo '  <option value="',0,'">', $elige ,'</option>';
                    foreach ($arrayTipoingreso as $i => $cod_ingreso)
                    echo '<option value="',$i,'">',$cod_ingreso,'</option>';
                             ?>
             </select >
        
            </div>

            <div class="col-lg-4 col-sm-4">
               <label>N° Documento</label>
                <input type="text" class="form-control">
            
            </div>

            <div class="col-lg-4 col-sm-4">
                <label>Folio</label>
                <input type="text"  readonly class="form-control">
            </div>
    
          <div class="col-lg-4 col-sm-4">
          <br>
                <label>Tipo Compra</label>
                  <select name='combo_tipocompra'  id ='combo_tipocompra'  class='form-control' >
             <?php

                 $elige="Elige una opcion";
                   echo '  <option value="',0,'">', $elige ,'</option>';
                    foreach ($arrayTipocompra as $i => $cod_tipocompra)
                    echo '<option value="',$i,'">',$cod_tipocompra,'</option>';
                             ?>
             </select >
            </div>
              <div class="col-lg-3 col-sm-3">
             <br>
                <label>Proveedor</label>
	
	     <input type="text" id="proveedorrut" list="misproveedores2" class="form-control" placeholder="Buscar Proveedor">
 
       <datalist id="misproveedores2">
            
         </datalist>
  
        
             </div>
  
            <div class="col-lg-1 col-sm-1">
            <br>
            <label>Agregar</label>
             <div class='input-group ' >
          	<button type="button" class="btn btn-success" data-toggle='modal' data-target='#myModalproveedor'>
          	<span class="glyphicon glyphicon-plus"> Prov.</span> 
          	</button>				
            </div>
          </div>
             <div class="col-lg-2 col-sm-2">
                   <br>
                <label>Fecha</label>
    		     <div class='input-group date' >
                    <input type='text' id='datetimepicker1' name="datetimepicker1" readonly disabled class="form-control" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
             </div>
               <div class="col-lg-2 col-sm-2">
                   <br>
                <label>Hora</label>
    		     <div class='input-group ' >
                    <input type='text' readonly id="hora" name="hora" class="form-control" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
             </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Row end -->
  
  <!-- Row start -->
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-primary">
        <div class="panel-heading clearfix">
          <i class="icon-calendar"></i>
          <h3 class="panel-title">Busqueda Articulo</h3>
        </div>
        
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-4 col-sm-4">
       
                <label>Buscar Articulos</label>
                 <input type="text" id="buscarproducto" list="buscandoprod" class="form-control" placeholder="Buscar Producto">
                  <datalist id="buscandoprod">
        
                       </datalist>
            </div>

            <div class="col-lg-4 col-sm-4">
                <label>Agregar Producto a la lista</label>
                <div class='input-group ' >
          				<button type="button" id="Agregandogrilla" class="btn btn-success"  class="btn btn-success"  data-toggle='modal' data-target='#largeModal'>
          				 <span class="glyphicon glyphicon-plus"></span> Agregar
          				</button>				
            </div>
            </div>
          <div class="col-lg-2 col-sm-2">
               <label>Descuento</label>
                <input type="text" class="form-control">
            
            </div>
             <div class="col-lg-2 col-sm-2">
                <label>Agregar Descuento</label>
                <div class='input-group ' >
          				<button type="button" class="btn btn-success" class="btn btn-success"  data-toggle='modal' data-target='#largeModal'>
          				 <span class="glyphicon glyphicon-plus"></span> Agregar
          				</button>				
            </div>
            </div>
    
          <div class="col-lg-12 col-sm-12">
          <br>
        
            <table id="tbproductos" name="tbproductos" class="table table-striped  table-hover ">
              <thead>
                <tr class="success">
                  <th>Codigo Interno </th>
                  <th>Codigo Barra</th>
                  <th>Nombre Articulo</th>
                  <th>Lote</th>
                  <th>F.de venc</th>
                  <th>Cantidad</th>
                  <th>Valor Unitario.</th>
                  <th>Valor total</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            </div>
        
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Row end -->
            </div>


   <!-- modal empieza aca -->
   <!-- Modal -->
<div class="modal fade" id="myModalproveedor" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  Ingresar proveedor
                </h4>
            </div>
            <div class="alert alert-danger" id="msg-error" style="text-align:left;">
                  <strong>¡Importante!</strong> Corregir los siguientes errores.
                  <div class="list-errors"></div>
              </div>
            <!-- Modal Body -->
            <div class="modal-body" >
                
                      <form  id="proveedorGuardar" role="form" action= "<?= base_url()?>control_proveedor/guardar " method="POST" >
                         <br>
                         <br>
                            <div class="form-group">
                               <label>Rut</label>
                                <input class="form-control" id="rut" name="rut" placeholder="Ingrese Rut  Ejemplo 11111111-1" onfocusout="validarRut() " maxlength="10" onkeypress="return solorut(event)">
                                  <p class="text-errors" id="msgerrorut"></p>
                            </div>

                            <div class="form-group">
                                <label>Nombre Proveedor</label>
                            <input class="form-control" id="nombre" name="nombre"  placeholder="Ingrese Nombre" onkeypress="return soloLetras(event)">
                            <button type="button" onclick="agregarproveedor()"></button>
                            </div>

                            <div class="form-group">
                            <label>Razon social</label>
                            <input class="form-control" id="razon" name="razon"  placeholder="Ingrese su Razon Social">
                            </div>

                            <div class="form-group">
                            <label>Direccion</label>
                            <input class="form-control" id="direccion" name="direccion"  placeholder="Ingrese su Direccion">
                            </div>

                            <div class="form-group">
                            <label>Telefono</label>
                            <input class="form-control" id="telefono" name="telefono"  placeholder="Ingrese su Telefono">
                            </div>

                            <div class="form-group">
                            <label>Correo</label>
                            <input class="form-control" id="correo" name="correo"  placeholder="Ingrese su Correo">
                            </div>
 
                <div class="modal-footer">
                <button type="button" id="cerrando" name="cerrando" onclick="cerrarModal()" class="btn btn-lg  btn-danger" data-dismiss="modal">
                 Cerrar
                </button>

                <button type="submit" id="enviar" name="enviar" class="btn btn-lg  btn-success" >
                    Guardar
                </button>
                </div>
                </form>

                
            </div>
            
        </div>
    </div>
</div>




<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <div class="modal-body">
          <div class="panel panel-primary">
        <div class="panel-heading clearfix">
          <i class="icon-calendar"></i>
          <h3 class="panel-title">Ingresar Articulos</h3>
        </div>
          <div class="panel-body">
          <div class="row">
         <form  id="ingresararticulo" onsubmit="addProductotabla(event)">
            <div class="col-lg-6 col-sm-6">
                <label>Codigo Articulo</label>
                <input id="codigoarticulo" name="codigoarticulo" type="text" readonly class="form-control">
            </div>
          <div class="col-lg-6 col-sm-6">
            <label>Codigo Barra</label>
                <input id="codigobarra" name="codigobarra" type="text" readonly class="form-control">
        
            </div>

            <div class="col-lg-12 col-sm-12">
            <br>
               <label>Nombre</label>
                <input id="nombreproducto" name="nombreproducto" type="text" readonly class="form-control">
            </div>

            <div class="col-lg-4 col-sm-4">
            <br>
                <label>Lote</label>
                <input type="text" id="lote" name="lote"  class="form-control">
            </div>
         
              <div class="col-lg-4 col-sm-4">
              <br>
              <label>Fecha</label>
    		     <div class='input-group date' >
                    <input type='date' id='fechaingreso' name="fechaingreso" class="form-control" />
                </div>
            </div>

            <div class="col-lg-4 col-sm-4">
            <br>
                <label>Recepcionado</label>
                <input type="text" id="recepcionado" name="recepcionado" onChange="multiplicar();" value="0" class="form-control">
            </div>
             <div class="col-lg-8 col-sm-8">
             </div>
            <div class="col-lg-4 col-sm-4">
            <br>
                <label>Valor Unidad</label>
                <input type="text" id="valorunidad" name="valorunidad" onChange="multiplicar();" value="0" class="form-control">
            </div>
            <div class="col-lg-8 col-sm-8">
             </div>
                <div class="col-lg-4 col-sm-4">
            <br>
                <label>Valor Total</label>
                <input type="text" id="valortotal" name="valortotal" value="0" readonly class="form-control">
            </div>


          </div>
        </div>

      <div class="modal-footer">
      <br>
        <button type="button" class="btn btn-default" onclick="cerrarModal();" data-dismiss="modal">Cerrar</button>
           <button type="button" class="btn btn-danger">Eliminar fila</button>
              <button type="submit" class="btn btn-success">Agregar fila</button>
      </div>
      </form>
            </div>
      </div>
    </div>
  </div>
</div>




  </body>