<?php
require_once __DIR__ . '/User.php';

class UserRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function create(User $user) {
        $stmt = $this->conn->prepare("
            INSERT INTO users (role, salutation, first_name, last_name, address, postal_code, city, country,
                               email, username, password_hash, payment_info, active)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "ssssssssssssi",
            $user->role,
            $user->salutation,
            $user->first_name,
            $user->last_name,
            $user->address,
            $user->postal_code,
            $user->city,
            $user->country,
            $user->email,
            $user->username,
            $user->password_hash,
            $user->payment_info,
            $user->active
        );

        if ($stmt->execute()) {
            return ['status' => 'success', 'id' => $stmt->insert_id];
        } else {
            return ['status' => 'error', 'message' => $stmt->error];
        }
    }

    public function findAll() {
        $result = $this->conn->query("SELECT * FROM users");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function update($id, $data) {
        $fields = [];
        $values = [];

        foreach ($data as $key => $value) {
            if ($key !== 'id') {
                $fields[] = "$key = ?";
                $values[] = $value;
            }
        }
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $values[] = $id;

        $types = str_repeat('s', count($values) - 1) . 'i';
        $stmt->bind_param($types, ...$values);

        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
