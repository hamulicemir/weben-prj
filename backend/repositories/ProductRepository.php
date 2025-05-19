<?php
// repository layer – zuständig für datenbankabfragen rund um produkte

class ProductRepository {
    private $conn; // repository layer – zuständig für datenbankabfragen rund um produkte

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // produkte filtern (z.b. nach suchwort oder kategorie)
    public function getFilteredProducts($search = null, $categoryId = null) {
        // grundabfrage, "1=1" ist platzhalter damit man flexibel erweitern kann
        $query = "SELECT * FROM products WHERE 1=1";
        $params = [];
        $types = "";

        // wenn suchbegriff vorhanden ist -> name, beschreibung, farbe oder geschlecht durchsuchen
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

        // wenn kategorie gefiltert werden soll
        if (!empty($categoryId)) {
            $query .= " AND category_id = ?";
            $params[] = $categoryId;
            $types .= "i";
        }

        // abfrage vorbereiten
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Fehler beim Vorbereiten der Abfrage: " . $this->conn->error);
        }

        // parameter binden, falls vorhanden
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        // abfrage ausführen und ergebnis zurückgeben
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // einzelnes produkt per id holen
    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Fehler beim Vorbereiten der Einzelprodukt-Abfrage: " . $this->conn->error);
        }
    
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // einzelnes produkt zurückgeben
    }

    // neues produkt in die datenbank speichern
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
        return $stmt->execute(); // true bei erfolg
    }
    
}
