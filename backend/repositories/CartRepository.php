<?php
// repository layer = spricht direkt mit der datenbank
class CartRepository {
    private $conn; // datenbankverbindung

     // constructor bekommt die verbindung übergeben
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // holt produktdaten für mehrere produkt-ids
    public function getProductsByIds(array $ids) {
        
        // wenn keine ids übergeben wurden, gib leeres array zurück
        if (empty($ids)) {
            return [];
        }

         // erstelle platzhalter (z. b. ?,?,?) für prepared statement
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        
        // bestimme typen für bind_param (i = integer)
        $types = str_repeat('i', count($ids));

        // statement vorbereiten
        $stmt = $this->conn->prepare("SELECT id, name, price, image FROM products WHERE id IN ($placeholders)");

        // fehlerbehandlung, falls prepare schiefgeht
        if ($stmt === false) {
            throw new Exception('Datenbankfehler beim Prepare.');
        }

        // ids einbinden und statement ausführen
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $result = $stmt->get_result();

        // alle ergebnisse als array zurückgeben
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}