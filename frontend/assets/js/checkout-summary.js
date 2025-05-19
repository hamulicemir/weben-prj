// Lokale Variablen zum Speichern von Payment und Shipping
let sessionPayment = '-';
let sessionShipping = '-';

document.addEventListener("DOMContentLoaded", async () => {
  try {
    const response = await fetch('../../backend/handlers/checkout-handler.php');
    const data = await response.json();

    console.log(data);
    if (data.status === 'success') {
      sessionPayment = data.payment;
      sessionShipping = data.shipping;

      console.log(data.paymentLabel);
      console.log(data.shippingLabel);
      document.getElementById('payment-method').textContent = data.paymentLabel;
      document.getElementById('shipping-method').textContent = data.shippingLabel;
    } else {
      alert("Fehler beim Laden der Zahlungsdaten.");
    }
  } catch (error) {
    console.error("Fetch error:", error);
    alert("Ein Fehler ist aufgetreten.");
  }
});

document.getElementById('placeOrderBtn').addEventListener('click', async () => {
  const cart = JSON.parse(sessionStorage.getItem('cart') || '[]');

  console.log("Sende Bestellung:", {
    action: 'createOrder',
    payment: sessionPayment,
    shipping: sessionShipping,
    cart: cart
  });

  const response = await fetch('/weben-prj/backend/api/order-api.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      action: 'createOrder',
      payment: sessionPayment,
      shipping: sessionShipping,
      cart: cart
    })
  });

  const result = await response.json();
  if (result.status === 'success') {
    window.location.href = 'order_success.php';
    console.log('Bestell-ID:', result.orderId);
    console.log('Bestell-Details:', result.orderDetails);
    console.log(result)
  } else {
    alert('Bestellung konnte nicht abgeschlossen werden: ' + result.message);
  }
});
