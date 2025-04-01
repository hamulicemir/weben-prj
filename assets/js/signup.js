
// signup.js (AJAX Handler)
$(document).ready(function () {
    $('#signupForm').submit(function (e) {
        e.preventDefault();
        const password1 = $('#passwort1').val();
        const password2 = $('#passwort2').val();

        $('#errorMsg').hide();

        if (password1.length < 6) {
            $('#errorMsg').text('Passwort muss mindestens 6 Zeichen lang sein.').show();
            return;
        }
        if (password1 !== password2) {
            $('#errorMsg').text('Passwörter stimmen nicht überein.').show();
            return;
        }

        const formData = $(this).serialize();

        $.post('../includes/signup-process.php', formData, function (response) {
            if (response.success) {
                window.location.href = '../pages/login.php';
            } else {
                $('#errorMsg').text(response.message).show();
            }
        }, 'json').fail(function () {
            $('#errorMsg').text('Ein Fehler ist aufgetreten.').show();
        });
    });
});
