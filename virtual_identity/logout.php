
<?php
session_start();

// Remove all session data.
$_SESSION = [];

// Expire the PHP session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(session_name(), "", [
        "expires" => time() - 42000,
        "path" => $params["path"],
        "domain" => $params["domain"],
        "secure" => $params["secure"],
        "httponly" => $params["httponly"],
        "samesite" => "Lax"
    ]);
}

// Destroy the server-side session.
session_destroy();

// Clear the custom user information cookie.
setcookie("user_info", "", [
    "expires" => time() - 3600,
    "path" => "/virtual_identity/",
    "httponly" => true,
    "secure" => false,
    "samesite" => "Lax"
]);

header("Location: index.html");
exit();
