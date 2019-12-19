<?php
if ($peticionAjax) {
		require_once "../modelos/vistaspruebaModelo.php";
	}else{
		require_once "./modelos/vistaspruebaModelo.php";
	}

	class vistapruebaControlador extends vistaspruebaModelo{

		public function agregar_empresa_controlador(){
			//utilizando funcion del mainmodel para evitar inyeccion sql
			//CAPTURAR LOS DATOS DEL FORMULARIO EN VARIABLES $
			$codigo=mainModel::limpiar_cadena($_POST['dni-reg']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
			$telefono=mainModel::limpiar_cadena($_POST['telefono-reg']);
			$email=mainModel::limpiar_cadena($_POST['email-reg']);
			$direccion=mainModel::limpiar_cadena($_POST['direccion-reg']);
			$director=mainModel::limpiar_cadena($_POST['director-reg']);
			$moneda=mainModel::limpiar_cadena($_POST['moneda-reg']);
			$year=mainModel::limpiar_cadena($_POST['year-reg']);

			
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT EmpresaCodigo FROM empresa WHERE EmpresaCodigo='$codigo'");
				//rowcount devuelve numero de fila afectadas por la consulta
				// if, si hay un dni identico al q queremos registrar, mandamos un error
				if ($consulta1->rowCount()<=1) {
					//comprobando si existe el nombre de la empresa en la bd
					$consulta2=mainModel::ejecutar_consulta_simple("SELECT EmpresaNombre FROM empresa WHERE EmpresaNombre='$nombre'");

					//comprobando si la consulta tiene un registro igual, si es menotr igual a 0 continuiamos, si no es error
					if ($consulta2->rowCount()<=0) {
						
						// si ya esta todo, colocamos un array de datos, para mandar al modelo. son "comas" en este tipo de arrays
						$datosEmpresa=[
									"Codigo"=>$codigo,
									"Nombre"=>$nombre,
									"Telefono"=>$telefono,
									"Email"=>$email,
									"Direccion"=>$direccion,
									"Director"=>$director,
									"Moneda"=>$moneda,
									"Year"=>$year
								];
								// luego del array se guarda los datos en el modelo

								$guardarEmpresa=vistaspruebaModelo::agregar_empresa_modelo($datosEmpresa);

								// comprobamos si se ha insertado,cuantos registros han sido afectado.
							if ($guardarEmpresa->rowCount()==1) {
								
								$alerta=[
									"Alerta"=>"limpiar",
									"Titulo"=>"BIEN BB",
									"Texto"=>"EMPRESA REGISTRADA MANO",
									"Tipo"=>"success"
										];

							}else{
								// si no mandamos error, no inserto
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Algo salió mal",
									"Texto"=>"no se pudo registrar la empresa uu",
									"Tipo"=>"error"
									];
							}

					}else{

						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Algo salió mal",
							"Texto"=>"El nombre de empresa ya está registrado",
							"Tipo"=>"error"
						];

					}

				}else{

					$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Algo salió mal",
							"Texto"=>"El codigo de empresa ya está registrado",
							"Tipo"=>"error"
						];

				}
			// verificar contraseñas coinciden con swett alert de mainmodel
			
			return mainModel::sweet_alert($alerta);
		}
		public function  paginador_empresa_controlador($pagina,$registros,$privilegio,$codigo,$busqueda){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$codigo=mainModel::limpiar_cadena($codigo);
			$busqueda=mainModel::limpiar_cadena($busqueda);

			$tabla="";
			$pagina=(isset($pagina) && $pagina>0) ? (int)$pagina:1 ;
        	//inicio-> desde donde va empezar a contar los registros en la bd
        	$inicio=($pagina>0) ? (($pagina*$registros)-$registros): 0;

        	if (isset($busqueda) && $busqueda!="") {
        		$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM empresa WHERE ((EmpresaCodigo!='$codigo') AND (EmpresaNombre LIKE '%$busqueda%' OR EmpresaTelefono LIKE '%$busqueda%'))  ORDER BY EmpresaNombre ASC LIMIT $inicio, $registros 
        		";
        		$paginaurl="companysearch";
        	}else{
        		$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM empresa WHERE EmpresaCodigo!='$codigo' ORDER BY EmpresaNombre ASC LIMIT $inicio, $registros 
        		";
        		$paginaurl="companylist";

        	}

        	$conexion=mainModel::conectar();

        	//SQL_CALC_FOUND_ROWS, permite calcular cuantos registros hay en una tabla
        	$datos =$conexion->query($consulta);
        	//array de datos de la consulta
        	$datos=$datos->fetchAll();
        	//calcular total de los registros
        	$total=$conexion->query("SELECT FOUND_ROWS()");
        	$total=(int) $total->fetchColumn();
        	//calcular total de paginas del paginador
        	$Npaginas=ceil($total/$registros);

        	$tabla.='
        				<div class="table-responsive">
						<table class="table table-hover text-center">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Nombre</th>
									<th class="text-center">Telefono</th>
									<th class="text-center">Email</th>
									<th class="text-center">Direccion</th>
									<th class="text-center">Director</th>
									<th class="text-center">Moneda</th>
									<th class="text-center">Año</th>';
									if ($privilegio<=2) {
										$tabla.='
												<th class="text-center">A. Datos</th>
												<th class="text-center">A. Cuenta</th>';
									}
									if ( $privilegio==1) {
										$tabla.='
												<th class="text-center">ELIMINAR</th> 
												';
									}
					$tabla.='</tr>
								</thead>
								<tbody>
					';

					//aqui codigo para mostrar los datos de la bd
					if ($total>=1 && $pagina<=$Npaginas) {
						$contador=$inicio+1;

						foreach ($datos as $rows) {
							$tabla.='
								<tr>
									<td>'.$contador.'</td>
									<td>'.$rows['EmpresaNombre'].'</td>
									<td>'.$rows['EmpresaTelefono'].'</td>
									<td>'.$rows['EmpresaEmail'].'</td>
									<td>'.$rows['EmpresaDireccion'].'</td>
									<td>'.$rows['EmpresaDirector'].'</td>
									<td>'.$rows['EmpresaMoneda'].'</td>
									<td>'.$rows['EmpresaYear'].'</td>';

									if ($privilegio<=2) {
										$tabla.='<td>
											<a href="'.SERVERURL.'myaccount/admin/'.mainModel::encryption($rows['EmpresaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
											<i class="zmdi zmdi-refresh"></i>
												</a>
											</td>
										<td>
											<a href="'.SERVERURL.'mydata/admin/'.mainModel::encryption($rows['EmpresaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
											<i class="zmdi zmdi-refresh"></i>
											</a>
										</td>
										';
									
									}
								if ($privilegio==1	) {
										$tabla.='
												<td>
													<form action="'.SERVERURL.'ajax/administradorAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
														<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['EmpresaCodigo']).'" >
														<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'" >
														<button type="submit" class="btn btn-danger btn-raised btn-xs">
														<i class="zmdi zmdi-delete"></i>
														</button>
														<div class="RespuestaAjax" ></div>
													</form>
												</td>
										';
									}
					$tabla.='
							</tr>
						';
						$contador++;
						}
					}else{
						if ($total>=1) {
							$tabla.='
							<tr>
								<td colspan="10">
									<a href="'.SERVERURL.$paginaurl.'/" class="btn btn-sm btn-info btn-raised ">
										Haga click aquí para recargar listado
									</a>
								</td>
							</tr>
						';
						}else{
							$tabla.='
							<tr>
								<td colspan="10">NO HAY REGISTROS BBCITO EN EL SISTEMA </td>
							</tr>
						';
						}
						
					}

					$tabla.='</tbody> </table> </div>';
					// para q no aparezca los numeros de paginador
					if ($total>=1 && $pagina<=$Npaginas){
					$tabla.='
						<nav class="text-center">
						<ul class="pagination pagination-sm">';

				if ($pagina==1) {
				$tabla.='
						<li class="disabled"><a><i class="zmdi zmdi-arrow-left"></i></a></li>
				';
				}else{
						$tabla.='
						<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina-1).'/" ><i class="zmdi zmdi-arrow-left"></i></a></li>
				';	
				}

				for ($i=1; $i <=$Npaginas ; $i++) { 
					if ($pagina==$contador) {
						$tabla.='
						<li class="active"><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>
				';
					}else{
						$tabla.='
						<li><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>
				';
					}
				}
				if ($pagina==$Npaginas) {
				$tabla.='
						<li class="disabled"><a><i class="zmdi zmdi-arrow-right"></i></a></li>
				';
				}else{
						$tabla.='
						<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina+1).'/" ><i class="zmdi zmdi-arrow-right"></i></a></li>
				';	
				}
				$tabla.='
						</ul>
						</nav>
				';
			}
        	return $tabla;
		
	}
}