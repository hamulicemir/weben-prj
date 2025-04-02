<footer class="footer bg-light border-top py-3"> <!-- Vertikales Padding reduziert -->
    <div class="container">
        <div class="row">
            <!-- Marke -->
            <div class="col-12 col-xl-4 mb-3 d-flex flex-column justify-content-between">
                <h1 class="fw-bold mb-3">ICONIQ</h1>
            </div>

            <!-- Über uns -->
            <div class="col-12 col-md-4 col-xl-2 mb-3">
                <h6 class="text-uppercase">About</h6>
                <ul class="list-unstyled mt-2">
                    <li><a href="../pages/thebrand.php" class="text-decoration-none text-dark mb-1 d-block">The Brand</a></li>
                    <li><a href="../pages/stores.php" class="text-decoration-none text-dark mb-1 d-block">Stores</a></li>
                    <li><a href="../pages/jobs.php" class="text-decoration-none text-dark d-block">Jobs</a></li>
                </ul>
            </div>

            <!-- Service & Support -->
            <div class="col-12 col-md-4 col-xl-2 mb-3">
                <h6 class="text-uppercase">Service & Support</h6>
                <ul class="list-unstyled mt-2">
                    <li><a href="#" class="text-decoration-none text-dark mb-1 d-block">Size Guide</a></li>
                    <li><a href="#" class="text-decoration-none text-dark mb-1 d-block">Newsletter</a></li>
                    <li><a href="../pages/faq.php" class="text-decoration-none text-dark mb-1 d-block">FAQ</a></li>
                    <li><a href="#" class="text-decoration-none text-dark d-block">Retoure</a></li>
                </ul>
            </div>

            <!-- Kontakt -->
            <div class="col-12 col-md-4 col-xl-2 mb-3">
                <h6 class="text-uppercase">Kontakt</h6>
                <ul class="list-unstyled mt-2">
                    <li><a href="mailto:support@iconiq.com" class="text-decoration-none text-dark mb-1 d-block">support@iconiq.com</a></li>
                    <li class="text-muted small mb-1">Mo - Fr von 09:00 bis 18:00 Uhr</li>
                </ul>
            </div>

            <hr class="my-3"> <!-- Vertikaler Abstand des Trennstrichs reduziert -->
            <!-- Footer Bottom -->
            <div class="row">
                <div class="col-6">
                    <span>AT | <span class="text-capitalize">Deutsch</span></span>
                </div>
                <div class="col-6 text-end">
                    <a href="../pages/agb.php" class="text-decoration-none text-dark me-2">AGB</a>
                    <a href="../pages/dataprotection.php" class="text-decoration-none text-dark me-2">Datenschutz</a>
                    <a href="../pages/imprint.php" class="text-decoration-none text-dark">Impressum</a>
                </div>
            </div>
        </div>
</footer>



<style>
    /* Roboto Flex von Google Fonts einbinden */
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap');

    .footer {
        font-family: 'Roboto Flex', sans-serif;
        font-size: 10px;
        /* Kleinere Schriftgröße */
        margin-top: auto; /* Sticky Footer */

    }
    html, body { /* Sticky Footer */
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    h1 {
        font-size: 24px;
    }

    h6 {
        font-family: 'Roboto Flex', sans-serif;
        font-size: 11px;
    }

    footer a:hover {
        text-decoration: underline;
    }
</style>