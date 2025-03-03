<?php
//This API will allow the admin to manage verifications (e.g., approve/reject).
header('Content-Type: application/json'); // Set response type to JSON
require_once '../../../connection/db.php'; // Include the database connection

$db = new Database();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Fetch all verifications
        $stmt = $db->conn->prepare("SELECT * FROM verifications");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        echo json_encode($result);
        break;

    case 'PUT':
        // Approve or reject a verification
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id'], $data['status'])) {
            $stmt = $db->conn->prepare("UPDATE verifications SET status = ?, verified_at = NOW() WHERE id = ?");
            $stmt->bind_param("si", $data['status'], $data['id']);
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