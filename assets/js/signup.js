
// signup.js (AJAX Handler)
$(document).ready(function () { // Heißt: „Warte, bis die ganze Seite geladen ist – dann führe den Code aus“.
    $('#signupForm').submit(function (e) {  // Wenn das Formular mit der ID 'signupForm' abgeschickt wird...
        e.preventDefault(); // Standard-Absenden verhindern (kein Neuladen)
        $('#errorMsg').hide(); // Fehlermeldung ausblenden

        const password1 = $('#password1').val(); // Passwort 1 auslesen
        const password2 = $('#password2').val();
        const iban = $('#payment_info').val().replace(/\s+/g, ''); // IBAN auslesen und Leerzeichen entfernen

        // Passwortprüfung
        if (password1.length < 6) {
            $('#errorMsg').text('Password must be at least 6 characters long.').show();
            return; //Abbrechen
        }

        if (password1 !== password2) {
            $('#errorMsg').text('Passwords do not match.').show();
            return;
        }

        // IBAN-Validierung
        if (!isValidIBAN(iban)) {
            $('#errorMsg').text('Please enter a valid IBAN.').show();
            return;
        }

        const formData = $(this).serialize(); // Alle Formulardaten als URL-codierten String sammeln

        // Daten per AJAX an PHP-Datei senden
        $.post('../includes/signup-process.php', formData, function (response) {
            // Wenn Registrierung erfolgreich war
            if (response.success) {
                // Weiterleitung zur Login-Seite mit Erfolgsparameter
                window.location.href = window.location.origin + '/weben-prj/pages/login.php?success=true';
            } else {
                // Fehlermeldung vom Server anzeigen
                $('#errorMsg').text(response.message).show();
            }
        }, 'json').fail(function () {
            // Wenn AJAX-Verbindung fehlgeschlagen ist
            $('#errorMsg').text('An error has occurred.').show();
        });
    });

    function isValidIBAN(iban) {
        iban = iban.replace(/\s+/g, '').toUpperCase(); // Leerzeichen entfernen, alles groß schreiben
        if (!/^[A-Z0-9]{15,34}$/.test(iban)) return false; // Format prüfen (nur Buchstaben/Zahlen, richtige Länge)

        const rearranged = iban.slice(4) + iban.slice(0, 4); // Die ersten 4 Zeichen nach hinten verschieben
        const converted = rearranged.replace(/[A-Z]/g, ch => ch.charCodeAt(0) - 55); // Buchstaben in Zahlen umwandeln (A=10, B=11, ...)
        
        // Reste berechnen mit Modulo 97
        const remainder = converted.match(/\d{1,7}/g)
            .reduce((acc, group) => parseInt(acc + group, 10) % 97, '');

        return parseInt(remainder, 10) === 1; // Gültig, wenn Rest 1 ist
    }
});


