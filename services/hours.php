<?php

$nombre_servidor = "//localhost:1521/XE";
$usuario = "SYSTEM";
$contrasena = "root";

// Establecer conexión a Oracle
$conn = oci_connect($usuario, $contrasena, $nombre_servidor);

if (!$conn) {
    $error = oci_error();
    die("Error de conexión a Oracle: " . $error['message']);
}

// Endpoint para peticiones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el cuerpo del JSON de la solicitud
    $jsonBody = file_get_contents('php://input');

    // Decodificar el JSON
    $requestData = json_decode($jsonBody, true);

    // Obtener fechas de la solicitud
    $date1 = isset($requestData['date1']) ? $requestData['date1'] : null;
    $date2 = isset($requestData['date2']) ? $requestData['date2'] : null;

    // Validar que se proporcionen las fechas
    if (!$date1 || !$date2) {
        echo json_encode(['error' => 'Se deben proporcionar las fechas date1 y date2.']);
        exit;
    }

    // Realizar la consulta a la tabla cblog_monitoreo_buffer sin filtro de fechas

    $host = isset($_GET['host']) ? $_GET['host'] : null;

    $query = "";

    if ($host == "Local" || $host == null){
        $query = "SELECT DAY, HOUR, SIZE_MB, USED_MB FROM cblog_monitoreo_buffer";
    }else{
        $query = "SELECT DAY, HOUR, SIZE_MB, USED_MB FROM cblog_monitoreo_buffer@" . $host . "";
    }

    $result = oci_parse($conn, $query);

    if (!$result) {
        $error = oci_error($conn);
        die("Error en la consulta: " . $error['message']);
    }

    oci_execute($result);

    // Obtener los resultados y convertirlos a un array
    $data = [];
    while ($row = oci_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Filtrar y transformar los resultados según las condiciones especificadas
    $filteredData = [];
    foreach ($data as $row) {
        // Apply filtering based on the condition
        if ($row['DAY'] >= $date1 && $row['DAY'] <= $date2) {
            $estado = ($row['USED_MB'] > $row['SIZE_MB']) ? 'Desbordamiento' : 'Normal';

            $filteredData[] = [
                'DAY' => $row['DAY'],
                'HOUR' => $row['HOUR'],
                'SIZE_MB' => $row['SIZE_MB'],
                'USED_MB' => $row['USED_MB'],
                'estado' => $estado,
            ];
        }
    }

    // Devolver los resultados filtrados como JSON
    echo json_encode($filteredData);
} else {
    // Manejar otros métodos HTTP si es necesario
    echo json_encode(['error' => 'Método no permitido']);
}

// Cerrar conexión a Oracle
oci_close($conn);
?>
