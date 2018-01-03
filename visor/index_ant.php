<?php
	try{
		$conn = new PDO('mysql:host=localhost;dbname=medieval_pdv3', 'root','');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare('SELECT name,img_slides,image FROM tec_products WHERE img_slides = 1');
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
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
			integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" 
			crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
			integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" 
			crossorigin="anonymous"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" 
			integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" 
			crossorigin="anonymous"></script>
	
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
/*
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



.last-calls .item {
	display: inline-block;
	width: 100%;
	float: left;
	padding: 25px 0;
	border-top: 1px solid rgba(255,255,255,0.3);
	border-bottom: 1px solid rgba(255,255,255,0.3);
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
*/
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

.last-calls h2 {
	text-transform:uppercase;
}

.config_slides{      
    width: 1000px;
    height: 670px;
    object-fit: contain;
}

</style>
</head>
<body>
	<div class="last-calls">
	  <h2>Ultimos Pedidos</h2>
	</div>

	<div id="demo" class="carousel slide" data-ride="carousel" data-interval = "10000">

		<!-- Indicators -->
		<ul class="carousel-indicators">
			<li data-target="#demo" data-slide-to="0" class="active"></li>
			<?php
				foreach ($data as $key => $value) {
					$indice = $key + 1;
					echo '<li data-target="#demo" data-slide-to="'.$indice.'"></li>';
				}
			?>
		</ul>

		<!-- The slideshow -->
		<div class="carousel-inner" role="listbox" style="text-align: center; margin-top: 0px;">

		    <div class="carousel-item active">
		    	<video loop autoplay volume="0" class="config_slides">
				 	<source src="video.mp4" type="video/mp4">
				</video>
		    </div>

		    <?php
		    	foreach ($data as $key => $value) {
		    		echo '<div class="carousel-item">
		      				<img src="../uploads/'.$value['image'].'" class="config_slides">		      	
		    			  </div>';
		    	}
		    ?>
		</div>
	</div>
</body>
</html>

<script>
	//var lastId = 0;

	$(document).ready(function(){
    	$("video").prop("volume", 0);

    	/*
		setInterval(function() {
			$.ajax({
				url: 'http://medievallanches.com.br/pdv3/sales/get_visor',
				type: 'GET',
				dataType: 'json'
			})
			.done(function(data) {

				var date = new Date(data.date);
				var current = new Date();

				var dif = current.getTime() - date.getTime();

				var Seconds_from_T1_to_T2 = dif / 1000;
				var Seconds_Between_Dates = Math.abs(Seconds_from_T1_to_T2);

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
		*/
	});
</script>