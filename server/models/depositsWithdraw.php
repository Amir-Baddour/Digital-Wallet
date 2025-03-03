<?php

class DepositsWithdrawals {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    // Create a new deposit/withdrawal
    public function create($wallet_id, $type, $amount) {
        $stmt = $this->db->conn->prepare("INSERT INTO deposits_withdrawals (wallet_id, type, amount) VALUES (?, ?, ?)");
        $stmt->bind_param("isd", $wallet_id, $type, $amount);
        return $stmt->execute();
    }

    // Read a deposit/withdrawal by ID
    public function read($id) {
        $stmt = $this->db->conn->prepare("SELECT * FROM deposits_withdrawals WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update a deposit/withdrawal's status
    public function updateStatus($id, $status) {
        $stmt = $this->db->conn->prepare("UPDATE deposits_withdrawals SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    // Delete a deposit/withdrawal
    public function delete($id) {
        $stmt = $this->db->conn->prepare("DELETE FROM deposits_withdrawals WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>