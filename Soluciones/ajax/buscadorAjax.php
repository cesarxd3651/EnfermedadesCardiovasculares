<?php 
	session_start(['name'=>'SBM']);
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	//isset es para ver si viene definido
	if (isset($_POST)) {
	
		// modulo de administradores
		if (isset($_POST['busqueda_inicial_admin'])) {
				$_SESSION['busqueda_admin']=$_POST['busqueda_inicial_admin'];
			}
			if (isset($_POST['eliminar_busqueda_admin'])) {
				unset($_SESSION['busqueda_admin']);
				$url="adminsearch";
			}

		//Modulo de Pacientes
		if (isset($_POST['busqueda_inicial_paciente'])) {
			//la variable session va tener lo q enviamos del input del formulario busqueda
			$_SESSION['busqueda_paciente']=$_POST['busqueda_inicial_paciente'];
		}
		if (isset($_POST['eliminar_busqueda_paciente'])) {
			# code...
			unset($_SESSION['busqueda_paciente']);
			$url="pacientesearch";
		}
		if (isset($url)) {
			# code...
			echo '<script> location.reload(); </script>';
		}else{
			echo '<script> location.reload(); </script>';
		}
		
	}else{	
		session_destroy();

		echo '<script> window.location.href="'.SERVERURL.'/" </script>';
	}