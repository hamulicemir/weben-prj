<?php
// Service Layer
require_once __DIR__ . '/ProductRepository.php';

class CartService {
    private $productRepository;

    public function __construct($conn) {
        $this->productRepository = new ProductRepository($conn);
    }

    public function addProduct($productId, $quantity) {
        $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + $quantity;
        return ['status' => 'ok', 'cart' => $_SESSION['cart']];
    }

    public function removeProduct($productId) {
        unset($_SESSION['cart'][$productId]);
        return ['status' => 'ok', 'cart' => $_SESSION['cart']];
    }

    public function clearCart() {
        unset($_SESSION['cart']);
        unset($_SESSION['cart_info']);
        return ['status' => 'ok'];
    }

    public function updateProduct($productId, $quantity) {
        $_SESSION['cart'][$productId] = $quantity;
        return ['status' => 'ok', 'cart' => $_SESSION['cart']];
    }

    public function saveCart() {
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart_info']);
            return ['status' => 'empty'];
        }

        $products = $this->productRepository->getProductsByIds(array_keys($_SESSION['cart']));

        $cart_info = [];
        $cart_info['products'] = [];
        $subtotal = 0;

        foreach ($products as $product) {
            $productId = (int)$product['id'];
            $quantity = (int)($_SESSION['cart'][$productId] ?? 0);

            if ($quantity <= 0) continue;

            $price = (float)$product['price'];
            $total_price = $price * $quantity;

            $cart_info['products'][] = [
                'id' => $productId,
                'name' => $product['name'],
                'price' => $price,
                'quantity' => $quantity,
                'total_price' => $total_price,
                'image' => $product['image'] ?? '../assets/img/products/no-image-available.jpg'
            ];

            $subtotal += $total_price;
        }

        if (empty($cart_info['products'])) {
            unset($_SESSION['cart_info']);
            return ['status' => 'empty'];
        }

        $shipping_fee = 5.00;

        $cart_info['summary'] = [
            'subtotal' => $subtotal,
            'shipping' => $shipping_fee,
            'total' => $subtotal + $shipping_fee
        ];

        $_SESSION['cart_info'] = $cart_info;

        return ['status' => 'ok'];
    }

    public function getCart() {
        if (empty($_SESSION['cart'])) {
            return ['status' => 'ok', 'products' => []];
        }

        $products = $this->productRepository->getProductsByIds(array_keys($_SESSION['cart']));

        foreach ($products as &$product) {
            $product['quantity'] = $_SESSION['cart'][$product['id']] ?? 1;
        }

        return ['status' => 'ok', 'products' => $products];
    }
}
