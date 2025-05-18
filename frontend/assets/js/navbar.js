document.getElementById('searchIcon').addEventListener('click', function (event) {
    event.preventDefault();
    const searchBox = document.getElementById('searchBox');
    searchBox.style.display = (searchBox.style.display === 'none') ? 'block' : 'none';
});

document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("searchForm");
    const searchInput = document.getElementById("searchInput");

    if (searchForm) {
        searchForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const query = searchInput.value.trim();
            if (query) {
                window.location.href = "../../pages/products.php?search=" + encodeURIComponent(query);
            }
        });
    }

    // Benutzerinformationen laden
    fetch("../../backend/api/user-api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "thisUser" })
    })
        .then(res => res.json())
        .then(data => {
            const wrapper = document.getElementById("userDropdownWrapper");
            const menu = document.getElementById("userDropdownMenu");

            menu.innerHTML = "";

            if (data.status === "success") {
                const user = data.user;
                wrapper.style.display = "block";

                // Username im Dropdown anzeigen
                const usernameItem = document.createElement("li");
                usernameItem.innerHTML = `<h6 class="dropdown-header">Welcome ${user.username}!</h6>`;
                menu.appendChild(usernameItem);

                const entries = [
                    { label: "My Account", href: "user-account.php" },
                    { label: "My Orders", href: "orders.php" }
                ];

                if (user.role === "admin") {
                    entries.push({ divider: true });
                    entries.push({ label: "Manage Users", href: "customer-management.php" });
                    entries.push({ label: "Manage Products", href: "edit-products.php" });
                    entries.push({ label: "Manage Vouchers", href: "voucher-management.php" });
                }

                entries.push({ divider: true });
                entries.push({ label: "Logout", href: "logout.php", class: "text-danger" });

                entries.forEach(item => {
                    const li = document.createElement("li");
                    if (item.divider) {
                        li.innerHTML = '<hr class="dropdown-divider">';
                    } else {
                        li.innerHTML = `<a class="dropdown-item ${item.class ?? ''}" href="${item.href}">${item.label}</a>`;
                    }
                    menu.appendChild(li);
                });
            } else {
                wrapper.style.display = "block";
                const userToggle = document.getElementById("userDropdown");
                userToggle.removeAttribute("data-bs-toggle"); // dropdown deaktivieren
                userToggle.removeAttribute("aria-expanded"); // optional für Barrierefreiheit
                userToggle.classList.remove("dropdown-toggle"); // Chevron-Symbol entfernen
                userToggle.href = "../pages/login.php"; // direkt zur Login-Seite
            }
        });

    // Warenkorbanzahl aktualisieren
    window.updateCartCount = function () {
        fetch("../../backend/api/cart-api.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ action: "get" })
        })
            .then(response => response.json())
            .then(data => {
                let count = 0;
                if (data.status === "ok" && Array.isArray(data.products)) {
                    data.products.forEach(item => {
                        count += item.quantity ?? 1;
                    });
                }
                const countSpan = document.getElementById("cart-count");
                if (countSpan) {
                    countSpan.textContent = count;
                }
            })
            .catch(error => console.error("Fehler beim Laden der Warenkorbanzahl:", error));
    };

    window.updateCartCount();
});
