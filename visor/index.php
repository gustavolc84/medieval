<?php
	try{
		$conn = new PDO('mysql:host=localhost;dbname=medieval_pdv3', 'root','');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare('SELECT name FROM tec_slides WHERE status = 1 ORDER BY orders');
		$stmt->execute();
		$data = $stmt->fetchAll();
 		$num_rows = sizeof($data);
	}catch(PDOException $e){
		echo 'ERROR: ' . $e->getMessage();
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Visor do PDV</title>

	<link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
	
	<script src='https://code.responsivevoice.org/responsivevoice.js'></script>
	<script src="../themes/default/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
			integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" 
			crossorigin="anonymous">
	</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" 
			integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" 
			crossorigin="anonymous">
	</script>

<style>
		
html, body {
  margin:0;
  padding:0;
  background:#000;
  width:100%;
  height:100%;
  overflow:hidden;
  position:absolute;
  min-width:900px;
}
.overlay {
	position:fixed;
	top:0;
	color:#fff;
	font-family: 'Rubik', sans-serif;
	text-align:center;
	font-size:100px;
	background:#000;
	height:100%;
	width:100%;
	z-index:99999;
	display:table;
}
.cont {
	display:table-cell;
	vertical-align: middle;
}
.overlay small {
	font-size:60px;
}

video {
  /* Make video to at least 100% wide and tall */
  min-width: 100%; 
  min-height: 100%; 
  
  /* Setting width & height to auto prevents the browser from stretching or squishing the video */
  width: auto;
  height: auto;
  
  /* Center the video */
  /*
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  */
}

.last-calls {
  display:inline-block;
  position:fixed;
  width:30%;
  height:100%;
  top:0;
  z-index:99;
  text-align:center;
  background:rgba(0,0,0,0.4);
  border-radius:10px;
  font-family:Rubik;
  color:#fff;
  padding:30px 0;
  right:0;
  overflow:hidden;
}
.last-calls .item {
  display: inline-block;
  width: 100%;
  float: left;
  padding: 25px 0;
  border-top: 1px solid rgba(255,255,255,0.3);
  border-bottom: 1px solid rgba(255,255,255,0.3);
}
.last-calls h2 {
  text-transform:uppercase;
}
.last-calls .item h4 {
  font-weight:900;
  margin:0;
  font-size:25px;
}
.last-calls .item p {
  font-size:20px;
  font-weight:900;
  margin: 0;
  font-size: 30px;
  margin-top: 10px;
}
.config_slides{      
    min-width: 90%;
    min-height: 90%;
    object-fit: cover;
}

</style>
</head>
<body>
	
<div class="overlay" style="display:none">
	
	<div class="cont">
		<div class="customer">Paulo Henrique</div>
		<div class="id"><small>Pedido</small> <span></span></div>
	</div>

</div>

<div class="last-calls">
  <h2>Ultimos Pedidos</h2>
</div>

<div id="demo" class="carousel slide" data-ride="carousel" data-interval = "5000">

		<!-- Indicators -->
		<!--
		<ul class="carousel-indicators">
			<li data-target="#demo" data-slide-to="0" class="active"></li>
			<?php
				foreach ($data as $key => $value) {
					$indice = $key + 1;
					//echo '<li data-target="#demo" data-slide-to="'.$indice.'"></li>';
				}
			?>
		</ul>
		-->

		<!-- The slideshow -->
		<div class="carousel-inner" style="text-align: center;">

		    <div class="carousel-item active">
		    	<video loop autoplay volume="0">
				 	<source src="video.mp4" type="video/mp4" class="config_slides">
				</video>
		    </div>

		    <?php
		    	foreach ($data as $key => $value) {
		    		echo '<div class="carousel-item">
		      				<img src="../uploads/slides/'.$value['name'].'" class="config_slides">		      	
		    			  </div>';
		    	}
		    ?>
		</div>
	</div>


<audio>
  <source src="victory.mp3" type="audio/mpeg">
	<!-- Your browser does not support the audio element. -->
	Seu navegador não suporta o elemento de áudio.
</audio>

<script>

	var lastId = 0;

	$(document).ready(function() {


    $("video").prop("volume", 0);

		setInterval(function() {
			var url = window.location.href;
				url = url.replace('visor/','') + 'sales/get_visor';
			$.ajax({
				//url: 'http://medievallanches.com.br/pdv3/sales/get_visor',
				url: url,
				type: 'GET',
				dataType: 'json'
			})
			.done(function(data) {

				var date = new Date(data.date);
				var current = new Date();

				var dif = current.getTime() - date.getTime();

				var Seconds_from_T1_to_T2 = dif / 1000;
				var Seconds_Between_Dates = Math.abs(Seconds_from_T1_to_T2);

        //console.log(Seconds_Between_Dates);
        //console.log(lastId);

				if(Seconds_Between_Dates < 10 && data.id != lastId) {

					$('.overlay').show();
					
					$('audio')[0].play();

					setTimeout(function() {
						responsiveVoice.speak(data.customer+", seu pedido de número "+data.id+" está pronto!", "Brazilian Portuguese Female");
					}, 5000);

					$('.customer').html(data.customer);
					$('.id span').html(data.id);

					setTimeout(function() {
						$('.overlay').hide();
					}, 15000);

					lastId = data.id;

          $('.last-calls h2').after('  <div class="item"><h4>'+data.customer+'</h4><p>Nº '+data.id+'</p></div>');


				}

			});


		}, 1000);

	});


</script>

</body>
</html>