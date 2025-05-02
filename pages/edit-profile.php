<?php
require_once("../includes/config.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION['user']['id'] ?? null;
if (!$userId) {
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT first_name, last_name, email, username, payment_info FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile - ICONIQ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/navbar.php'; ?>

<main class="container py-5">
    <h2 class="mb-4">Edit Profile</h2>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($_SESSION['errors'] as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; unset($_SESSION['errors']); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="../includes/profile-update-handler.php" method="POST" class="fs-5">

                <div class="mb-3">
                    <label class="form-label">First name</label>
                    <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Last name</label>
                    <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Info (IBAN)</label>
                    <input type="text" name="payment_info" class="form-control" value="<?= htmlspecialchars($user['payment_info']) ?>">
                </div>

                <hr>
                <h5 class="mt-4">Change Password</h5>

                <div class="mb-3">
                    <label class="form-label">Current password</label>
                    <input type="password" name="current_password" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">New password</label>
                    <input type="password" name="password1" class="form-control" minlength="6">
                </div>

                <div class="mb-3">
                    <label class="form-label">Repeat new password</label>
                    <input type="password" name="password2" class="form-control" minlength="6">
                </div>

                <button type="submit" class="btn btn-dark">Save Changes</button>
                <a href="user-account.php" class="btn btn-outline-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html>
