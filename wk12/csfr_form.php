<?php
session_start();

if (empty($_SESSION['confirmation'])) {
    $_SESSION['confirmation'] = bin2hex(random_bytes(16));
}

$confirmation = $_SESSION['confirmation'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSRF lab — csfr_form.php</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 28rem; margin: 2rem auto; }
        label { display: block; margin-top: 1rem; }
        input[type="text"], input[type="password"] { width: 100%; box-sizing: border-box; padding: 0.5rem; }
        button { margin-top: 1rem; padding: 0.5rem 1rem; }
    </style>
</head>
<body>
    <h1>Login (with confirmation token)</h1>
    <form method="post" action="csfr_action.php">
        <input type="hidden" name="confirmation" value="<?php echo htmlspecialchars($confirmation, ENT_QUOTES, 'UTF-8'); ?>">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" autocomplete="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="current-password" required>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
