<?php
require_once("config.php");
?>

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
                    <?php if (!isset($_SESSION['user'])): ?>
                        <li class="nav-item"><a class="nav-link underline-hover" href="../pages/index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link underline-hover" href="../pages/products.php">Products</a></li>
                    <?php elseif ($_SESSION['user']['role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link underline-hover" href="../pages/index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link underline-hover" href="../pages/products.php">Products</a></li>
                        <li class="nav-item"><a class="nav-link underline-hover" href="../pages/edit-products.php">Edit Products</a></li>
                        <li class="nav-item"><a class="nav-link underline-hover" href="../pages/edit-users.php"> Edit Users</a></li>
                        <li class="nav-item"><a class="nav-link underline-hover" href="../pages/vouchers.php">Handle Vouchers</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link underline-hover" href="../pages/index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link underline-hover" href="../pages/products.php">Products</a></li>
                        <li class="nav-item"><a class="nav-link underline-hover" href="../pages/user-account.php">My Account</a></li>
                    <?php endif; ?>
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

            <!-- Benutzer-Login/Name -->
            <?php if (isset($_SESSION['user'])): ?>
                <a class="nav-link me-3 cursor-hover d-flex align-items-center gap-1" href="../pages/user-account.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person"
                        viewBox="0 0 16 16" >
                        <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                    </svg>
                    <?= htmlspecialchars($_SESSION['user']['username']) ?>
            </a>
                <a class="nav-link me-3 cursor-hover" href="../includes/logout.php">Logout</a>
            <?php else: ?>
                <a class="nav-link me-3 cursor-hover" href="../pages/login.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person"
                        viewBox="0 0 16 16">
                        <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                    </svg>
                    Login
                </a>
            <?php endif; ?>

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

<script>
    // JavaScript, um das Suchfeld ein- und auszublenden im Mobile-Modus
    document.getElementById('searchIcon').addEventListener('click', function (event) {
        event.preventDefault();
        const searchBox = document.getElementById('searchBox');
        searchBox.style.display = (searchBox.style.display === 'none') ? 'block' : 'none';
    });

    // Führt den Code aus, sobald das DOM vollständig geladen ist
    document.addEventListener("DOMContentLoaded", function () {

    // Holt das Suchformular und das Eingabefeld aus dem DOM
    const searchForm = document.getElementById("searchForm");
    const searchInput = document.getElementById("searchInput");

    // Nur wenn das Formular existiert, wird der Submit-Handler registriert
    if (searchForm) {
      searchForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Verhindert das Standardverhalten (Seitenreload)

        const query = searchInput.value.trim(); // Holt und bereinigt die Suchanfrage

        // Falls eine Eingabe vorhanden ist, leite zur Produktseite mit Such-Query weiter
        if (query) {
          window.location.href = "../pages/products.php?search=" + encodeURIComponent(query);
        }
      });
    }
  });
// Funktion zum Aktualisieren der Warenkorbanzahl
window.updateCartCount = function () {
    fetch("../includes/cart-api.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action: "get" })
    })
    .then(response => response.json())
    .then(data => {
        let count = 0;
        if (data.status === "ok" && Array.isArray(data.products)) {
            data.products.forEach(item => {
                count += item.quantity ?? 1;
            });
        }
        const countSpan = document.getElementById("cart-count");
        if (countSpan) {
            countSpan.textContent = count;
        }
    })
    .catch(error => console.error("Fehler beim Laden der Warenkorbanzahl:", error));
};

window.updateCartCount(); 

</script>

<style>
    /* Roboto Flex von Google Fonts einbinden */
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap');

    :root {
        --navbar-hover-color: #f8f9fa;
        --navbar-icon-color: #333;
    }

    .form-control {
        font-family: 'Roboto Flex', sans-serif;
        font-size: 12px;
        /* Kleinere Schriftgröße */
    }

    /* Globale Schriftart für die Navbar */
    .navbar,
    .navbar-brand,
    .nav-link,
    .offcanvas-title {
        font-family: 'Roboto Flex', sans-serif;
        text-transform: uppercase;
        /* Text in Großbuchstaben */
        font-size: 12px;
        /* Kleinere Schriftgröße */
    }

    .navbar {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Unterstreichung beim Hover nur für spezielle Links */
    .underline-hover {
        position: relative;
        display: inline-block;
        text-decoration: none;
    }

    .underline-hover:hover::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -0.5px;
        width: 100%;
        height: 1px;
        background-color: black;
    }

    /* Nur Cursor ändern beim Hover */
    .cursor-hover {
        cursor: pointer;
    }

    .navbar-toggler {
        border: none;
    }

    .offcanvas {
        background-color: #fff;
    }

    .offcanvas-header {
        border-bottom: 1px solid #e9ecef;
    }

    .offcanvas-title {
        font-weight: bold;
    }

    .form-control {
        border-radius: 20px;
    }

    /* Blauen Rand beim Klick ins Suchfeld entfernen */
    .form-control:focus {
        outline: none;
        box-shadow: none;
        border-color: #ccc;
        /* Optional: neutrale Randfarbe */
    }

    @media (max-width: 425px) {
        #searchIcon {
            display: none;
        }
    }
</style>