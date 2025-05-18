<?php
// Repository Layer

class ProductRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getFilteredProducts($search = null, $categoryId = null) {
        $query = "SELECT * FROM products WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $searchWildcard = '%' . $search . '%';
            $query .= " AND (
                name LIKE ? OR
                description LIKE ? OR
                colour LIKE ? OR
                gender LIKE ?
            )";
            $params = array_fill(0, 4, $searchWildcard);
            $types .= "ssss";
        }

        if (!empty($categoryId)) {
            $query .= " AND category_id = ?";
            $params[] = $categoryId;
            $types .= "i";
        }

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Fehler beim Vorbereiten der Abfrage: " . $this->conn->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Fehler beim Vorbereiten der Einzelprodukt-Abfrage: " . $this->conn->error);
        }
    
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createProduct($data): bool {
        $stmt = $this->conn->prepare("
            INSERT INTO products (name, description, price, rating, gender, colour, image, stock, category_id, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        $stmt->bind_param(
            "sssdsssii",
            $data['name'],
            $data['description'],
            $data['price'],
            $data['rating'],
            $data['gender'],
            $data['colour'],
            $data['image'],
            $data['stock'],
            $data['category_id']
        );
        return $stmt->execute();
    }
    
}
