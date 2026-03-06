/* =========================================
   GLOBAL STATE
========================================= */

let selectedUserId = null;
let requiredText = '';
let researchList = [];

/* =========================================
   USER ACTIVATE / DEACTIVATE
========================================= */

function confirmDeactivate(id, name) {
    openModal(
        "Deactivate User",
        `You are about to deactivate ${name}. Type 'inactive' to confirm.`,
        "inactive",
        id,
        "#dc2626"
    );
}

function confirmActivate(id, name) {
    openModal(
        "Activate User",
        `You are about to activate ${name}. Type 'active' to confirm.`,
        "active",
        id,
        "#16a34a"
    );
}

function openModal(title, text, required, id, color) {
    const modal = document.getElementById('confirmModal');
    const btn = document.getElementById('confirmBtn');

    if (!modal || !btn) return;

    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalText').innerText = text;
    document.getElementById('confirmInput').value = '';

    btn.style.background = color;

    requiredText = required;
    selectedUserId = id;

    modal.style.display = 'flex';
}

function closeModal() {
    const modal = document.getElementById('confirmModal');
    if (modal) modal.style.display = 'none';
}

/* =========================================
   FETCH TOGGLE STATUS
========================================= */

function handleToggleStatus() {
    const confirmBtn = document.getElementById('confirmBtn');
    const inputField = document.getElementById('confirmInput');

    if (!confirmBtn || !inputField) return;

    const input = inputField.value.toLowerCase().trim();

    if (input !== requiredText) {
        showToast(`You must type '${requiredText}' to confirm.`, "error");
        return;
    }

    confirmBtn.disabled = true;

    fetch(BASE_URL + "/superadmin/user/toggle", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${encodeURIComponent(selectedUserId)}&status=${encodeURIComponent(requiredText)}`
    })
    .then(res => res.json())
    .then(data => {

        confirmBtn.disabled = false;

        if (!data.success) {
            showToast("Something went wrong.", "error");
            return;
        }

        showToast(
            data.status === "active"
                ? "User activated successfully."
                : "User deactivated successfully.",
            "success"
        );

        updateUserRow(data.id, data.status);
        closeModal();
    })
    .catch(() => {
        confirmBtn.disabled = false;
        showToast("Server error occurred.", "error");
    });
}

function updateUserRow(id, status) {

    const statusCell = document.getElementById(`user-status-${id}`);
    const actionCell = document.getElementById(`user-action-${id}`);

    if (!statusCell || !actionCell) return;

    if (status === "active") {
        statusCell.innerHTML = `<span class="badge-active">Active</span>`;
        actionCell.innerHTML = `
            <button class="btn-danger-modern"
                onclick="confirmDeactivate(${id}, 'User')">
                Deactivate
            </button>`;
    } else {
        statusCell.innerHTML = `<span class="badge-inactive">Inactive</span>`;
        actionCell.innerHTML = `
            <button class="btn-success-modern"
                onclick="confirmActivate(${id}, 'User')">
                Activate
            </button>`;
    }
}

/* =========================================
   TOAST NOTIFICATION
========================================= */

function showToast(message, type = "success") {

    let toast = document.getElementById("toast");

    if (!toast) {
        toast = document.createElement("div");
        toast.id = "toast";
        toast.className = "modern-toast";
        document.body.appendChild(toast);
    }

    toast.textContent = message;
    toast.className = `modern-toast show ${type}`;

    setTimeout(() => {
        toast.classList.remove("show");
    }, 3000);
}

/* =========================================
   PASSWORD VALIDATION
========================================= */

function validatePasswordStrength(password) {
    const minLength = 8;
    const hasUpper = /[A-Z]/.test(password);
    const hasLower = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);

    if (password.length < minLength) {
        return "Password must be at least 8 characters.";
    }

    if (!hasUpper || !hasLower || !hasNumber) {
        return "Password must contain uppercase, lowercase and a number.";
    }

    return null;
}

function initRegisterValidation() {

    const form = document.getElementById("registerForm");
    const passwordInput = document.getElementById("password");
    const confirmInput = document.getElementById("confirm_password");
    const submitBtn = form ? form.querySelector("button[type='submit']") : null;

    if (!form || !passwordInput || !confirmInput) return;

    function validatePasswords() {

        const password = passwordInput.value.trim();
        const confirm = confirmInput.value.trim();

        const strengthError = validatePasswordStrength(password);

        if (strengthError) {
            showToast(strengthError, "error");
            return false;
        }

        if (password !== confirm) {
            showToast("Passwords do not match.", "error");
            return false;
        }

        return true;
    }

    confirmInput.addEventListener("input", function () {

        if (!passwordInput.value || !confirmInput.value) {
            confirmInput.style.borderColor = "";
            return;
        }

        confirmInput.style.borderColor =
            passwordInput.value === confirmInput.value
                ? "#16a34a"
                : "#dc2626";
    });

    form.addEventListener("submit", function (e) {

        if (!validatePasswords()) {
            e.preventDefault();
            return;
        }

        // Show loading state
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerText = "Registering...";
        }

        // Let form submit normally
    });
}

/* =========================================
   RESEARCH INTEREST TAG SYSTEM
========================================= */

function initResearchInterestSystem() {

    const researchInput = document.getElementById("researchInput");
    const addBtn = document.getElementById("addResearchBtn");
    const tagsContainer = document.getElementById("researchTags");
    const hiddenInput = document.getElementById("researchHidden");

    if (!researchInput || !addBtn || !tagsContainer || !hiddenInput) return;

    function renderTags() {

        tagsContainer.innerHTML = "";

        researchList.forEach((item, index) => {

            const tag = document.createElement("div");
            tag.className = "research-tag";

            tag.innerHTML = `
                ${item}
                <button type="button" data-index="${index}">×</button>
            `;

            tagsContainer.appendChild(tag);
        });

        // Save as pipe-separated string
        hiddenInput.value = researchList.join("|");
    }

    addBtn.addEventListener("click", function () {

        const value = researchInput.value.trim();

        if (!value) return;

        if (researchList.includes(value)) {
            showToast("Research interest already added.", "error");
            return;
        }

        researchList.push(value);
        renderTags();
        researchInput.value = "";
    });

    researchInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            addBtn.click();
        }
    });

    tagsContainer.addEventListener("click", function (e) {

        if (e.target.tagName === "BUTTON") {

            const index = e.target.getAttribute("data-index");

            researchList.splice(index, 1);
            renderTags();
        }
    });
}

/* =========================================
   INIT
========================================= */

document.addEventListener("DOMContentLoaded", function () {

    const confirmBtn = document.getElementById("confirmBtn");
    if (confirmBtn) {
        confirmBtn.addEventListener("click", handleToggleStatus);
    }

    initRegisterValidation();
    initResearchInterestSystem();

});