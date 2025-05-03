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

$stmt = $conn->prepare("SELECT salutation, first_name, last_name, address, postal_code, city, country, email, username, payment_info FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Adresse aufsplitten
$street = $no = $addition = "";
if (preg_match('/^(.*?)[\s]+(\d+[a-zA-Z]*)[,]*[\s]*(.*)?$/', $user['address'], $matches)) {
    $street = $matches[1] ?? '';
    $no = $matches[2] ?? '';
    $addition = $matches[3] ?? '';
}



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

            <h5 class="mt-3">Change Personal Information</h5>

             <div class="mb-3">
                    <label class="form-label"></label><br>
                    <?php foreach (["Ms", "Mr", "Other"] as $s): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="salutation" id="salutation_<?= $s ?>" value="<?= $s ?>" <?= $user['salutation'] === $s ? 'checked' : '' ?>>
                            <label class="form-check-label" for="salutation_<?= $s ?>"><?= $s ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">First name</label>
                    <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Last name</label>
                    <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Street</label>
                        <input type="text" name="street" class="form-control" value="<?= htmlspecialchars($street) ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">No.</label>
                        <input type="text" name="no" class="form-control" value="<?= htmlspecialchars($no) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address Addition (optional)</label>
                    <input type="text" name="addressaddition" class="form-control" value="<?= htmlspecialchars($addition) ?>">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" name="postal_code" class="form-control" value="<?= htmlspecialchars($user['postal_code']) ?>" required>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($user['city']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control" value="<?= htmlspecialchars($user['country']) ?>" required>
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



                <div class="mb-3 position-relative">
                    <label class="form-label">Current password</label>
                    <input type="password" name="current_password" class="form-control pe-5" id="current_password">
                    <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2"
                            onmousedown="togglePassword('current_password', true)"
                            onmouseup="togglePassword('current_password', false)"
                            onmouseleave="togglePassword('current_password', false)">
                        Show
                    </button>
                </div>


                <div class="mb-3 position-relative">
                    <label class="form-label">New password</label>
                    <input type="password" name="password1" class="form-control pe-5" id="password1">
                    <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2"
                            onmousedown="togglePassword('password1', true)"
                            onmouseup="togglePassword('password1', false)"
                            onmouseleave="togglePassword('password1', false)">
                        Show
                    </button>
                </div>

                <div class="mb-3 position-relative">
                    <label class="form-label">Repeat new password</label>
                    <input type="password" name="password2" class="form-control pe-5" id="password2">
                    <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2"
                            onmousedown="togglePassword('password2', true)"
                            onmouseup="togglePassword('password2', false)"
                            onmouseleave="togglePassword('password2', false)">
                        Show
                    </button>
                </div>

                <button type="submit" class="btn btn-dark">Save Changes</button>
                <aef="user-account.php" class="btn btn-outline-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(id, show) {
    const input = document.getElementById(id);
    input.type = show ? 'text' : 'password';
}
</script>

<?php include '../includes/footer.php'; ?>
</body>
</html>
