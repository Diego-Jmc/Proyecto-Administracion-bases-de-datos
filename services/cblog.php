<?php

$nombre_servidor = "//localhost:1521/XE";
$usuario = "SYSTEM";
$contrasena = "root";

$conn = oci_connect($usuario, $contrasena, $nombre_servidor);

if (!$conn) {
    $error = oci_error();
    die("Error de conexión a Oracle: " . $error['message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the POST data
    $postData = file_get_contents('php://input');
    
    // Parse the POST data as JSON (assuming it's JSON data)
    $jsonData = json_decode($postData, true);
    
    // Check if JSON parsing was successful
    if ($jsonData !== null) {
        // Here, you can process the received JSON data as needed
        
        $host = isset($_GET['host']) ? $_GET['host'] : null;

        // Define the SQL query to insert data into the table
    if($host == "Local" || $host == null){
        $sql = "INSERT INTO cblog_monitoreo_buffer (size_mb, used_mb, free_mb, process_id, day, hour) 
                VALUES (:size_mb, :used_mb, :free_mb, :process_id, :day, :hour)";
        
    } else {
        $sql = "INSERT INTO cblog_monitoreo_buffer@" . $host . "(size_mb, used_mb, free_mb, process_id, day, hour) 
                VALUES (:size_mb, :used_mb, :free_mb, :process_id, :day, :hour)";
    }
        
        // Prepare the SQL statement
        $stmt = oci_parse($conn, $sql);
        
        // Bind the JSON data to the placeholders in the SQL query
        oci_bind_by_name($stmt, ':size_mb', $jsonData['size_mb']);
        oci_bind_by_name($stmt, ':used_mb', $jsonData['used_mb']);
        oci_bind_by_name($stmt, ':free_mb', $jsonData['free_mb']);
        oci_bind_by_name($stmt, ':process_id', $jsonData['process_id']);
        oci_bind_by_name($stmt, ':day', $jsonData['day']);
        oci_bind_by_name($stmt, ':hour', $jsonData['hour']);
        
        // Execute the SQL statement
        $result = oci_execute($stmt);
        
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode(array('message' => 'Data inserted successfully'));
        } else {
            // Error occurred during insertion
            http_response_code(500); // Internal Server Error
            echo json_encode(array('error' => 'Data insertion failed'));
        }
        
        // Clean up
        oci_free_statement($stmt);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $host = isset($_GET['host']) ? $_GET['host'] : null;

    $sql = "";

    if ($host == "Local" || $host == null) {
        $sql = "SELECT * FROM cblog_monitoreo_buffer";
    } else {
        $sql = "SELECT * FROM cblog_monitoreo_buffer@" . $host;
    }

    // Intenta preparar la consulta SQL
    $stmt = oci_parse($conn, $sql);

    if (!$stmt) {
        $error = oci_error($conn);
        http_response_code(500); // Internal Server Error
        echo json_encode(array('error' => 'Error preparing SQL statement: ' . $error['message']));
        exit;
    }

    // Intenta ejecutar la consulta SQL
    $success = oci_execute($stmt);

    if (!$success) {
        $error = oci_error($stmt);
        http_response_code(500); // Internal Server Error
        echo json_encode(array('error' => 'Error executing SQL statement: ' . $error['message']));
        exit;
    }

    $data = array();
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // No es una solicitud POST ni GET
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Method not allowed'));
}


oci_close($conn);
?>
