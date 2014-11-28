<?php
require_once 'Distancia.php';

use Distancia\Distancia;

$cal = new Distancia();
$string = "Calcule a distância entre dois pontos de GPS com PHP.";
if($_POST){

	$cal->setSaida($_POST['saida']);
	$dist = $cal->distanciaPontosGPS((float)$_POST['laA'], (float)$_POST['loA'], (float)$_POST['laB'], (float)$_POST['loB']);

	if($cal->getSaida() == 'km'){
		$string = number_format($dist, 1, ',', ' ') . " km de distância";
	}else{
		$string = number_format($dist, 0, ',', ' ') . " métros de distância";
	}

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calcula Distância de Coordenadas e GPS</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
<div class="container"><br><br>
	
	<h1>Calcula Distância de Coordenadas e GPS</h1>
	<div id="outputDiv" class="alert alert-success text-center" role="alert"><?php echo $string;  ?></div>

	<br><br>
	<form action method="POST" role="form">
		<div class="col-md-6">	
			<div class="form-group">
				<label for="distA">Latitude A</label>
				<input type="text" class="form-control laA" name="laA" value="<?php echo (isset($_POST['laA'])? $_POST['laA'] : '');  ?>" placeholder="Latitude A">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="distA">Longitude A</label>
				<input type="text" class="form-control loA" name="loA" value="<?php echo (isset($_POST['loA'])? $_POST['loA'] : '');  ?>" placeholder="Longitude A">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="distB">Latitude B</label>
				<input type="text" class="form-control laB" name="laB" value="<?php echo (isset($_POST['laB'])? $_POST['laB'] : '');  ?>" placeholder="Latitude B">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="distB">Longitude B</label>
				<input type="text" class="form-control loB" name="loB" value="<?php echo (isset($_POST['loB'])? $_POST['loB'] : '');  ?>" placeholder="Longitude B">
			</div>
		</div>
		<div class="col-md-12">
			<select class="form-control" id="saida" name="saida">
			  <option value="km">KM</option>
			  <option value="M" <?php echo (isset($_POST['saida']) && $_POST['saida'] == 'M' ? 'selected' : '');  ?> >Métros</option>
			  
			</select>
		</div>

		<div class="col-md-12"><br><br>
			<button type="submit" class="btn btn-default">Calcular PHP</button>
			<a onclick="calculateDistances();" class="btn btn-info">Calcular com API Google</a>
		</div>
	</form>
</div>
<br><br><br><br>
<center>By GuiFerreira 2014</center>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
  </body>
</html>
	
<script>

function calculateDistances() {
	var origin1 = new google.maps.LatLng($('.laA').val(), $('.loA').val());
	var destinationA = new google.maps.LatLng($('.laB').val(), $('.loB').val());
	
	

  	var service = new google.maps.DistanceMatrixService();
  	service.getDistanceMatrix(
	    {
	      origins: [origin1],
	      destinations: [destinationA],
	      travelMode: google.maps.TravelMode.DRIVING,
	      unitSystem: google.maps.UnitSystem.METRIC,
	      avoidHighways: false,
	      avoidTolls: false
	    }, callback);
}

function callback(response, status) {
	var tipo = $('#saida').val();
  if (status != google.maps.DistanceMatrixStatus.OK) {
    alert('Error was: ' + status);
  } else {
    var origins = response.originAddresses;
    var destinations = response.destinationAddresses;
    var outputDiv = document.getElementById('outputDiv');
    var string = '';
    outputDiv.innerHTML = '';
    

    for (var i = 0; i < origins.length; i++) {
      var results = response.rows[i].elements;
      
      for (var j = 0; j < results.length; j++) {
       	
        string += origins[i] + ' para ' + destinations[j]
            + ': ' + results[j].distance.text + ' em '
            + results[j].duration.text + '<br>';
      }
      $('#outputDiv').html(string);
    }
  }
}







    </script>
	
	




