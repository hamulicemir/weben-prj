document.addEventListener("DOMContentLoaded", function () {
    loadCustomers();

    document.getElementById("confirmDeactivateBtn").addEventListener("click", function () {
        const customerId = this.getAttribute("data-id");
        deactivateCustomer(customerId);
    });

    console.log("Deactivate button clicked. ID:", customerId);

});

// Load all customers
function loadCustomers() {
    fetch("../../backend/api/customers-api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "getAll" })
    })
        .then(res => res.json())
        .then(data => {
            console.log("API response:", data);

            if (data.status === "success") {
                const tbody = document.getElementById("customerTableBody");
                tbody.innerHTML = "";
                data.data.forEach(customer => {
                    const row = document.createElement("tr");
                    let actions = "";

                    if (parseInt(customer.active) === 1) {
                        actions = `
        <button class="btn btn-outline-primary btn-sm" onclick="showOrders(${customer.id})">Details</button>
        <button class="btn btn-outline-warning btn-sm" onclick="confirmDeactivate(${customer.id})">Deactivate</button>
    `;
                    } else {
                        actions = `
        <button class="btn btn-outline-success btn-sm" onclick="reactivateCustomer(${customer.id})">Reactivate</button>
    `;
                    }

                    row.innerHTML = `
    <td>${customer.username}</td>
    <td>${customer.email}</td>
    <td>${parseInt(customer.active) === 1 ? "Active" : "Inactive"}</td>
    <td>${actions}</td>
`;
                    tbody.appendChild(row);
                });
            } else {
                alert("Error loading customers.");
            }
        });
}

// Show confirm deactivate modal
function confirmDeactivate(customerId) {
    const btn = document.getElementById("confirmDeactivateBtn");
    btn.setAttribute("data-id", customerId);
    const modal = new bootstrap.Modal(document.getElementById("deactivateModal"));
    modal.show();
}

// Deactivate customer
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
                loadCustomers();
                bootstrap.Modal.getInstance(document.getElementById("deactivateModal")).hide();
            } else {
                alert("Failed to deactivate customer.");
            }
        });
}

function reactivateCustomer(customerId) {
    fetch("../../backend/api/customers-api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "reactivate", id: customerId })
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                loadCustomers();
            } else {
                alert("Failed to reactivate customer.");
            }
        });
}


// Show customer's orders
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
                tbody.innerHTML = "";

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

// Remove product from order
function removeProduct(orderId, productId, customerId) {
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
                showOrders(customerId); // reload orders
            } else {
                alert("Failed to remove product.");
            }
        });
}
