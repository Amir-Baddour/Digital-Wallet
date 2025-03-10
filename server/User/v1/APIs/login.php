<?php
header('Content-Type: application/json'); // Set response type to JSON

// CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../../connection/db.php'; // Include the database connection
require_once '../../../models/Users.php'; // Include the Users model

$db = new Database();
$users = new Users($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        // Handle login
        $data = json_decode(file_get_contents('php://input'), true);
        error_log('Received Data: ' . print_r($data, true));  // Log received data for debugging

        if (isset($data['email_phone'], $data['password'])) {
            $emailPhone = $data['email_phone'];
            $password = $data['password'];

            // Fetch the user by email or phone
            $stmt = $db->conn->prepare("SELECT id, password_hash FROM users WHERE email = ? OR phone_number = ?");
            $stmt->bind_param("ss", $emailPhone, $emailPhone);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($userId, $passwordHash);

            if ($stmt->fetch() && password_verify($password, $passwordHash)) {
                // Login successful
                error_log("Login successful for user: " . $emailPhone);  // Log successful login
                echo json_encode(['success' => true, 'message' => 'Login successful', 'user_id' => $userId]);
            } else {
                // Invalid credentials
                http_response_code(401); // Unauthorized
                error_log("Invalid credentials for: " . $emailPhone);  // Log invalid attempt
                echo json_encode(['error' => 'Invalid email/phone or password']);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Missing required fields']);
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>