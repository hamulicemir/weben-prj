<?php

class Customer {
    public int $id;
    public string $username;
    public string $email;
    public bool $active;

    public function __construct($id, $username, $email, $active) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->active = $active;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'active' => $this->active
        ];
    }
}
