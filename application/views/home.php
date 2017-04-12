<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bodega</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?= base_url()?>plantilla/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url()?>plantilla/assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?= base_url()?>plantilla/assets/css/form-elements.css">
        <link rel="stylesheet" href="<?= base_url()?>plantilla/assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?= base_url()?>plantilla/assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url()?>plantilla/assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url()?>plantilla/assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url()?>plantilla/assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?= base_url()?>plantilla/assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><span>Bodega Hospital Chimbarongo</span></h1>
                            <div class="description">
                            	<p><span><strong>Este es un programa de bodega diseñado para el uso exclusivo del </strong><a href="http://azmind.com"> Hospital Chimbarongo</a>
                            	</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3><strong>Ingreso al sistema</strong></h3>
                            		<p><strong>Ingrese su usuario y contraseña</strong></p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Usuario</label>
			                        	<input type="text" id ="username" name="username" placeholder="Usuario..." class="form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Clave</label>
			                        	<input type="password" id ="password" name="password" placeholder="Clave..." class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" class="btn">Ingresar</button>
                                    
			                    </form>
                                <h1><?if (empty(= $errores)) { echo'' ;}else{echo = $errores;} ?></h1>
		                    </div>
                        </div>
                    </div>
                 
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="<?= base_url()?>plantilla/assets/js/jquery-1.11.1.min.js"></script>
        <script src="<?= base_url()?>plantilla/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?= base_url()?>plantilla/assets/js/jquery.backstretch.min.js"></script>
        <script src="<?= base_url()?>plantilla/assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>