<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - Data Protection</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php include '../components/navbar.php'; ?> <!-- navbar -->

<main class="py-5">
    <div class="container">
        <h1 class="text-center fw-bold mb-5">Privacy Policy</h1>

        <p>This privacy policy informs you about the nature, scope, and purpose of the collection and use of personal data (hereinafter referred to as "data") within our online offering and the associated websites, functions, and content.</p>

        <div class="mb-5">
            <h5 class="fw-bold mt-4">Responsible Entity</h5>
            <p>
                ICONIQ GmbH<br>
                Streetname 123<br>
                1010 Vienna, Austria<br>
                Email: support@iconiq.com<br>
                Managing Directors: Jane Doe, John Smith<br>
                <a href="imprint.php">View Imprint</a>
            </p>

            <h5 class="fw-bold mt-4">Types of Data Processed</h5>
            <ul>
                <li>Inventory data (e.g., names, addresses)</li>
                <li>Contact data (e.g., email, phone numbers)</li>
                <li>Content data (e.g., text input, photos, videos)</li>
                <li>Usage data (e.g., visited pages, interests, access times)</li>
                <li>Meta/communication data (e.g., device information, IP addresses)</li>
            </ul>

            <h5 class="fw-bold mt-4">Categories of Data Subjects</h5>
            <p>Visitors and users of the online offering (hereinafter referred to collectively as “users”).</p>

            <h5 class="fw-bold mt-4">Purpose of Processing</h5>
            <ul>
                <li>Providing the online offering, its functions and content</li>
                <li>Responding to contact inquiries and communication with users</li>
                <li>Security measures</li>
                <li>Reach measurement and marketing</li>
            </ul>

            <h5 class="fw-bold mt-4">Definitions</h5>
            <p>"Personal data" means any information relating to an identified or identifiable natural person (“data subject”).</p>
            <p>"Processing" means any operation which is performed on personal data, such as collection, recording, organization, structuring, storage, adaptation, retrieval, use, or disclosure by transmission.</p>
            <p>The terms used in this policy follow the definitions under Article 4 of the General Data Protection Regulation (GDPR).</p>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<?php include '../components/footer.php'; ?> <!-- Footer -->
</body>
</html>