<?php
header('Content-Type: application/json'); // Set response type to JSON
require_once '../../../connection/db.php'; // Include the database connection
require_once '../../../models/users.php'; // Include the Users model

$db = new Database();
$users = new Users($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $user = $users->read($_GET['id']);
            echo json_encode($user);
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'User ID is required']);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['email'], $data['password'], $data['role'], $data['fname'],$data['lname'], $data['phone'], $data['address'])) {
            $result = $users->create($data['email'], $data['password'], $data['role'], $data['fname'],$data['lname'], $data['phone'], $data['address']);
            echo json_encode(['success' => $result]);
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Missing required fields']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id'], $data['first_name'],$data['last_name'], $data['phone'], $data['address'])) {
            $result = $users->update($data['id'], $data['first_name'],$data['last_name'], $data['phone'], $data['address']);
            echo json_encode(['success' => $result]);
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Missing required fields']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id'])) {
            $result = $users->delete($data['id']);
            echo json_encode(['success' => $result]);
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'User ID is required']);
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>