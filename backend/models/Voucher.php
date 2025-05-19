<?php
// das ist die klasse für einen gutschein (voucher)
class Voucher {
    // eigenschaften (datenfelder) eines gutscheins
    public int $id;
    public string $code;
    public float $amount;
    public string $expiration_date;
    public bool $used;

    // konstruktor: wird beim erstellen eines neuen voucher-objekts aufgerufen
    public function __construct($id, $code, $amount, $expiration_date, $used) {
        $this->id = $id;
        $this->code = $code;
        $this->amount = $amount;
        $this->expiration_date = $expiration_date;
        $this->used = $used;
    }

    // gibt den gutschein als array zurück (praktisch für json)
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