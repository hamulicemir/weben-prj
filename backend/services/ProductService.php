<?php
// Service Layer für Produkte

require_once __DIR__ .  '/../repositories/ProductRepository.php';

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

    public function createProduct(array $data, string $imagePath): bool
    {
        $stmt = $this->conn->prepare("
            INSERT INTO products (name, description, price, rating, gender, colour, image, stock, category_id, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
    
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
    
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = (float)($data['price'] ?? 0);
        $rating = (float)($data['rating'] ?? 0);
        $gender = $data['gender'] ?? '';
        $colour = $data['colour'] ?? '';
        $stock = (int)($data['stock'] ?? 0);
        $categoryId = (int)($data['category_id'] ?? 0);
    
        $stmt->bind_param("sssdsssii", $name, $description, $price, $rating, $gender, $colour, $imagePath, $stock, $categoryId);
        return $stmt->execute();
    }
    
    public function updateProduct(array $data, string $imagePath): bool
    {
        $id = (int)($data['id'] ?? 0);
        if ($id <= 0) {
            return false;
        }
    
        // Falls kein neues Bild hochgeladen wurde → altes Bild beibehalten
        if (!$imagePath || $imagePath === "/weben-prj/frontend/assets/img/products/no-image-available.jpg") {
            $stmtImg = $this->conn->prepare("SELECT image FROM products WHERE id = ?");
            $stmtImg->bind_param("i", $id);
            $stmtImg->execute();
            $result = $stmtImg->get_result();
            $row = $result->fetch_assoc();
            $imagePath = $row['image'] ?? "/weben-prj/frontend/assets/img/products/no-image-available.jpg";
        }
    
        $stmt = $this->conn->prepare("
            UPDATE products
            SET name = ?, description = ?, price = ?, rating = ?, gender = ?, colour = ?, image = ?, stock = ?, category_id = ?, updated_at = NOW()
            WHERE id = ?
        ");
    
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
    
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = (float)($data['price'] ?? 0);
        $rating = (float)($data['rating'] ?? 0);
        $gender = $data['gender'] ?? '';
        $colour = $data['colour'] ?? '';
        $stock = (int)($data['stock'] ?? 0);
        $categoryId = (int)($data['category_id'] ?? 0);
    
        $stmt->bind_param("sssdsssiii", $name, $description, $price, $rating, $gender, $colour, $imagePath, $stock, $categoryId, $id);
        return $stmt->execute();
    }
    
    public function deleteProduct(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
    
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    
}
