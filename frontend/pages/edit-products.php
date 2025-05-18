<?php
require_once("../../backend/config/config.php");
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="../assets/js/edit-products.js"></script>
</head>

<body>
    <?php include '../components/navbar.php'; ?>

    <div class="container py-5">
        <h2>Manage Products</h2>
        <p class="fs-4">Here you can manage your products. You can add, edit, and delete products.</p>

        <form id="productForm" enctype="multipart/form-data" class="row g-3 mb-5">
            <input type="hidden" name="id" id="productId">
            <input type="hidden" name="action" value="create" id="formAction">

            <div class="col-md-6">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Price (€)</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Rating (0–5)</label>
                <input type="number" step="0.1" name="rating" min="0" max="5" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="">Select gender</option>
                    <option value="men">Men</option>
                    <option value="women">Women</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required id="categorySelect">
                    <option value="">Select category</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Colour</label>
                <input type="text" name="colour" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" min="0" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Image</label>
                <input type="file" name="image" accept="image/*" class="form-control">
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <img id="imagePreview" src="../assets/img/products/no-image-available.jpg" alt="Preview"
                    style="max-height: 100px; max-width: 100%; border: 1px solid #ccc;">
            </div>

            <!-- Aktionsbuttons -->
            <div class="col-12 d-flex gap-2">
                <button type="submit" id="createBtn" class="btn btn-success">Create Product</button>
                <button type="submit" id="updateBtn" class="btn btn-warning d-none">Change Product</button>
                <button type="button" id="cancelBtn" class="btn btn-secondary d-none">Delete Product</button>
            </div>


            <div id="productList" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"></div>
    </div>
</body>

</html>