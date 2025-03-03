<?php
//This API allows users to view their transactions.
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
        // Fetch user transactions
        $stmt = $db->conn->prepare("SELECT * FROM transactions WHERE wallet_id IN (SELECT id FROM wallets WHERE user_id = ?)");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        echo json_encode($result);
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>