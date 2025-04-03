
// signup.js (AJAX Handler)
$(document).ready(function () {
    $('#signupForm').submit(function (e) {
        e.preventDefault();
        $('#errorMsg').hide();

        const password1 = $('#password1').val();
        const password2 = $('#password2').val();
        const iban = $('#payment_info').val().replace(/\s+/g, '');

        // Passwortprüfung
        if (password1.length < 6) {
            $('#errorMsg').text('Password must be at least 6 characters long.').show();
            return;
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

        const formData = $(this).serialize();

        $.post('../includes/signup-process.php', formData, function (response) {
            if (response.success) {
                window.location.href = window.location.origin + '/weben-prj/pages/login.php?success=true';

            } else {
                $('#errorMsg').text(response.message).show();
            }
        }, 'json').fail(function () {
            $('#errorMsg').text('An error has occurred.').show();
        });
    });

    function isValidIBAN(iban) {
        iban = iban.replace(/\s+/g, '').toUpperCase();
        if (!/^[A-Z0-9]{15,34}$/.test(iban)) return false;

        const rearranged = iban.slice(4) + iban.slice(0, 4);
        const converted = rearranged.replace(/[A-Z]/g, ch => ch.charCodeAt(0) - 55);
        const remainder = converted.match(/\d{1,7}/g)
            .reduce((acc, group) => parseInt(acc + group, 10) % 97, '');

        return parseInt(remainder, 10) === 1;
    }
});


