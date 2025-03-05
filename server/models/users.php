<?php
class Users {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    // Create a new user
    public function create($email, $password, $role, $fname, $lname, $phone, $address) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->conn->prepare("INSERT INTO users (email, password_hash, role, first_name, last_name, phone_number, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        // Add type definition string: "sssisss"
        $stmt->bind_param("sssssss", $email, $password_hash, $role, $fname, $lname, $phone, $address);
    
        return $stmt->execute();
    }
    

    // Read a user by ID
    public function read($id) {
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update a user
    public function update($id, $first_name, $last_name, $phone, $address) {
        $stmt = $this->db->conn->prepare("UPDATE users SET first_name = ?, last_name = ?, phone_number = ?, address = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $first_name, $last_name, $phone, $address, $id);
        return $stmt->execute();
    }

    // Delete a user
    public function delete($id) {
        $stmt = $this->db->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>