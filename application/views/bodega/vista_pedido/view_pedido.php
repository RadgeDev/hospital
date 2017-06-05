 <div id="page-wrapper">

           

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h2 >
            Pedidos
                        </h2>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Inicio</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Pedidos

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
          <h3 class="panel-title">Encabezado de Pedido</h3>
        </div>
        
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-4 col-sm-4">
          <label>Departamento</label>
               <select name='combo_depto' id ='combo_depto' class='form-control' >
             <?php
                 $elige="Elige una opcion";
                   echo '  <option value="',0,'">', $elige ,'</option>';
                    foreach ($arrayTipodepto as $i => $cod_depto)
                    echo '<option value="',$i,'">',$cod_depto,'</option>';
                             ?>
             </select >
        
            </div>

            <div class="col-lg-2 col-sm-2">
         
               <label>Horario Recepcion </label>
                <input type="text" id="recepcion" style="background:yellow;color:red;font-weight:bold;" onblur="habilitando();" onkeypress="return solonumerosenteros(event)" class="form-control" maxlength="25" readonly="" placeholder="Horario Recepcion">
            
            </div>
              <div class="col-lg-2 col-sm-2">
               <label>Horario Entrega </label>
                <input type="text" id="entrega" style="background:yellow;color:red;font-weight:bold;" onblur="habilitando();" onkeypress="return solonumerosenteros(event)" class="form-control" maxlength="25" readonly="" placeholder="Horario Entrega">
            
            </div>

            <div class="col-lg-4 col-sm-4">
                <label>Folio</label>
                <input type="text" id="folio" readonly class="form-control">
            </div>
    
          <div class="col-lg-4 col-sm-4">
          <br>
                <label>Tipo Pedido</label>
                  <select name='combo_pedido'  id ='combo_tipocompra'  class='form-control' >
                  <?php
                 $elige="Elige una opcion";
                   echo '  <option value="',0,'">', $elige ,'</option>';
                    foreach ($arrayTipopedido as $i => $cod_bodegas)
                    echo '<option value="',$i,'">',$cod_bodegas,'</option>';
                  ?>
             </select >
            </div>
              <div class="col-lg-4 col-sm-4">
             <br>
                <label>Tiempo de Pedido</label>
                  <select name='combo_tiempo'  id ='combo_tipocompra'  class='form-control' >
                  <option value="0">Eliga un pedido</option>
                     <option value="1">Mensual</option>
                        <option value="2">Semanal</option>
             </select >
        
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
    <select name="buscando" id ="buscando" class="form-control" >
        <option value="nombre">Nombre</option>
        <option value="cod_interno_prod">Codigo Interno</option>
        <option value="codigo_barra">Codigo de barra </option>
        </select>

      </div>
      <div class="col-lg-4 col-sm-4">
        <div class="form-group has-feedback has-feedback-left">

            <input type="text" class="form-control" name="busqueda" id="busqueda" placeholder="Buscar producto aqui" />
            <i class="glyphicon glyphicon-search form-control-feedback"></i>
        </div>
        
      </div>

          <div class="col-lg-4 col-sm-4">
              <strong>Mostrar por : </strong>
              <select name="cantidadpag" id="cantidadpag">
                <option value="5">5</option>
                <option value="10">10</option>
              </select>
                   </div>
            </p>

            <table id="tbproductos" name="tbproductos" class="table table-striped  table-hover ">
              <thead>
                <tr class="success">
                  <th>Codigo Interno </th>
                  <th>Codigo Barra</th>
                  <th>Nombre Articulo</th>
                  <th>Agregar</th>
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
   
  <!-- Row start -->
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-primary">
        <div class="panel-heading clearfix">
          <i class="icon-calendar"></i>
          <h3 class="panel-title">Carro Pedido</h3>
        </div>
        
        <div class="panel-body">
          <div class="row">
          <div class="col-lg-12 col-sm-12">
    
     
            <table id="tbpedidos" name="tbpedidos" class="table table-striped  table-hover ">
              <thead>
                <tr class="success">
                  <th>Codigo Interno </th>
                  <th>Codigo Barra</th>
                  <th>Nombre Articulo</th>
                  <th>Cantidad a Pedir</th>
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
             <button type="button"  id="limpiaringreso" class="btn btn-danger" onclick="limpiar();" > Limpiar Campos </button> 
           
             <button type="button" id="imprimiringreso" onclick="abrirEnPestana();" class="btn btn-info" target="BLANK" disabled > Imprimir Ingreso </button>  
             <button type="button" id="guardaringreso" onclick="guardaringreso();" class="btn btn-success" > Guardar Ingreso </button>  
           </div>
            <div class="form-group form-inline col-lg-4 col-sm-4">
<input type="text" id="micomentario"  class="form-control" placeholder="Escriba una Observacion">
            
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
             
    </div>
          
      

  <!-- Row end -->

   <!-- modal empieza aca -->
   <!-- Modal -->





  </body>