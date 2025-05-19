// Funktion zum Abrufen der Benutzerdaten (AJAX)
async function fetchUserData() {
  const res = await fetch('../../backend/api/user-api.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action: 'thisUser' })
  });

  // Ergebnis verarbeiten
  const result = await res.json();
  if (result.status === 'success') {
    populateUserData(result.user); // Benutzerdaten anzeigen
    document.getElementById('userDataView').classList.remove('d-none'); // Profil-Anzeige sichtbar machen
  } else {
    alert("Fehler beim Laden der Benutzerdaten.");
  }
}

// Funktion zum Eintragen der Userdaten in HTML-Felder
function populateUserData(user) {
  document.getElementById('view-salutation').textContent = user.salutation;
  document.getElementById('view-firstName').textContent = user.first_name;
  document.getElementById('view-lastName').textContent = user.last_name;
  document.getElementById('view-email').textContent = user.email;
  document.getElementById('view-username').textContent = user.username;
  document.getElementById('view-street').textContent = user.address;
  document.getElementById('view-zip').textContent = user.postal_code;
  document.getElementById('view-city').textContent = user.city;

}

function populateEditProfileForm(user) {
  // Anrede (Radio Buttons)
  const salutationInput = document.querySelector(`[name="salutation"][value="${user.salutation}"]`);
  if (salutationInput) salutationInput.checked = true;

  // Input-Felder
  document.getElementById('first_name').value = user.first_name || '';
  document.getElementById('last_name').value = user.last_name || '';
  document.getElementById('email').value = user.email || '';
  document.getElementById('username').value = user.username || '';
  document.getElementById('street').value = user.street || '';
  document.getElementById('no').value = user.no || '';
  document.getElementById('addressaddition').value = user.address_addition || '';
  document.getElementById('postal_code').value = user.postal_code || '';
  document.getElementById('city').value = user.city || '';
  document.getElementById('country').value = user.country || '';
  document.getElementById('payment_info').value = user.payment_info || '';
}


window.addEventListener('DOMContentLoaded', fetchUserData); //  Auto-Aufruf beim Laden der Seite
