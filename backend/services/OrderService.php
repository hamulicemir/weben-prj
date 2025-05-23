<?php
// lädt benötigte repository- und model-klassen
require_once __DIR__ . '/../repositories/OrderRepository.php';
require_once __DIR__ . '/../repositories/OrderItemRepository.php';
require_once __DIR__ . '/../repositories/ProductRepository.php';
require_once __DIR__ . '/../models/Order.php';

class OrderService {
    private $repo; // für bestellungen
    private $itemRepo; // für bestellungen
    private $productRepo; // für produkte in bestellungen

    // konstruktor bekommt datenbankverbindung
    public function __construct($conn) {
        $this->repo = new OrderRepository($conn);
        $this->itemRepo = new OrderItemRepository($conn);
        $this->productRepo = new ProductRepository($conn);
    }

    // erstellt eine neue bestellung
    public function createOrder($data) {
        // nur eingeloggte nutzer dürfen bestellen
        if (!isset($_SESSION['user']['id'])) {
            return ['status' => 'error', 'message' => 'Nicht eingeloggt'];
        }

        // nutzer-id zur bestellung hinzufügen
        $data['user_id'] = $_SESSION['user']['id'];
        $voucher = $_SESSION['voucher'] ?? null;
        
        // falls ein gutschein in session gespeichert ist, anhängen
        if ($voucher && isset($voucher['code'], $voucher['amount'])) {
            $data['voucher_code'] = $voucher['code'];
            $data['voucher_amount'] = $voucher['amount'];
        }

        // erstellt bestell-objekt (inkl. berechnung vom preis)
        $order = new Order($data, $this->productRepo);

        // 1. Hauptbestellung speichern (tabelle "orders")
        $success = $this->repo->save($order);
        if (!$success) {
            return ['status' => 'error', 'message' => 'Order speichern fehlgeschlagen'];
        }

        // 2. ID der gespeicherten Bestellung holen
        $orderId = $this->repo->getLastInsertId();
        error_log("ORDER ID: " . $orderId);


        // 3. Jedes Produkt als einzelnes order_item speichern
        $cart = $data['cart'] ?? [];

        foreach ($cart as $productId => $quantity) {
            $product = $this->productRepo->findById($productId);
            if (!$product) {
                error_log("Produkt-ID $productId nicht gefunden – übersprungen.");
                continue;
            }
        
            $price = $product['price'] ?? 0;
            $this->itemRepo->addItem(
                $orderId,
                $productId,
                $quantity,
                $price
            );
            error_log("Produkt $productId hinzugefügt: $quantity Stück à $price");
        }        
        error_log("ORDER ID: $orderId");
        error_log("CART:\n" . print_r($cart, true));
        
        return ['status' => 'success', 'order_id' => $orderId];
    }

    // gibt bestellung nach id zurück
    public function getOrderById($id) {
        if (!$id) {
            return ['status' => 'error', 'message' => 'Keine ID angegeben'];
        }

        $order = $this->repo->findById($id);
        if ($order) {
            return ['status' => 'success', 'order' => $order];
        }

        return ['status' => 'error', 'message' => 'Bestellung nicht gefunden'];
    }

    // alle bestellungen (admins)
    public function getAllOrders() {
        $orders = $this->repo->findAll();
        return ['status' => 'success', 'orders' => $orders];
    }

    public function getOrdersByUserId($userId = null, $sort = 'DESC')
    {
        if (!$userId && isset($_SESSION['user']['id'])) {
            $userId = $_SESSION['user']['id'];
        }

        if (!$userId) {
            return ['status' => 'error', 'message' => 'Kein Benutzer angemeldet'];
        }

        $orders = $this->repo->findByUserId($userId, $sort);
        return ['status' => 'success', 'orders' => $orders];
    }

    public function deleteOrder($id) {
        if (!$id) {
            return ['status' => 'error', 'message' => 'Keine ID übergeben'];
        }

        $success = $this->repo->delete($id);
        return $success
            ? ['status' => 'success', 'message' => 'Bestellung gelöscht']
            : ['status' => 'error', 'message' => 'Löschen fehlgeschlagen'];
    }
}
