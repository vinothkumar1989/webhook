<?php 

// Set the refresh time to 10 seconds
// header("Refresh:10");
// Capture the incoming webhook payload
$payload = file_get_contents('php://input');
date_default_timezone_set('Asia/Kolkata');

// Log the request for debugging (optional)
file_put_contents('webhook1.log', date('Y-m-d H:i:s') . " - Raw payload: " . $payload . "\n", FILE_APPEND);

// Decode the JSON payload into a PHP array
$data = json_decode($payload, true);

// Check if JSON decoding failed
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    file_put_contents('webhook1.log', date('Y-m-d H:i:s') . " - JSON decoding error: " . json_last_error_msg() . "\n", FILE_APPEND);
    echo json_encode(["error" => "JSON decoding error: " . json_last_error_msg()]);
    http_response_code(400); // Bad request
    exit;
}

// Check if payload is empty or JSON decoding failed
if (empty($data)) {
    file_put_contents('webhook1.log', date('Y-m-d H:i:s') . " - Error: Payload is empty or JSON decoding failed.\n", FILE_APPEND);
    echo json_encode(["error" => "Payload is empty or JSON decoding failed."]);
    http_response_code(400); // Bad request
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "onlinepayment";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO onlinepayments (`name`, `email`, `phone`, `orderTime`, `orderId`, `amount`, `gst`, `discount`, `coupon`, `country`, `amountPayable`, `mangoName`, `status`, `slotId`, `eventId`, `slotDate`, `subscriberId`, `payment_id`)
VALUES (
    '" . mysqli_real_escape_string($conn, $data['name']) . "',
    '" . mysqli_real_escape_string($conn, $data['email']) . "',
    '" . mysqli_real_escape_string($conn, $data['phone']) . "',
    '" . mysqli_real_escape_string($conn, $data['orderTime']) . "',
    '" . mysqli_real_escape_string($conn, $data['orderId']) . "',
    '" . mysqli_real_escape_string($conn, $data['amount']) . "',
    '" . mysqli_real_escape_string($conn, $data['gst']) . "',
    '" . mysqli_real_escape_string($conn, $data['discount']) . "',
    '" . mysqli_real_escape_string($conn, $data['coupon']) . "',
    '" . mysqli_real_escape_string($conn, $data['country']) . "',
    '" . mysqli_real_escape_string($conn, $data['amountPayable']) . "',
    '" . mysqli_real_escape_string($conn, $data['mangoName']) . "',
    '" . mysqli_real_escape_string($conn, $data['status']) . "',
    '" . mysqli_real_escape_string($conn, $data['slotId']) . "',
    '" . mysqli_real_escape_string($conn, $data['eventId']) . "',
    '" . mysqli_real_escape_string($conn, $data['slotDate']) . "',
    '" . mysqli_real_escape_string($conn, $data['subscriberId']) . "',
    '" . mysqli_real_escape_string($conn, $data['id']) . "'
)";

if (mysqli_query($conn, $sql)) {
    // Log the request for debugging (optional)
file_put_contents('webhook1.log', date('Y-m-d H:i:s') . " - Raw payload: New record created successfully");
} else {
    file_put_contents('webhook1.log', date('Y-m-d H:i:s') . " - Raw payload: Error creating New record");
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);


?>
