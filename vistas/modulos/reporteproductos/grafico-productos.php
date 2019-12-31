<?php

error_reporting(0);

if(isset($_GET["fechaInicial"])){

    $fechaInicial = $_GET["fechaInicial"];
    $fechaFinal = $_GET["fechaFinal"];

}else{

$fechaInicial = null;
$fechaFinal = null;

}

$respuesta = ControladorProductos::ctrRangoFechasProductos($fechaInicial, $fechaFinal);

$arrayFechas = array();
$arrayProductos = array();
$sumaProductosMes = array();

foreach ($respuesta as $key => $value) {

	#Capturamos sólo el año y el mes
	$fecha = substr($value["fecha"],0,7);

	#Introducir las fechas en arrayFechas
	array_push($arrayFechas, $fecha);

	#Capturamos las ventas
	$arrayProductos = array($fecha => $value["ventas"]);

	#Sumamos los pagos que ocurrieron el mismo mes
	foreach ($arrayProductos as $key => $value) {
		
		$sumaStockMes[$key] += $value;
	}

}


$noRepetirFechas = array_unique($arrayFechas);


?>

<!--=====================================
GRÁFICO DE PRODUCTOS
======================================-->


<div class="box box-solid bg-teal-gradient">
	
	<div class="box-header">
		
 		<i class="fa fa-th"></i>

  		<h3 class="box-title">Gráfico de productos</h3>

	</div>

	<div class="box-body border-radius-none nuevoGraficoproductos">

		<div class="chart" id="line-chart-ventas" style="height: 250px;"></div>

  </div>

</div>

<script>
	
 var line = new Morris.Line({
    element          : 'line-chart-ventas',
    resize           : true,
    data             : [

    <?php

    if($noRepetirFechas != null){

	    foreach($noRepetirFechas as $key){

	    	echo "{ y: '".$key."', productos: ".$sumaStockMes[$key]." },";


	    }

	    echo "{y: '".$key."', productos: ".$sumaStockMes[$key]." }";

    }else{

       echo "{ y: '0', productos: '0' }";

    }

    ?>

    ],
    xkey             : 'y',
    ykeys            : ['productos'],
    labels           : ['productos'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    postUnits        : ' Pzs',
    gridTextSize     : 10
  });

</script>