<?php
class Cards {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    // Create a new card
    public function create($user_id, $card_number, $expiry_date, $cvv) {
        $stmt = $this->db->conn->prepare("INSERT INTO cards (user_id, card_number, expiry_date, cvv) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $card_number, $expiry_date, $cvv);
        return $stmt->execute();
    }

    // Read a card by ID
    public function read($id) {
        $stmt = $this->db->conn->prepare("SELECT * FROM cards WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update a card
    public function update($id, $card_number, $expiry_date, $cvv) {
        $stmt = $this->db->conn->prepare("UPDATE cards SET card_number = ?, expiry_date = ?, cvv = ? WHERE id = ?");
        $stmt->bind_param("sssi", $card_number, $expiry_date, $cvv, $id);
        return $stmt->execute();
    }

    // Delete a card
    public function delete($id) {
        $stmt = $this->db->conn->prepare("DELETE FROM cards WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>