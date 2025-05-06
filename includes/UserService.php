<?php
require_once __DIR__ . '/UserRepository.php';

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
