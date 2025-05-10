<?php

class Order {
    public $id;
    public $user_id;
    public $payment_method;
    public $shipping_method;
    public $cart;
    public $total_price;
    public $created_at;

    public function __construct($data) {
        $this->user_id = $data['user_id'];
        $this->payment_method = $data['payment'];
        $this->shipping_method = $data['shipping'];
        $this->cart = json_encode($data['cart'] ?? []);
        $this->created_at = date('Y-m-d H:i:s');
    
        $this->total_price = $this->calculateTotal($data['cart'] ?? []);
    }
    
    private function calculateTotal($cart) {
        $total = 5;
        foreach ($cart as $item) {
            if (isset($item['price']) && isset($item['quantity'])) {
                $total += $item['price'] * $item['quantity'];
            }
        }
        return number_format($total, 2, '.', '');
    }
    
}
?>