async function fetchUserData() {
  const res = await fetch('/weben-prj/includes/user-api.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action: 'thisUser' })
  });

  const result = await res.json();
  if (result.status === 'success') {
    populateUserData(result.user);
    document.getElementById('userDataView').classList.remove('d-none');
  } else {
    alert("Fehler beim Laden der Benutzerdaten.");
  }
}

function populateUserData(user) {
  document.getElementById('view-salutation').textContent = user.salutation;
  document.getElementById('view-firstName').textContent = user.first_name;
  document.getElementById('view-lastName').textContent = user.last_name;
  document.getElementById('view-email').textContent = user.email;
  document.getElementById('view-username').textContent = user.username;
}

window.addEventListener('DOMContentLoaded', fetchUserData);
