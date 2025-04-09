// Führt den Code aus, sobald das DOM geladen ist
window.addEventListener("DOMContentLoaded", () => {
    const productContainer = document.getElementById("product-list");
    const categorySelect = document.getElementById("categorySelect");

    // Produkte vom Server holen (ggf. mit Kategorie oder Suchbegriff)
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
                    productContainer.innerHTML = `<div class='alert alert-info mt-3'>No products found.</div>`;
                    return;
                }

                products.forEach(product => {
                    const card = createProductCard(product);
                    productContainer.appendChild(card);
                });
            })
            .catch(err => {
                productContainer.innerHTML = `<div class='alert alert-danger'>Error loading products</div>`;
                console.error(err);
            });
    }

    // Kategorie-Änderung
    if (categorySelect) {
        categorySelect.addEventListener("change", fetchProducts);
    }

    // Kategorien laden
    fetch("../includes/get-categories.php")
        .then(res => res.json())
        .then(data => {
            if (!categorySelect) return;
            data.categories.forEach(cat => {
                const option = document.createElement("option");
                option.value = cat.id;
                option.textContent = cat.name;
                if (cat.id === data.default) option.selected = true;
                categorySelect.appendChild(option);
            });

            fetchProducts(); // Produkte laden
        })
        .catch(err => console.error("Fehler beim Laden der Kategorien:", err));

    if (!categorySelect) fetchProducts();

    // 🧲 Drop-Ziel dynamisch erstellen
    const dropZone = document.createElement("div");
    dropZone.id = "customDropZone";
    dropZone.className = "position-fixed end-0 top-50 translate-middle-y p-3 bg-light border rounded shadow text-center";
    dropZone.style.zIndex = "1050";
    dropZone.style.width = "220px";
    dropZone.style.cursor = "pointer";
    dropZone.style.display = "none"; // <- wird nur sichtbar beim Draggen

    dropZone.innerHTML = `
        <strong>Drop the item<br>to add it to the cart</strong>
    `;

    document.body.appendChild(dropZone);

    // Drop-Zone Events
    dropZone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZone.classList.add("border-primary", "bg-white");
    });

    dropZone.addEventListener("dragleave", () => {
        dropZone.classList.remove("border-primary", "bg-white");
    });

    dropZone.addEventListener("drop", (e) => {
        e.preventDefault();
        dropZone.classList.remove("border-primary", "bg-white");

        const productId = e.dataTransfer.getData("text/plain");
        console.log("Produkt per Drag & Drop in die Drop-Zone:", productId);
        alert("Produkt wurde erfolgreich dem Warenkorb hinzugefügt!");

        hideDropZone();
    });

    // Drop-Zone Steuerung (ohne Animation)
    window.showDropZone = function () {
        dropZone.style.display = "block";
    };

    window.hideDropZone = function () {
        dropZone.style.display = "none";
    };
});


// Funktion: Produkt-Card generieren
function createProductCard(product) {
    const col = document.createElement("div");
    col.className = "col-12 col-md-4 mb-4 d-flex";
    col.setAttribute("draggable", "true");
    col.dataset.productId = product.id;

    col.innerHTML = `
        <div class="w-100 d-flex flex-column bg-white h-100 p-2 position-relative">
            <img src="${product.image || '../assets/img/products/no-image-available.jpg'}" 
                 class="img-fluid w-100 cursor-pointer product-click" 
                 alt="${product.name}" data-id="${product.id}">

            <div class="pt-2 d-flex justify-content-between align-items-center mt-auto">
                <a href="#" class="text-uppercase small text-decoration-none text-dark product-click" data-id="${product.id}">
                    ${product.name}
                </a>
                <button class="btn btn-sm btn-outline-dark add-to-cart-btn" data-id="${product.id}" title="In den Warenkorb">
                    <i class="bi bi-cart"></i>
                </button>
            </div>
            <div class="text-end fw-medium">€ ${product.price}</div>
        </div>
    `;

    // Klick auf Name oder Bild öffnet Modal
    col.querySelectorAll(".product-click").forEach(el => {
        el.addEventListener("click", (e) => {
            e.preventDefault();
            showProductModal(product);
        });
    });

    // Warenkorb-Button
    col.querySelector(".add-to-cart-btn").addEventListener("click", (e) => {
        e.stopPropagation();
        console.log("Produkt in Warenkorb:", product.id);
        alert(`„${product.name}“ wurde zum Warenkorb hinzugefügt!`);
    });

    // Drag & Drop
    col.addEventListener("dragstart", (e) => {
        e.dataTransfer.setData("text/plain", product.id);
        e.dataTransfer.effectAllowed = "move";
        if (typeof showDropZone === "function") showDropZone();
    });

    col.addEventListener("dragend", () => {
        if (typeof hideDropZone === "function") hideDropZone();
    });

    return col;
}


// Funktion: Produkt-Modal anzeigen
function showProductModal(product) {
    document.getElementById("modalImage").src = product.image || '../assets/img/products/no-image-available.jpg';
    document.getElementById("modalTitle").textContent = product.name;
    document.getElementById("modalPrice").textContent = `€ ${product.price}`;
    document.getElementById("addToCartBtn").dataset.productId = product.id;

    const modal = new bootstrap.Modal(document.getElementById("productModal"));
    modal.show();
}


// Warenkorb-Button im Modal
document.getElementById("addToCartBtn").addEventListener("click", () => {
    const productId = document.getElementById("addToCartBtn").dataset.productId;
    console.log("Produkt aus Modal in Warenkorb:", productId);
    alert("Produkt wurde zum Warenkorb hinzugefügt!");
});
