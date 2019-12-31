<?php



$item = null;

$valor = null;



$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
$arrayClientes = array();

foreach ($clientes as $key => $clienteindividual) {

  array_push($arrayClientes, $clienteindividual["nombre"]);

  $arrayClientesCompras = array($clienteindividual["nombre"] => $clienteindividual["compras"]);

  foreach ($arrayClientesCompras as $key => $valor)
  {
    $sumaTotalCompras[$key]+= $valor;
  }
}

$noRepetirNombres = array_unique($arrayClientes);


?>

<!--=====================================

CLIENTES

======================================-->



<div class="box box-success">

	

	<div class="box-header with-border">

    

    	<h3 class="box-title">Mejores Compradores</h3>

  

  	</div>



  	<div class="box-body">

  		

		<div class="chart-responsive">

			

			<div class="chart" id="bar-chart2" style="height: 300px;"></div>



		</div>



  	</div>



</div>



<script>

	

//BAR CHART
var arreglo = [



<?php

  rsort($noRepetirNombres);
   
    foreach($noRepetirNombres as $value)
    {
      echo "{y: '".$value."', a: '".$sumaTotalCompras[$value]."'},";
    }
   
?>

]

function compare(a, b) {
  // Use toUpperCase() to ignore character casing
  const comprasA = Number(a.a);
  const comprasB = Number(b.a);

  let comparison = 0;
  if (comprasA > comprasB) {
    comparison = -1;
  } else if (comprasA < comprasB) {
    comparison = 1;
  }
  return comparison;
}

arreglo.sort(compare);


var bar = new Morris.Bar({

  element: 'bar-chart2',

  resize: true,

  data: arreglo ,

  barColors: ['#0af'],

  xkey: 'y',

  ykeys: ['a'],
  labels:['total'],

  postUnits: ' compras',

  hideHover: 'auto'

});





</script>