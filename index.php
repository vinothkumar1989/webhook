<?php 

// Set the refresh time to 10 seconds
// header("Refresh:10");
// Capture the incoming webhook payload
$payload = file_get_contents('php://input');
date_default_timezone_set('Asia/Kolkata');

// Log the request for debugging (optional)
file_put_contents('C:\Users\dell\Documents\webhook\webhook\webhook1.log', date('Y-m-d H:i:s') . " - Raw payload: " . $payload . "\n", FILE_APPEND);

// Decode the JSON payload into a PHP array
$data = json_decode($payload, true);

// Check if JSON decoding failed
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    file_put_contents('C:\Users\dell\Documents\webhook\webhook\webhook1.log', date('Y-m-d H:i:s') . " - JSON decoding error: " . json_last_error_msg() . "\n", FILE_APPEND);
    echo json_encode(["error" => "JSON decoding error: " . json_last_error_msg()]);
    http_response_code(400); // Bad request
    exit;
}

// Check if payload is empty or JSON decoding failed
if (empty($data)) {
    file_put_contents('C:\Users\dell\Documents\webhook\webhook\webhook1.log', date('Y-m-d H:i:s') . " - Error: Payload is empty or JSON decoding failed.\n", FILE_APPEND);
    echo json_encode(["error" => "Payload is empty or JSON decoding failed."]);
    http_response_code(400); // Bad request
    exit;
}


?>
