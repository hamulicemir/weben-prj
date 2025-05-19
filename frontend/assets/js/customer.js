// Wird aufgerufen, sobald die Seite geladen ist
document.addEventListener("DOMContentLoaded", function () {
    loadCustomers();

    // Setzt den Click-Handler für den Bestätigungsbutton im Deaktivieren-Modal
    document.getElementById("confirmDeactivateBtn").addEventListener("click", function () {
        const customerId = this.getAttribute("data-id"); // ID aus dem Button-Attribut holen
        deactivateCustomer(customerId); // Kunde deaktivieren
    });

    console.log("Deactivate button clicked. ID:", customerId);

});

// Alle Kunden vom Backend laden und anzeigen
function loadCustomers() {
    fetch("../../backend/api/customers-api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "getAll" })  // Anfrage zum Abrufen aller Kunden
    })
        .then(res => res.json())
        .then(data => {
            console.log("API response:", data);

            if (data.status === "success") {
                const tbody = document.getElementById("customerTableBody");
                tbody.innerHTML = ""; // Tabelle leeren

                // Für jeden Kunden eine Tabellenzeile erzeugen
                data.data.forEach(customer => {
                    const row = document.createElement("tr");
                    let actions = "";

                    // Wenn aktiv → "Details" und "Deactivate"
                    if (parseInt(customer.active) === 1) {
                        actions = `
        <button class="btn btn-outline-primary btn-sm" onclick="showOrders(${customer.id})">Details</button>
        <button class="btn btn-outline-warning btn-sm" onclick="confirmDeactivate(${customer.id})">Deactivate</button>
    `;
                    } else {
                        // Wenn inaktiv → "Reactivate"
                        actions = `
        <button class="btn btn-outline-success btn-sm" onclick="reactivateCustomer(${customer.id})">Reactivate</button>
    `;
                    }

                    // Zeile mit Kundendaten + Aktionen einfügen
                    row.innerHTML = `
    <td>${customer.username}</td>
    <td>${customer.email}</td>
    <td>${parseInt(customer.active) === 1 ? "Active" : "Inactive"}</td>
    <td>${actions}</td>
`;
                    tbody.appendChild(row);
                });
            } else {
                alert("Error loading customers."); // Fehlerbehandlung
            }
        });
}

// Bestätigungs-Modal für Deaktivierung anzeigen
function confirmDeactivate(customerId) {
    const btn = document.getElementById("confirmDeactivateBtn");
    btn.setAttribute("data-id", customerId);
    const modal = new bootstrap.Modal(document.getElementById("deactivateModal"));
    modal.show(); // Bootstrap-Modal anzeigen
}

// Kunde deaktivieren (Backend-Aufruf)
function deactivateCustomer(customerId) {
    fetch("../../backend/api/customers-api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "deactivate", id: customerId })
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                console.log("Reloading customers...");
                loadCustomers(); // Tabelle neu laden
                bootstrap.Modal.getInstance(document.getElementById("deactivateModal")).hide(); // Modal schließen
            } else {
                alert("Failed to deactivate customer.");
            }
        });
}

// Kunde reaktivieren (bei Inaktivem)
function reactivateCustomer(customerId) {
    fetch("../../backend/api/customers-api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "reactivate", id: customerId })
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                loadCustomers(); // Tabelle aktualisieren
            } else {
                alert("Failed to reactivate customer.");
            }
        });
}


// Bestellungen eines Kunden anzeigen (in Modal)
function showOrders(customerId) {
    fetch("../../backend/api/customers-api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "getOrders", id: customerId })
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                const tbody = document.getElementById("orderDetailsBody");
                tbody.innerHTML = ""; // Bestellliste leeren

                // Für jedes Produkt eine Zeile einfügen
                data.orders.forEach(item => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                    <td>${item.order_id}</td>
                    <td>${item.product_name}</td>
                    <td>${item.quantity}</td>
                    <td><button class="btn btn-outline-danger btn-sm" onclick="removeProduct(${item.order_id}, ${item.product_id}, ${customerId})">Remove</button></td>
                `;
                    tbody.appendChild(row);
                });

                const modal = new bootstrap.Modal(document.getElementById("customerDetailsModal"));
                modal.show();
            } else {
                alert("No orders found for this customer.");
            }
        });
}

// Produkt aus Bestellung entfernen
function removeProduct(orderId, productId, customerId) {
    // Nutzer vorher um Bestätigung fragen
    if (!confirm("Are you sure you want to remove this product from the order?")) return;

    fetch("../../backend/api/customers-api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "removeProduct", order_id: orderId, product_id: productId })
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                alert("Product removed successfully.");
                showOrders(customerId);  // Bestellung neu laden
            } else {
                alert("Failed to remove product.");
            }
        });
}
