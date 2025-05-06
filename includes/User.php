<?php

class User {
    public $id;
    public $role;
    public $salutation;
    public $first_name;
    public $last_name;
    public $address;
    public $postal_code;
    public $city;
    public $country;
    public $email;
    public $username;
    public $password_hash;
    public $payment_info;
    public $created_at;
    public $updated_at;
    public $active;

    public function __construct(array $data) {
        $this->role = $data['role'] ?? 'customer';
        $this->salutation = $data['salutation'] ?? null;
        $this->first_name = $data['first_name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->postal_code = $data['postal_code'] ?? null;
        $this->city = $data['city'] ?? null;
        $this->country = $data['country'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->payment_info = $data['payment_info'] ?? null;
        $this->active = $data['active'] ?? 1;
        $this->password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
    }
}
