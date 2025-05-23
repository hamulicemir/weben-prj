<?php
// lädt das repository für user
require_once __DIR__ . '/../repositories/UserRepository.php';

// die service-klasse verarbeitet business-logik für benutzer
class UserService {
    private $repo;

    // konstruktor bekommt datenbankverbindung und erstellt das repository
    public function __construct($conn) {
        $this->repo = new UserRepository($conn);
    }

    // erstellt einen neuen benutzer
    public function createUser($data) {
        // prüft, ob passwörter vorhanden sind und übereinstimmen
        if (!isset($data['password']) || !isset($data['confirm_password']) || $data['password'] !== $data['confirm_password']) {
            return ['status' => 'error', 'message' => 'Passwörter stimmen nicht überein'];
        }

        $user = new User($data); // erstellt ein neues user-objekt
        return $this->repo->create($user); // gibt das ergebnis vom repository zurück
    }

    public function listUsers() { // gibt alle benutzer zurück
        return $this->repo->findAll();
    }    

    public function getCurrentUser() { // holt den aktuell eingeloggten benutzer aus der session
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) { // prüft, ob session vorhanden ist
            http_response_code(401);
            return ['status' => 'error', 'message' => 'Nicht eingeloggt'];
        }
    
        $userId = $_SESSION['user']['id']; 
        $user = $this->repo->findById($userId); // benutzer aus datenbank holen
    
        if (!$user) {
            http_response_code(404);
            return ['status' => 'error', 'message' => 'User nicht gefunden'];
        }
    
        // Entferne sensible Felder, z. B. Passwort
        unset($user['password']);
    
        return ['status' => 'success', 'user' => $user];
    }

    // benutzer aktualisieren
    public function updateUser($id, $data) {
        return $this->repo->update($id, $data) ?
            ['status' => 'success'] :
            ['status' => 'error', 'message' => 'Update fehlgeschlagen'];
    }

    // benutzer löschen
    public function deleteUser($id) {
        return $this->repo->delete($id) ?
            ['status' => 'success'] :
            ['status' => 'error', 'message' => 'Löschen fehlgeschlagen'];
    }


    public function getUserForEditProfile() {
    if (!isset($_SESSION['user']['id'])) {
        return ['status' => 'error', 'message' => 'Nicht eingeloggt'];
    }

    $user = $this->repo->findById($_SESSION['user']['id']);

    if (!$user) {
        return ['status' => 'error', 'message' => 'Benutzer nicht gefunden'];
    }

    // Adresse aufsplitten
    [$street, $no, $addition] = $this->splitAddress($user['address'] ?? '');

    // Neue Felder einfügen
    $user['street'] = $street;
    $user['no'] = $no;
    $user['address_addition'] = $addition;

    // Optional: Passwort nicht mitsenden
    unset($user['password_hash']);

    return ['status' => 'success', 'user' => $user];
}


private function splitAddress($address) {
    $street = $no = $addition = "";
    if (preg_match('/^(.*?)[\s]+(\d+[a-zA-Z]*)[,]*[\s]*(.*)?$/', $address, $matches)) {
        $street = $matches[1] ?? '';
        $no = $matches[2] ?? '';
        $addition = $matches[3] ?? '';
    }
    return [$street, $no, $addition];
}

}
