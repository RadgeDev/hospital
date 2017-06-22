 <div id="page-wrapper">

           

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h2 >
               Salidas/Egresos
                        </h2>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Inicio</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Salidas
<button class='btn btn-success' onclick="cambiarlote();" >aaaaaa</button>

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
          <h3 class="panel-title">Encabezado de Egreso</h3>
        </div>
        
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-4 col-sm-4">
          <label>Tipo Salida</label>
               <select name='combo_salida' id ='combo_salida' class='form-control' >
               <option selected="selected" value="0">Eliga una opcion</option>
               <option value="1">Pedidos</option>
               <option value="2">Ajustes de Inventario</option>
               <option value="2">Salida Directa </option>
             </select >
        
            </div>

            <div class="col-lg-4 col-sm-4">
               <label>N°Pedido</label>
                <input type="text" id="npedido" onblur=""  readonly class="form-control">
            
            </div>

            <div class="col-lg-4 col-sm-4">
                <label>N°Egreso</label>
                <input type="text" id="nsalida" readonly class="form-control">
            </div>
    
          <div class="col-lg-4 col-sm-4">
          <br>
                <label>Depto./Servicio</label>
                  <select name='combo_depto'  id ='combo_depto'   class='form-control' >
              <?php
                 $elige="Elige una opcion";
                   echo '  <option selected="selected" value="',0,'">', $elige ,'</option>';
                    foreach ($arrayTipodepto as $i => $cod_depto)
                    echo '<option value="',$i,'" >',$cod_depto,'</option>';
                             ?>
             </select >
            </div>
              <div class="col-lg-4 col-sm-4">
             <br>
            

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
            <div class="col-lg-5 col-sm-5">
   
                <label>Buscar Articulos</label>
                 <input type="text" id="buscarproducto" onblur="" list="buscandoprod"  class="form-control " placeholder="Buscar Producto">
           
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
                  <th>Nombre Articulo</th>
                  <th>Lote</th>
                  <th>F.de venc</th>
                  <th>Cant.Pedido</th>
                  <th>Cant.Entrega</th>
                  <th>Valor Unitario.</th>
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

  
              <div class="form-group form-inline col-lg-4 col-sm-4 "></div>
              <div class="form-group form-inline col-lg-4 col-sm-4 ">
             <button type="button"  id="limpiarsalida" class="btn btn-danger" onclick="limpiar();" > Limpiar Campos </button> 
           
             <button type="button" id="imprimirsalida" onclick="abrirEnPestana();" class="btn btn-info" target="BLANK" disabled > Imprimir Egreso </button>  
             <button type="button" id="guardarsalida" onclick="guardarsalida();" class="btn btn-success" > Guardar Egreso </button>  
         
         
    </div>
                <div class="form-group form-inline col-lg-4 col-sm-offset-4 ">
              	  <div class="alert alert-danger" id="msg-error3" style="text-align:left;">
                  <strong>¡Error!</strong> Intentelo mas tarde.
                  <div class="list-errors3"></div>
                  </div>
                  <div class="alert alert-success" id="msg-bien" style="text-align:left;">
                  <strong>¡Ingreso Correcto!</strong> Datos Guardados.
                  <div class="list-errors4"></div>
              </div>     
    </div>



   <!-- modal empieza aca -->
   <!-- Modal -->

<div class="modal fade" id="modal_lotes" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="width:1000px;">
      
      <div class="modal-body">
          <div class="panel panel-primary">
        <div class="panel-heading clearfix">
          <i class="icon-calendar"></i>
            <h3 class="panel-title">Seleccionar Lotes</h3>
        </div>
          <div class="panel-body"  >
          <div class="row">
         <form   >
           <div class="col-lg-8 col-sm-8">
           </div>
           <div class="col-lg-4 col-sm-4">
             <label style=" text-align: right;">Cantidad Solicitada:  </label><label id="cantped" ></label>
        
             </div>
   <div class="col-lg-12 col-sm-12">
          <br>
        
            <table id="tblotes" name="tblotes" class="table table-striped-responsive table-sm  table-hover ">
              <thead>
                <tr class="success">
                 <th>Seleccionar</th>
                  <th>Lotes</th>
                  <th>Cod.Producto</th>
                  <th>Nombre</th>
                  <th>Fecha Venc.</th>
                  <th>Precio</th>
                  <th>Stock</th>
                  <th>Ingresar Cant.</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            </div>
            
        </div>

      <div class="modal-footer">
      <br>
        <button type="button" class="btn btn-success" onclick="agregarlotes();">  Agregar pedido </button>
        <button type="button" class="btn btn-danger" onclick="cerrarModal();" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
            </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="modal_pedidos" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="width:1000px;">
      <div class="modal-body" >
          <div class="panel panel-primary">
        <div class="panel-heading clearfix">
          <i class="icon-calendar"></i>
          <h3 class="panel-title">Seleccionar Pedido</h3>
        </div>
          <div class="panel-body"  >
          <div class="row">
         <form  id="ingresararticulo" onsubmit="addProductotabla(event)">
       
   <div class="col-lg-12 col-sm-12">
          <br>
        
            <table id="tbpedidos" name="tbpedidos" class="table table-striped-responsive table-sm  table-hover ">
              <thead>
                <tr class="success">
                  <th>Servicio Destino </th>
                <th>Observaciones</th>
                  <th>Estado</th>
                  <th>Fecha</th>
                  <th>Hora</th>
                  <th>Realizar</th>
                  <th>Cancelar</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            </div>
            
        </div>

      <div class="modal-footer">
      <br>
        <button type="button" class="btn btn-danger" onclick="cerrarModal();" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
            </div>
      </div>
    </div>
  </div>
</div>


  </body>