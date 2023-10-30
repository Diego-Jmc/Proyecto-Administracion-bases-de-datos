<?php

// Configuración de conexión a Oracle
$nombre_servidor = "//localhost:1521/XE";
$usuario = "SYSTEM";
$contrasena = "root";

// Conexión a la base de datos Oracle
$conn = oci_connect($usuario, $contrasena, $nombre_servidor);

if (!$conn) {
    $error = oci_error();
    die("Error de conexión a Oracle: " . $error['message']);
}

// Esta consulta sql obtiene el sql en el sga que tiene mas hits de cache
$sql = "
    SELECT sql_id, sql_text, executions, buffer_gets, disk_reads, elapsed_time
    FROM v\$sql
    WHERE 
        CASE
            WHEN (buffer_gets + disk_reads) = 0 THEN 0 -- Evita la división por cero
            ELSE (buffer_gets / (buffer_gets + disk_reads))
        END > 0.8
    ORDER BY buffer_gets DESC
";

// Preparar la consulta
$stmt = oci_parse($conn, $sql);

// Ejecutar la consulta
oci_execute($stmt);

// Obtener la primera fila de resultados
$row = oci_fetch_assoc($stmt);

if ($row) {
    // Obtener el SQL Text de la primera fila
    $sql_text = $row['SQL_TEXT'];
    
    // Devolver el SQL Text
    echo $sql_text;
} else {
    echo "No se encontraron resultados para la consulta.";
}

// Cerrar la conexión
oci_free_statement($stmt);
oci_close($conn);
