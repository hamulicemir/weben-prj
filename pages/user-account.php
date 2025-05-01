<?php 
require_once("../includes/config.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hier echte Benutzer-ID verwenden
$userId = $_SESSION['user']['id'] ?? null;

if (!$userId) {
    header("Location: login.php");
    exit;
}

// Daten holen
$stmt = $conn->prepare("SELECT first_name, last_name, email, username, payment_info FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Bestellungen laden
$orderStmt = $conn->prepare("SELECT id, created_at AS order_date, total_price, status FROM orders WHERE user_id = ?");
if (!$orderStmt) {
    die("SQL-Fehler: " . $conn->error);
}
$orderStmt->bind_param("i", $userId);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();
$orders = $orderResult->fetch_all(MYSQLI_ASSOC);


function maskIBAN($iban) {
    if (!$iban) return "-";
    return substr($iban, 0, 4) . str_repeat("*", strlen($iban) - 8) . substr($iban, -4);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - My Account</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<?php include '../includes/navbar.php'; ?> <!-- navbar -->

<main class="container py-5">
    <h2 class="mb-4">My Account</h2>

    <!-- User info -->
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5 class="card-title fs-3">Profile Information</h5>
            <div class="table-responsive">
            <table class="table table-borderless fs-5">
                <tr><th>First name:</th><td><?= htmlspecialchars($user['first_name']) ?></td></tr>
                <tr><th>Last name:</th><td><?= htmlspecialchars($user['last_name']) ?></td></tr>
                <tr><th>Email:</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
                <tr><th>Username:</th><td><?= htmlspecialchars($user['username']) ?></td></tr>
                <tr><th>Payment method:</th>
                    <td><?= maskIBAN($user['payment_info']) ?>
                        <a href="edit_account.php" class="btn btn-sm btn-outline-secondary ms-2">Edit</a>
                    </td>
                </tr>
            </table>
            <a href="edit_account.php" class="btn btn-dark">Edit Profile</a>
            </div>
        </div>
    </div>

    <!-- Orders-->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title fs-3">My Orders</h5>
            <?php if (empty($orders)): ?>
                <p class="text-muted">No orders found.</p>
            <?php else: ?>
                <ul class="list-group list-group-item-light fs-5">
                    <?php foreach ($orders as $order): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Order #<?= $order['id'] ?></strong><br>
                                <small><?= date("d.m.Y", strtotime($order['order_date'])) ?></small>
                            </div>
                            <span class="badge bg-dark rounded-pill">
                                € <?= number_format($order['total_price'], 2, ',', '.') ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</main>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<?php include '../includes/footer.php'; ?> <!-- Footer -->
</body>
</html>