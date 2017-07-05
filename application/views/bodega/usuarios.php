 <div id="page-wrapper">
 <div class="container-fluid">

              <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          Usuarios
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?= base_url('welcome') ?>">Inicio</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Usuarios
                            </li>
                        </ol>
                    </div>
              
        
             
                
                        <h2>Datos de los usuarios</h2>
          
                     <div class=" col-lg-3 col-sm-3">
                
                                <select name="buscando" id ="buscando" class="form-control">
                                    <option value="rut">Rut</option>
                                    <optiocol-lg-12 col-sm-12n value="nombre">Nombre</option>
                                    <option value="login">Login</option>
                                    <option value="tipo_usuario">Tipo Usuario</option>
                                </select>
                    
                            </div>
                            <div class=" col-lg-3 col-sm-3">   <input  class="form-control" id="buscar" style="width: 400px" placeholder="Ingrese datos para buscar">   </div>
              
                   <div class="col-lg-4 col-sm-4"> <button type="button" class="btn btn-search btn-info">
                            <span class="glyphicon glyphicon-search"></span>
                            <span class="label-icon">Buscar</span>
                        </button>   <button type="button" id="btnbuscar"  class="btn btn-primary">Mostrar Todos</button>    <button type="button" href='#' class='btn btn-success' data-toggle='modal' data-target='#myModalHorizontal'>Agregar Nuevo Usuario</button>  </div>
             
                     </div>
                    <br>
                    <br>
                    <br>
                        <div id ="tablausuarios" class="table-responsive">
                         <!-- se cargan los datos js  de la tabla-->
                        </div>
                    </div>
        

                </div>
                <!-- /.row -->
                <div style="height: 300px;"></div>
            </div>
            <!-- /.container-fluid -->
     </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
 
   <!-- modal empieza aca -->
   <!-- Modal -->
<div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" 
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
                  Ingresar usuario
                </h4>
            </div>
            <div class="alert alert-danger" id="msg-error" style="text-align:left;">
                  <strong>¡Importante!</strong> Corregir los siguientes errores.
                  <div class="list-errors"></div>
              </div>
            <!-- Modal Body -->
            <div class="modal-body" >
                
                      <form  id="usuarioGuardar" role="form" action= "http://localhost/hospital/man_usuarios/guardar" method="POST" >
                         <br>
                         <br>
                            <div class="form-group">
                               <label>Rut</label>
                                <input class="form-control" id="rut" name="rut" placeholder="Ingrese Rut  Ejemplo 11111111-1" onfocusout="validarRut() " maxlength="10" onkeypress="return solorut(event)">
                                  <p class="text-errors" id="msgerrorut"></p>
                            </div>

                            <div class="form-group">
                                <label>Nombre</label>
                                <input class="form-control" id="nombre" name="nombre"  placeholder="Ingrese Nombre" onkeypress="return soloLetras(event)">
                            </div>

                            <div class="form-group">
                                <label>Login</label>
                             <input class="form-control" id="login" name="login"  placeholder="Ingrese su usuario">
                            </div>

                             <div class="form-group">
                                <label>Clave</label>
                             <input class="form-control" id="clave" name="clave"  placeholder="Ingrese su Clave">

                            </div>
                            
                             <div  class="form-group">
                                <label>Tipo de Usuario</label>
                                <select name="cargo" class="form-control">
                                    <option>Seleccione una opcion</option>
                                    <option>Administrador</option>
                                    <option>Bodeguero</option>
                                    <option>Invitado</option>
                                </select>
                            </div>
                            <input type="hidden" class="form-control" id="seleccion" name="seleccion"  placeholder="Ingrese su Clave">
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
                
                      <form  id="usuarioEditar" role="form" action= "http://localhost/hospital/man_usuarios/actualizar" method="POST" >
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
                                <label>Login</label>
                             <input class="form-control" id="seleclogin" name="seleclogin"  placeholder="Ingrese su usuario">
                            </div>

                             <div class="form-group">
                                <label>Clave</label>
                             <input type="text" class="form-control" id="seleclave" name="selecclave"  placeholder="Ingrese su Clave" ">
                         
                            </div>
                            
                             <div  class="form-group">
                                <label>Tipo de Usuario</label>
                                <select name="cargo" id="cargo" class="form-control">
                                    <option>Administrador</option>
                                    <option>Bodeguero</option>
                                    <option>Invitado</option>
                                </select>
                            </div>
                            <input type="hidden"   class="form-control" id="seleccion2" name="seleccion2"  placeholder="Ingrese su cargo">
                <!-- 
                    <button type="button" class="btn btn-lg  btn-primary">Nuevo</button>
                    <button type="button" class="btn btn-lg  btn-success">Guardar</button>
                    <button type="button" class="btn btn-lg  btn-info">Modificar</button>
                    <button type="button" class="btn btn-lg  btn-danger">Eliminar</button>
                   -->
                          <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-lg  btn-danger"
                        data-dismiss="modal">
                            Cerrar
                </button>
                <button type="submit" id="cerrarmodal2" name="cerrarmodal2" class="btn btn-lg  btn-success" >
                    Guardar
                </button>
            </div>
                        </form>

                
            </div>
            
        </div>
    </div>
</div>