<?php
// si es peticiion ajax itenemos q regrsar una carpeta atras
// else simplemente incluimos el archivo en la carpeta
if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}
	// hereda mainModel por la clase conexion
	class citaModelo extends mainModel{
		protected function agregar_cita_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO cita(CitaCodigo,CodigoPaciente,CodigoDoctor,FechaInicioCita,FechaFinCita,AsuntoCita,EstadoCita,LugarCita) VALUES (:citcod,:codpac,:coddoc,:fechini,:fechfin,:asuncita,:estado,:lugcita)");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":citcod",$datos['citcod']);
			$sql->bindParam(":codpac",$datos['codpac']);
			$sql->bindParam(":coddoc",$datos['coddoc']);
			$sql->bindParam(":fechini",$datos['fechini']);
			$sql->bindParam(":fechfin",$datos['fechfin']);
			$sql->bindParam(":asuncita",$datos['asuncita']);
			$sql->bindParam(":estado",$datos['estado']);
			$sql->bindParam(":lugcita",$datos['lugcita']);
			$sql->execute();
			return $sql;
		}
		protected function eliminar_cita_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM cita WHERE CitaCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function datos_cita_modelo($codigo){
			//if ($tipo=="Unico") {
				//$query=mainModel::conectar()->prepare("SELECT * from cita WHERE CitaCodigo=:Codigo");
				//$query->bindParam(":Codigo",$codigo);
				
				
				//}elseif($tipo=="Conteo"){
				//$query=mainModel::conectar()->prepare("SELECT id FROM cita ") ;

				//}
			//$query->execute();
			//return $query;
			$query=mainModel::conectar()->prepare("SELECT ci.CitaCodigo,cl.CuentaCodigo as codpaciente,cl.ClienteNombre,cl.ClienteApellido,ad.CuentaCodigo as coddoctor,ad.AdminNombre,ad.AdminApellido,FechaInicioCita,FechaFinCita,AsuntoCita,LugarCita from cita ci INNER JOIN cliente cl on ci.CodigoPaciente=cl.CuentaCodigo INNER JOIN admin ad on ci.CodigoDoctor=ad.CuentaCodigo WHERE ci.CitaCodigo=:Codigo ");
			$query->bindParam(":Codigo",$codigo);
			//$query->bindParam(":Tipo",$tipo);
			$query->execute();
			return $query;
		}

		protected function actualizar_administrador_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE  cita SET CodigoPaciente=:codpac,CodigoDoctor=:coddoc,FechaInicioCita=:fechini,FechaFinCita=:fechfin
				,AsuntoCita=:asuncita,EstadoCita=:estado,LugarCita=:lugcita WHERE id=:idcita");
			$sql->bindParam(":codpac",$datos['codpac']);
			$sql->bindParam(":coddoc",$datos['coddoc']);
			$sql->bindParam(":fechini",$datos['fechini']);
			$sql->bindParam(":fechfin",$datos['fechfin']);
			$sql->bindParam(":asuncita",$datos['asuncita']);
			$sql->bindParam(":estado",$datos['estado']);
			$sql->bindParam(":lugcita",$datos['lugcita']);
			$sql->execute();
			return $query;
		}

	}