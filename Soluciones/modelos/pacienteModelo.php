<?php
// si es peticiion ajax itenemos q regrsar una carpeta atras
// else simplemente incluimos el archivo en la carpeta
if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class pacienteModelo extends mainModel{

		protected function agregar_paciente_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO cliente (ClienteDNI,ClienteNombre,ClienteApellido,ClienteTelefono,ClienteOcupacion,ClienteDireccion,CuentaCodigo) VALUES(:DNI,:Nombre,:Apellido,:Telefono,:Ocupacion,:Direccion,:Codigo)  ");

			$sql->bindParam(":DNI",$datos['DNI']);
			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Apellido",$datos['Apellido']);
			$sql->bindParam(":Telefono",$datos['Telefono']);
			$sql->bindParam(":Ocupacion",$datos['Ocupacion']);
			$sql->bindParam(":Direccion",$datos['Direccion']);
			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->execute();
			return $sql;
		}

		protected function datos_paciente_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM cliente WHERE CuentaCodigo=:Codigo");
				$query->bindParam(":Codigo",$codigo);
				
				
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT id FROM cliente ");
			}
			$query->execute();
			return $query;
		}
		protected function eliminar_paciente_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM cliente WHERE CuentaCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function actualizar_paciente_modelo($datos){
		$query=self::conectar()->prepare("UPDATE cliente SET ClienteDNI=:DNI, ClienteNombre=:Nombre, ClienteApellido=:Apellido, ClienteTelefono=:Telefono, ClienteOcupacion=:Ocupacion, ClienteDireccion
		=:Direccion WHERE CuentaCodigo=:Codigo ");
			
			$query->bindParam(":DNI",$datos['ClienteDNI']);
			$query->bindParam(":Nombre",$datos['ClienteNombre']);		
			$query->bindParam(":Apellido",$datos['ClienteApellido']);
			$query->bindParam(":Telefono",$datos['ClienteTelefono']);
			$query->bindParam(":Ocupacion",$datos['ClienteOcupacion']);
			$query->bindParam(":Direccion",$datos['ClienteDireccion']);
			$query->bindParam(":Codigo",$datos['ClienteCodigo']);
			$query->execute();
			return $query;
		}

	}