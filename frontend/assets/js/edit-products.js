document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("productForm");
    const productList = document.getElementById("productList");
    const actionField = document.getElementById("formAction");
    const categorySelect = document.getElementById("categorySelect");

    // Kategorien laden
    fetch("../../backend/api/get-categories.php")
        .then(res => res.json())
        .then(data => {
            data.categories
                .filter(cat => cat.id !== 0) // Entfernt "All Categories"
                .forEach(cat => {
                    const option = document.createElement("option");
                    option.value = cat.id;
                    option.textContent = cat.name;
                    categorySelect.appendChild(option);
                });
        });

    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const res = await fetch("../../backend/api/product-admin-api.php", {
                method: "POST",
                body: formData
            });
            const result = await res.json();

            if (result.status === "ok") {
                alert("Success");
                loadProducts();
                form.reset();
                actionField.value = "create";
                form.productId.value = "";
                document.getElementById("updateBtn").classList.add("d-none");
                document.getElementById("createBtn").classList.remove("d-none");
            } else {
                alert("Error: " + (result.error || "Unknown error"));
            }
        } catch (err) {
            alert("An error has occurred");
            console.error(err);
        }
    });

    async function loadProducts() {
        try {
            const res = await fetch("../../backend/api/product-api.php?action=getAll");
            const products = await res.json();
            productList.innerHTML = "";

            products.forEach(p => {
                const col = document.createElement("div");
                col.className = "col";

                col.innerHTML = `
    <div class="card h-100 shadow-sm">
        ${p.image ? `<img src="${p.image.replace('../../frontend', '/weben-prj/frontend')}" class="card-img-top" alt="${p.name}" style="object-fit: cover; max-height: 180px;">` : ''}
        <div class="card-body">
            <h5 class="card-title">${p.name}</h5>
            <p class="card-text small">${p.description}</p>
            <p class="card-text small text-muted">${p.gender === 'men' ? 'For Men' : p.gender === 'women' ? 'For Women' : ''}</p>
            <p class="card-text mb-2"><strong>€${parseFloat(p.price).toFixed(2)}</strong> · ⭐ ${p.rating}</p>
            <p class="card-text small text-muted">Stock: ${p.stock}</p>
            <button onclick="editProduct(${p.id})" class="btn btn-sm btn-outline-secondary me-2">Edit Product</button>
            <button onclick="deleteProduct(${p.id})" class="btn btn-sm btn-outline-danger">Delete Product</button>
        </div>
    </div>
`;


                productList.appendChild(col);
            });
        } catch (err) {
            alert("Error when loading the products");
            console.error(err);
        }
    }


    window.editProduct = async function (id) {
        try {
            const res = await fetch(`../../backend/api/product-api.php?action=getById&id=${id}`);
            const product = await res.json();

            form.productId.value = product.id;
            form.name.value = product.name;
            form.description.value = product.description;
            form.category_id.value = product.category_id ?? "";
            form.price.value = product.price;
            form.rating.value = product.rating;
            form.gender.value = product.gender ?? "";
            form.stock.value = product.stock;
            actionField.value = "update";

            const preview = document.getElementById("imagePreview");
            preview.src = product.image || "../assets/img/products/no-image-available.jpg";
            preview.style.display = "block";
            form.scrollIntoView({ behavior: "smooth" });

            document.getElementById("updateBtn").classList.remove("d-none");
            document.getElementById("createBtn").classList.add("d-none");

        } catch (err) {
            alert("Error during loading product");
            console.error(err);
        }
    };


    window.deleteProduct = async function (id) {
        if (!confirm("Delete this product?")) return;

        const formData = new FormData();
        formData.append("action", "delete");
        formData.append("id", id);

        try {
            const res = await fetch("../../backend/api/product-admin-api.php", {
                method: "POST",
                body: formData
            });

            const result = await res.json();
            if (result.status === "ok") {
                loadProducts();
            } else {
                alert("Error: " + (result.error || "Unknown error"));
            }
        } catch (err) {
            alert("Error during deletion");
            console.error(err);
        }
    };

    loadProducts();
});
