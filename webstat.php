<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Simulate data
$response = [
    "totalVisits" => 12345,
    "trafficDetails" => "High traffic from US and Europe"
];

// Return JSON response
echo json_encode($response);
?>
