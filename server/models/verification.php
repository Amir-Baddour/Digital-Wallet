<?php
class Verifications {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    // Create a new verification
    public function create($user_id, $document_type, $document_url) {
        $stmt = $this->db->conn->prepare("INSERT INTO verifications (user_id, document_type, document_url) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $document_type, $document_url);
        return $stmt->execute();
    }

    // Read a verification by ID
    public function read($id) {
        $stmt = $this->db->conn->prepare("SELECT * FROM verifications WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update a verification's status
    public function updateStatus($id, $status) {
        $stmt = $this->db->conn->prepare("UPDATE verifications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    // Delete a verification
    public function delete($id) {
        $stmt = $this->db->conn->prepare("DELETE FROM verifications WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>