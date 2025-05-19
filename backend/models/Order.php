<?php
// das ist das modell für eine bestellung
class Order {
    // öffentliche eigenschaften, die später gespeichert werden
    public $id;
    public $user_id;
    public $payment_method;
    public $shipping_method;
    public $cart;
    public $total_price;
    public $created_at;
    public $voucher_code;
    public $voucher_amount;

    // private eigenschaft, um auf produkte zugreifen zu können
    private $productRepo;

    // constructor wird aufgerufen, wenn eine neue bestellung erstellt wird
    public function __construct($data, $productRepo) {
        // daten aus dem request oder session zuweisen
        $this->user_id = $data['user_id'];
        $this->payment_method = $data['payment'];
        $this->shipping_method = $data['shipping'];
        $this->cart = json_encode($data['cart'] ?? []); // warenkorb als json speichern
        $this->created_at = date('Y-m-d H:i:s'); // aktuelles datum/zeit
        $this->productRepo = $productRepo;

        $voucherAmount = $data['voucher']['amount'] ?? 0; // gutscheinbetrag holen (falls vorhanden)
        $this->total_price = $this->calculateTotal($data['cart'] ?? [], $voucherAmount); // gesamtpreis berechnen (mit versand, ohne steuer)

         // gutschein-code und betrag speichern (falls vorhanden)
        $this->voucher_code = $data['voucher_code'] ?? null;
        $this->voucher_amount = $data['voucher_amount'] ?? null;
    }

    private function calculateTotal($cart, $voucherAmount = 0) { // hilfsfunktion zum berechnen des gesamtpreises
        $total = 5; // Versandkosten
        foreach ($cart as $productId => $quantity) {
            $product = $this->productRepo->findById($productId); // produkt holen
            if ($product) {
                $total += $product['price'] * $quantity; // preis mal anzahl
            }
        }
        // gutschein abziehen, aber nie unter 0
        return number_format(max(0, $total - $voucherAmount), 2, '.', '');
    }
}
