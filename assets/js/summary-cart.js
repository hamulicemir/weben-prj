async function fetchSummaryCart() {
  const res = await fetch('../includes/cart-api.php', {
    method: 'POST',
    body: JSON.stringify({ action: 'get' }),
    headers: { 'Content-Type': 'application/json' }
  });
  const result = await res.json();
  renderSummaryCart(result.products);
}

function renderSummaryCart(products) {
  const container = document.getElementById('summary-products');
  container.innerHTML = "";

  if (!products || products.length === 0) {
    container.innerHTML = `<div class="alert alert-warning text-center">Warenkorb ist leer</div>`;
    return;
  }

  let total = 0;

  const listCard = document.createElement("div");
  listCard.className = "card shadow rounded-4 p-4 mb-4";

  listCard.innerHTML = `<h4 class="mb-4">Deine Produkte</h4>`;

  products.forEach(product => {
    const name = product.name ?? 'Produkt';
    const quantity = product.quantity ?? 1;
    const price = parseFloat(product.price ?? 0);
    const image = product.image ?? "../assets/img/products/no-image-available.jpg";
    const subtotal = (price * quantity).toFixed(2);
    total += parseFloat(subtotal);

    const item = document.createElement("div");
    item.className = "row mb-4 align-items-center";

    item.innerHTML = `
      <div class="col-3 text-center">
        <img src="${image}" class="img-fluid rounded shadow-sm" style="max-height: 100px;" alt="${name}">
      </div>
      <div class="col-9">
        <h6 class="fw-bold mb-1">${name}</h6>
        <p class="mb-1 text-muted">Menge: ${quantity}</p>
        <p class="mb-0 fw-bold">€ ${subtotal}</p>
      </div>
    `;

    listCard.appendChild(item);
  });

  const totalDiv = document.createElement("div");
  totalDiv.className = "text-end mt-4 border-top pt-3";
  totalDiv.innerHTML = `
    <h5 class="fw-bold">Gesamtsumme: € ${(total + 5).toFixed(2)}</h5>
    <p class="text-muted small">inkl. Versand (€ 5) und 20% MwSt.</p>
  `;

  listCard.appendChild(totalDiv);
  container.appendChild(listCard);
}

document.addEventListener("DOMContentLoaded", fetchSummaryCart);
