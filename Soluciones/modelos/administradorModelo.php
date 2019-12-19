<?php
// si es peticiion ajax itenemos q regrsar una carpeta atras
// else simplemente incluimos el archivo en la carpeta
if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}
	// hereda mainModel por la clase conexion
	class administradorModelo extends mainModel{
		protected function agregar_administrador_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO admin(AdminDNI,AdminNombre,AdminApellido,AdminTelefono,AdminDireccion,CuentaCodigo) VALUES (:dni,:nom,:ape,:tel,:direccion,:codigo)");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":dni",$datos['dni']);
			$sql->bindParam(":nom",$datos['nom']);
			$sql->bindParam(":ape",$datos['ape']);
			$sql->bindParam(":tel",$datos['tel']);
			$sql->bindParam(":direccion",$datos['direccion']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->execute();
			return $sql;
		}
		protected function eliminar_administrador_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM admin WHERE CuentaCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function datos_administrador_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM admin WHERE CuentaCodigo=:Codigo");
				$query->bindParam(":Codigo",$codigo);
				
				
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT id FROM admin WHERE id!='1'");
			}
			$query->execute();
			return $query;
		}

		protected function actualizar_administrador_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE  admin SET AdminDNI=:DNI,AdminNombre=:Nombre,AdminApellido=:Apellido,AdminTelefono=:Telefono,AdminDireccion=:Direccion WHERE CuentaCodigo=:Codigo");
			$query->bindParam(":DNI",$datos['DNI']);
			$query->bindParam(":Nombre",$datos['Nombre']);
			$query->bindParam(":Apellido",$datos['Apellido']);
			$query->bindParam(":Telefono",$datos['Telefono']);
			$query->bindParam(":Direccion",$datos['Direccion']);
			$query->bindParam(":Codigo",$datos['Codigo']);
			$query->execute();
			return $query;
		}

	}