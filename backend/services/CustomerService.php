<?php
// lädt das repository, das direkt mit der datenbank arbeitet
require_once __DIR__ . '/../repositories/CustomerRepository.php';

class CustomerService {
    // speichert die repository-instanz
    private CustomerRepository $repo;

      // constructor: bekommt eine datenbankverbindung und erstellt ein repository
    public function __construct($conn) {
        $this->repo = new CustomerRepository($conn);
    }

    // gibt alle kunden aus der datenbank zurück
    public function getAllCustomers(): array {
        return $this->repo->getAllCustomers();
    }

     // deaktiviert einen kunden in der datenbank (z. b. bei kündigung)
    public function deactivateCustomer(int $customerId): bool {
        return $this->repo->deactivateCustomer($customerId);
    }

    // reaktiviert einen kunden
    public function reactivateCustomer(int $customerId): bool {
        return $this->repo->reactivateCustomer($customerId);
    }
    
    // holt alle bestellungen eines kunden
    public function getOrdersByCustomer(int $customerId): array {
        return $this->repo->getOrdersByCustomer($customerId);
    }

    // entfernt ein produkt aus einer bestimmten bestellung
    public function removeProductFromOrder(int $orderId, int $productId): bool {
        return $this->repo->removeProductFromOrder($orderId, $productId);
    }
}
