<?php

require_once __DIR__ . '/../repositories/VoucherRepository.php';

class VoucherService
{
    private $repo;

    public function __construct($conn)
    {
        $this->repo = new VoucherRepository($conn);
    }

    public function createVoucher(string $code, float $amount, string $expiration_date): bool
    {
        return $this->repo->addVoucher($code, $amount, $expiration_date);
    }

    public function getAllVouchers(): array
    {
        return $this->repo->getAllVouchers();
    }

    public function getVoucherByCode(string $code): ?array
    {
        $voucher = $this->repo->getVoucherByCode($code);
        return $voucher ?: null;
    }

    public function updateVoucher(string $originalCode, string $newCode, float $amount, string $expiration_date): bool
    {
        return $this->repo->updateVoucher($originalCode, $newCode, $amount, $expiration_date);
    }

    public function deleteVoucher(string $code): bool
    {
        return $this->repo->deleteVoucher($code);
    }

    public function generateRandomCode(): string
    {
        return str_pad(strval(random_int(0, 99999)), 5, '0', STR_PAD_LEFT);
    }

    public function validateVoucher(string $code): ?Voucher {
        $voucher = $this->repo->findByCode($code);

        if (!$voucher || $voucher->used) {
            return null;
        }

        $now = new DateTime();
        $expiration = new DateTime($voucher->expiration_date);

        if ($expiration < $now) {
            return null;
        }

        return $voucher;
    }

}
