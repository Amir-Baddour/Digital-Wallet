<?php
header('Content-Type: application/json'); // Set response type to JSON
require_once '../../../connection/db.php'; // Include the database connection
require_once '../../../models/Users.php'; // Include the Users model

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$db = new Database();

$users = new Users($db);


$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'POST':
        // Handle signup with file upload
        if (isset($_POST['email'], $_POST['password'], $_POST['fname'], $_POST['lname'], $_POST['phone'], $_POST['address'], $_POST['card_number'], $_POST['expiry_date'], $_POST['cvv'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $firstName = $_POST['fname'];
            $lastName = $_POST['lname'];
            $fullName = $firstName . ' ' . $lastName; // Combine first and last name
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $role = 'client'; // Default role for new users

            // Handle file upload
            if (isset($_FILES['id_document'])) {
                $file = $_FILES['id_document'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileDestination = 'uploads/' . $fileName; // Save the file in the "uploads" folder

                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    // File uploaded successfully
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['error' => 'Failed to upload file']);
                    exit;
                }
            }

            // Check if the email already exists
            $stmt = $db->conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Email already exists']);
            } else {
                // Create the user
                $result = $users->create($email, $password, $role, $firstName, $lastName, $phone, $address);

                if ($result) {
                    // Insert card details
                    $userId = $db->conn->insert_id; // Get the ID of the newly created user
                    $cardNumber = $_POST['card_number'];
                    $expiryDate = $_POST['expiry_date'];
                    $cvv = $_POST['cvv'];

                    $stmt = $db->conn->prepare("INSERT INTO cards (user_id, card_number, expiry_date, cvv) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("isss", $userId, $cardNumber, $expiryDate, $cvv);
                    $cardResult = $stmt->execute();

                    if ($cardResult) {
                        echo json_encode(['success' => true, 'message' => 'User and card created successfully']);
                    } else {
                        http_response_code(500); // Internal Server Error
                        echo json_encode(['error' => 'Failed to add card']);
                    }
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['error' => 'Failed to create user']);
                }
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