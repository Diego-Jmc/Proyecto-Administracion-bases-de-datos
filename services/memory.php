<?php



class BufferMonitorResult {
    private $component;
    private $currentDate;
    private $currentTime;
    private $bufferCacheTotalMB;
    private $freeMemoryMB;
    private $usedMemoryMB;

    public function setComponent($component) {
        $this->component = $component;
    }

    public function getComponent() {
        return $this->component;
    }

    public function setCurrentDate($currentDate) {
        $this->currentDate = $currentDate;
    }

    public function getCurrentDate() {
        return $this->currentDate;
    }

    public function setCurrentTime($currentTime) {
        $this->currentTime = $currentTime;
    }

    public function getCurrentTime() {
        return $this->currentTime;
    }

    public function setBufferCacheTotalMB($bufferCacheTotalMB) {
        $this->bufferCacheTotalMB = $bufferCacheTotalMB;
    }

    public function getBufferCacheTotalMB() {
        return $this->bufferCacheTotalMB;
    }

    public function setFreeMemoryMB($freeMemoryMB) {
        $this->freeMemoryMB = $freeMemoryMB;
    }

    public function getFreeMemoryMB() {
        return $this->freeMemoryMB;
    }

    public function setUsedMemoryMB($usedMemoryMB) {
        $this->usedMemoryMB = $usedMemoryMB;
    }

    public function getUsedMemoryMB() {
        return $this->usedMemoryMB;
    }

    public function getAllData() {
        return [
            'component' => $this->component,
            'currentDate' => $this->currentDate,
            'currentTime' => $this->currentTime,
            'bufferCacheTotalMB' => $this->bufferCacheTotalMB,
            'freeMemoryMB' => $this->freeMemoryMB,
            'usedMemoryMB' => $this->usedMemoryMB,
        ];
    }
}


$nombre_servidor = "//localhost:1521/XE";
$usuario = "SYSTEM";
$contrasena = "root";

$conn = oci_connect($usuario, $contrasena, $nombre_servidor);

if (!$conn) {
    $error = oci_error();
    die("Error de conexión a Oracle: " . $error['message']);
}


$host = isset($_GET['host']) ? $_GET['host'] : null;



$sql = "";

if ($host == "Local" || $host == null) {
    $sql = "SELECT 'Buffer Cache' AS component, " .
        "TO_CHAR(SYSDATE, 'YYYY-MM-DD') AS current_date, " .
        "TO_CHAR(SYSDATE, 'HH24:MI:SS') AS current_time, " .
        "ROUND(SUM(CASE WHEN name = 'buffer_cache' THEN BYTES ELSE 0 END) / 1024 / 1024) AS buffer_cache_total_mb, " .
        "ROUND(SUM(CASE WHEN name = 'free memory' THEN BYTES ELSE 0 END) / 1024 / 1024) AS free_memory_mb, " .
        "ROUND((SUM(CASE WHEN name = 'buffer_cache' THEN BYTES ELSE 0 END) - SUM(CASE WHEN name = 'free memory' THEN BYTES ELSE 0 END)) / 1024 / 1024) AS used_memory_mb " .
        "FROM V\$SGASTAT " .
        "WHERE name IN ('buffer_cache', 'free memory')";
} else {
    $sql = "SELECT 'Buffer Cache' AS component, " .
        "TO_CHAR(SYSDATE, 'YYYY-MM-DD') AS current_date, " .
        "TO_CHAR(SYSDATE, 'HH24:MI:SS') AS current_time, " .
        "ROUND(SUM(CASE WHEN name = 'buffer_cache' THEN BYTES ELSE 0 END) / 1024 / 1024) AS buffer_cache_total_mb, " .
        "ROUND(SUM(CASE WHEN name = 'free memory' THEN BYTES ELSE 0 END) / 1024 / 1024) AS free_memory_mb, " .
        "ROUND((SUM(CASE WHEN name = 'buffer_cache' THEN BYTES ELSE 0 END) - SUM(CASE WHEN name = 'free memory' THEN BYTES ELSE 0 END)) / 1024 / 1024) AS used_memory_mb " .
        "FROM V\$SGASTAT@" . $host .
        " WHERE name IN ('buffer_cache', 'free memory')";
}








$stid = oci_parse($conn, $sql);
oci_execute($stid);

if ($row = oci_fetch_assoc($stid)) {
    $bufferMonitorResult = new BufferMonitorResult();
    $bufferMonitorResult->setComponent($row['COMPONENT']);
    $bufferMonitorResult->setCurrentDate($row['CURRENT_DATE']);
    $bufferMonitorResult->setCurrentTime($row['CURRENT_TIME']);
    $bufferMonitorResult->setBufferCacheTotalMB($row['BUFFER_CACHE_TOTAL_MB']);
    $bufferMonitorResult->setFreeMemoryMB($row['FREE_MEMORY_MB']);
    $bufferMonitorResult->setUsedMemoryMB($row['USED_MEMORY_MB']);

    $datos = $bufferMonitorResult->getAllData();

    header('Content-Type: application/json');
    echo json_encode($datos);
} else {
    header('HTTP/1.1 404 Not Found');
    echo 'No se encontraron datos';
}




?>
