<?php
// Enable CORS (Cross-Origin Resource Sharing)
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers

// Handle preflight requests for CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Include necessary files
require_once '../../../connection/db.php'; // Include the database connection
require_once '../../../models/Users.php'; // Include the Users model

// Set the response content type to JSON
header("Content-Type: application/json");

// Initialize the database and Users class
$db = new Database(); // Assuming you have a Database class that connects to your DB
$users = new Users($db);

// Get the HTTP method
$method = $_SERVER['REQUEST_METHOD'];

// Handle GET requests (fetch user profile)
if ($method === 'GET') {
    // Get the user ID from the query string
    $userId = $_GET['user_id'];

    // Fetch the user data
    $userData = $users->read($userId);

    if ($userData) {
        // Return the user data as JSON
        echo json_encode($userData);
    } else {
        // Return a 404 error if the user is not found
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
}

// Handle PUT requests (update user profile)
elseif ($method === 'PUT') {
    // Get the raw input from the request body
    $input = file_get_contents("php://input");

    // Decode the JSON input
    $put_vars = json_decode($input, true);

    // Debugging: Log the received data
    error_log("Received data: " . print_r($put_vars, true));

    // Get the user ID from the query string
    $userId = $_GET['user_id'];

    // Extract the updated data from the request
    $firstName = $put_vars['first_name'] ?? null;
    $lastName = $put_vars['last_name'] ?? null;
    $phone = $put_vars['phone'] ?? null;
    $address = $put_vars['address'] ?? null;

    // Debugging: Log the extracted data
    error_log("Extracted data: first_name = $firstName, last_name = $lastName, phone = $phone, address = $address");

    // Update the user profile
    if ($users->update($userId, $firstName, $lastName, $phone, $address)) {
        // Fetch the updated user data
        $updatedUserData = $users->read($userId);

        // Return a success response with the updated data
        echo json_encode([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => $updatedUserData
        ]);
    } else {
        // Return a 500 error if the update fails
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
    }
}

// Handle unsupported methods
else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>