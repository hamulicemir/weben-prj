// Produkte aus dem Warenkorb holen (AJAX)
async function fetchSummaryCart() {
  const res = await fetch('../../backend/api/cart-api.php', {
    method: 'POST',
    body: JSON.stringify({ action: 'get' }),
    headers: { 'Content-Type': 'application/json' }
  });
  const result = await res.json();
  renderSummaryCart(result.products, result.voucher ?? null);
}

// Funktion zum Darstellen der Zusammenfassung
function renderSummaryCart(products, voucher) {
  // HTML-Element mit ID summary-products wird geleert
  const container = document.getElementById('summary-products');
  container.innerHTML = "";

  // Wenn der Warenkorb leer ist
  if (!products || products.length === 0) {
    container.innerHTML = `<div class="alert alert-warning text-center">Cart is empty</div>`;
    return;
  }

  // Zwischensumme berechnen
  let subtotal = 0;
  const listCard = document.createElement("div");
  listCard.className = "card shadow rounded-4 p-4 mb-4";
  listCard.innerHTML = `<h4 class="mb-4">Your Products</h4>`;

  // Alle Produkte durchgehen und anzeigen
  products.forEach(product => {
    const name = product.name ?? 'Product';
    const quantity = product.quantity ?? 1;
    const price = parseFloat(product.price ?? 0);
    const image = product.image ?? "../assets/img/products/no-image-available.jpg";
    const itemTotal = price * quantity;
    subtotal += itemTotal;

    const item = document.createElement("div");
    item.className = "row mb-4 align-items-center";
    item.innerHTML = `
      <div class="col-3 text-center">
        <img src="${image}" class="img-fluid rounded shadow-sm" style="max-height: 100px;" alt="${name}">
      </div>
      <div class="col-9">
        <h6 class="fw-bold mb-1">${name}</h6>
        <p class="mb-1 text-muted">Quantity: ${quantity}</p>
        <p class="mb-0 fw-bold">€ ${itemTotal.toFixed(2)}</p>
      </div>
    `;
    listCard.appendChild(item);
  });

  // Versand, Rabatt und Gesamtsumme berechnen
  const shipping = 5;
  const voucherAmount = voucher?.amount ? parseFloat(voucher.amount) : 0;
  const discounted = Math.max(0, subtotal - voucherAmount);
  const total = discounted + shipping;

  // Summe und Hinweise anzeigen
  const totalDiv = document.createElement("div");
  totalDiv.className = "text-end mt-4 border-top pt-3";
  totalDiv.innerHTML = `
    <h5 class="fw-bold">Total: € ${total.toFixed(2)}</h5>
    <p class="text-muted small">
      incl. shipping (€ ${shipping.toFixed(2)})
      ${voucherAmount > 0 ? `, minus voucher (-€ ${voucherAmount.toFixed(2)})` : ''}
      and 20% VAT.
    </p>
  `;

  // Alles zusammensetzen und anhängen
  listCard.appendChild(totalDiv);
  container.appendChild(listCard);
}

document.addEventListener("DOMContentLoaded", fetchSummaryCart); // Alles bei Seitenstart laden
