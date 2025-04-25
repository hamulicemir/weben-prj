const apiUrl = '../includes/cart-api.php';

async function fetchCart() {
    const res = await fetch(apiUrl, {
        method: 'POST',
        body: JSON.stringify({ action: 'get' }),
        headers: { 'Content-Type': 'application/json' }
    });
    const result = await res.json();
    renderCart(result.products);
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
        fetchCart(); // Neu rendern
    }
}


function renderCart(products) {
    const cartContainer = document.getElementById('cart-container');
    cartContainer.innerHTML = "";

    if (!products || products.length === 0) {
        cartContainer.innerHTML = `<div class="alert alert-dark text-center mt-4">🛒 Dein Warenkorb ist leer</div>`;
        return;
    }

    let total = 0;

    products.forEach(product => {
        const id = parseInt(product.id);
        const name = product.name || `Produkt #${id}`;
        const quantity = parseInt(product.quantity) || 0;
        const price = parseFloat(product.price) || 0;
        const image = product.image || "../assets/img/products/no-image-available.jpg";
        const sum = (price * quantity).toFixed(2);

        total += parseFloat(sum);

        const card = document.createElement("div");
        card.className = "card shadow border-0";
        card.style.minHeight = "120px";

        card.innerHTML = `
    <div class="row g-0 align-items-stretch">
        <!-- Bild -->
        <div class="col-md-3 bg-light d-flex justify-content-center align-items-center p-3">
            <img src="${image}" class="img-fluid rounded" alt="${name}" style="max-height: 100px;">
        </div>

        <!-- Produktinfos -->
        <div class="col-md-8 p-3 d-flex flex-column justify-content-between">
            <h5 class="mb-1">${name}</h5>

            <div class="d-flex align-items-center mb-2">
                <button class="btn btn-outline-dark btn-sm me-2" onclick="updateCart(${id}, ${quantity - 1})">−</button>
                <span class="fw-bold">${quantity}</span>
                <button class="btn btn-outline-dark btn-sm ms-2" onclick="updateCart(${id}, ${quantity + 1})">+</button>
            </div>

            <p class="mb-1 small text-muted">Einzelpreis: € ${price.toFixed(2)}</p>
            <p class="mb-0 fw-bold">Zwischensumme: € ${sum}</p>
        </div>

        <!-- Löschen (rechte Spalte) -->
        <div class="col-md-1 d-flex justify-content-center bg-dark text-white">
            <button class="btn text-white border-0 p-0 w-100" onclick="removeFromCart(${id})" title="Produkt entfernen" style="height: 100%; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-trash3-fill fs-4"></i>
            </button>
        </div>
    </div>
`;

        cartContainer.appendChild(card);
    });

    // Gesamtsumme anzeigen
    const summary = document.createElement("div");
    summary.className = "text-end mt-4 border-top pt-3 fw-bold fs-5";
    summary.innerHTML = `Gesamt: € ${total.toFixed(2)}`;
    cartContainer.appendChild(summary);

    const checkoutButton = document.createElement("div");
    checkoutButton.className = "d-flex justify-content-end mt-3";
    checkoutButton.innerHTML = `
        <a href="../pages/checkout.php" class="btn btn-dark btn-lg">Proceed to Payment</a>
    `;
    cartContainer.appendChild(checkoutButton);
}

document.addEventListener("DOMContentLoaded", fetchCart);
