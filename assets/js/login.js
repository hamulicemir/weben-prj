document.addEventListener("DOMContentLoaded", () => {
    // Falls schon eingeloggt, redirect (per API check)
    fetch("../includes/login-handler.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "check" })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.href = "../pages/index.php";
        }
    });

    const form = document.getElementById("loginForm");
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const login = document.getElementById("login");
        const password = document.getElementById("password");
        const remember = document.getElementById("remember_me").checked;

        // Reset
        login.classList.remove("is-invalid");
        password.classList.remove("is-invalid");

        const formData = new URLSearchParams();
        formData.append("login", login.value);
        formData.append("password", password.value);
        if (remember) formData.append("remember_me", "1");

        const res = await fetch("../includes/login-handler.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: formData.toString()
        });

        const result = await res.json();

        if (result.success) {
            showWelcomeModal();
        } else {
            if (result.errors.email) login.classList.add("is-invalid");
            if (result.errors.password) password.classList.add("is-invalid");
            if (result.errors.general) alert(result.errors.general);
        }
    });

 function showWelcomeModal() {
    const html = `
        <div class="modal fade" id="welcomeModal" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center">
                    <div class="modal-header border-0">
                        <h5 class="modal-title w-100">Welcome!</h5>
                    </div>
                    <div class="modal-body border-top">
                        <p>Welcome back to ICONIQ!</p>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML("beforeend", html);

    const modal = new bootstrap.Modal(document.getElementById("welcomeModal"));
    modal.show();

    setTimeout(() => {
        window.location.href = "../pages/index.php";
    }, 1500);
}
});
