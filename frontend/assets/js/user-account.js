document.addEventListener("DOMContentLoaded", async () => {
    try {
        const res = await fetch("../../../backend/api/user-api.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "thisUser" })
        });

        const result = await res.json();

        if (result.status === "success") {
            const user = result.user;

            document.getElementById("firstName").textContent = user.first_name;
            document.getElementById("lastName").textContent = user.last_name;
            document.getElementById("email").textContent = user.email;
            document.getElementById("username").textContent = user.username;
            document.getElementById("iban").textContent = maskIBAN(user.payment_info);
            document.getElementById("address").innerHTML = `
                ${user.address}<br>
                ${user.postal_code} ${user.city}<br>
                ${user.country}
            `;
        } else {
            alert("Fehler beim Laden der Benutzerdaten.");
        }
    } catch (err) {
        console.error(err);
        alert("Serverfehler beim Abrufen der Daten.");
    }
});

function maskIBAN(iban) {
    if (!iban) return "-";
    return iban.slice(0, 4) + "*".repeat(iban.length - 8) + iban.slice(-4);
}