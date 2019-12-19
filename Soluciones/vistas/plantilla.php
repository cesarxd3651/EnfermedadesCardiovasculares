 <!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/css/main.css">
	<?php  include 	"./vistas/modulos/script.php"; ?>
</head>
<body> 

	<?php 
		$peticionAjax=false;
		require_once "./controladores/vistasControlador.php";
		$vt = new vistasControlador();
		$vistasrpt=$vt->obtener_vistas_controlador();
		
		if ($vistasrpt=="login" || $vistasrpt=="404"): 
			if ($vistasrpt=="login") {
				require_once "./vistas/contenidos/login-view.php";
			}else{
				require_once "./vistas/contenidos/404-view.php";
			}
		 	
		 else:
		 	session_start(['name'=>'SBM']);
		 	require_once "./controladores/loginControlador.php";

		 	//instanciando logincontrolador
		 	$lc =  new loginControlador();
		 	//para comprobar si se han logeado
		 	if (!isset($_SESSION['token_sbm']) || !isset($_SESSION['usuario_sbm'])) {
		 		# si ningun ode los viene definido, es decir, el usuario no ha inicido sesion bien, y cerramos laq sesion.
		 		echo $lc->forzar_cierre_sesion_controlador();  
		 	}
	?>
	<?php  include 	"vistas/modulos/navlateral.php"; ?>

	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->
	<?php  include 	"vistas/modulos/navbar.php"; ?>
		<!-- Content page -->
		<?php require_once $vistasrpt; ?>
	</section>	
	<?php  
	include 	"./vistas/modulos/logoutScript.php"; 
	endif; 
	?>
	<!--====== Scripts -->
	<script>
		$.material.init();
	</script>
</body>
</html>