<?php



class ControladorProductos{



	/*=============================================

	MOSTRAR PRODUCTOS

	=============================================*/



	static public function ctrMostrarProductos($item, $valor, $orden){



		$tabla = "productos";



		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $orden);



		return $respuesta;



	}



	/*=============================================

	CREAR PRODUCTO

	=============================================*/



	static public function ctrCrearProducto(){



		if(isset($_POST["nuevaDescripcion"])){



			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"]) &&

			   preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) &&	

			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompra"]) &&

			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioVenta"])){



		   		/*=============================================

				VALIDAR IMAGEN

				=============================================*/



			   	$ruta = "vistas/img/productos/default/anonymous.png";



			   	if(isset($_FILES["nuevaImagen"]["tmp_name"])){



					list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);



					$nuevoAncho = 500;

					$nuevoAlto = 500;



					/*=============================================

					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO

					=============================================*/



					$directorio = "./vistas/img/productos/".$_POST["nuevoCodigo"];



					if(mkdir($directorio, 0777))
					{
						echo("<script>console.log('se creo el directorio con exito')</script>");
					}else{
						echo("<script>console.log('no se creo el directorio con exito')</script>");
						
					}




					/*=============================================

					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP

					=============================================*/



					if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){



						/*=============================================

						GUARDAMOS LA IMAGEN EN EL DIRECTORIO

						=============================================*/



						$aleatorio = mt_rand(100,999);



						$ruta = "./vistas/img/productos/".$aleatorio.".jpg";


						$origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);						



						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);



						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);



						imagejpeg($destino, $ruta);



					}



					if($_FILES["nuevaImagen"]["type"] == "image/png"){



						/*=============================================

						GUARDAMOS LA IMAGEN EN EL DIRECTORIO

						=============================================*/



						$aleatorio = mt_rand(100,999);



						$ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".png";



						$origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);						



						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);



						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);



						imagepng($destino, $ruta);



					}



				}



				$tabla = "productos";



				$datos = array("id_categoria" => $_POST["nuevaCategoria"],

							   "codigo" => $_POST["nuevoCodigo"],

							   "descripcion" => $_POST["nuevaDescripcion"],

							   "stock" => $_POST["nuevoStock"],

							   "precio_compra" => $_POST["nuevoPrecioCompra"],

							   "precio_venta" => $_POST["nuevoPrecioVenta"],

							   "precio_mayoreo" => $_POST["precioMayoreo"],

							   "imagen" => $ruta);





				$respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);



				if($respuesta == "ok"){



					echo'<script>



						swal({

							  type: "success",

							  title: "El producto ha sido guardado correctamente",

							  showConfirmButton: true,

							  confirmButtonText: "Cerrar"

							  }).then(function(result){

										if (result.value) {



										window.location = "productos";



										}

									})



						</script>';



				}





			}else{



				echo'<script>



					swal({

						  type: "error",

						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",

						  showConfirmButton: true,

						  confirmButtonText: "Cerrar"

						  }).then(function(result){

							if (result.value) {



							window.location = "productos";



							}

						})



			  	</script>';

			}

		}



	}



	/*=============================================

	EDITAR PRODUCTO

	=============================================*/



	static public function ctrEditarProducto(){



		if(isset($_POST["editarDescripcion"])){



			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"]) &&

			   preg_match('/^[0-9]+$/', $_POST["editarStock"]) &&	

			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioCompra"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioMayoreo"]) &&

			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioVenta"])){



		   		/*=============================================

				VALIDAR IMAGEN

				=============================================*/



			   	$ruta = $_POST["imagenActual"];



			   	if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){



					list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);



					$nuevoAncho = 500;

					$nuevoAlto = 500;



					/*=============================================

					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO

					=============================================*/



					$directorio = "vistas/img/productos/".$_POST["editarCodigo"];



					/*=============================================

					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD

					=============================================*/



					if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png"){



						unlink($_POST["imagenActual"]);
						mkdir($directorio, 0755);


					}else{



						mkdir($directorio, 0755);	

					

					}

					

					/*=============================================

					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP

					=============================================*/



					if($_FILES["editarImagen"]["type"] == "image/jpeg"){



						/*=============================================

						GUARDAMOS LA IMAGEN EN EL DIRECTORIO

						=============================================*/



						$aleatorio = mt_rand(100,999);



						$ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".jpg";



						$origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);						



						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);



						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);



						imagejpeg($destino, $ruta);



					}



					if($_FILES["editarImagen"]["type"] == "image/png"){



						/*=============================================

						GUARDAMOS LA IMAGEN EN EL DIRECTORIO

						=============================================*/



						$aleatorio = mt_rand(100,999);



						$ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".png";



						$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);						



						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);



						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);



						imagepng($destino, $ruta);



					}



				}



				$tabla = "productos";



				$datos = array("id_categoria" => $_POST["editarCategoria"],

							   "codigo" => $_POST["editarCodigo"],

							   "descripcion" => $_POST["editarDescripcion"],

							   "stock" => $_POST["editarStock"],

							   "precio_compra" => $_POST["editarPrecioCompra"],

							   "precio_venta" => $_POST["editarPrecioVenta"],

							   "precio_mayoreo" => $_POST["editarPrecioMayoreo"],

							   "imagen" => $ruta);



				$respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);



				if($respuesta == "ok"){



					echo'<script>



						swal({

							  type: "success",

							  title: "El producto ha sido editado correctamente",

							  showConfirmButton: true,

							  confirmButtonText: "Cerrar"

							  }).then(function(result){

										if (result.value) {



										window.location = "productos";



										}

									})



						</script>';



				}





			}else{



				echo'<script>



					swal({

						  type: "error",

						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",

						  showConfirmButton: true,

						  confirmButtonText: "Cerrar"

						  }).then(function(result){

							if (result.value) {



							window.location = "productos";



							}

						})



			  	</script>';

			}

		}



	}



	/*=============================================

	BORRAR PRODUCTO

	=============================================*/

	static public function ctrEliminarProducto(){



		if(isset($_GET["idProducto"])){



			$tabla ="productos";

			$datos = $_GET["idProducto"];



			if($_GET["imagen"] != "" && $_GET["imagen"] != "vistas/img/productos/default/anonymous.png"){



				unlink($_GET["imagen"]);

				rmdir('vistas/img/productos/'.$_GET["codigo"]);



			}



			$respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);



			if($respuesta == "ok"){



				echo'<script>



				swal({

					  type: "success",

					  title: "El producto ha sido borrado correctamente",

					  showConfirmButton: true,

					  confirmButtonText: "Cerrar"

					  }).then(function(result){

								if (result.value) {



								window.location = "productos";



								}

							})



				</script>';



			}		

		}





	}



	/*=============================================

	MOSTRAR SUMA VENTAS

	=============================================*/



	static public function ctrMostrarSumaVentas(){



		$tabla = "productos";



		$respuesta = ModeloProductos::mdlMostrarSumaVentas($tabla);



		return $respuesta;



	}


	/*=============================================

	RANGO FECHAS
	=============================================*/	
	



	static public function ctrRangoFechasProductos($fechaInicial, $fechaFinal){



		$tabla = "productos";



		$respuesta = ModeloProductos::mdlRangoFechasProductos($tabla, $fechaInicial, $fechaFinal);



		return $respuesta;

		

	}

