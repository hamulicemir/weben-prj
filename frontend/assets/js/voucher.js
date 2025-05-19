// DOM-Referenzen
const voucherTable = document.getElementById('voucherTableBody');
const voucherForm = document.getElementById('voucherForm');
const codeInput = document.getElementById('code');
const amountInput = document.getElementById('amount');
const dateInput = document.getElementById('expiration_date');

//  Edit-Modus speichern
let editMode = false;
let originalCode = '';

// Alle Gutscheine laden und anzeigen
function loadVouchers() {
    fetch('../../backend/api/vouchers-api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'getAll' })
    })
    .then(res => res.json()) // Antwort verarbeiten
    .then(data => {
        voucherTable.innerHTML = '';
        data.data.forEach(v => { // Status berechnen & HTML-Zeilen erzeugen
            const today = new Date().toISOString().split('T')[0];
            const isExpired = v.expiration_date < today;
            const statusText = v.used ? 'Used' : (isExpired ? 'Expired' : 'Active');
            const statusClass = v.used ? 'secondary' : (isExpired ? 'danger' : 'success');
            const rowClass = isExpired ? 'table-danger' : '';
        
            // Zeile einfügen
            const row = `
                <tr class="${rowClass}">
                    <td>${v.code}</td>
                    <td>${parseFloat(v.amount).toFixed(2)}</td>
                    <td>${v.expiration_date}</td>
                    <td><span class="badge bg-${statusClass}">${statusText}</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-dark me-1" onclick="editVoucher('${v.code}', ${v.amount}, '${v.expiration_date}')">Edit</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteVoucher('${v.code}')">Delete</button>
                    </td>
                </tr>`;
            voucherTable.insertAdjacentHTML('beforeend', row); //  neue HTML-Elemente dynamisch "angrenzend" einfügen willst
        });        
    });
}

// Bearbeiten
function editVoucher(code, amount, expiration) {
    editMode = true;
    originalCode = code;
    codeInput.value = code;
    amountInput.value = amount;
    dateInput.value = expiration;
    const modal = new bootstrap.Modal(document.getElementById('voucherModal'));
    modal.show();
}

// Löschen vorbereiten
let deleteCode = '';

function deleteVoucher(code) {
    deleteCode = code;
    document.getElementById('deleteModalText').textContent = `Möchtest du den Gutschein "${code}" wirklich löschen?`;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Löschen bestätigen
document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    fetch('../../backend/api/vouchers-api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'delete', code: deleteCode })
    })
    .then(res => res.json())
    .then(() => {
        bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
        loadVouchers();
    });
});

// Zufallscode generieren lassen
function generateCode() {
    fetch('../../backend/api/vouchers-api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'generate' })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            codeInput.value = data.code;
        }
    });
}

// Speichern (neu oder bearbeiten)
voucherForm.addEventListener('submit', function(e) {
    e.preventDefault(); // Verhindert Reload beim Formular-Submit
    const payload = {
        action: editMode ? 'edit' : 'add',
        code: codeInput.value.trim(),
        amount: parseFloat(amountInput.value),
        expiration_date: dateInput.value
    };
    if (editMode) payload.original_code = originalCode;
    // Bereitet das Datenpaket für die API vor. Bei Bearbeitung wird auch der alte Code mitgeschickt

    //API aufrufen → Modal schließen → Formular zurücksetzen → Tabelle neu laden
    fetch('../../backend/api/vouchers-api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(() => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('voucherModal'));
        modal.hide();
        voucherForm.reset();
        editMode = false;
        loadVouchers();
    });
});

window.addEventListener('DOMContentLoaded', loadVouchers); // Start: Gutscheine automatisch laden
