<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - Products</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php include '../includes/navbar.php'; ?> <!-- navbar -->
<main class="py-5">

  <div class="container">
    <div id="product-list" class="row"></div>
  </div>
  
</main>
<?php include '../includes/footer.php'; ?> <!-- Footer -->

<script>
fetch('../includes/get-products.php')
  .then(response => response.json())
  .then(products => {
    const container = document.getElementById('product-list');
    container.innerHTML = ''; // Reset
    
    products.forEach(product => {
      const card = document.createElement('div');
      card.className = 'col-md-3 mb-4';
      card.innerHTML = `
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">${product.name}</h5>
            <p class="card-text small">${product.description}</p>
            <p class="fw-bold mb-1">€ ${product.price}</p>
            <span class="badge bg-secondary">${product.gender}</span>
            <span class="badge bg-light text-dark border ms-1">${product.colour}</span>
          </div>
        </div>
      `;
      container.appendChild(card);
    });
  })
  .catch(err => {
    document.getElementById('product-list').innerHTML = `<div class="alert alert-danger">Fehler beim Laden der Produkte</div>`;
    console.error(err);
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>