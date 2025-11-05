<?php
header('Content-Type: application/json');

$fileName = __DIR__ . '/../../../public/data/events.json';
if (file_exists($fileName)){
    echo file_get_contents($fileName);
}else {
    echo json_encode([]);
}
?>