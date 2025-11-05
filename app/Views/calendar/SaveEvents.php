<?php
header('Content-Type: application/json');

$fileName = __DIR__ . '/../../../public/data/events.json';
$data = file_get_contents("php://input");

if (!$data) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "No data received"]);
    exit;
}

if (file_put_contents($fileName, $data)) {
    echo json_encode(["success" => true, "message" => "Events saved successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Failed to save events"]);
}
?>