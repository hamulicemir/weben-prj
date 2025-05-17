// Führt den Code aus, sobald das DOM geladen ist
window.addEventListener("DOMContentLoaded", () => {
    const productContainer = document.getElementById("product-list");
    const categorySelect = document.getElementById("categorySelect");

    // Produkte vom Server holen (ggf. mit Kategorie oder Suchbegriff)
    function fetchProducts() {
        let url = "../includes/product-api.php?action=getAll";
        const params = new URLSearchParams();


        // hole Search und Category aus der URL
        const search = new URLSearchParams(window.location.search).get("search");
        const selectedCategory = categorySelect?.value;

        if (search) params.append("search", search);
        if (selectedCategory) params.append("category", selectedCategory);

        if ([...params].length > 0) {
            url += "&" + params.toString();
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

    // Live-Suche beim Tippen im Suchfeld
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener("input", () => {
            const query = searchInput.value.trim();

            // URL-Parameter aktualisieren (nur im Speicher)
            const newParams = new URLSearchParams(window.location.search);
            if (query) {
                newParams.set("search", query);
            } else {
                newParams.delete("search");
            }

            // Pfad aktualisieren (kein Reload!)
            const newUrl = window.location.pathname + "?" + newParams.toString();
            window.history.replaceState(null, "", newUrl);

            fetchProducts(); // Ergebnisse neu laden
        });
    }

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

    // Drop-Ziel dynamisch erstellen
    const dropZone = document.createElement("div");
    dropZone.id = "customDropZone";
    dropZone.className = "position-fixed end-0 top-50 translate-middle-y p-3 bg-light border rounded shadow text-center";
    dropZone.style.zIndex = "1050";
    dropZone.style.width = "15%";
    dropZone.style.height = "100%";
    dropZone.style.cursor = "pointer";
    dropZone.style.display = "none";
    dropZone.style.position = "relative";
    dropZone.innerHTML = `
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
            <strong>Drop the item<br>to add it to the cart</strong>
        </div>
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
        addToCart(productId);
        console.log("Produkt per Drag & Drop in die Drop-Zone:", productId);
        showCartToast("🛒 Product has been added to the cart!");

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
                <a href="#" class="text-uppercase small text-decoration-none text-dark product-click fs-5" data-id="${product.id}">
                    ${product.name}
                </a>
                <button class="btn btn-md btn-outline-dark add-to-cart-btn" data-id="${product.id}" title="Add to the cart">
                    <i class="bi bi-cart"></i>
                </button>
            </div>
            <div class="text-end fw-medium fs-5">€ ${product.price}</div>

            <div class="d-flex justify-content-between align-items-center mt-1">
    <small class="text-muted">${product.colour}</small>
    <div class="text-warning small">Rating: ${getStars(product.rating)}</div>
</div>
        </div>
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
        addToCart(product.id);
        showCartToast(`„${product.name}“ has been added to the cart!`);
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

// Bewertung
function getStars(rating) {
    const validRating = parseFloat(rating);
    if (isNaN(validRating)) return "No rating";

    const maxStars = 5;
    const roundedStars = Math.round(validRating); // rundet auf volle Zahl

    const stars = "★".repeat(roundedStars).padEnd(maxStars, "☆");
    return `${validRating.toFixed(1)} ${stars}`;
}



async function addToCart(productId, quantity = 1) {
    try {
        const res = await fetch("../includes/cart-api.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                action: "add",
                productId: productId,
                quantity: quantity
            })
        });

        const result = await res.json();
        console.log("Warenkorb-Update:", result);
        if (result.status === "ok") {
            showCartToast("✔️ Product has been added to the cart!");

            // Warenkorb-Zähler in Navbar aktualisieren
            if (typeof window.updateCartCount === "function") {
                window.updateCartCount();
            }
        } else {
            alert("Fehler beim Hinzufügen zum Warenkorb.");
        }
    } catch (err) {
        console.error("Fehler bei addToCart:", err);
        alert("Fehler beim Hinzufügen zum Warenkorb.");
    }
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
function showCartToast(message = "Product has been added to the cart!") {
    const toastEl = document.getElementById('cartToast');
    if (!toastEl) {
        return;
    }

    toastEl.querySelector('.toast-body').textContent = message;

    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}


// Warenkorb-Button im Modal
document.getElementById("addToCartBtn").addEventListener("click", () => {
    const productId = document.getElementById("addToCartBtn").dataset.productId;
    addToCart(productId);
    showCartToast("🛒 Produkt erfolgreich hinzugefügt!");
});


