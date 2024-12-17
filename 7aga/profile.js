document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".profile-form");

    form.addEventListener("submit", (event) => {
        const password = document.getElementById("password").value.trim();
        const confirmPassword = document.getElementById("confirm-password").value.trim();

        if (password !== confirmPassword) {
            event.preventDefault();
            alert("Passwords do not match!");
        }

        const email = document.getElementById("email").value.trim();
        if (!/\S+@\S+\.\S+/.test(email)) {
            event.preventDefault();
            alert("Please enter a valid email address.");
        }
    });
});
