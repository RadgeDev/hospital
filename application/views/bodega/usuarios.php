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
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Inicio</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Usuarios
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

               <!--   <div class="row">
                    <div class="col-lg-4">

                        <form role="form">
                         <br>
                         <br>
                            <div class="form-group">
                               <label>Rut</label>
                                <input class="form-control" placeholder="Ingrese Rut  Ejemplo 11111111-1">
                            </div>

                            <div class="form-group">
                                <label>Nombre</label>
                                <input class="form-control" placeholder="Ingrese Nombre">
                            </div>

                            <div class="form-group">
                                <label>Login</label>
                             <input class="form-control" placeholder="Ingrese su usuario">
                            </div>

                             <div class="form-group">
                                <label>Clave</label>
                             <input class="form-control" placeholder="Ingrese su Clave">
                            </div>
                            
                             <div class="form-group">
                                <label>Tipo de Usuario</label>
                                <select class="form-control">
                                    <option>Administrador</option>
                                    <option>Bodeguero</option>
                                    <option>Invitado</option>
                                </select>
                            </div>
                
                    <button type="button" class="btn btn-lg  btn-primary">Nuevo</button>
                    <button type="button" class="btn btn-lg  btn-success">Guardar</button>
                    <button type="button" class="btn btn-lg  btn-info">Modificar</button>
                    <button type="button" class="btn btn-lg  btn-danger">Eliminar</button>
                   

                        </form>

                    </div>-->
                    <div class="col-lg-12">
                
                        <h2>Datos de los usuarios</h2>
                <div class="form-group">
                     <div class=" col-sm-3">
                
                                <select class="form-control">
                                    <option>Rut</option>
                                    <option>Nombre</option>
                                    <option>Login</option>
                                    <option>Password</option>
                                    <option>Tipo_usuario</option>
                                </select>
                            </div>
                 <input  class="form-control input-sm col-sm-3" id="buscar" style="width: 400px" placeholder="Ingrese datos para buscar">   
                   <div class="col-sm-2"> <button type="button" class="btn btn-success">Buscar</button> </div>
                
                     </div>
                    <br>
                    <br>
                    <br>
                        <div id ="tablausuarios" class="table-responsive">
                         <!--     <table  class="table table-bordered table-hover table-striped">

                              <thead>
                                    <tr>
                                   
                                        <th>Rut</th>
                                        <th>Nombre</th>
                                        <th>Login</th>
                                        <th>Clave</th>
                                        <th>Tipo de usuario</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 //<?php foreach ($consulta->result() as $fila) {
                                        # code...
                                     ?>
                                    <tr>
                                        <td><?= $fila->rut ?></td>
                                        <td><?= $fila->nombre ?></td>
                                        <td><?= $fila->login ?></td>
                                        <td><?= $fila->password ?></td>
                                        <td><?= $fila->tipo_usuario ?></td>
                                    </tr>
                                 
                                   <?php } ?>
                                </tbody>
                            </table> -->
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
 
   