
<?php
session_start();

// Accept login submissions only.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit();
}

// Read and validate the submitted values.
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

// Classroom demonstration credentials only.
if ($username !== "student" || $password !== "password123") {
    http_response_code(401);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Failed</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <main class="login-container">
            <h1>Login Failed</h1>
            <p class="message">Invalid username or password.</p>
            <a class="button-link" href="index.html">Try Again</a>
        </main>
    </body>
    </html>
    <?php
    exit();
}

// Regenerate the session ID after successful authentication.
session_regenerate_id(true);

// Store the virtual identity on the server.
$_SESSION["username"] = $username;

// Get the client IP address as seen by PHP.
$ipAddress = $_SERVER["REMOTE_ADDR"] ?? "Unknown";

// Create an additional cookie for demonstration only.
$userInfo = json_encode([
    "username" => $username,
    "ip" => $ipAddress
]);

setcookie("user_info", $userInfo, [
    "expires" => time() + 3600,
    "path" => "/virtual_identity/",
    "httponly" => true,
    "secure" => false, // Localhost uses HTTP in this practical.
    "samesite" => "Lax"
]);

// Redirect to the dashboard.
header("Location: dashboard.php");
exit();
