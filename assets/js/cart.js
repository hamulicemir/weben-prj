// cart.js
const apiUrl = '../includes/cart-api.php';
const voucherApiUrl = '../includes/vouchers-api.php';
let appliedVoucher = null;
let lastFetchedProducts = [];

async function fetchCart() {
    const res = await fetch(apiUrl, {
        method: 'POST',
        body: JSON.stringify({ action: 'get' }),
        headers: { 'Content-Type': 'application/json' }
    });

    const result = await res.json();
    appliedVoucher = result.voucher || null;
    lastFetchedProducts = result.products;
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
        console.error("❌ Fehler beim Speichern des Warenkorbs!");
    }

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
    }
}

async function updateCart(productId, quantity) {
    if (quantity <= 0) {
        removeFromCart(productId);
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

function calculateDiscountedTotal(subtotal) {
    if (appliedVoucher && appliedVoucher.amount) {
        return Math.max(0, subtotal - parseFloat(appliedVoucher.amount));
    }
    return subtotal;
}

function renderCart(products) {
    const cartContainer = document.getElementById('cart-container');
    cartContainer.innerHTML = "";

    if (!products || products.length === 0) {
        cartContainer.innerHTML = `<div class="alert alert-dark text-center mt-4">Dein Warenkorb ist leer</div>`;
        return;
    }

    let subtotal = 0;
    const productList = document.createElement('div');
    productList.className = "col-md-8";

    products.forEach(product => {
        const id = parseInt(product.id);
        const name = product.name || `Produkt #${id}`;
        const quantity = parseInt(product.quantity) || 0;
        const price = parseFloat(product.price) || 0;
        const image = product.image || "../assets/img/products/no-image-available.jpg";
        const sum = (price * quantity).toFixed(2);

        subtotal += parseFloat(sum);

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

    const discountedTotal = calculateDiscountedTotal(subtotal);
    const shipping = 5;
    const totalWithShipping = discountedTotal + shipping;

    const summaryBox = document.createElement('div');
    summaryBox.className = "col-md-4";

    summaryBox.innerHTML = `
        <div class="card p-4 shadow-sm">
            <h5 class="mb-3">Voucher</h5>
            <div id="voucherFeedback" class="mb-2 text-success small">
                ${appliedVoucher ? `🎉 Voucher <strong>${appliedVoucher.code}</strong> applied!` : ''}
            </div>
            <div class="input-group mb-4">
                <input type="text" class="form-control" id="VoucherCode" placeholder="Enter voucher code">
                <button class="btn btn-outline-dark" id="AddVoucher" type="button">Add</button>
            </div>

            <div class="border-top pt-3">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>€ ${subtotal.toFixed(2)}</span>
                </div>
                ${appliedVoucher ? `
                <div class="d-flex justify-content-between mb-2 text-success">
                    <span>Voucher (-${appliedVoucher.code})</span>
                    <span>- € ${parseFloat(appliedVoucher.amount).toFixed(2)}</span>
                </div>` : ''}
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping fee</span>
                    <span>€ ${shipping.toFixed(2)}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3 fw-bold fs-5">
                    <span>Total</span>
                    <span>€ ${totalWithShipping.toFixed(2)}</span>
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

    const voucherBtn = document.getElementById("AddVoucher");
    if (voucherBtn) {
        voucherBtn.addEventListener("click", applyVoucher);
    }
}

async function applyVoucher() {
    const codeInput = document.getElementById('VoucherCode');
    const code = codeInput.value.trim();

    if (!code) {
        showCartToast("⚠️ Please enter a voucher code.");
        return;
    }

    try {
        const res = await fetch(voucherApiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'applyVoucher', code })
        });

        const result = await res.json();
        console.log("Voucher Response:", result);

        if (result.status === 'success') {
            appliedVoucher = result.voucher;
            showCartToast(`🎉 Voucher '${appliedVoucher.code}' applied!`);
            renderCart(lastFetchedProducts);
            await saveCart();
        } else {
            showCartToast("Voucher invalid or expired.");
        }
    } catch (error) {
        console.error('Fehler beim Anwenden des Gutscheins:', error);
        showCartToast("Fehler beim Anwenden des Gutscheins.");
    }
}

function showCartToast(message = "Aktion erfolgreich!") {
    const toastEl = document.getElementById('cartToast');
    if (!toastEl) {
        console.warn("Toast-Element fehlt im DOM.");
        return;
    }

    toastEl.querySelector('.toast-body').textContent = message;
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}

document.addEventListener("DOMContentLoaded", fetchCart);
