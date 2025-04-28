<?php
// Repository Layer
class ProductRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getProductsByIds(array $ids) {
        if (empty($ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $stmt = $this->conn->prepare("SELECT id, name, price, image FROM products WHERE id IN ($placeholders)");

        if ($stmt === false) {
            throw new Exception('Datenbankfehler beim Prepare.');
        }

        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}