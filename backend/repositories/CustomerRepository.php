<?php

class CustomerRepository {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    // Get all customers
    public function getAllCustomers(): array {
        $query = "SELECT id, username, email, active FROM users WHERE role = 'customer' ORDER BY username ASC";
        $result = $this->conn->query($query);

        if (!$result) {
            throw new Exception("Failed to fetch customers.");
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Deactivate a customer
    public function deactivateCustomer(int $id): bool {
        $stmt = $this->conn->prepare("UPDATE users SET active = 0 WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare deactivation.");
        }

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Reactivate a customer
    public function reactivateCustomer(int $id): bool {
        $stmt = $this->conn->prepare("UPDATE users SET active = 1 WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare reactivation.");
        }
    
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    

    // Get orders and products for a customer
    public function getOrdersByCustomer(int $customerId): array {
        $stmt = $this->conn->prepare("
            SELECT 
                oi.order_id,
                p.name AS product_name,
                oi.product_id,
                oi.quantity
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            WHERE o.user_id = ?
            ORDER BY oi.order_id DESC
        ");

        if (!$stmt) {
            throw new Exception("Failed to prepare order query.");
        }

        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Remove a product from an order
    public function removeProductFromOrder(int $orderId, int $productId): bool {
        $stmt = $this->conn->prepare("DELETE FROM order_items WHERE order_id = ? AND product_id = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare delete statement.");
        }

        $stmt->bind_param("ii", $orderId, $productId);
        return $stmt->execute();
    }
}
