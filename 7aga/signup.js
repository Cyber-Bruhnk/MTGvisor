// Frontend validation for the signup form
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".signup-form");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm-password");

    form.addEventListener("submit", (event) => {
        // Validate password match
        if (passwordInput.value !== confirmPasswordInput.value) {
            event.preventDefault();
            alert("Passwords do not match. Please try again.");
        }

        // Additional validations (optional)
        const username = document.getElementById("username").value.trim();
        const email = document.getElementById("email").value.trim();

        if (!username || !email) {
            event.preventDefault();
            alert("All fields are required!");
        }

        // Validate email format
        if (!/\S+@\S+\.\S+/.test(email)) {
            event.preventDefault();
            alert("Please enter a valid email address.");
        }
    });
});
