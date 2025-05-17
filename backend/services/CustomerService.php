<?php

require_once __DIR__ . '/../repositories/CustomerRepository.php';

class CustomerService {
    private CustomerRepository $repo;

    public function __construct($conn) {
        $this->repo = new CustomerRepository($conn);
    }

    public function getAllCustomers(): array {
        return $this->repo->getAllCustomers();
    }

    public function deactivateCustomer(int $customerId): bool {
        return $this->repo->deactivateCustomer($customerId);
    }

    public function reactivateCustomer(int $customerId): bool {
        return $this->repo->reactivateCustomer($customerId);
    }
    

    public function getOrdersByCustomer(int $customerId): array {
        return $this->repo->getOrdersByCustomer($customerId);
    }

    public function removeProductFromOrder(int $orderId, int $productId): bool {
        return $this->repo->removeProductFromOrder($orderId, $productId);
    }
}
