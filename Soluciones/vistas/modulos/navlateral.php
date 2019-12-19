 	<section class="full-box cover dashboard-sideBar">
		<div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
		<div class="full-box dashboard-sideBar-ct">
			<!--SideBar Title -->
			<div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
				Clínica Baca & Mariños <i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
			</div>
			<!-- SideBar User info -->
			<div class="full-box dashboard-sideBar-UserInfo">
				<figure class="full-box">
					<img src="<?php echo SERVERURL; ?>vistas/assets/avatars/<?php echo $_SESSION['foto_sbm'];?>" alt="UserIcon">
					<figcaption class="text-center text-titles"><?php echo $_SESSION['nombre_completo_sbm']=$_SESSION['nombre_sbm']." ".$_SESSION['apellido_sbm']; ?></figcaption>
				</figure>

				<?php 
				if ($_SESSION['tipo_sbm']=="Administrador") {
					$tipo="admin";
				}else {
					$tipo="user";
				}
				?>
				
				<ul class="full-box list-unstyled text-center">
					<li>
						<a href="<?php echo SERVERURL;?>mydata/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_sbm']); ?>/" title="Mis datos">
							<i class="zmdi zmdi-account-circle"></i>
						</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL;?>myaccount/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_sbm']); ?>/" title="Mi cuenta">
							<i class="zmdi zmdi-settings"></i>
						</a>
					</li>
					<li>
						<a href="<?php echo $lc->encryption($_SESSION['token_sbm']); ?>" title="Salir del sistema" class="btn-exit-system">
							<i class="zmdi zmdi-power"></i>
						</a>
					</li>
				</ul>
			</div>
			<!-- SideBar Menu -->
			<ul class="list-unstyled full-box dashboard-sideBar-Menu">
				<!-- ocultando si es cliente o usuario, el navlateral-->
				<?php if($_SESSION['tipo_sbm']=="Administrador"): ?>
				<li>
					<a href="<?php echo SERVERURL;?>home/">
						<i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Dashboard
					</a>
				</li>
				<?php if ( $_SESSION['privilegio_sbm']== 1 ): ?>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-case zmdi-hc-fw"></i> Administración <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="<?php echo SERVERURL;?>companylist/"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Empresa</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL;?>paciente/"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Nuevo Paciente</a>
						</li>
					</ul>
				</li> 

				<?php endif; ?>

				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Usuarios <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="<?php echo SERVERURL;?>adminlist/"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Administradores</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL;?>pacientelist/"><i class="zmdi zmdi-male-female zmdi-hc-fw"></i> Pacientes</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-accounts-list-alt"></i> Compromiso <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="<?php echo SERVERURL;?>citalist/"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Citas</a>
						</li>
					</ul>
				</li>
				<?php endif; ?>

				<?php if($_SESSION['tipo_sbm']!="Administrador"): ?>
				

				<li>
					<a href="<?php echo SERVERURL;?>catalog/">
						<i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Dashboard
					</a>
				</li>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-case zmdi-hc-fw"></i> Servicios <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
				<ul class="list-unstyled full-box">
					<a>
				<form action="<?php echo SERVERURL;?>analisislist" method="POST">
					
					<input type="hidden" value="<?php echo $_SESSION['codigo_cuenta_sbm']; ?>" name="cod">
					<input class="btn btn-primary" type="submit" value="Análisis Realizados ">
				</form>
				</a> 
				</ul>
				<?php endif; ?>
			</ul>
		</div>
	</section>