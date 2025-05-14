document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("productForm");
    const productList = document.getElementById("productList");
    const actionField = document.getElementById("formAction");

    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const res = await fetch("../includes/product-admin-api.php", {
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
            } else {
                alert("Fehler: " + (result.error || "Unbekannter Fehler"));
            }
        } catch (err) {
            alert("Ein Fehler ist aufgetreten");
            console.error(err);
        }
    });

    async function loadProducts() {
        try {
            const res = await fetch("../includes/product-api.php?action=getAll");
            const products = await res.json();
            productList.innerHTML = "";

            products.forEach(p => {
                const div = document.createElement("div");
                div.innerHTML = `
                    <strong>${p.name}</strong> - €${parseFloat(p.price).toFixed(2)}<br>
                    ${p.image ? `<img src="../${p.image}" alt="${p.name}" style="max-width: 100px;"><br>` : ''}
                    <button onclick="editProduct(${p.id})">Edit</button>
                    <button onclick="deleteProduct(${p.id})">Delete</button>
                `;
                productList.appendChild(div);
            });
        } catch (err) {
            alert("Fehler beim Laden der Produkte");
            console.error(err);
        }
    }

    window.editProduct = async function (id) {
        try {
            const res = await fetch(`../includes/product-api.php?action=getById&id=${id}`);
            const product = await res.json();

            form.productId.value = product.id;
            form.name.value = product.name;
            form.description.value = product.description;
            form.price.value = product.price;
            form.rating.value = product.rating;
            actionField.value = "update";
        } catch (err) {
            alert("Fehler beim Laden des Produkts");
            console.error(err);
        }
    };

    window.deleteProduct = async function (id) {
        if (!confirm("Delete this product?")) return;

        const formData = new FormData();
        formData.append("action", "delete");
        formData.append("id", id);

        try {
            const res = await fetch("../includes/product-admin-api.php", {
                method: "POST",
                body: formData
            });

            const result = await res.json();
            if (result.status === "ok") {
                loadProducts();
            } else {
                alert("Fehler: " + (result.error || "Unbekannter Fehler"));
            }
        } catch (err) {
            alert("Fehler beim Löschen");
            console.error(err);
        }
    };

    loadProducts();
});
