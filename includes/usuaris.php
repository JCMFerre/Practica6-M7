<?php 
include 'includes/conexio.php';
if ($con){
	mysqli_set_charset($con,"utf8");
	mysqli_select_db($con, $esquema);
	if (isset($_GET['act']) && $_GET['act'] == "del"){
		unset($_GET['act']);
		$query_borrar = "DELETE FROM usuaris WHERE usuari_id = '".$_GET['id']."'";
		$resultado_borrar = mysqli_query($con, $query_borrar);
	} elseif (isset($_POST['usuari_nom'])) {
		$query_act = "UPDATE usuaris SET usuari_nom='".$_POST['usuari_nom']."', usuari_clau='".md5($_POST['usuari_clau'])."', usuari_email='".$_POST['usuari_email']."', usuari_freq='".$_POST['usuari_freq']."' WHERE usuari_id = '".$_POST['usuari_id']."'";
		$resultado_act = mysqli_query($con, $query_act);
	} elseif (isset($_POST['nom_form'])) {
		$query_insertar = "INSERT INTO usuaris VALUES (NULL, '".$_POST['nom_form']."', '".md5($_POST['pass_form'])."', '".$_POST['email_form']."', '".$_POST['freq_form']."')";
		$resultado_insert = mysqli_query($con, $query_insertar);
	}
	$query = "SELECT * FROM usuaris";
	$result = mysqli_query($con, $query);
	if (mysqli_num_rows($result) > 0){
		echo "<table><tr class='ini'><th>usuari_id</th><th>usuari_nom</th><th>usuari_clau</th><th>usuari_email</th><th>usuari_freq</th><th>Modificar</th><th>Eliminar</th></tr>";
		while ($row = mysqli_fetch_assoc($result)) {
			$usuari_id = $row["usuari_id"];
			if (isset($_GET['act']) && $_GET['act'] == "mod" && isset($_GET['id']) && $_GET['id'] == $usuari_id){
				echo "<tr><form method='POST' action='index.php?ci=1'><td><input name='usuari_id' type='hidden' value='".$usuari_id."'>".$usuari_id."</td><td><input type='text' name='usuari_nom' value='".$row["usuari_nom"]."'></td><td><input type='password' name='usuari_clau' value='".$row["usuari_clau"]."'></td><td><input type='text' name='usuari_email' value='".$row["usuari_email"]."'></td><td><input name='usuari_freq' type='text' value='".$row["usuari_freq"]."'></td><td colspan='2'><input type='submit' value='Guardar'></td></form></tr>";
			} else{
				echo "<tr><td>" . $usuari_id. "</td><td>" . $row["usuari_nom"]."<td>" . $row["usuari_clau"]. "</td><td>" . $row["usuari_email"]."</td><td>" . $row["usuari_freq"]."</td><td><a href='index.php?ci=1&id=".$usuari_id."&act=mod'><img src='resources/edit.png'></a></td><td><a href='index.php?ci=1&id=".$usuari_id."&act=del'><img src='resources/delete.png'></a></td></tr>";
			}
		}
		echo "</table><br>";
		if (isset($_GET['act']) && $_GET['act'] == "afegir"){
			echo "<form method='POST' action='index.php?ci=1'> Nom: <input name='nom_form' type='text' placeholder='Nom usuari'>"
			. " Password: <input name='pass_form' type='password' placeholder='Password usuari'>"
			. " Email: <input name='email_form' type='text' placeholder='Email usuari'>"
			. " Freqüència: <input name='freq_form' type='text' value='0000-00-00 00:00:00' placeholder='Freqüència usuari'>"
			. " <input type='submit' value='Inserir usuari'></form>";
		} else{
			echo "<a href='index.php?ci=1&act=afegir'><button>Afegir usuari</button></a>";
		}
		mysqli_close($con);
	} else{
		echo "No hay ningún registro en la base de datos.";
	}
} else{
	echo "Error al connectar amb la BD.";
}
?>
