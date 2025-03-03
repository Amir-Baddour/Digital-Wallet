<?php
header('Content-Type: application/json'); // Set response type to JSON
require_once '../../../connection/db.php'; // Include the database connection
require_once '../../../models/Users.php'; // Include the Users model

$db = new Database();
$users = new Users($db);

$method = $_SERVER['REQUEST_METHOD'];
$userId = $_GET['user_id'] ?? null; // Assume user_id is passed as a query parameter

if (!$userId) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'User ID is required']);
    exit;
}

switch ($method) {
    case 'GET':
        // Fetch user profile
        $user = $users->read($userId);
        echo json_encode($user);
        break;

    case 'PUT':
        // Update user profile
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['full_name'], $data['phone'], $data['address'])) {
            $result = $users->update($userId, $data['full_name'], $data['phone'], $data['address']);
            echo json_encode(['success' => $result]);
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