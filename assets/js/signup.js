// signup.js (AJAX Handler) - jQuery + Bootstrap Modal
$(document).ready(function () {

     // Event-Handler für das Formular mit ID #signupForm
    $('#signupForm').submit(function (e) {
        e.preventDefault(); // Verhindert das Standard-Formularverhalten (Seitenreload)
        $('#errorMsg').hide(); // Versteckt vorherige Fehlermeldung

        // Holt Passwort-Felder und entfernt Leerzeichen aus der IBAN
        const password1 = $('#password1').val();
        const password2 = $('#password2').val();
        const iban = $('#payment_info').val().replace(/\s+/g, '');

         // Prüft Mindestlänge des Passworts
        if (password1.length < 6) {
            $('#errorMsg').text('Password must be at least 6 characters long.').show();
            return;
        }
        
         // Prüft, ob Passwörter übereinstimmen
        if (password1 !== password2) {
            $('#errorMsg').text('Passwords do not match.').show();
            return;
        }

        // Prüft Gültigkeit der IBAN
        if (!isValidIBAN(iban)) {
            $('#errorMsg').text('Please enter a valid IBAN.').show();
            return;
        }

        // Serialisiert alle Formulardaten in ein URL-encoded Format
        const formData = $(this).serialize();

        // AJAX POST-Request an signup-process.php (PHP-Backend)
        $.post('../includes/signup-process.php', formData, function (response) {
            if (response.success) {

                // Zeigt Bootstrap Modal bei Erfolg
                const modal = new bootstrap.Modal(document.getElementById('signupSuccessModal'));
                modal.show();

                // Weiterleitung zur Startseite nach 3,5 Sekunden
                setTimeout(() => {
                    window.location.href = "../pages/index.php";
                }, 3500);
            } else {
                // Zeigt Fehlermeldung aus dem Backend
                $('#errorMsg').text(response.message).show();
            }
        }, 'json').fail(function () {
             // AJAX-Fehlerbehandlung (z. B. Server nicht erreichbar)
            $('#errorMsg').text('Something went wrong. Please try again later.').show();
        });
    }); 
    
    // IBAN-Validierungsfunktion (Client-seitig)
    function isValidIBAN(iban) {
        iban = iban.replace(/\s+/g, '').toUpperCase(); // Leerzeichen entfernen und Großbuchstaben erzwingen
        if (!/^[A-Z0-9]{15,34}$/.test(iban)) return false; // Grundformat prüfen

        // IBAN für Modulo-97-Berechnung umstellen
        const rearranged = iban.slice(4) + iban.slice(0, 4);
        const converted = rearranged.replace(/[A-Z]/g, ch => ch.charCodeAt(0) - 55); // Buchstaben in Zahlen umwandeln

        // Schrittweise Modulo-97 berechnen (IBAN-Prüfziffer)
        const remainder = converted.match(/\d{1,7}/g)
            .reduce((acc, group) => parseInt(acc + group, 10) % 97, '');

        return parseInt(remainder, 10) === 1; // Gültig, wenn Rest = 1
    }
});
