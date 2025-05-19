// Suchfeld (toggle durch Klick aufs Icon)
document.getElementById('searchIcon').addEventListener('click', function (event) {
    event.preventDefault(); // verhindert, dass z. B. ein Link navigiert
    const searchBox = document.getElementById('searchBox');
    // Toggle: Zeige oder verstecke das Suchfeld
    searchBox.style.display = (searchBox.style.display === 'none') ? 'block' : 'none';
});

// Alles erst nach DOM-Load
document.addEventListener("DOMContentLoaded", function () {
    // Suche absenden und Weiterleitung mit Query-String
    const searchForm = document.getElementById("searchForm");
    const searchInput = document.getElementById("searchInput");

    if (searchForm) {
        searchForm.addEventListener("submit", function (e) {
            e.preventDefault(); // verhindert Reload
            const query = searchInput.value.trim(); // eingegebener Suchbegriff
            if (query) {
                // Geschlecht aus der aktuellen URL extrahieren (falls vorhanden)
                const gender = new URLSearchParams(window.location.search).get("gender");
                // URL bauen mit search (und evtl. gender)
                let url = "/weben-prj/frontend/pages/products.php?search=" + encodeURIComponent(query);
                if (gender) {
                    url += "&gender=" + encodeURIComponent(gender);
                }
                window.location.href = url; // Weiterleitung zur Ergebnisliste
            }
        });
    }
    

    // Benutzerinformationen für Dropdown laden
    fetch("../../backend/api/user-api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "thisUser" })
    })
        .then(res => res.json())
        .then(data => {
            const wrapper = document.getElementById("userDropdownWrapper");
            const menu = document.getElementById("userDropdownMenu");

            menu.innerHTML = "";  // vorherige Einträge entfernen

            if (data.status === "success") {
                const user = data.user;
                wrapper.style.display = "block";

                // Username im Dropdown anzeigen
                const usernameItem = document.createElement("li");
                usernameItem.innerHTML = `<h6 class="dropdown-header">Welcome ${user.username}!</h6>`;
                menu.appendChild(usernameItem);

                // Standard-Links für eingeloggte Benutzer
                const entries = [
                    { label: "My Account", href: "user-account.php" },
                    { label: "My Orders", href: "orders.php" }
                ];

                 // Zusätzliche Admin-Menüpunkte
                if (user.role === "admin") {
                    entries.push({ divider: true });
                    entries.push({ label: "Manage Users", href: "customer-management.php" });
                    entries.push({ label: "Manage Products", href: "edit-products.php" });
                    entries.push({ label: "Manage Vouchers", href: "voucher-management.php" });
                }

                 // Logout-Link
                entries.push({ divider: true });
                entries.push({ label: "Logout", href: "../components/logout.php", class: "text-danger" });

                // Alle Menüeinträge als <li> einfügen
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
                // Falls nicht eingeloggt: Dropdown zu Login-Link umbauen
                wrapper.style.display = "block";
                const userToggle = document.getElementById("userDropdown");
                userToggle.removeAttribute("data-bs-toggle"); // dropdown deaktivieren
                userToggle.removeAttribute("aria-expanded"); // optional für Barrierefreiheit
                userToggle.classList.remove("dropdown-toggle"); // Chevron-Symbol entfernen
                userToggle.href = "../pages/login.php"; // direkt zur Login-Seite
            }
        });

    // Warenkorbanzahl aktualisieren (global aufrufbar)
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
                // Produkte summieren (alle Mengen zusammenzählen)
                if (data.status === "ok" && Array.isArray(data.products)) {
                    data.products.forEach(item => {
                        count += item.quantity ?? 1;
                    });
                }
                // In Navbar anzeigen
                const countSpan = document.getElementById("cart-count");
                if (countSpan) {
                    countSpan.textContent = count;
                }
            })
            .catch(error => console.error("Fehler beim Laden der Warenkorbanzahl:", error));
    };

    window.updateCartCount(); // Sofort ausführen beim Laden
});
