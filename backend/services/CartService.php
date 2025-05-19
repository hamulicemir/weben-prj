<?php
// service layer = geschäftslogik (logik, die über datenbankzugriffe hinausgeht)

// repository wird eingebunden (für produktdaten)
require_once __DIR__ . '/../repositories/CartRepository.php';

class CartService {
    private $CartRepository;

    // constructor bekommt datenbankverbindung und erstellt repository
    public function __construct($conn) {
        $this->CartRepository = new CartRepository($conn);
    }

    // produkt zum warenkorb hinzufügen (oder menge erhöhen)
    public function addProduct($productId, $quantity) {
        $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + $quantity;
        return ['status' => 'ok', 'cart' => $_SESSION['cart']];
    }

     // produkt aus dem warenkorb entfernen
    public function removeProduct($productId) {
        unset($_SESSION['cart'][$productId]);
        return ['status' => 'ok', 'cart' => $_SESSION['cart']];
    }
    // gesamten warenkorb leeren
    public function clearCart() {
        unset($_SESSION['cart']);
        unset($_SESSION['cart_info']);
        return ['status' => 'ok'];
    }

    // menge eines produkts aktualisieren
    public function updateProduct($productId, $quantity) {
        $_SESSION['cart'][$productId] = $quantity;
        return ['status' => 'ok', 'cart' => $_SESSION['cart']];
    }

    // warenkorb zusammenfassen und berechnen
    public function saveCart() {
        // wenn leer, cart_info löschen
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart_info']);
            return ['status' => 'empty'];
        }

        // produktdaten aus datenbank laden
        $products = $this->CartRepository->getProductsByIds(array_keys($_SESSION['cart']));

        $cart_info = [];
        $cart_info['products'] = [];
        $subtotal = 0;

        // alle produkte durchgehen und summieren
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

        // wenn keine gültigen produkte vorhanden
        if (empty($cart_info['products'])) {
            unset($_SESSION['cart_info']);
            return ['status' => 'empty'];
        }

        // versandkosten fix
        $shipping_fee = 5.00;

        // zusammenfassung speichern
        $cart_info['summary'] = [
            'subtotal' => $subtotal,
            'shipping' => $shipping_fee,
            'total' => $subtotal + $shipping_fee
        ];

         // cart_info in session speichern
        $_SESSION['cart_info'] = $cart_info;

        return ['status' => 'ok'];
    }

    // warenkorb zurückgeben (mit produktdetails)
    public function getCart() {
        // wenn leer, gib leeres array zurück
        if (empty($_SESSION['cart'])) {
            return ['status' => 'ok', 'products' => []];
        }

        // produktdetails aus datenbank
        $products = $this->CartRepository->getProductsByIds(array_keys($_SESSION['cart']));

        // menge hinzufügen
        foreach ($products as &$product) {
            $product['quantity'] = $_SESSION['cart'][$product['id']] ?? 1;
        }

        return ['status' => 'ok', 'products' => $products];
    }
}
