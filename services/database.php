<?php
// Conexión a la base de datos (código de conexión a Oracle que proporcionaste)
$nombre_servidor = "//localhost:1521/XE";
$usuario = "SYSTEM";
$contrasena = "root";

$conn = oci_connect($usuario, $contrasena, $nombre_servidor);

if (!$conn) {
    $error = oci_error();
    die("Error de conexión a Oracle: " . $error['message']);
}

// Consulta SQL (código de consulta que proporcionaste)
$sql = "
    SELECT l.tablespace_name \"Tablespace\",
           totalusedspace \"Used MB\",
           (l.totalspace - m.totalusedspace) \"Free MB\",
           l.totalspace \"Total MB\",
           ROUND(100 * ((l.totalspace - m.totalusedspace) / l.totalspace)) \"Pct. Free\"
    FROM
        (SELECT tablespace_name,
                ROUND(SUM(bytes) / 1048576) TotalSpace
         FROM dba_data_files
         GROUP BY tablespace_name) l,
        (SELECT ROUND(SUM(bytes) / (1024 * 1024)) totalusedspace, tablespace_name
         FROM dba_segments
         GROUP BY tablespace_name) m
    WHERE l.tablespace_name = m.tablespace_name";

$stid = oci_parse($conn, $sql);
oci_execute($stid);

// Creamos una clase para almacenar los resultados
class TableSpaceInfo {
    public $tablespace;
    public $usedMB;
    public $freeMB;
    public $totalMB;
    public $pctFree;
}

// Creamos un array para almacenar los objetos TableSpaceInfo
$tablespaceInfoArray = [];

while ($row = oci_fetch_assoc($stid)) {
    $tablespaceInfo = new TableSpaceInfo();
    $tablespaceInfo->tablespace = $row['Tablespace'];
    $tablespaceInfo->usedMB = $row['Used MB'];
    $tablespaceInfo->freeMB = $row['Free MB'];
    $tablespaceInfo->totalMB = $row['Total MB'];
    $tablespaceInfo->pctFree = $row['Pct. Free'];
    
    $tablespaceInfoArray[] = $tablespaceInfo;
}

oci_free_statement($stid);
oci_close($conn);

header('Content-Type: application/json');
echo json_encode($tablespaceInfoArray);
?>
