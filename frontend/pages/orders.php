<?php
require_once("../includes/config.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - My Orders</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <?php include '../includes/navbar.php'; ?> <!-- navbar -->

    <main class="container py-5">
        <h2 class="mb-4">My Account</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fs-3 mb-0">My Orders</h5>
                    <!-- Dropdown zur Sortierung -->
                    <select id="sortSelect" class="form-select form-select-sm w-auto">
                        <option value="desc" selected>Newest first</option>
                        <option value="asc">Oldest first</option>
                    </select>
                </div>
                <ul class="list-group list-group-item-light fs-5" id="orderList"></ul>
                <p id="noOrdersMsg" class="text-muted d-none">No orders found.</p>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../assets/js/orders.js" defer></script>

    <?php include '../includes/footer.php'; ?> <!-- Footer -->
</body>

</html>