<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - Login</title>
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden; /* Verhindert Scrollen */
        }
        .form-check-input:checked {
            background-color: black;
            border-color: black;
        }
    </style>
</head>
<body>
<?php include '../includes/navbar.php'; ?> <!-- navbar -->
<section class="py-3 py-md-5 py-xl-8 d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card border-0 rounded-4 shadow">
            <div class="card-body p-3 p-md-4 p-xl-5">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-4 text-center">
                            <p class="mb-0" style="font-size: 26px; font-weight: bold">Log In</p>
                        </div>
                    </div>
                </div>
                <form action="#!">
                    <div class="row gy-3 overflow-hidden">
                        <div class="col-12">
                            <div class="form-floating mb-2"> <!-- Eventuell ändern auf E-Mail oder Username-->
                                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                                <label for="email" class="form-label">E-Mail</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                <label for="password" class="form-label">Password</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="remember_me" id="remember_me">
                                <label class="form-check-label text-secondary" for="remember_me">
                                    Keep me logged in
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-grid">
                                <button class="btn btn-outline-dark btn-lg fw-bold" type="submit">Log in</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between gap-2 gap-md-4 flex-column flex-md-row mt-4">
                            <a class="text-muted fw-bold" href="#!">Forgot password?</a>
                            <a class="text-muted fw-bold" href="../pages/signup.php">Don't have an account?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>