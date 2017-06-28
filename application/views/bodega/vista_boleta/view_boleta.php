 <div id="page-wrapper">

           

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h2 >
                 Ingreso Compra Directa
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
               <select name='combo_tipoingreso' id ='combo_tipoingreso' class='form-control' >
           <option value="0" selected>Eliga tipo Ingreso</option>
           <option value="1" selected>Boleta</option>
           <option value="2" selected>Factura</option>
             </select >
        
            </div>

            <div class="col-lg-4 col-sm-4">
               <label>N° Documento</label>
                <input type="text" id="ndocumento" onblur="habilitando();" onkeypress="return solonumerosenteros(event)" class="form-control" maxlength="25">
            
            </div>

            <div class="col-lg-4 col-sm-4">
                <label>Folio</label>
                <input type="text" id="folio" readonly class="form-control">
            </div>
    
          <div class="col-lg-4 col-sm-4">
          <br>
                <label>Tipo Compra</label>
          <select name='combo_tipocompra'  id ='combo_tipocompra'  class='form-control' >
           <option value="0" selected>Eliga tipo Compra</option>
           <option value="1" selected>Compra Directa</option>
          </select >
            </div>
              <div class="col-lg-3 col-sm-3">
             <br>
                <label>Proveedor</label>
	
	     <input type="text" id="proveedorrut" onblur="habilitando();"  list="misproveedores2" class="form-control" placeholder="Buscar Proveedor">
 
       <datalist id="misproveedores2">
            
         </datalist>
  
        
             </div>
  
            <div class="col-lg-1 col-sm-1">
            <br>
            <label>Agregar</label>
             <div class='input-group ' >
          	<button type="button" class="btn btn-success" id="agregarprov" data-toggle='modal' data-target='#myModalproveedor'>
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
                 <input type="text" id="buscarproducto" onblur="habilitando();" list="buscandoprod" class="form-control" placeholder="Buscar Producto">
                  <datalist id="buscandoprod">
        
                       </datalist>

            </div>

            <div class="col-lg-2 col-sm-2">
                <label>Producto a la lista</label>
                <div class='input-group ' >
          				<button type="button" id="Agregandogrilla" class="btn btn-success"  class="btn btn-success"  onclick="listarproductos();">
          				 <span class="glyphicon glyphicon-plus"></span> Agregar Lista
          				</button>				
            </div>
            </div>

            <div class="col-lg-2 col-sm-2">
                <label>Agregar Nuevo  Prod.</label>
                <div class='input-group ' >
          				<button type="button" id="agreganuevo" class="btn btn-info"  class="btn btn-info"  data-toggle='modal' data-target='#myModalguardar'>
          				 <span class="glyphicon glyphicon-plus"></span> Agregar Prod.
          				</button>				
            </div>
            </div>
          <div class="col-lg-4 col-sm-4">
               <label>Comentarios</label>
                <input type="text" id="Comentarios"  class="form-control">
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
                  <th>Borrar</th>
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

  
              <div class="form-group form-inline col-lg-4 col-sm-4 " ">
               <label  style=" float: right;">Descuento :
             <input type="text" id="descuento" style="text-align:right;" value="0" class="form-control"  onBlur="calculartotal();">	<button type="button" onclick="calculartotal();" id="agregardesc" class="btn btn-warning" >
          				 <span class="glyphicon glyphicon-plus"></span> Desc.
          				</button>				</label>
           </div>

              <div class="form-group form-inline col-lg-4 col-sm-4 " ">
               <label style=" float: right;" >Valor factura/boleta :
            <input type="text"  id="valorfactura" onblur="habilitando();" onChange="habilitando();" style="text-align:right;" class="form-control" readonly  placeholder="VALOR  FACT/BOL" name="valorfactura"/></label>
           </div>

           <div class="form-group form-inline col-lg-4 col-sm-4 ">
        
              <label style=" float: right;">NETO :
          <input type="text" style="text-align:right;" id="neto" class="form-control" readonly placeholder="NETO" name="neto">
                </label>
           <label id="lblneto" style=" float: right;Color:red;">Descuento Aplicado +  </label>
            </div>
        <div class="form-group form-inline col-lg-4 col-sm-4 "></div>
              <div class="form-group form-inline col-lg-4 col-sm-4 ">
           </div>
            <div class="form-group form-inline col-lg-4 col-sm-4">
              <label style=" float: right;">I.V.A :
            <input type="text" style="text-align:right;" id="iva" class="form-control" readonly placeholder="IVA" name="iva">
             </label>
            </div>
              <div class="form-group form-inline col-lg-4 col-sm-4 "></div>
              <div class="form-group form-inline col-lg-4 col-sm-4 ">
             <button type="button"  id="limpiaringreso" class="btn btn-danger" onclick="limpiar();" > Limpiar Campos </button> 
           
             <button type="button" id="imprimiringreso" onclick="abrirEnPestana();" class="btn btn-info" target="BLANK" disabled > Imprimir Ingreso </button>  
             <button type="button" id="guardaringreso" onclick="guardaringreso();" class="btn btn-success" > Guardar Ingreso </button>  
         
              
           </div>
            <div class="form-group form-inline col-lg-4 col-sm-4">
             <label style=" float: right;">TOTAL :
            <input type="text" id="total" style="text-align:right;"  class="form-control" readonly placeholder="TOTAL" name="total"/>
             </label>
            </div>
             <div class="form-group form-inline col-lg-4 col-sm-4 "></div>
              <div class="form-group form-inline col-lg-4 col-sm-4 ">
              	  <div class="alert alert-danger" id="msg-error3" style="text-align:left;">
                  <strong>¡Error!</strong> Intentelo mas tarde.
                  <div class="list-errors3"></div>
                  </div>
                  <div class="alert alert-success" id="msg-bien" style="text-align:left;">
                  <strong>¡Ingreso Correcto!</strong> Datos Guardados.
                  <div class="list-errors4"></div>
              </div>
                <div class="form-group form-inline col-lg-4 col-sm-4 "></div>
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
                <input id="codigoarticulo"  name="codigoarticulo" type="text" readonly class="form-control">
            </div>
          <div class="col-lg-6 col-sm-6">
            <label>Codigo Barra</label>
                <input id="codigobarra"  name="codigobarra" type="text" readonly class="form-control">
        
            </div>

            <div class="col-lg-12 col-sm-12">
            <br>
               <label>Nombre</label>
                <input id="nombreproducto"  name="nombreproducto" type="text" readonly class="form-control">
            </div>

            <div class="col-lg-4 col-sm-4">
            <br>
                <label>Lote</label>
                <input type="text" id="lote" name="lote" style="text-align:right;"  class="form-control">
            </div>
         
              <div class="col-lg-4 col-sm-4">
              <br>
              <label>Fecha Vencimiento</label>
    		     <div class='input-group date' >
                    <input type='date' id='fechavencimiento' name="fechavencimiento" class="form-control" />
                </div>
            </div>

            <div class="col-lg-4 col-sm-4">
            <br>
                <label>Valor Unidad</label>
               <input type="text" id="valorunidad" style="text-align:right;" onkeypress="return solonumeros(event)" name="valorunidad" onChange="multiplicar();" value="0" class="form-control">
            </div>
             <div class="col-lg-8 col-sm-8">
             </div>
            <div class="col-lg-4 col-sm-4">
            <br>
                <label>Cantidad Recepcionado</label>
                <input type="text" id="recepcionado" style="text-align:right;" onkeypress="return solonumerosenteros(event)" name="recepcionado" onChange="multiplicar();" value="0" class="form-control">
            </div>
            <div class="col-lg-8 col-sm-8">
             </div>
                <div class="col-lg-4 col-sm-4">
            <br>
                <label>Valor Total</label>
                <input type="text" id="valortotal" style="text-align:right;" name="valortotal" value="0" readonly class="form-control">
            </div>


          </div>
        </div>

      <div class="modal-footer">
      <br>
        <button type="button" class="btn btn-danger" onclick="cerrarModal();" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-success">Agregar fila</button>
      </div>
      </form>
            </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModalguardar" tabindex="-1" role="dialog" 
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
                  Ingresar Nuevo Producto
                </h4>
            </div>
            <div class="alert alert-danger" id="msg-error2" style="text-align:left;">
                  <strong>¡Importante!</strong> Corregir los siguientes errores.
                  <div class="list-errors2"></div>
              </div>
            <!-- Modal Body -->
            <div class="modal-body" >
                
              <form  id="formGuardar" role="form" action= "<?= base_url()?>control_producto/guardar " method="POST" >
                 <div class="row">
                  <div class="col-md-6">

                              <div  class="form-group">
                              <label>Eliga Correlativo</label>
                        <select name='cod_combo' id ='cod_combo'  class='form-control' >
            
                           <?php
                           $elige="Elige una opcion";
                           echo '  <option value="',0,'">', $elige ,'</option>';
                           foreach ($arrayCorrelativo as $i => $cod_bodega)
                           
                             echo '<option value="',$i,'">',$cod_bodega,'</option>';
                             ?>
                           </select >

                            <input type="hidden"  class="form-control" id="combocorrelativo" name="combocorrelativo"  >
                             <input  type="hidden" class="form-control" id="ultimocorrelativo" name="ultimocorrelativo"  >
                              </div>
                             <div class="form-group">

                              <label>Codigo Interno</label> 
                                <input class="form-control" id="codigo" name="codigo" placeholder="Ingrese codigo"  readonly  >
                                  <p class="text-errors" id="msgerrorut"></p>
                            </div>

                            <div class="form-group">
                                <label>Codigo Barra</label>
                            <input class="form-control" id="codigobarra"  name="codigobarra"  placeholder="Ingrese Codigo Barra" >
                            </div>

                            <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" id="nombre" name="nombre"  placeholder="Ingrese su nombre">
                            </div>

                            <div class="form-group">
                            <label>Cantidad</label>
                            <input class="form-control" id="cantidad" name="cantidad" value="0" onkeypress="return solonumerosenteros(event)" readonly placeholder="Ingrese su cantidad">
                            </div>
                            <label>Precio</label>
                            <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input class="form-control" id="precio" name="precio"  onkeypress="return solonumeros(event)"  placeholder="Ingrese su precio">
                            </div>
                            </div>
                      

                      
                       <div class="col-md-6">

                            <div  class="form-group">
                                <label>Unidad Medida</label>
                                <select name="medida" class="form-control">
                                    <option>Seleccione una opcion</option>
                                    <option>Botella</option>
                                    <option>Unidad</option>
                                    <option>Paquete</option>
                                    <option>Caja</option>
                                </select>
                            </div>
                            <input type="hidden"  class="form-control" id="seleccion" name="seleccion"  >
                            <div class="form-group">
                            <label>Stock Critico</label>
                            <input class="form-control" id="stockcri" name="stockcri"  onkeypress="return solonumeros(event)" placeholder="Ingrese su Stock">
                            </div>
                            <div class="form-group">
                            <label>Stock Minimo</label>
                            <input class="form-control" id="stockmin" name="stockmin"  onkeypress="return solonumeros(event)" placeholder="Ingrese su Stock">
                            </div>
                            <div class="form-group">
                            <label>Stock Maximo</label>
                            <input class="form-control" id="stockmax" name="stockmax"  onkeypress="return solonumeros(event)"  placeholder="Ingrese su Stock">
                            </div>
                        </div>
                        </div>
            <div class="modal-footer">
                <button type="button" id="cerrando" name="cerrando" class="btn btn-lg  btn-danger"
                        data-dismiss="modal">
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

  </body>