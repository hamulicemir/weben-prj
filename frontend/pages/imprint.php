<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - Imprint</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php include '../components/navbar.php'; ?> <!-- navbar -->

<main class="py-5">
    <div class="container">
        <h1 class="text-center fw-bold mb-5">IMPRINT</h1>

        <div class="mb-5">
            <h5 class="fw-bold">ICONIQ GmbH</h5>
            <p>
                Streetname 123<br>
                1010 Vienna<br>
                Austria
            </p>

            <p>
                Managing Directors: Jane Doe, John Smith<br>
                E-Mail: support@iconiq.com<br>
                Company Register: FN 123456a<br>
                VAT ID: ATU12345678
            </p>

            <p>
                Online Dispute Resolution: The European Commission provides a platform for online dispute resolution (ODR), which you can find here:<br>
                <a href="http://ec.europa.eu/consumers/odr/" target="_blank">http://ec.europa.eu/consumers/odr/</a><br>
                We are neither willing nor obliged to participate in dispute resolution procedures before a consumer arbitration board.
            </p>
        </div>

        <div class="mb-5">
            <h2 class="fw-bold">DISCLAIMER</h2>

            <h6 class="fw-bold mt-4">Liability for Contents</h6>
            <p>
                The contents of our pages were created with great care. However, we cannot guarantee the contents' accuracy, completeness or topicality. As a service provider, we are responsible for our own content on these pages under general laws.
            </p>

            <h6 class="fw-bold mt-4">Liability for Links</h6>
            <p>
                Our offer contains links to external websites of third parties on whose contents we have no influence. Therefore, we cannot accept any responsibility for these external contents. The respective provider or operator is always responsible for the content of the linked pages.
            </p>

            <h6 class="fw-bold mt-4">Copyright</h6>
            <p>
                The contents and works on these pages created by the website operators are subject to copyright law. Duplication, processing, distribution and any kind of exploitation outside the limits of copyright require the written consent of the respective author or creator.
            </p>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<?php include '../components/footer.php'; ?> <!-- Footer -->
</body>
</html>