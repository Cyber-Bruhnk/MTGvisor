document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".login-form");

    form.addEventListener("submit", (event) => {
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        if (!email || !password) {
            event.preventDefault();
            alert("Both fields are required!");
        }

        if (!/\S+@\S+\.\S+/.test(email)) {
            event.preventDefault();
            alert("Please enter a valid email address.");
        }
    });
});