/*=============================================

	DESCARGAR EXCEL

	=============================================*/



	public function ctrDescargarReporteProductos(){



		if(isset($_GET["reporteproducto"])){



			$tabla = "productos";


/*
			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){



				$reporteproducto = ModeloProductos::mdlRangoFechasProductos($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);



			}else{



				$item = null;

				$valor = null;



				$reporteproducto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor);



			}
*/
				$item = null;

				$valor = null;

				$orden = "codigo";



				$reporteproducto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $orden);




			/*=============================================

			CREAMOS EL ARCHIVO DE EXCEL

			=============================================*/



			$Name = $_GET["reporteproducto"].'.xls';



			header('Expires: 0');

			header('Cache-control: private');

			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel

			header("Cache-Control: cache, must-revalidate"); 

			header('Content-Description: File Transfer');

			header('Last-Modified: '.date('D, d M Y H:i:s'));

			header("Pragma: public"); 

			header('Content-Disposition:; filename="'.$Name.'"');

			header("Content-Transfer-Encoding: binary");

		

			echo utf8_decode("<table border='0'> 



					<tr> 

					<td style='font-weight:bold; border:1px solid #eee;'>CODIGO</td> 

					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTO</td>

					<td style='font-weight:bold; border:1px solid #eee;'>CATEGORIA</td>

					<td style='font-weight:bold; border:1px solid #eee;'>STOCK</td>

					<td style='font-weight:bold; border:1px solid #eee;'>PRECIO DE COMPRA</td>

					<td style='font-weight:bold; border:1px solid #eee;'>PRECIO DE VENTA</td>

					<td style='font-weight:bold; border:1px solid #eee;'>PRECIO DE MAYOREO</td>		

					<td style='font-weight:bold; border:1px solid #eee;'>VENDIDOS</td>		

					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td	

					</tr>");


					

			
			foreach ($reporteproducto as $row => $item){



				$categoria = ControladorCategorias::ctrMostrarCategorias("id", $item["id_categoria"]);

		
			 	
			
						echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
						<td style='border:1px solid #eee;'>".$item["descripcion"]."</td>
						<td style='border:1px solid #eee;'>".$categoria["categoria"]."</td>
						<td style='border:1px solid #eee;'>".$item["stock"]."</td>
						<td style='border:1px solid #eee;'>".$item["precio_compra"]."</td>
						<td style='border:1px solid #eee;'>".$item["precio_venta"]."</td>
						<td style='border:1px solid #eee;'>".$item["precio_mayoreo"]."</td>
						<td style='border:1px solid #eee;'>".$item["ventas"]."</td>
						<td style='border:1px solid #eee;'>".$item["fecha"]."</td>
						</tr>");
			
			}

			echo "</table>";



		}



	}





}