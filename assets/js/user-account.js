document.addEventListener("DOMContentLoaded", async () => {
    try {
        const res = await fetch("../includes/user-api.php", {
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

loadOrders();

async function loadOrders(sort = "desc") {
    try {
        const res = await fetch("../includes/order-api.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "viewOrdersByUserID", sort })
        });

        const data = await res.json();
        const orderList = document.getElementById("orderList");
        const noOrdersMsg = document.getElementById("noOrdersMsg");

        if (data.status === "success") {
            if (data.orders.length === 0) {
                noOrdersMsg.classList.remove("d-none");
                return;
            }

            data.orders.forEach(order => {
                const li = document.createElement("li");
                li.className = "list-group-item d-flex justify-content-between align-items-center";

                li.innerHTML = `
                    <div>
                        <strong>Order #${order.id}</strong><br>
                        <small>${formatDate(order.order_date)}</small><br>
                        <a href="generate-invoice.php?order_id=${order.id}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Download Invoice</a>
                    </div>
                    <span class="badge bg-dark rounded-pill">
                        € ${parseFloat(order.total_price).toFixed(2).replace('.', ',')}
                    </span>
                `;

                orderList.appendChild(li);
            });
        } else {
            noOrdersMsg.textContent = data.message || "Fehler beim Laden der Bestellungen.";
            noOrdersMsg.classList.remove("d-none");
        }
    } catch (err) {
        console.error(err);
        alert("Fehler beim Abrufen der Bestellungen.");
    }
}

function formatDate(isoString) {
    const date = new Date(isoString);
    return date.toLocaleDateString('de-DE');
}

document.getElementById("sortSelect").addEventListener("change", (e) => {
    const sort = e.target.value;
    document.getElementById("orderList").innerHTML = ""; // Liste leeren
    document.getElementById("noOrdersMsg").classList.add("d-none");
    loadOrders(sort);
});


