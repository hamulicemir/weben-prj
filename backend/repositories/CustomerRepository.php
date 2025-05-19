<?php

// repository layer = zuständig für datenbankabfragen zur tabelle "users" und "orders"
// enthält keine logik, nur sql-zugriffe

class CustomerRepository {
    private mysqli $conn; // verbindung zur datenbank

    // konstruktor bekommt die datenbankverbindung übergeben
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    // gibt alle benutzer mit rolle "customer" zurück
    public function getAllCustomers(): array {
        $query = "SELECT id, username, email, active FROM users WHERE role = 'customer' ORDER BY username ASC";
        $result = $this->conn->query($query);

        if (!$result) {
            throw new Exception("Failed to fetch customers.");
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // setzt den status "active" eines benutzers auf 0 (also deaktiviert)
    public function deactivateCustomer(int $id): bool {
        $stmt = $this->conn->prepare("UPDATE users SET active = 0 WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare deactivation.");
        }

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // setzt den status "active" eines benutzers wieder auf 1 (reaktivieren)
    public function reactivateCustomer(int $id): bool {
        $stmt = $this->conn->prepare("UPDATE users SET active = 1 WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare reactivation.");
        }
    
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    

    // holt alle bestellungen und produkte eines bestimmten kunden
    public function getOrdersByCustomer(int $customerId): array {
        // bestellungen und produkte aus mehreren tabellen
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

    // entfernt ein produkt aus einer bestimmten bestellung
    public function removeProductFromOrder(int $orderId, int $productId): bool {
        $stmt = $this->conn->prepare("DELETE FROM order_items WHERE order_id = ? AND product_id = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare delete statement.");
        }

        $stmt->bind_param("ii", $orderId, $productId);
        return $stmt->execute();
    }
}
