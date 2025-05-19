async function loadEditProfileData() {
  try {
    const res = await fetch('../../backend/api/user-api.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'editProfileData' })
    });

    const result = await res.json();

    if (result.status === 'success') {
      const user = result.user;
      populateEditProfileForm(user);
    } else {
      document.getElementById("profileError").classList.remove("d-none");
      document.getElementById("profileError").textContent = "Fehler beim Laden des Profils.";
    }
  } catch (err) {
    console.error("Fetch error", err);
  }
}

function populateEditProfileForm(user) {
  document.querySelector(`[name="salutation"][value="${user.salutation}"]`).checked = true;
  document.getElementById('first_name').value = user.first_name || '';
  document.getElementById('last_name').value = user.last_name || '';
  document.getElementById('street').value = user.street || '';
  document.getElementById('no').value = user.no || '';
  document.getElementById('addressaddition').value = user.address_addition || '';
  document.getElementById('postal_code').value = user.postal_code || '';
  document.getElementById('city').value = user.city || '';
  document.getElementById('country').value = user.country || '';
  document.getElementById('email').value = user.email || '';
  document.getElementById('username').value = user.username || '';
  document.getElementById('payment_info').value = user.payment_info || '';
}

window.addEventListener('DOMContentLoaded', loadEditProfileData);
