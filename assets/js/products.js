// Führt den Code aus, sobald die Seite vollständig geladen ist
document.addEventListener('DOMContentLoaded', function () {

    // Holt die Kategorien vom PHP-Backend via fetch (AJAX)
    fetch('../includes/get-categories.php')
        .then(res => res.json()) // Wandelt die Antwort in ein JSON-Objekt um
        .then(data => {
            const select = document.getElementById('categorySelect'); // Referenz zum Dropdown-Element
            
            // Fügt jede Kategorie als Option ins Dropdown ein
            data.categories.forEach(cat => {
                const option = document.createElement('option'); // Neue Option erstellen
                option.value = cat.id; // Wert = Kategorie-ID
                option.textContent = cat.name; // Sichtbarer Text = Kategorie-Name
                
                // Wenn es die Default-Kategorie ist, wird sie vorausgewählt
                if (cat.id === data.default) option.selected = true;
                select.appendChild(option); // Option ins Dropdown einfügen
            });
        })
        // Fehlerbehandlung: Ausgabe in der Konsole
        .catch(err => console.error("Kategorien konnten nicht geladen werden:", err));
});

