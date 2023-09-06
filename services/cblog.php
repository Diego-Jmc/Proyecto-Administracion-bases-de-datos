<?php

$nombre_servidor = "//localhost:1521/XE";
$usuario = "SYSTEM";
$contrasena = "root";

$conn = oci_connect($usuario, $contrasena, $nombre_servidor);

if (!$conn) {
    $error = oci_error();
    die("Error de conexión a Oracle: " . $error['message']);
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the POST data
    $postData = file_get_contents('php://input');
    
    // Parse the POST data as JSON (assuming it's JSON data)
    $jsonData = json_decode($postData, true);
    
    // Check if JSON parsing was successful
    if ($jsonData !== null) {
        // Here, you can process the received JSON data as needed
        
        // Define the SQL query to insert data into the table
        $sql = "INSERT INTO cblog_monitoreo_buffer (size_mb, used_mb, free_mb, process_id, day, hour) 
                VALUES (:size_mb, :used_mb, :free_mb, :process_id, :day, :hour)";
        
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
    } else {
        // JSON parsing failed
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'Invalid JSON data'));
    }
} else {
    // Not a POST request
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Method not allowed'));
}

// Close the database connection
oci_close($conn);

?>
