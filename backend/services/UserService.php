<?php
require_once __DIR__ . '../repositories/UserRepository.php';

class UserService {
    private $repo;

    public function __construct($conn) {
        $this->repo = new UserRepository($conn);
    }

    public function createUser($data) {
        if (!isset($data['password']) || !isset($data['confirm_password']) || $data['password'] !== $data['confirm_password']) {
            return ['status' => 'error', 'message' => 'Passwörter stimmen nicht überein'];
        }

        $user = new User($data);
        return $this->repo->create($user);
    }

    public function listUsers() {
        return $this->repo->findAll();
    }    

    public function getCurrentUser() {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            http_response_code(401);
            return ['status' => 'error', 'message' => 'Nicht eingeloggt'];
        }
    
        $userId = $_SESSION['user']['id'];
        $user = $this->repo->findById($userId);
    
        if (!$user) {
            http_response_code(404);
            return ['status' => 'error', 'message' => 'User nicht gefunden'];
        }
    
        // Entferne sensible Felder, z. B. Passwort
        unset($user['password']);
    
        return ['status' => 'success', 'user' => $user];
    }

    public function updateUser($id, $data) {
        return $this->repo->update($id, $data) ?
            ['status' => 'success'] :
            ['status' => 'error', 'message' => 'Update fehlgeschlagen'];
    }

    public function deleteUser($id) {
        return $this->repo->delete($id) ?
            ['status' => 'success'] :
            ['status' => 'error', 'message' => 'Löschen fehlgeschlagen'];
    }
}
