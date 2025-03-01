<?php
class Transactions {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    // Create a new transaction
    public function create($wallet_id, $type, $amount, $description) {
        $stmt = $this->db->conn->prepare("INSERT INTO transactions (wallet_id, type, amount, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isds", $wallet_id, $type, $amount, $description);
        return $stmt->execute();
    }

    // Read a transaction by ID
    public function read($id) {
        $stmt = $this->db->conn->prepare("SELECT * FROM transactions WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update a transaction
    public function update($id, $type, $amount, $description) {
        $stmt = $this->db->conn->prepare("UPDATE transactions SET type = ?, amount = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sdsi", $type, $amount, $description, $id);
        return $stmt->execute();
    }

    // Delete a transaction
    public function delete($id) {
        $stmt = $this->db->conn->prepare("DELETE FROM transactions WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>