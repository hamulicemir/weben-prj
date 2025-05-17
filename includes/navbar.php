<?php require_once("config.php"); ?>
<nav class="navbar navbar-expand-md navbar-light bg-white sticky-top border-bottom" data-bs-theme="light">
    <div class="container-fluid">
        <!-- Toggler für Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Offcanvas Menü für Mobile -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">ICONIQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link underline-hover" href="../pages/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link underline-hover" href="../pages/products.php">Products</a></li>
                </ul>
            </div>
        </div>

        <!-- Brand/Logo -->
        <a class="navbar-brand position-absolute start-50 translate-middle-x" href="../pages/index.php"
            style="font-size: 32px; font-weight: bold">ICONIQ</a>

        <!-- Suchleiste und Icons -->
        <div class="d-flex align-items-center">

            <!-- Such-Icon (nur im Mobile-Modus sichtbar) -->
            <a class="nav-link me-3 d-md-none cursor-hover" href="#" id="searchIcon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search"
                    viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </a>

            <!-- Suchleiste (nur im Desktop-Modus sichtbar) -->
            <form id="searchForm" class="d-flex me-3 d-none d-md-block" role="search">
                <input class="form-control" type="search" placeholder="Search" id="searchInput" aria-label="Search">
            </form>

            <!-- Benutzer-Dropdown (JS-basiert) -->
            <div class="dropdown me-3" id="userDropdownWrapper" style="display: none;">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-1 cursor-hover" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person"
                        viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 
                        1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 
                        10.68 10.289 10 8 10s-3.516.68-4.168 
                        1.332c-.678.678-.83 1.418-.832 1.664z" />
                    </svg>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow rounded-3 mt-2" id="userDropdownMenu" aria-labelledby="userDropdown">
                    <!-- Inhalte per JS -->
                </ul>
            </div>

            <!-- Warenkorb Icon -->
            <a class="nav-link cursor-hover position-relative" id="navbarCartIcon" href="../pages/cart.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart"
                    viewBox="0 0 16 16">
                    <path
                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                </svg>
                <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    0
                </span>
            </a>

        </div>
    </div>

    <!-- Zweite Zeile für das Suchfeld (nur im Mobile-Modus sichtbar) -->
    <div class="container-fluid d-md-none" id="searchBox" style="display: none;">
        <form id="searchForm" class="d-flex mt-2" role="search">
            <input class="form-control" type="search" placeholder="Search" id="searchInput" aria-label="Search">
        </form>
    </div>
</nav>
<script src="../assets/js/navbar.js"></script>
<style src="../assets/css/navbar-style.css"></style>