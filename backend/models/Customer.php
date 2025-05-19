<?php
// klasse customer repräsentiert einen einfachen kunden
class Customer {
    public int $id;
    public string $username;
    public string $email;
    public bool $active;

    // konstruktor – wird beim erstellen eines kunden-objekts aufgerufen
    public function __construct($id, $username, $email, $active) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->active = $active;
    }

     // wandelt das objekt in ein array um
    public function toArray(): array {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'active' => $this->active
        ];
    }
}
