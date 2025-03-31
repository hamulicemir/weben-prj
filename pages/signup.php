<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - Sign-Up</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;

        }
    </style>
</head>

<body>
    <?php include '../includes/navbar.php'; ?> <!-- navbar -->
    <section>
        <!-- Bitte gleichen Style wie Log-In Page-->
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <main class="container py-5">
        <div class="row">
            <section class="col-12 col-md-4 offset-md-1 mb-4">
                <h2>Deine Vorteile mit einem ICONIQ-Konto</h2>
                <ul class="list-checked">
                    <li>Schneller einkaufen</li>
                    <li>Lieblingsartikel speichern</li>
                    <li>Bestellstatus verfolgen</li>
                    <li>Rechnungen & Daten verwalten</li>
                </ul>
            </section>
            <section class="col-12 col-md-6">
                <h1>KUNDENKONTO ERSTELLEN</h1>
                <form action="../includes/signup-process.php" method="post">
                    <div class="form-row pt-3">
                        <div class="col-12 mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="anrede" value="Frau" required>
                                <label class="form-check-label">Frau</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="anrede" value="Herr" required>
                                <label class="form-check-label">Herr</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="anrede" value="Divers" required>
                                <label class="form-check-label">Divers</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" id="vorname" name="vorname" placeholder="" required>
                                <label for="vorname">Vorname</label>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" id="nachname" name="nachname" placeholder="" required>
                                <label for="nachname">Nachname</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control" id="strasse" name="strasse" placeholder="" required>
                                <label for="strasse">Strasse</label>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control" id="nr" name="nr" placeholder="" required>
                                <label for="nr">Nr.</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="adresszusatz" name="adresszusatz" placeholder="">
                                <label for="adresszusatz">Adresszusatz (optional)</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control" id="plz" name="plz" placeholder="" required>
                                <label for="plz">PLZ</label>
                            </div>
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control" id="ort" name="ort" placeholder="" required>
                                <label for="ort">Ort</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="land" name="land" placeholder="" required>
                                <label for="land">Land</label>
                            </div>
                        </div>

                        <div class="row">
                            <label for="geburtstag" class="form-label">Geburtstag (optional)</label>

                            <div class="form-group col-md-4">
                                <select class="form-control" id="geburtstag_tag" name="geburtstag_tag">
                                    <option value="">TT</option>
                                    <?php for ($i = 1; $i <= 31; $i++): ?>
                                        <option value="<?= $i ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <select class="form-control" id="geburtstag_monat" name="geburtstag_monat">
                                    <option value="">MM</option>
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?= $i ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <select class="form-control" id="geburtstag_jahr" name="geburtstag_jahr">
                                    <option value="">JJJJ</option>
                                    <?php for ($i = date('Y'); $i >= 1950; $i--): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="tel" class="form-control" id="telefon" name="telefon" placeholder="">
                                <label for="telefon">Telefonnummer (optional)</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="email" class="form-control" id="email" name="email" placeholder="" required>
                                <label for="email">E-Mail-Adresse</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="password" class="form-control" id="passwort1" name="passwort1" placeholder="" required>
                                <label for="passwort1">Passwort</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="password" class="form-control" id="passwort2" name="passwort2" placeholder="" required>
                                <label for="passwort2">Passwort wiederholen</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <input type="checkbox" class="form-check-input" id="datenschutz" required>
                                <label class="form-check-label" for="datenschutz">
                                    Ich akzeptiere die <a href="#">Datenschutzbestimmungen</a>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <button type="submit" name="submit" class="btn btn-primary btn-block">Konto erstellen</button>
                            </div>
                        </div>
                    </div>

                </form>
            </section>
        </div>
    </main>


    <?php include '../includes/footer.php'; ?> <!-- Footer -->
</body>

</html>