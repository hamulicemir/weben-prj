<?php
class Order {
    public $id;
    public $user_id;
    public $payment_method;
    public $shipping_method;
    public $cart;
    public $total_price;
    public $created_at;

    private $productRepo;

    public function __construct($data, $productRepo) {
        $this->user_id = $data['user_id'];
        $this->payment_method = $data['payment'];
        $this->shipping_method = $data['shipping'];
        $this->cart = json_encode($data['cart'] ?? []);
        $this->created_at = date('Y-m-d H:i:s');
        $this->productRepo = $productRepo;

        $voucherAmount = $data['voucher']['amount'] ?? 0;
        $this->total_price = $this->calculateTotal($data['cart'] ?? [], $voucherAmount);
    }

    private function calculateTotal($cart, $voucherAmount = 0) {
        $total = 5; // Versandkosten
        foreach ($cart as $productId => $quantity) {
            $product = $this->productRepo->findById($productId);
            if ($product) {
                $total += $product['price'] * $quantity;
            }
        }
        return number_format(max(0, $total - $voucherAmount), 2, '.', '');
    }
}
