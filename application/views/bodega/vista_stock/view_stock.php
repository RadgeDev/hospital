<div id="page-wrapper">
 <div class="container-fluid">
 <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                  Stock Inventario
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?= base_url('welcome') ?>">Inicio</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Stock Inventario
                            </li>
                        </ol>
                    </div>
                </div>
   <div class="row">
      <div class="col-md-2">
     
      </div>
     
          <div class="col-md-2 ">
    

      </div>
      <div class="col-md-4 ">
        
        
      </div>
      
    </div>         
         <div class="panel panel-primary">
        <div class="panel-heading clearfix">
          <i class="icon-calendar"></i>
          <h3 class="panel-title">Encabezado de Stock</h3>
        </div>
        <div class="panel-body">
          <div class="row">
             <div class="col-lg-4 col-sm-4">
          <label>Tipo Stock</label>
            <select name='combo_stock' id ='combo_stock' class='form-control' >
            <option value="0"> Eliga un Stock</option>
            <option value="1"> Critico</option>
            <option value="2"> Minimo</option>
            <option value="3"> Maximo</option>
            </select >
        
            </div>

            <div class="col-lg-4 col-sm-4">
            <label>Buscar por:</label>
        <select name="buscando" id ="buscando" class="form-control" >
        <option value="nombre">Nombre</option>
        <option value="cod_interno_prod">Codigo Interno</option>
        <option value="codigo_barra">Codigo de barra </option>
        <option value="cantidad">Cantidad</option>
        <option value="precio">Precio</option>
        </select>
            </div>
    <br>
            <div class="col-lg-4 col-sm-4 ">

        <div class="form-group has-feedback has-feedback-left">
      <input type="text" class="form-control" name="busqueda" placeholder="Buscar algo" />
       <i class="glyphicon glyphicon-search form-control-feedback"></i>
      
        </div>
         
            </div>

             <div class="col-md-2">
         <a  class='btn btn-info' type="button"  onclick="exportarexcel();">Exportar tabla a Excel</a>
      </div>
   <div class="col-md-2">
         <a href="<?= base_url('control_producto/exceltodo') ?>" class='btn btn-info' type="button"  >Exportar todo a Excel</a>
    </div>
          </div>
            </div>
              </div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h4>Stock de Productos</h4>
          </div>

            
          <div id="tbproductos" class="panel-body table-responsive">
            
            <p>
              <strong>Mostrar por : </strong>
              <select name="cantidadpag" id="cantidadpag">
                <option value="10">10</option>
                <option value="20">20</option>
              </select>
            </p>
            <table id="tbclientes" name="tbclientes" class="table table-striped  table-hover ">
              <thead>
                <tr class="success">
                  <th>Codigo Interno </th>
                  <th>Codigo Barra</th>
                  <th>Codigo Bodega</th>
                  <th>Nombre</th>
                  <th>Cantidad</th>
                  <th>Stock Critico</th>
                  <th>Stock Min.</th>
                  <th>Stock Max</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            <div class="text-center paginacion ">
              
            </div>
          </div>
        </div>
      </div>
    </div>




     <!-- modal empieza aca -->
   <!-- Modal -->
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
                  Ingresar Producto
                </h4>
            </div>
            <div class="alert alert-danger" id="msg-error" style="text-align:left;">
                  <strong>¡Importante!</strong> Corregir los siguientes errores.
                  <div class="list-errors"></div>
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
                            <input class="form-control" id="cantidad" name="cantidad" onkeypress="return solonumeros(event)"  placeholder="Ingrese su cantidad">
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



   <!-- Modal -->
<div class="modal fade" id="myModalEditar" tabindex="-1" role="dialog" 
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
                  Ingresar Producto
                </h4>
            </div>
            <div class="alert alert-danger" id="msg-error2" style="text-align:left;">
                  <strong>¡Importante!</strong> Corregir los siguientes errores.
                  <div class="list-errors2"></div>
              </div>
            <!-- Modal Body -->
            <div class="modal-body" >
                
              <form  id="formEditar" role="form" action= "<?= base_url()?>control_producto/actualizar " method="POST" >
                 <div class="row">
                  <div class="col-md-6">
                             <div class="form-group">
                              <label>Codigo Interno</label> 
                                <input class="form-control" id="editcodigo" name="editcodigo" placeholder="Ingrese codigo"  readonly  >
            
                            </div>

                            <div class="form-group">
                                <label>Codigo Barra</label>
                            <input class="form-control" id="editcodigobarra"  name="editcodigobarra"  placeholder="Ingrese Codigo Barra" >
                            </div>

                            <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" id="editnombre" name="editnombre"  placeholder="Ingrese su nombre">
                            </div>

                            <div class="form-group">
                            <label>Cantidad</label>
                            <input class="form-control" id="editcantidad" name="editcantidad" onkeypress="return solonumeros(event)"  placeholder="Ingrese su cantidad">
                            </div>
                            <label>Precio</label>
                            <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input class="form-control" id="editprecio" name="editprecio"  onkeypress="return solonumeros(event)"  placeholder="Ingrese su precio">
                            </div>
                            </div>
                      

                      
                       <div class="col-md-6">

                            <div  class="form-group">
                                <label>Unidad Medida</label>
                                <select id="medida2" name="medida2" class="form-control">
                                    <option>Seleccione una opcion</option>
                                    <option>Botella</option>
                                    <option>Unidad</option>
                                    <option>Paquete</option>
                                    <option>Caja</option>
                                </select>
                            </div>
                            <input type="hidden"  class="form-control" id="seleccion2" name="seleccion2"  >
                            <div class="form-group">
                            <label>Stock Critico</label>
                            <input class="form-control" id="editstockcri" name="editstockcri"  onkeypress="return solonumeros(event)" placeholder="Ingrese su Stock">
                            </div>
                            <div class="form-group">
                            <label>Stock Minimo</label>
                            <input class="form-control" id="editstockmin" name="editstockmin"  onkeypress="return solonumeros(event)" placeholder="Ingrese su Stock">
                            </div>
                            <div class="form-group">
                            <label>Stock Maximo</label>
                            <input class="form-control" id="editstockmax" name="editstockmax"  onkeypress="return solonumeros(event)"  placeholder="Ingrese su Stock">
                            </div>
                        </div>
                        </div>
            <div class="modal-footer">
                <button type="button" id="cerrando" name="cerrando" class="btn btn-lg  btn-danger" data-dismiss="modal">
                            Cerrar
                 </button>
                <button type="submit" id="enviar" name="enviar" class="btn btn-lg  btn-success" >
                  Actualizar
                </button>
            </div>
             </form> 
            </div>
            
        </div>
    </div>
</div>
