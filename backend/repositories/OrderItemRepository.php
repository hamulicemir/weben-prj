<?php

class OrderItemRepository {
    private $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function addItem($orderId, $productId, $quantity, $price) {
        $stmt = $this->conn->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
    
        $stmt->bind_param("iiid", $orderId, $productId, $quantity, $price);
        
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
    
        return true;
    }
}
?>