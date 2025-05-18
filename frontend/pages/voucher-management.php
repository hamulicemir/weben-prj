<?php session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: ../pages/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - Vouchers</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php include '../components/navbar.php'; ?>

<main class="container py-5">
    <h1 class="">Vouchers Management</h1>
    <p class="fs-4">Here you can manage your vouchers. You can add, edit, and delete vouchers.</p>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fs-3 mb-0">Voucher Management</h5>
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#voucherModal">Add Voucher</button>
            </div>

            <!-- Voucher Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Amount (€)</th>
                            <th>Expires</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="voucherTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Voucher Modal -->
<div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="voucherModalLabel">Voucher Management</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="voucherForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">Voucher Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="code" name="code" maxlength="10" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="generateCode()">Generate</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount (€)</label>
                        <input type="number" step="1" class="form-control" id="amount" name="amount" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="expiration_date" class="form-label">Expiration Date</label>
                        <input type="date" class="form-control" id="expiration_date" name="expiration_date" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirm Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-sm">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Gutschein löschen</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="deleteModalText">Wirklich löschen?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Löschen</button>
      </div>
    </div>
  </div>
</div>

<script src="../assets/js/voucher.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../components/footer.php'; ?>
</body>
</html>
