<?php

error_reporting(0);

if(isset($_GET["fechaInicial"])){

    $fechaInicial = $_GET["fechaInicial"];
    $fechaFinal = $_GET["fechaFinal"];

}else{

$fechaInicial = null;
$fechaFinal = null;

}

$respuesta = ControladorIngresos::ctrRangoFechasIngresos($fechaInicial, $fechaFinal);

$arrayFechas = array();
$arrayIngresos = array();
$sumaPagosMes = array();

foreach ($respuesta as $key => $value) {

	#Capturamos sólo el año y el mes
	$fecha = substr($value["fecha"],0,7);

	#Introducir las fechas en arrayFechas
	array_push($arrayFechas, $fecha);

	#Capturamos las Ingresos
	$arrayIngresos = array($fecha => $value["total"]);

	#Sumamos los pagos que ocurrieron el mismo mes
	foreach ($arrayIngresos as $key => $value) {
		
		$sumaPagosMes[$key] += $value;
	}

}


$noRepetirFechas = array_unique($arrayFechas);


?>

<!--=====================================
GRÁFICO DE Ingresos
======================================-->


<div class="box box-solid bg-teal-gradient">
	
	<div class="box-header">
		
 		<i class="fa fa-th"></i>

  		<h3 class="box-title">Gráfico de Ingresos</h3>

	</div>

	<div class="box-body border-radius-none nuevoGraficoIngresos">

		<div class="chart" id="line-chart-Ingresos" style="height: 250px;"></div>

  </div>

</div>

<script>
	
 var line = new Morris.Line({
    element          : 'line-chart-Ingresos',
    resize           : true,
    data             : [

    <?php

    if($noRepetirFechas != null){

	    foreach($noRepetirFechas as $key){

	    	echo "{ y: '".$key."', Ingresos: ".$sumaPagosMes[$key]." },";


	    }

	    echo "{y: '".$key."', Ingresos: ".$sumaPagosMes[$key]." }";

    }else{

       echo "{ y: '0', Ingresos: '0' }";

    }

    ?>

    ],
    xkey             : 'y',
    ykeys            : ['Ingresos'],
    labels           : ['Ingresos'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits         : '$',
    gridTextSize     : 10
  });

</script>