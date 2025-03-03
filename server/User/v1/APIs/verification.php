<?php
header('Content-Type: application/json'); // Set response type to JSON
require_once '../../../connection/db.php'; // Include the database connection

$db = new Database();

$method = $_SERVER['REQUEST_METHOD'];
$userId = $_GET['user_id'] ?? null; // Assume user_id is passed as a query parameter

if (!$userId) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'User ID is required']);
    exit;
}

switch ($method) {
    case 'GET':
        // Fetch verification status
        $stmt = $db->conn->prepare("SELECT * FROM verifications WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        echo json_encode($result);
        break;

    case 'POST':
        // Submit a new verification
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['document_type'], $data['document_url'])) {
            $stmt = $db->conn->prepare("INSERT INTO verifications (user_id, document_type, document_url) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $userId, $data['document_type'], $data['document_url']);
            $result = $stmt->execute();
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