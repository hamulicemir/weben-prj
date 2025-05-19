<?php

class OrderRepository
{
    private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function save(Order $order)
    {
        $stmt = $this->conn->prepare("
        INSERT INTO orders (user_id, payment_method, shipping_method, cart, total_price, created_at, voucher_code, voucher_amount)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
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
        return $stmt->execute();
    }

    public function findById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function findAll()
    {
        $result = $this->conn->query("SELECT * FROM orders ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

public function findByUserId($userId, $sort = 'DESC')
{
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


    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getLastInsertId() {
        return $this->conn->insert_id;
    }
    
}
