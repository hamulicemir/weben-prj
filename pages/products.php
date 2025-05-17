<?php session_start(); ?>
<!--Live Search-->
<?php
$searchQuery = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - Products</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include '../includes/navbar.php'; ?> <!-- navbar -->
    <main class="py-5" data-search="<?= $searchQuery ?>">

        <div class="container">
            <select id="categorySelect" class="form-select mb-3" style="max-width: 300px;">
            </select>

            <div id="product-list" class="row"></div>
        </div>

    </main>

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="modalImage" class="img-fluid mb-4 d-block mx-auto" alt="Produktbild">

                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="fs-4 mb-0" id="modalTitle">Produktname</h5>

                        <p class="fw-bold fs-4 mb-0 text-center flex-grow-1" id="modalPrice">€99,99</p>

                        <button class="btn btn-md btn-outline-dark" id="addToCartBtn">
                            <i class="bi bi-cart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div id="cartToast" class="toast align-items-center text-bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Produkt wurde dem Warenkorb hinzugefügt!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Schließen"></button>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?> <!-- Footer -->


    <script src="../assets/js/products.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>