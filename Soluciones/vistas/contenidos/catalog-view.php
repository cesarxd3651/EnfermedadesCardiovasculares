<?php 
$cuentacodigo=$_SESSION['codigo_cuenta_sbm'];

?>
<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-airline-seat-recline-extra"></i> Bienvenido: <?php echo  $_SESSION['nombre_sbm'];?> <?php echo  $_SESSION['apellido_sbm']; ?> </h1>
			</div>
			<p class="lead">Apartado de paciente</p>
		</div>

		<div class="full-box text-center" style="padding: 30px 10px;">
            <?php 
                require "./controladores/pacienteControlador.php";
                $obj= new pacienteControlador();

                //conteo administrador
                $filas=$obj->contar_analisis($cuentacodigo);
             ?>
             <form action="<?php echo SERVERURL;?>analisislist">
			<article onclick="analisis();"  class="full-box tile">
				<input type="submit" value="j" name="">
				<div class="full-box tile-title text-center text-titles text-uppercase">
					Análisis Realizados
				</div> REALIZADOS
				<div class="full-box tile-icon text-center">
					<i class="zmdi zmdi-account"></i>
				</div>
				<div  class="full-box tile-number text-titles">
					<p  class="full-box"><?php echo $filas; ?></p>
					<small>Registrados</small>
				</div>
			</article>
			</form>
		</div>
				