<?php
// Service Layer für Produkte

require_once __DIR__ .  '../repositories/ProductRepository.php';

class ProductService {
    private $productRepository;
    private $repo;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->repo = new ProductRepository($this->conn);
        $this->productRepository = new ProductRepository($conn);
    }
          

    public function getProducts($search = null, $categoryId = null) {
        return $this->repo->getFilteredProducts($search, $categoryId);
    }

    public function getAll($search = null, $categoryId = null) {
        $query = "SELECT * FROM products WHERE 1=1";
        $params = [];
        $types = "";
    
        if ($search) {
            $query .= " AND (
                name LIKE ? OR
                description LIKE ? OR
                colour LIKE ? OR
                gender LIKE ?
            )";
            $wildcard = '%' . $search . '%';
            $params = [$wildcard, $wildcard, $wildcard, $wildcard];
            $types .= "ssss";
        }
    
        if ($categoryId) {
            $query .= " AND category_id = ?";
            $params[] = $categoryId;
            $types .= "i";
        }
    
        $stmt = $this->conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
