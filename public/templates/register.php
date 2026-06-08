<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../app/core/Auth.php';
require_once __DIR__ . '/../../app/core/Redirect.php';
require_once __DIR__ . '/../../app/models/User.php';

if (Auth::isLoggedIn()) {
    $redirect = new Redirect('home.php');
    $redirect->redirect();
}

$userObj = new User();
$auth    = new Auth();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';
    $password2 = $_POST['password_confirm'] ?? '';
    $hash = password_hash($password, PASSWORD_DEFAULT);
    if (strlen($username) < 3 || strlen($username) > 50) {
        $errors[] = 'Používateľské meno musí mať 3-50 znakov.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Neplatný email.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Heslo musí mať minimálne 8 znakov.';
    }
    if ($password !== $password2) {
        $errors[] = 'Heslá sa nezhodujú.';
    }
    if (empty($errors) && $userObj->existsByUsername($username)) {
        $errors[] = 'Používateľské meno je už obsadené.';
    }
    if (empty($errors) && $userObj->existsByEmail($email)) {
        $errors[] = 'Email je už registrovaný.';
    }

    if (empty($errors)) {
        $userObj->register($username, $email, $password);
        $auth->login($username, $password);

        $redirect = new Redirect('home.php');
        $redirect->redirect();
    }
}
?>
<?php include __DIR__ . '/partials/header.php'; ?>

<div class="auth-box">
    <h1>Registrácia</h1>

    <?php foreach ($errors as $err): ?>
        <p class="error"><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endforeach; ?>

    <form method="POST" action="register.php">
        <label>
            Používateľské meno
            <input type="text" name="username" minlength="3" maxlength="50" required>
        </label>

        <label>
            Email
            <input type="email" name="email" required>
        </label>

        <label>
            Heslo (min. 8 znakov)
            <input type="password" name="password" minlength="8" required>
        </label>

        <label>
            Potvrdenie hesla
            <input type="password" name="password_confirm" minlength="8" required>
        </label>

        <button type="submit">Registrovať</button>
    </form>

    <p>Už máte účet? <a href="login.php">Prihláste sa</a>.</p>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>