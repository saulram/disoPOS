<?php



$item = null;

$valor = null;



$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);



$arrayClientes = array();

$arraylistaClientes = array();



foreach ($ventas as $key => $valueVentas) {

  

  foreach ($clientes as $key => $valueClientes) {

    if ($valueVentas["status"] == "Debe"){

      if($valueClientes["id"] == $valueVentas["id_cliente"]){



        #Capturamos los Clientes en un array

        array_push($arrayClientes, $valueClientes["nombre"]);


       
        #Capturamos las nombres y los valores netos en un mismo array

        $arraylistaClientes = array($valueClientes["nombre"] => $valueVentas["total"]);

         

          

          #Sumamos los netos de cada cliente

          foreach ($arraylistaClientes as $key => $value) {

            

            $sumaTotalClientes[$key] += $value;

          

          }
        }


      }   

  }



}



#Evitamos repetir nombre

$noRepetirNombres = array_unique($arrayClientes);



?>

<!--=====================================

CLIENTES

======================================-->



<div class="box box-success">

	

	<div class="box-header with-border">

    

    	<h3 class="box-title">Clientes Adeudores</h3>

  

  	</div>



  	<div class="box-body">

  		

		<div class="chart-responsive">

			

			<div class="chart" id="bar-chart5" style="height: 300px;"></div>



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
      echo "{y: '".$value."', a: '".$sumaTotalClientes[$value]."'},";
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

  element: 'bar-chart5',

  resize: true,

  data: arreglo ,

  barColors: ['#FE2E2E'],

  xkey: 'y',

  ykeys: ['a'],
  labels:['deuda'],

  preUnits: '$',

  hideHover: 'auto'

});





</script>