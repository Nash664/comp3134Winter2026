<?php
session_start();

$splash = '';
$showSplash = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $showSplash = true;

    $sessionConfirmation = isset($_SESSION['confirmation']) ? (string) $_SESSION['confirmation'] : '';
    $postConfirmation = isset($_POST['confirmation']) ? (string) $_POST['confirmation'] : '';

    if ($sessionConfirmation === '' || $postConfirmation === '' || !hash_equals($sessionConfirmation, $postConfirmation)) {
        $splash = 'Failure: invalid or missing confirmation token (request not allowed).';
    } else {
        $username = isset($_POST['username']) ? trim((string) $_POST['username']) : '';
        $password = isset($_POST['password']) ? (string) $_POST['password'] : '';

        if ($username === 'host' && $password === 'pass') {
            $splash = 'Success: login accepted.';
        } else {
            $splash = 'Failure: invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSRF lab — csfr_action.php (mitigated)</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 28rem; margin: 2rem auto; }
        label { display: block; margin-top: 1rem; }
        input[type="text"], input[type="password"] { width: 100%; box-sizing: border-box; padding: 0.5rem; }
        button { margin-top: 1rem; padding: 0.5rem 1rem; }
        #splash {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 6px;
            display: none;
        }
        #splash.visible { display: block; }
        #splash.success { background: #e8f5e9; border: 1px solid #81c784; }
        #splash.failure { background: #ffebee; border: 1px solid #e57373; }
    </style>
</head>
<body>
    <h1>Login (CSRF mitigated)</h1>
    <p>Use <a href="csfr_form.php">csfr_form.php</a> for a request that includes a valid session token. Submitting from this page without a token will fail the confirmation check.</p>
    <form method="post" action="">
        <input type="hidden" name="confirmation" value="">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" autocomplete="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="current-password" required>

        <button type="submit">Submit</button>
    </form>

    <div id="splash" class="<?php
        if (!$showSplash) {
            echo '';
        } elseif (strpos($splash, 'Success') === 0) {
            echo 'visible success';
        } else {
            echo 'visible failure';
        }
    ?>" role="status" aria-live="polite">
        <?php echo $showSplash ? htmlspecialchars($splash, ENT_QUOTES, 'UTF-8') : ''; ?>
    </div>
</body>
</html>
