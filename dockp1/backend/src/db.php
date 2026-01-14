<?php
// Read DB settings from environment variables passed by Docker Compose
$host = getenv('DB_HOST');   // should be "db"
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');

// Retry because MySQL may take time to start
$attempts = 10;

while ($attempts > 0) {
    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$db;charset=utf8mb4",
            $user,
            $pass,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        // Success: stop retrying and let the request continue
        return;
    } catch (PDOException $e) {
        $attempts--;
        sleep(2);
    }
}

// If we get here, DB is unreachable
http_response_code(500);
header("Content-Type: application/json");
echo json_encode([
    "status" => "error",
    "message" => "Database unavailable"
]);
exit;
