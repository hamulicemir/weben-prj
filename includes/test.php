<nav class="navbar navbar-expand-md navbar-light bg-white sticky-top border-bottom" data-bs-theme="light">
  <div class="container-fluid">
    <!-- Links (Women, Men, Accessories) -->
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item"><a class="nav-link" href="#">Women</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Men</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Accessories</a></li>
    </ul>

    <!-- Logo in der Mitte -->
    <a class="navbar-brand mx-auto" href="#">ICONIQ</a>

    <!-- Suchleiste und Icons -->
    <div class="d-flex align-items-center">
      <!-- Suchleiste (nur im Desktop-Modus sichtbar) -->
      <form class="d-flex me-3 d-none d-md-block" role="search">
        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
      </form>
      <!-- Icons -->
      <a class="nav-link me-3" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
          <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
        </svg>
      </a>
      <a class="nav-link" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
          <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
        </svg>
      </a>
    </div>

    <!-- Toggler für Mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
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
          <li class="nav-item"><a class="nav-link" href="#">Women</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Men</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Accessories</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<style>
    /* Roboto Flex von Google Fonts einbinden */
  @import url('https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap');


  :root {
    --navbar-hover-color: #f8f9fa;
    --navbar-icon-color: #333;
  }

  /* Globale Schriftart für die Navbar */
  .navbar,
  .navbar-brand,
  .nav-link,
  .offcanvas-title {
    font-family: 'Roboto Flex', sans-serif;
    text-transform: uppercase; /* Text in Großbuchstaben */
    font-size: 12px; /* Kleinere Schriftgröße */
  }

  .navbar {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .nav-link {
    color: var(--navbar-icon-color);
    transition: color 0.3s ease;
  }

  .nav-link:hover {
    color: #007bff;
    background-color: var(--navbar-hover-color);
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
</style>