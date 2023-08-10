<?php
include 'includes/connect.php';

//consulta
$querydb = "SELECT * FROM cuestionario";
$save = $connect->query($querydb);

$sql = "SELECT * FROM `Contenidos` WHERE `numero` = 1";

$result = $connect->query($sql);

$numero = "";
$descripcion = "";

if ($result->num_rows > 0) {
    // Obtener datos del registro
    $row = $result->fetch_assoc();
    $numero = $row["numero"];
    $descripcion = $row["descripcion"];
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Inicio </title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/jquery-3.7.0.min.js"></script>
</head>
<body>
    <script src="js/bootstrap.min.js"></script>

    <div class="container">
        <h1><?php echo $numero; ?> : Control interno de bases de datos</h1>
        <p><?php echo $descripcion; ?></p>



		<h3 class="text-center"> Cuestionario de Objetivos de Control </h3>
    <div class="table-responsive table/hover" id="TablaConsulta">
        <table class="table">
            <thead class="text-muted">
                <th class="text-center">ID</th>
                <th class="text-center">Objetivo</th>
                <th class="text-center">Sí</th>
                <th class="text-center">No</th>
                <th class="text-center">N/A</th>
            </thead>
            <tbody>
                <?php while($row = $save->fetch_assoc()){ ?>
                <tr>
                    <td class="text-center"> <?php echo $row['id'] ?> </td>
                    <td class="text-center"> <?php echo $row['objetivo'] ?> </td>
                    <td class="text-center"> <input type="checkbox" name="hola" value=SI> </td>
                    <td class="text-center"> <input type="checkbox" name="hola" value=SI> </td>
                    <td class="text-center"> <input type="checkbox" name="hola" value=SI> </td>
                </tr>
                <?php } ?>

            </tbody>
        </table>

    </div>

    </div>
</body>
</html>
