<?php
//This API allows users to view their wallet balance and perform deposits/withdrawals.
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
        // Fetch wallet balance
        $stmt = $db->conn->prepare("SELECT * FROM wallets WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        echo json_encode($result);
        break;

    case 'POST':
        // Deposit or withdraw funds
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['type'], $data['amount'])) {
            $type = $data['type']; // 'deposit' or 'withdrawal'
            $amount = $data['amount'];

            // Insert into deposits_withdrawals table
            $stmt = $db->conn->prepare("INSERT INTO deposits_withdrawals (wallet_id, type, amount) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $userId, $type, $amount);
            $result = $stmt->execute();

            // Update wallet balance
            if ($result) {
                $balanceUpdate = ($type === 'deposit') ? $amount : -$amount;
                $stmt = $db->conn->prepare("UPDATE wallets SET balance = balance + ? WHERE user_id = ?");
                $stmt->bind_param("di", $balanceUpdate, $userId);
                $stmt->execute();
            }

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