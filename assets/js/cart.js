const apiUrl = '../includes/cart-api.php';

async function fetchCart() {
    const res = await fetch(apiUrl, {
        method: 'POST',
        body: JSON.stringify({ action: 'get' }),
        headers: { 'Content-Type': 'application/json' }
    });
    const result = await res.json();
    renderCart(result.products);
    await saveCart(); 
}


async function saveCart() {
    const res = await fetch(apiUrl, {
        method: 'POST',
        body: JSON.stringify({ action: 'save' }),
        headers: { 'Content-Type': 'application/json' }
    });

    const result = await res.json();
    if (result.status !== "ok") {
        console.error("Fehler beim Speichern des Warenkorbs!");
    }

    // Warenkorb-Zähler aktualisieren
    if (typeof window.updateCartCount === "function") {
        window.updateCartCount();
    }
}


async function removeFromCart(productId) {
    const res = await fetch(apiUrl, {
        method: 'POST',
        body: JSON.stringify({ action: 'remove', productId }),
        headers: { 'Content-Type': 'application/json' }
    });
    const result = await res.json();

    if (result.status === "ok") {
        fetchCart(); 
        await saveCart();
    }}

async function updateCart(productId, quantity) {
    if (quantity <= 0) {
        removeFromCart(productId); // Wenn 0 oder weniger: Entferne
        return;
    }

    const res = await fetch(apiUrl, {
        method: 'POST',
        body: JSON.stringify({ action: 'update', productId, quantity }),
        headers: { 'Content-Type': 'application/json' }
    });

    const result = await res.json();
    if (result.status === "ok") {
        fetchCart();
        await saveCart();
    }
}


function renderCart(products) {
    const cartContainer = document.getElementById('cart-container');
    cartContainer.innerHTML = "";

    if (!products || products.length === 0) {
        cartContainer.innerHTML = `<div class="alert alert-dark text-center mt-4">Dein Warenkorb ist leer</div>`;
        return;
    }

    let total = 0;
    const productList = document.createElement('div');
    productList.className = "col-md-8";

    products.forEach(product => {
        const id = parseInt(product.id);
        const name = product.name || `Produkt #${id}`;
        const quantity = parseInt(product.quantity) || 0;
        const price = parseFloat(product.price) || 0;
        const image = product.image || "../assets/img/products/no-image-available.jpg";
        const sum = (price * quantity).toFixed(2);

        total += parseFloat(sum);

        const card = document.createElement("div");
        card.className = "card border-0 shadow-sm p-3 mb-4"; 
        card.style.minHeight = "120px";

        card.innerHTML = `
            <div class="row g-3 align-items-center">
                <div class="col-4 col-md-3 bg-light d-flex justify-content-center align-items-center p-3">
                    <img src="${image}" class="img-fluid rounded" alt="${name}" style="max-height: 140px;">
                </div>

                <div class="col-7 col-md-8 p-2">
                    <h5 class="mb-2 fs-5">${name}</h5>

                    <div class="d-flex align-items-center mb-2">
                        <button class="btn btn-outline-dark btn-md me-2" onclick="updateCart(${id}, ${quantity - 1})">−</button>
                        <span class="fw-bold fs-5">${quantity}</span> 
                        <!-- Etwas größere Zahl (fs-5) -->
                        <button class="btn btn-outline-dark btn-md ms-2" onclick="updateCart(${id}, ${quantity + 1})">+</button>
                    </div>

                    <p class="mb-1 small text-muted">Price: € ${price.toFixed(2)}</p>
                    <p class="mb-0 fw-bold">Subtotal: € ${sum}</p>
                </div>

                <div class="col-1 d-flex justify-content-center">
                    <button class="btn btn-link btn-sm text-danger" onclick="removeFromCart(${id})" title="Produkt entfernen">
                        <i class="bi bi-trash3-fill fs-4"></i>
                    </button>
                </div>
            </div>
        `;

        productList.appendChild(card);
    });

    const summaryBox = document.createElement('div');
    summaryBox.className = "col-md-4";

    summaryBox.innerHTML = `
        <div class="card p-4 shadow-sm">
            <h5 class="mb-3">Voucher</h5>
            <div class="input-group mb-4">
                <input type="text" class="form-control" placeholder="Enter voucher code">
                <button class="btn btn-outline-dark" type="button">Add</button>
            </div>

            <div class="border-top pt-3">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>€ ${total.toFixed(2)}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping fee</span>
                    <span>€ 5</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3 fw-bold fs-5">
                    <span>Total</span>
                    <span>€ ${(total + 5).toFixed(2)}</span>
                </div>
                <p class="text-muted small mb-4">incl. 20% VAT</p>
                <a href="../pages/checkout_data.php" class="btn btn-dark w-100">Go to Checkout</a>
            </div>
        </div>
    `;

    const row = document.createElement('div');
    row.className = "row g-4";
    row.appendChild(productList);
    row.appendChild(summaryBox);

    cartContainer.appendChild(row);
}

document.addEventListener("DOMContentLoaded", fetchCart);
