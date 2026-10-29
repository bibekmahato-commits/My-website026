
const loginForm = document.getElementById("loginForm");

if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value;
        const message = document.getElementById("formMessage");

        message.textContent = "";

        if (username === "" || password === "") {
            event.preventDefault();
            message.textContent = "Please enter both username and password.";
            return;
        }

        if (username.length > 50 || password.length > 100) {
            event.preventDefault();
            message.textContent = "The entered details are too long.";
            return;
        }

        // If validation passes, the form submits to login.php.
    });
}
