<?php
include 'includes/conexio.php';
if ($con) {
    mysqli_set_charset($con, "utf8");
    mysqli_select_db($con, $esquema);
    if (isset($_GET['act']) && $_GET['act'] == "del") {
        unset($_GET['act']);
        $query_borrar = "DELETE FROM llibres WHERE id = '" . $_GET['id'] . "'";
        $resultado_borrar = mysqli_query($con, $query_borrar);
    } elseif (isset($_POST['titol'])) {
        $query_actualizar = "UPDATE llibres SET titol='" . $_POST["titol"] . "', resum='" . $_POST["resum"] . "', autor='" . $_POST["autor"] . "', editorial='" . $_POST["editorial"] . "', any='" . $_POST["any"] . "', password='" . $_POST["password"] . "' WHERE id = '" . $_POST['id'] . "'";
        $resultado_actualizar = mysqli_query($con, $query_actualizar);
    } elseif (isset($_POST['titol_form'])) {
        $query_insertar = "INSERT INTO llibres VALUES (NULL, '" . $_POST['titol_form'] . "', '" . $_POST['resum_form'] . "', '" . $_POST['autor_form'] . "', '" . $_POST['editorial_form'] . "', " . $_POST['any_form'] . ", '" . md5($_POST['pass_llibre_form']) . "')";
        $resultado_insert = mysqli_query($con, $query_insertar);
    }
    $query = "SELECT * FROM llibres";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "<table><tr class='ini'><th>id</th><th>titol</th><th class='resum'>resum</th><th>autor</th><th>editorial</th><th>any</th><th>password</th><th>Modificar</th><th>Eliminar</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row["id"];
            if (isset($_GET['act']) && $_GET['act'] == "mod" && isset($_GET['id']) && $_GET['id'] == $id) {
                echo "<tr><form method='POST' action='index.php?ci=0'><td><input type='hidden' value='" . $id . "' name='id'>" . $id . "</td><td><input type='text' name='titol' value='" . $row["titol"] . "'></td><td><textarea name='resum' rows='4' cols='45'>" . $row["resum"] . "</textarea></td><td><input type='text' name='autor' value='" . $row["autor"] . "'></td><td><input type='text' name='editorial' value='" . $row["editorial"] . "'></td><td><input type='number' name='any' value='" . $row["any"] . "'></td><td><input type='text' name='password' value='" . $row["password"] . "'></td><td colspan='2'><input type='submit' value='Guardar'></td></form></tr>";
            } else {
                echo "<tr><td>" . $id . "</td><td>" . $row["titol"] . "<td>" . $row["resum"] . "</td><td>" . $row["autor"] . "</td><td>" . $row["editorial"] . "</td><td>" . $row["any"] . "</td><td>" . $row["password"] . "</td><td><a href='index.php?ci=0&id=" . $id . "&act=mod'><img src='resources/edit.png'></a></td><td><a href='index.php?ci=0&id=" . $id . "&act=del'><img src='resources/delete.png'></a></td></tr>";
            }
        }
        echo "</table><br>";
        if (isset($_GET['act']) && $_GET['act'] == "afegir") {
            echo "<form method='POST' action='index.php?ci=0'> Titol: <input name='titol_form' type='text' placeholder='Titol llibre'>"
            . " Resum: <textarea name='resum_form' rows='1' cols='40' placeholder='Resum llibre'></textarea>"
            . " Autor: <input name='autor_form' type='text' placeholder='Autor llibre'><br><br>"
            . " Editorial: <input name='editorial_form' type='text' placeholder='Editorial llibre'>"
            . " Any: <input name='any_form' type='number' placeholder='Any llibre'>"
            . " Password: <input name='pass_llibre_form' type='password' placeholder='Password'><br><br>"
            . " <input type='submit' value='Inserir llibres'></form>";
        } else {
            echo "<a href='index.php?ci=0&act=afegir'><button>Afegir llibre</button></a>";
        }
        mysqli_close($con);
    } else {
        echo "No hay ningún registro en la base de datos.";
    }
} else {
    echo "Error al connectar amb la BD.";
}
?>