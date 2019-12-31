<?php

require_once "../../controladores/ingresos.controlador.php";
require_once "../../modelos/ingresos.modelo.php";
require_once "../../controladores/clientes.controlador.php";
require_once "../../modelos/clientes.modelo.php";
require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";
require_once "../../controladores/productos.controlador.php";
require_once "../../modelos/productos.modelo.php";

$reporteingresos = new ControladorIngresos();
$reporteingresos -> ctrDescargarReporteIngresos();