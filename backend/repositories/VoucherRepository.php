<?php
// Repository Layer

require_once __DIR__ . '/Voucher.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/VoucherService.php';

class VoucherRepository
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllVouchers()
    {
        $query = "SELECT id, code, amount, expiration_date, used FROM vouchers ORDER BY expiration_date ASC";
        $result = $this->conn->query($query);

        if (!$result) {
            throw new Exception("Fehler beim Abrufen der Gutscheine.");
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findByCode(string $code): ?Voucher
    {
        $stmt = $this->conn->prepare("SELECT * FROM vouchers WHERE code = ? LIMIT 1");
        if (!$stmt) {
            error_log("MySQL Prepare Error: " . $this->conn->error);
            return null;
        }

        $stmt->bind_param('s', $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if (!$data) {
            return null;
        }

        return new Voucher(
            (int) $data['id'],
            $data['code'],
            (float) $data['amount'],
            $data['expiration_date'],
            (bool) $data['used']
        );
    }


    public function getVoucherByCode(string $code)
    {
        $stmt = $this->conn->prepare("SELECT id, code, amount, expiration_date, used FROM vouchers WHERE code = ?");
        if (!$stmt) {
            throw new Exception("Prepare fehlgeschlagen.");
        }

        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc() ?: null;
    }

    public function addVoucher(string $code, float $amount, string $expiration_date): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO vouchers (code, amount, expiration_date) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare fehlgeschlagen.");
        }

        $stmt->bind_param("sds", $code, $amount, $expiration_date);
        return $stmt->execute();
    }

    public function updateVoucher(string $originalCode, string $newCode, float $amount, string $expiration_date): bool
    {
        $stmt = $this->conn->prepare("UPDATE vouchers SET code = ?, amount = ?, expiration_date = ? WHERE code = ?");
        if (!$stmt) throw new Exception("Prepare fehlgeschlagen (update).");
        $stmt->bind_param("sdss", $newCode, $amount, $expiration_date, $originalCode);
        return $stmt->execute();
    }

    public function deleteVoucher(string $code): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM vouchers WHERE code = ?");
        if (!$stmt) throw new Exception("Prepare fehlgeschlagen (delete).");
        $stmt->bind_param("s", $code);
        return $stmt->execute();
    }
}
