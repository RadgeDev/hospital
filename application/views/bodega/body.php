  <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12 ">
                        <h1 class="page-header"> Bodega<small> Hospital Chimbarongo</small>
                        </h1>
                        <ol class="breadcrumb alert alert-success alert-dismissable">
                            <li class="active">
                                <i class="fa fa-dashboard "></i> Inicio
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                          <!--   <div class="alert alert-info alert-dismissable">
                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong>Like SB Admin?</strong> Try out <a href="http://startbootstrap.com/template-overviews/sb-admin-2" class="alert-link">SB Admin 2</a> for additional features! 
                        </div>-->
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">26</div>
                                        <div>Total Egresos!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver Detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $stockmaximo; ?></div>
                                        <div>Stock Maximo!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= base_url('control_stock') ?>">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver Detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"> <?php echo $totalcompra; ?></div>
                                        <div>Total de Ingresos!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= base_url('control_historial_ingreso') ?>">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver Detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                        <?php echo $totalregistros; ?></div>
                                        <div>Stock Critico!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= base_url('control_stock') ?>">
                                <div class="panel-footer">
                                        <span class="pull-left">Ver Detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

              
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Ultimas Transacciones Ingreso</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="tbclientes" name="tbclientes"  class="table table-bordered table-hover table-striped">
                                     <thead>
                                   <tr class="success">
                                  <th>Codigo Compra </th>
                                  <th>Compra</th>
                                  <th>Fecha</th>
                                  <th>Total</th>
                                  </tr>
              </thead>
              <tbody>
              </tbody>
                                    </table>
                                </div>
                                <div class="text-right">
                                    <a href="<?= base_url('control_historial_ingreso') ?>">Ver Transacciones <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
            
                <!-- /.row -->
         <!-- /.row -->

              
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Ultimas Transacciones Pedidos</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="tbpedidos" name="tbpedidos"  class="table table-bordered table-hover table-striped">
                                     <thead>
                                   <tr class="success">
                                  <th>Codigo  </th>
                                  <th>Depto/Serv</th>
                                  <th>Nombre</th>
                                  <th>Fecha</th>
                                  </tr>
              </thead>
              <tbody>
              </tbody>
                                    </table>
                                </div>
                                <div class="text-right">
                                    <a href="<?= base_url('control_historial_pedido') ?>">Ver Transacciones <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Ultimas Transacciones Egresos</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="tbsalidas" name="tbsalidas"  class="table table-bordered table-hover table-striped">
                                     <thead>
                                   <tr class="success">
                                  <th>Codigo Salida </th>
                                  <th>Salida</th>
                                  <th>Fecha</th>
                                  <th>Depto/serv</th>
                                  </tr>
              </thead>
              <tbody>
              </tbody>
                                    </table>
                                </div>
                                <div class="text-right">
                                    <a href="<?= base_url('control_historial_egreso') ?>">Ver Transacciones <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->