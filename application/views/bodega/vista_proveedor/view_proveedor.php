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
      <div class="col-md-6">
        <a href="#" class="btn btn-success">Agregar Proveedor</a>
      </div>
      <div class="col-md-4">
        <?php echo form_open('control_proveedor/busqueda'); ?>
          <div class="input-group">
            <?php if ($this->session->userdata("busqueda")) {
               echo form_input(["type" => "text", "name" => "busqueda", "class" => "form-control", "placeholder" => "Ingrese su busqueda", "value" => $this->session->userdata("busqueda")]);
            }else{
              echo form_input(["type" => "text", "name" => "busqueda", "class" => "form-control", "placeholder" => "Ingrese su busqueda"]); 
            } ?>
            
                <span class="input-group-btn">
                  <?php echo form_button(["type" => "submit", "class" => "btn btn-warning", "content"=>"<span class='glyphicon glyphicon-search'></span>"]);?>                  
                </span>
            </div>
        <?php echo form_close(); ?>
      </div>
      <div class="col-md-2">
        <?php echo form_open('control_proveedor/mostrar');?>
          <?php echo form_submit("", "Mostrar Todo", "class= 'btn btn-danger btn-block'");?>
        <?php echo form_close(); ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h4>Lista de Proveedores</h4>
          </div>
          <div class="panel-body">
            <?php
              $options = array(
                        '5'  => '5',
                        '10'    => '10'
                      );

              $selected = "5";
              if ($this->session->userdata("cantidad")) {
                $selected = $this->session->userdata("cantidad");
              }
            ?>
            <p><strong>Mostrar por : </strong><?php  echo form_dropdown('cantidad', $options,$selected)?></p>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Rut</th>
                  <th>Nombres</th>
                  <th>Razon Social</th>
                  <th>Direccion</th>
                  <th>Celular</th>
                  <th>Email</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php foreach ($proveedor as $usuario) { ?>
                  <tr>
                    <td><?php echo $usuario->rut_proveedor;?></td>
                    <td><?php echo $usuario->nombre_proveedor;?></td>
                    <td><?php echo $usuario->razon_social;?></td>
                    <td><?php echo $usuario->direccion;?></td>
                    <td><?php echo $usuario->telefono;?></td>
                    <td><?php echo $usuario->correo;?></td>
                  
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <div   class="text-center">
              <?php echo $this->pagination->create_links(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 </div>
  </div>