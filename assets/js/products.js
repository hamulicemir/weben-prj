// Führt den Code aus, sobald das DOM geladen ist
window.addEventListener("DOMContentLoaded", () => {
    const productContainer = document.getElementById("product-list"); // Bereich, wo Produkte angezeigt werden
    const categorySelect = document.getElementById("categorySelect"); // Dropdown für Kategorien (optional)

    // Funktion: Produkte vom Server holen (ggf. mit Kategorie oder Suchbegriff)
    function fetchProducts() {
        let url = "../includes/get-products.php";
        const params = new URLSearchParams();
    
        const search = new URLSearchParams(window.location.search).get("search");
        const selectedCategory = categorySelect?.value;
    
        if (search) params.append("search", search);
        if (selectedCategory) params.append("category", selectedCategory);
    
        if ([...params].length > 0) {
            url += "?" + params.toString();
        }
    
        fetch(url)
            .then(res => res.json())
            .then(products => {
                productContainer.innerHTML = "";
    
                if (products.length === 0) {
                    productContainer.innerHTML = `<div class='alert alert-info'>No products found.</div>`;
                    return;
                }
    
                products.forEach(product => {
                    const card = document.createElement("div");
                    card.className = "col-md-3 mb-4";
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
                    productContainer.appendChild(card);
                });
            })
            .catch(err => {
                productContainer.innerHTML = `<div class='alert alert-danger'>Error loading products</div>`;
                console.error(err);
            });
    }
    

    // Event-Listener für Kategorieauswahl (falls vorhanden)
    if (categorySelect) {
        categorySelect.addEventListener("change", fetchProducts);
    }

    // Kategorien vom Server holen und Dropdown befüllen
    fetch("../includes/get-categories.php")
        .then(res => res.json())
        .then(data => {
            if (!categorySelect) return;
            data.categories.forEach(cat => {
                const option = document.createElement("option");
                option.value = cat.id;
                option.textContent = cat.name;
                if (cat.id === data.default) option.selected = true;
                categorySelect.appendChild(option); // Option hinzufügen
            });

            fetchProducts(); // Produkte laden nachdem Kategorien geladen wurden
        })
        .catch(err => console.error("Fehler beim Laden der Kategorien:", err));

    // Falls keine Kategorieauswahl existiert → direkt laden
    if (!categorySelect) fetchProducts();
});

