<?php
// si es peticiion ajax itenemos q regrsar una carpeta atras
// else simplemente incluimos el archivo en la carpeta
if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class vistaspruebaModelo extends mainModel{

		protected function agregar_empresa_modelo($datos){

			$sql=mainModel::conectar()->prepare("INSERT INTO empresa(EmpresaCodigo, EmpresaNombre, EmpresaTelefono, EmpresaEmail, EmpresaDireccion, EmpresaDirector, EmpresaMoneda, EmpresaYear) VALUES (:Codigo,:Nombre,:Telefono,:Email,:Direccion,:Director, :Moneda, :Year)");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Telefono",$datos['Telefono']);
			$sql->bindParam(":Email",$datos['Email']);
			$sql->bindParam(":Direccion",$datos['Direccion']);
			$sql->bindParam(":Director",$datos['Director']);
			$sql->bindParam(":Moneda",$datos['Moneda']);
			$sql->bindParam(":Year",$datos['Year']);
			$sql->execute();
			return $sql;

		}

		protected function datos_empresa_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM empresa WHERE CuentaCodigo=:Codigo");
				$query->bindParam(":Codigo",$codigo);
				
				
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT id FROM cliente ");
			}
			$query->execute();
			return $query;

		}

	}