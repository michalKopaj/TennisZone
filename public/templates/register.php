<?php
session_start();

require_once __DIR__ . '/../../app/models/User.php';

$user = new User();

if ($user->isLoggedIn()) {
    header('Location: home.php');
    exit;
}

$errors = [];
$old = ['username' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';
    $password2 = $_POST['password_confirm'] ?? '';

    $old['username'] = $username;
    $old['email']    = $email;

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

    if (empty($errors) && $user->existsByUsername($username)) {
        $errors[] = 'Používateľské meno je už obsadené.';
    }

    if (empty($errors) && $user->existsByEmail($email)) {
        $errors[] = 'Email je už registrovaný.';
    }

    if (empty($errors)) {
        $user->register($username, $email, $password);
        $user->login($username, $password);

        header('Location: home.php');
        exit;
    }
}
?>

<?php include __DIR__ . '/partials/header.php'; ?>

<div class="auth-box">
    <h1>Registrácia</h1>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $err): ?>
            <p class="error"><?php echo htmlspecialchars($err); ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <label>
            Používateľské meno
            <input type="text" name="username" minlength="3" maxlength="50" required
                   value="<?php echo htmlspecialchars($old['username']); ?>">
        </label>

        <label>
            Email
            <input type="email" name="email" required
                   value="<?php echo htmlspecialchars($old['email']); ?>">
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
