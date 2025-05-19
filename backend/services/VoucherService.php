<?php

// lädt das repository für die datenbankzugriffe
require_once __DIR__ . '/../repositories/VoucherRepository.php'; 

class VoucherService
{
    private $repo;

    // beim erstellen wird die datenbankverbindung an das repository übergeben
    public function __construct($conn)
    {
        $this->repo = new VoucherRepository($conn);
    }

    // erstellt einen neuen gutschein
    public function createVoucher(string $code, float $amount, string $expiration_date): bool
    {
        return $this->repo->addVoucher($code, $amount, $expiration_date);
    }

    // gibt alle gutscheine zurück
    public function getAllVouchers(): array
    {
        return $this->repo->getAllVouchers();
    }

    // sucht einen gutschein anhand des codes (als array, nicht als objekt)
    public function getVoucherByCode(string $code): ?array
    {
        $voucher = $this->repo->getVoucherByCode($code);
        return $voucher ?: null;
    }

    // aktualisiert einen bestehenden gutschein
    public function updateVoucher(string $originalCode, string $newCode, float $amount, string $expiration_date): bool
    {
        return $this->repo->updateVoucher($originalCode, $newCode, $amount, $expiration_date);
    }

    // löscht einen gutschein anhand des codes
    public function deleteVoucher(string $code): bool
    {
        return $this->repo->deleteVoucher($code);
    }

    // erzeugt einen zufälligen gutschein-code mit 5 stellen (z.b. "04287")
    public function generateRandomCode(): string
    {
        return str_pad(strval(random_int(0, 99999)), 5, '0', STR_PAD_LEFT);
    }

    // prüft, ob ein gutschein gültig ist (nicht abgelaufen und nicht benutzt)
    public function validateVoucher(string $code): ?Voucher {
        $voucher = $this->repo->findByCode($code);

        // wenn nicht vorhanden oder schon benutzt -> ungültig
        if (!$voucher || $voucher->used) {
            return null;
        }

        // prüft, ob der gutschein abgelaufen ist
        $now = new DateTime();
        $expiration = new DateTime($voucher->expiration_date);

        if ($expiration < $now) {
            return null;
        }

        // wenn alles passt -> gutschein ist gültig
        return $voucher;
    }

}
