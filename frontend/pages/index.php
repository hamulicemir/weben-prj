<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        p {
            font-size: 40 px;
        }

        .shop-section {
            margin-top: 2rem;
        }

        .shop-section img {
            width: 100%;
            height: auto;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .shop-section a:hover img {
            transform: scale(1.02);
        }

        .newsletter-section {
            text-align: center;
            padding: 4rem 1rem;
            background-color: #fff;
        }

        .newsletter-section h2 {
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .newsletter-section p {
            margin-bottom: 2rem;
        }

        .logo-banner {
            width: 100%;
            margin: 3rem 0;
        }

        .discount-banner {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 1rem;
            font-size: 1rem;
        }

        .btn-link {
            text-decoration: none;
            font-weight: bold;
            border-bottom: 1px solid #000;
        }
    </style>

</head>

<body>
    <?php include '../includes/navbar.php'; ?> <!-- navbar -->

    <main class="container shop-section">
        <div class="row">
            <div class="col-12">
                <img src="../assets/img/products/ICONIQ.svg" alt="ICONIQ Logo" class="logo-banner">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="/shop/women">
                    <img src="../assets/img/products/Index_Women.svg" alt="Shop Women">
                </a>
            </div>
            <div class="col-md-6 mb-4">
                <a href="/shop/men">
                    <img src="../assets/img/products/Index_Men.svg" alt="Shop Men">
                </a>
            </div>
        </div>

        <section>
            <h2>GOOD NEWS</h2>
            <p>Subscribe to our newsletter and get 10% off your first order!</p>

            <form class="form-group col-md-6" action="#" method="post">
                <div class="row">
                    <div class="form-group col-md-12">
                        <input type="email" class="form-control" name="email" placeholder="" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="PP">
                        <button type="submit" class="btn btn-primary btn-block">SUBMIT</button>
                    </div>
                </div>
                <p class="newsletter-caption mt-3">
                    By submitting this form you accept our <a href="#">privacy policy</a>.
                </p>
            </form>

        </section>

    </main>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php include '../includes/footer.php'; ?> <!-- Footer -->
</body>

</html>