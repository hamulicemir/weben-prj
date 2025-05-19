<?php
// diese klasse kümmert sich um alle datenbank-abfragen zur tabelle "orders"
class OrderRepository
{
    private $conn; // diese klasse kümmert sich um alle datenbank-abfragen zur tabelle "orders"

    // beim erstellen wird die datenbankverbindung gespeichert
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

       // speichert eine neue bestellung in die datenbank
    public function save(Order $order)
    {
        $stmt = $this->conn->prepare("
        INSERT INTO orders (user_id, payment_method, shipping_method, cart, total_price, created_at, voucher_code, voucher_amount)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    // übergibt werte aus dem order-objekt an das sql-statement
        $stmt->bind_param(
            "isssdsds",
            $order->user_id,
            $order->payment_method,
            $order->shipping_method,
            $order->cart,
            $order->total_price,
            $order->created_at,
            $order->voucher_code,
            $order->voucher_amount
        );
        return $stmt->execute(); // führt die speicherung aus
    }

    public function findById($id) // holt eine bestimmte bestellung anhand der id
    {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // gibt ein einzelnes datensatz-array zurück
    }

    // holt alle bestellungen, neueste zuerst
    public function findAll()
    {
        $result = $this->conn->query("SELECT * FROM orders ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC); // gibt ein array mit allen bestellungen zurück
    }

    // holt alle bestellungen eines bestimmten benutzers
    public function findByUserId($userId, $sort = 'DESC')
    {
         // sortierung validieren
        $sort = strtoupper($sort);
        if (!in_array($sort, ['ASC', 'DESC'])) {
            $sort = 'DESC';
        }

        $query = "SELECT id, created_at AS order_date, total_price, status FROM orders WHERE user_id = ? ORDER BY created_at $sort";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    // löscht eine bestellung anhand ihrer id
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // gibt die id der zuletzt eingefügten bestellung zurück
    public function getLastInsertId() {
        return $this->conn->insert_id;
    }
    
}
