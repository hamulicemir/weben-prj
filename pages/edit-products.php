<?php
require_once("../includes/config.php");
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Products</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script defer src="../assets/js/edit-products.js"></script>
</head>

<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="container py-5">
        <h2>Manage Products</h2>

        <form id="productForm" enctype="multipart/form-data" class="row g-3 mb-5">
    <input type="hidden" name="id" id="productId">
    <input type="hidden" name="action" value="create" id="formAction">

    <div class="col-md-6">
        <input type="text" name="name" class="form-control" placeholder="Product Name" required>
    </div>
    <div class="col-md-6">
        <input type="number" step="0.01" name="price" class="form-control" placeholder="Price" required>
    </div>
    <div class="col-md-6">
        <input type="number" step="0.1" name="rating" min="0" max="5" class="form-control" placeholder="Rating" required>
    </div>
    <div class="col-md-6">
        <input type="file" name="image" accept="image/*" class="form-control">
    </div>
    <div class="col-12">
        <textarea name="description" rows="2" class="form-control" placeholder="Description"></textarea>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-dark">Save</button>
    </div>
</form>

<div id="productList" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"></div>
    </div>
</body>

</html>