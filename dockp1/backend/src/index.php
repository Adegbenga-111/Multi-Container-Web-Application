<?php
header("Content-Type: application/json");

// This will exit with error JSON if DB is unavailable
require 'db.php';

echo json_encode([
    "status" => "ok",
    "message" => "Backend is running and DB is connected"
]);
