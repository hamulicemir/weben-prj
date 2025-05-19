// Bestellungen des aktuellen Users laden
async function loadOrders(sort = "desc") {
    try {
        const res = await fetch("../../backend/api/order-api.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "viewOrdersByUserID", sort })
        });

        console.log("HTTP Status:", res.status);
        if (!res.ok) {
            throw new Error("Fehler beim Serverabruf: " + res.status + " " + res.statusText);
        }

        // JSON-Daten weiterverarbeiten
        const data = await res.json();
        console.log("Antwort-Daten:", data);

        const orderList = document.getElementById("orderList");

        if (data.status === "success") {
            if (data.orders.length === 0) {
                document.getElementById("noOrdersMsg").classList.remove("d-none");  // Kein Ergebnis → Hinweis anzeigen
                return;
            }

            // Jede Bestellung als <li>-Element anzeigen
            data.orders.forEach(order => {
                const li = document.createElement("li");
                li.className = "list-group-item d-flex justify-content-between align-items-center";

                li.innerHTML = `
                <div>
                    <strong>Order #${order.id}</strong><br>
                    <small>${formatDate(order.order_date)}</small><br>
                    <div class="mt-2">
                        <a href="../../backend/handlers/generate-invoice.php?order_id=${order.id}" target="_blank" class="btn btn-sm btn-outline-primary me-2">Download Invoice</a>
                        <button class="btn btn-sm btn-outline-secondary" onclick="showOrderDetails(${order.id})">Details</button>
                    </div>
                </div>
                <span class="badge bg-dark rounded-pill">
                    € ${parseFloat(order.total_price).toFixed(2).replace('.', ',')}
                </span>
            `;
                orderList.appendChild(li);
            });
        // Fehlerbehandlung
        } else {
            throw new Error("Fehlgeschlagene Antwort: " + (data.message || "Unbekannter Fehler"));
        }
    } catch (err) {
        console.error("Fehler beim Abrufen der Bestellungen:", err);
        alert("Fehler beim Abrufen der Bestellungen: " + err.message);
    }
}

// formatDate() – ISO-String in deutsches Datum umwandeln
function formatDate(isoString) {
    const date = new Date(isoString);
    return date.toLocaleDateString('de-DE');
}

// Sortieren der Bestellungen (per Dropdown)
document.getElementById("sortSelect").addEventListener("change", (e) => {
    const sort = e.target.value;
    document.getElementById("orderList").innerHTML = ""; // Liste leeren
    document.getElementById("noOrdersMsg").classList.add("d-none"); // Hinweis verstecken
    loadOrders(sort); // Neue Sortierung laden
});

// Bei Seitenstart: Bestellungen laden
document.addEventListener("DOMContentLoaded", () => {
    loadOrders(); // Standardmäßig "desc"
});

// Einzelne Bestellung anzeigen (Modal)
function showOrderDetails(orderId) {
    fetch("../../backend/api/order-api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "getOrderItems", order_id: orderId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            const tbody = document.getElementById("orderDetailBody");
            tbody.innerHTML = "";

            data.items.forEach(item => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${item.product_name}</td>
                    <td>${item.quantity}</td>
                `;
                tbody.appendChild(row);
            });

            const modal = new bootstrap.Modal(document.getElementById("orderDetailsModal"));
            modal.show(); // Modal mit Produkten anzeigen
        } else {
            alert("No details found for this order.");
        }
    });
}

window.showOrderDetails = showOrderDetails; // Für globale Verwendung:

