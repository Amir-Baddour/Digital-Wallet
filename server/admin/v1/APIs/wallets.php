<?php
header('Content-Type: application/json'); // Set response type to JSON
require_once '../../../connection/db.php'; // Include the database connection

$db = new Database();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Fetch all wallets
        $stmt = $db->conn->prepare("SELECT * FROM wallets");
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