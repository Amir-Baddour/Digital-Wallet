<?php
class Wallets {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    // Create a new wallet
    public function create($user_id, $balance = 0.00) {
        $stmt = $this->db->conn->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, ?)");
        $stmt->bind_param("id", $user_id, $balance);
        return $stmt->execute();
    }

    // Read a wallet by ID
    public function read($id) {
        $stmt = $this->db->conn->prepare("SELECT * FROM wallets WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update a wallet's balance
    public function updateBalance($id, $balance) {
        $stmt = $this->db->conn->prepare("UPDATE wallets SET balance = ? WHERE id = ?");
        $stmt->bind_param("di", $balance, $id);
        return $stmt->execute();
    }

    // Delete a wallet
    public function delete($id) {
        $stmt = $this->db->conn->prepare("DELETE FROM wallets WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>