<?php
class Voucher {
    public int $id;
    public string $code;
    public float $amount;
    public string $expiration_date;
    public bool $used;

    public function __construct($id, $code, $amount, $expiration_date, $used) {
        $this->id = $id;
        $this->code = $code;
        $this->amount = $amount;
        $this->expiration_date = $expiration_date;
        $this->used = $used;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'amount' => $this->amount,
            'expiration_date' => $this->expiration_date,
            'used' => $this->used
        ];
    }
}