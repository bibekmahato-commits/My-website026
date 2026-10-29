
<?php
session_start();

// Only a logged-in session can access this page.
if (!isset($_SESSION["username"])) {
    header("Location: index.html");
    exit();
}

$username = $_SESSION["username"];
$ipAddress = $_SERVER["REMOTE_ADDR"] ?? "Unknown";

// Read the demonstration cookie separately.
$cookieUsername = "Not available";
$cookieIP = "Not available";

if (isset($_COOKIE["user_info"])) {
    $cookieData = json_decode($_COOKIE["user_info"], true);

    if (is_array($cookieData)) {
        $cookieUsername = $cookieData["username"] ?? "Not available";
        $cookieIP = $cookieData["ip"] ?? "Not available";
    }
}

// Escape displayed values to prevent HTML injection.
function safeOutput($value) {
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES | ENT_SUBSTITUTE,
        "UTF-8"
    );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Identity Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="dashboard-container">
        <h1>Welcome, <?= safeOutput($username) ?>!</h1>
        <p class="subtitle">Your virtual identity dashboard</p>

        <section class="info-card">
            <h2>Server-side session</h2>
            <p><strong>Logged-in username:</strong>
                <?= safeOutput($username) ?></p>
            <p><strong>Client IP address:</strong>
                <?= safeOutput($ipAddress) ?></p>
            <p><strong>Login status:</strong> Authenticated</p>
        </section>

        <section class="info-card">
            <h2>Custom browser cookie</h2>
            <p><strong>Cookie username:</strong>
                <?= safeOutput($cookieUsername) ?></p>
            <p><strong>Cookie IP address:</strong>
                <?= safeOutput($cookieIP) ?></p>
        </section>

        <p class="security-note">
            The session controls authentication. The custom cookie
            is for demonstration and must not be trusted for login.
        </p>

        <a class="button-link" href="logout.php">Logout</a>
    </main>
</body>
</html>
