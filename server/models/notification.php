<?php
class Notifications {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    // Create a new notification
    public function create($user_id, $message, $type) {
        $stmt = $this->db->conn->prepare("INSERT INTO notifications (user_id, message, type) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $message, $type);
        return $stmt->execute();
    }

    // Read a notification by ID
    public function read($id) {
        $stmt = $this->db->conn->prepare("SELECT * FROM notifications WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Mark a notification as read
    public function markAsRead($id) {
        $stmt = $this->db->conn->prepare("UPDATE notifications SET is_read = TRUE WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Delete a notification
    public function delete($id) {
        $stmt = $this->db->conn->prepare("DELETE FROM notifications WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>