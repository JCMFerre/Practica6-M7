<?php
function mantenimentLlibres(){
	echo "Llibres";
}
function mantenimentUsuaris(){
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/estil.css">
	<link rel="shortcut icon" type="image/png" href="resources/favicon.png"/>
	<title>Bilioteca</title>
</head>
<body>
	<div class="container">
		<div class="cap"> 
			<h1>Biblioteca</h1>
		</div>		
		<div class="contingut">
			<div class="menu">
				<ul>
					<li><a href="index.php?ci=0">Manteniment Llibres</a></li>
					<li><a href="index.php?ci=1">Manteniment Usuaris</a></li>
				</ul>
			</div>
			<div class="article">
				<?php
				if (isset($_GET['ci'])){
					if ($_GET['ci'] == 0){
						include 'includes/llibres.php';
					} elseif ($_GET['ci'] == 1) {
						include 'includes/usuaris.php';
					} else{
						include 'includes/default.php';
					}
				} else{
					include 'includes/default.php';
				}
				?>
			</div>
		</div>
		<div class="clear"></div>
		<div class="peu">
			<?php include 'includes/peu.php';?>
		</div>
	</div>
</body>
</html>

