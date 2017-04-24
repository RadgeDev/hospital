<div id="page-wrapper">
 <div class="container-fluid">
 <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          Proveedores
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Inicio</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Proveedor
                            </li>
                        </ol>
                    </div>
                </div>
   <div class="row">
      <div class="col-md-2">
        <a href="#" class='btn btn-success' data-toggle='modal' data-target='#myModalproveedor'>Agregar Proveedor</a>

      </div>
   
          <div class="col-md-3 col-md-offset-4">
    <select name="buscando" id ="buscando" class="form-control" >
        <option value="rut_proveedor">Rut</option>
        <option value="nombre_proveedor">Nombre</option>
        <option value="razon_social">Razon Social</option>
        <option value="direccion">Direccion</option>
        <option value="telefono">Telefono</option>
        <option value="correo">Correo</option>

        </select>

      </div>
      <div class="col-md-3 ">
        <div class="form-group has-feedback has-feedback-left">

            <input type="text" class="form-control" name="busqueda" placeholder="Buscar algo" />
            <i class="glyphicon glyphicon-search form-control-feedback"></i>
        </div>
        
      </div>
      
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h4>Lista de Proveedor</h4>
          </div>
          <div id="tbproveedor" class="panel-body">
            
            <p>
              <strong>Mostrar por : </strong>
              <select name="cantidad" id="cantidad">
                <option value="10">10</option>
                <option value="20">20</option>
              </select>
            </p>
            <table id="tbclientes" name="tbclientes" class="table table-bordered-responsive ">
              <thead>
                <tr>
                  <th>Rut</th>
                  <th>Nombres</th>
                  <th>Razon Social</th>
                  <th>Direccion</th>
                  <th>Telefono</th>
                  <th>Correo</th>
                  <th>Accion</th>
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
                            
                        
                <!--
                    <button type="button" class="btn btn-lg  btn-primary">Nuevo</button>
                    <button type="button" class="btn btn-lg  btn-success">Guardar</button>
                    <button type="button" class="btn btn-lg  btn-info">Modificar</button>
                    <button type="button" class="btn btn-lg  btn-danger">Eliminar</button>
                   -->
                          <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" id="cerrando" name="cerrando" class="btn btn-lg  btn-danger"
                        data-dismiss="modal">
                            Cerrar
                </button>
                <button type="submit" id="cerrarmodal" name="cerrarmodal" class="btn btn-lg  btn-success" >
                    Guardar
                </button>
            </div>
                        </form>

                
            </div>
            
        </div>
    </div>
</div>



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
                  Editar usuario
                </h4>
            </div>
             <div class="alert alert-danger" id="msg-error2" style="text-align:left;">
                  <strong>¡Importante!</strong> Corregir los siguientes errores.
                  <div class="list-errors"></div>
              </div>
            <!-- Modal Body -->
            <div class="modal-body" >
                
                      <form  id="usuarioEditar" role="form" action= "<?= base_url()?>man_usuarios/actualizar" method="POST" >
                         <br>
                         <br>
                            <div class="form-group">
                               <label>Rut</label>
                                <input class="form-control" id="selecrut" name="selecrut" placeholder="Ingrese Rut  Ejemplo 11111111-1" readonly  >
                            </div>

                            <div class="form-group">
                                <label>Nombre</label>
                                <input class="form-control" id="selecnombre" name="selecnombre"  placeholder="Ingrese Nombre" onkeypress="return soloLetras(event)">
                            </div>

                            <div class="form-group">
                                <label>Razon Social</label>
                             <input class="form-control" id="selecrazon" name="selecrazon"  placeholder="Ingrese su razon social">
                            </div>

                             <div class="form-group">
                                <label>Direccion</label>
                             <input  class="form-control" id="selecdireccion" name="selecdireccion"  placeholder="Ingrese su direccion" ">
                            </div>

                            <div class="form-group">
                            <label>Telefono</label>
                             <input class="form-control" id="selectelefono" name="selectelefono"  placeholder="Ingrese su telefono">
                            </div>

                            <div class="form-group">
                            <label>Correo</label>
                             <input class="form-control" id="seleccorreo" name="seleccorreo"  placeholder="Ingrese su correo">
                            </div>
                           
            <div class="modal-footer">
                <button type="button" class="btn btn-lg  btn-danger"
                        data-dismiss="modal">
                            Cerrar
                </button>
                <button type="submit" id="cerrarmodal2" name="cerrarmodal2" class="btn btn-lg  btn-success" >
                    Actualizar
















































                </button>
            </div>
                        </form>

                
            </div>
            
        </div>
    </div>
</div>