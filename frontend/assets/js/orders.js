
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

        const data = await res.json();
        console.log("Antwort-Daten:", data);

        const orderList = document.getElementById("orderList");

        if (data.status === "success") {
            if (data.orders.length === 0) {
                document.getElementById("noOrdersMsg").classList.remove("d-none");
                return;
            }

            data.orders.forEach(order => {
                const li = document.createElement("li");
                li.className = "list-group-item d-flex justify-content-between align-items-center";

                li.innerHTML = `
                    <div>
                        <strong>Order #${order.id}</strong><br>
                        <small>${formatDate(order.order_date)}</small><br>
                        <a href="../../backend/handlers/generate-invoice.php?order_id=${order.id}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Download Invoice</a>
                    </div>
                    <span class="badge bg-dark rounded-pill">
                        € ${parseFloat(order.total_price).toFixed(2).replace('.', ',')}
                    </span>
                `;

                orderList.appendChild(li);
            });
        } else {
            throw new Error("Fehlgeschlagene Antwort: " + (data.message || "Unbekannter Fehler"));
        }
    } catch (err) {
        console.error("Fehler beim Abrufen der Bestellungen:", err);
        alert("Fehler beim Abrufen der Bestellungen: " + err.message);
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

document.addEventListener("DOMContentLoaded", () => {
    loadOrders();
});