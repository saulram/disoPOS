<?php



require_once "conexion.php";



class ModeloProductos{



	/*=============================================

	MOSTRAR PRODUCTOS

	=============================================*/



	static public function mdlMostrarProductos($tabla, $item, $valor, $orden){



		if($item != null){



			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");



			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);



			$stmt -> execute();



			return $stmt -> fetch();



		}else{



			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC");



			$stmt -> execute();



			return $stmt -> fetchAll();



		}



		$stmt -> close();



		$stmt = null;



	}



	/*=============================================

	REGISTRO DE PRODUCTO

	=============================================*/

	static public function mdlIngresarProducto($tabla, $datos){

		
		
		
		

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_categoria, codigo, descripcion, imagen, stock, precio_compra, precio_venta, precio_mayoreo) VALUES (:id_categoria, :codigo, :descripcion, :imagen, :stock, :precio_compra, :precio_venta, :precio_mayoreo)");



		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);

		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);

		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);

		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);

		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);

		$stmt->bindParam(":precio_mayoreo", $datos["precio_mayoreo"], PDO::PARAM_STR);



		if($stmt->execute()){



			return "ok";



		}else{

			


			return "error";

		

		}



		$stmt->close();

		$stmt = null;



	}



	/*=============================================

	EDITAR PRODUCTO

	=============================================*/

	static public function mdlEditarProducto($tabla, $datos){



		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria = :id_categoria, descripcion = :descripcion, imagen = :imagen, stock = :stock, precio_compra = :precio_compra, precio_venta = :precio_venta, precio_mayoreo = :precio_mayoreo WHERE codigo = :codigo");



		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);

		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);

		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);

		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);

		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);

		$stmt->bindParam(":precio_mayoreo", $datos["precio_mayoreo"], PDO::PARAM_STR);




		if($stmt->execute()){



			return "ok";



		}else{



			return "error";

		

		}



		$stmt->close();

		$stmt = null;



	}



	/*=============================================

	BORRAR PRODUCTO

	=============================================*/



	static public function mdlEliminarProducto($tabla, $datos){



		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");



		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);



		if($stmt -> execute()){



			return "ok";

		

		}else{



			return "error";	



		}



		$stmt -> close();



		$stmt = null;



	}



	/*=============================================

	ACTUALIZAR PRODUCTO

	=============================================*/



	static public function mdlActualizarProducto($tabla, $item1, $valor1, $valor){



		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");



		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);

		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);



		if($stmt -> execute()){



			return "ok";

		

		}else{



			return "error";	



		}



		$stmt -> close();



		$stmt = null;



	}



	/*=============================================

	MOSTRAR SUMA VENTAS

	=============================================*/	



	static public function mdlMostrarSumaVentas($tabla){



		$stmt = Conexion::conectar()->prepare("SELECT SUM(ventas) as total FROM $tabla");



		$stmt -> execute();



		return $stmt -> fetch();



		$stmt -> close();



		$stmt = null;

	}

	/*=============================================

	RANGO FECHAS

	=============================================*/	


	static public function mdlRangoFechasProductos($tabla, $fechaInicial, $fechaFinal){



		if($fechaInicial == null){



			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");



			$stmt -> execute();



			return $stmt -> fetchAll();	





		}else if($fechaInicial == $fechaFinal){



			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%'");



			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);



			$stmt -> execute();



			return $stmt -> fetchAll();



		}else{



			$fechaActual = new DateTime();

			$fechaActual ->add(new DateInterval("P1D"));

			$fechaActualMasUno = $fechaActual->format("Y-m-d");



			$fechaFinal2 = new DateTime($fechaFinal);

			$fechaFinal2 ->add(new DateInterval("P1D"));

			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");



			if($fechaFinalMasUno == $fechaActualMasUno){



				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");



			}else{





				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");



			}

		

			$stmt -> execute();



			return $stmt -> fetchAll();



		}



	}




}