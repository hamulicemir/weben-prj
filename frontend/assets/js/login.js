document.addEventListener("DOMContentLoaded", () => {
    // Falls schon eingeloggt, redirect (per API check)
    fetch("../../backend/handlers/login-handler.php", {
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

        const res = await fetch("../../backend/handlers/login-handler.php", {
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
            if (result.errors.general) showErrorModal(result.errors.general);
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

function showErrorModal(message) {
    const existing = document.getElementById("errorModal");
    if (existing) existing.remove();

    const html = `
        <div class="modal fade" id="errorModal" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center">
                    <div class="modal-header border-0 bg-danger text-white">
                        <h5 class="modal-title w-100">Login Failed</h5>
                    </div>
                    <div class="modal-body border-top">
                        <p>${message}</p>
                    </div>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML("beforeend", html);
    const modal = new bootstrap.Modal(document.getElementById("errorModal"));
    modal.show();
}

});
