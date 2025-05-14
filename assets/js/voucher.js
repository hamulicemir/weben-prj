const voucherTable = document.getElementById('voucherTableBody');
const voucherForm = document.getElementById('voucherForm');
const codeInput = document.getElementById('code');
const amountInput = document.getElementById('amount');
const dateInput = document.getElementById('expiration_date');

let editMode = false;
let originalCode = '';

function loadVouchers() {
    fetch('../includes/vouchers-api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'getAll' })
    })
    .then(res => res.json())
    .then(data => {
        voucherTable.innerHTML = '';
        data.data.forEach(v => {
            const row = `
                <tr>
                    <td>${v.code}</td>
                    <td>${parseFloat(v.amount).toFixed(2)}</td>
                    <td>${v.expiration_date}</td>
                    <td>${v.used ? 'Used' : 'Active'}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-dark me-1" onclick="editVoucher('${v.code}', ${v.amount}, '${v.expiration_date}')">Edit</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteVoucher('${v.code}')">Delete</button>
                    </td>
                </tr>`;
            voucherTable.insertAdjacentHTML('beforeend', row);
        });
    });
}

function editVoucher(code, amount, expiration) {
    editMode = true;
    originalCode = code;
    codeInput.value = code;
    amountInput.value = amount;
    dateInput.value = expiration;
    const modal = new bootstrap.Modal(document.getElementById('voucherModal'));
    modal.show();
}

let deleteCode = '';

function deleteVoucher(code) {
    deleteCode = code;
    document.getElementById('deleteModalText').textContent = `Möchtest du den Gutschein "${code}" wirklich löschen?`;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    fetch('../includes/vouchers-api.php', {
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

function generateCode() {
    fetch('../includes/vouchers-api.php', {
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

voucherForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const payload = {
        action: editMode ? 'edit' : 'add',
        code: codeInput.value.trim(),
        amount: parseFloat(amountInput.value),
        expiration_date: dateInput.value
    };
    if (editMode) payload.original_code = originalCode;

    fetch('../includes/vouchers-api.php', {
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

window.addEventListener('DOMContentLoaded', loadVouchers);
