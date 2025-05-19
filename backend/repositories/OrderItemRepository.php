<?php
// repository für bestellpositionen (produkte innerhalb einer bestellung)
class OrderItemRepository {
    private $conn;

    // repository für bestellpositionen (produkte innerhalb einer bestellung)
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    // fügt ein einzelnes produkt zu einer bestellung hinzu
    public function addItem($orderId, $productId, $quantity, $price) {
        $stmt = $this->conn->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");
        if (!$stmt) { // fehler beim vorbereiten der sql-abfrage
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
    
        // werte an sql übergeben: int, int, int, double
        $stmt->bind_param("iiid", $orderId, $productId, $quantity, $price);
        
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
    
        return true;
    }

    // gibt alle produkte (name und menge) zu einer bestimmten bestellung zurück
    public function findByOrderId($orderId) {
        $stmt = $this->conn->prepare("
            SELECT p.name AS product_name, oi.quantity
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // gibt alle zeilen als array zurück
    }
    
}
?>