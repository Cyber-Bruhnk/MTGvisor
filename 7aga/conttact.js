document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".contact-form");

    form.addEventListener("submit", (event) => {
        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const subject = document.getElementById("subject").value.trim();
        const message = document.getElementById("message").value.trim();

        if (!name || !email || !subject || !message) {
            event.preventDefault();
            alert("All fields are required!");
        }

        if (!/\S+@\S+\.\S+/.test(email)) {
            event.preventDefault();
            alert("Please enter a valid email address.");
        }
    });
});
