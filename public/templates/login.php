<?php
require_once __DIR__ . '/../../autoload.php';
 
use App\Models\User;
use App\Core\Redirect;
?>

<?php
session_start();

$user = new User();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($user->login($login, $password)) {
        $redirect = new Redirect('home.php');
        $redirect->redirect();
    } else {
        $error = 'Nesprávne prihlasovacie údaje.';
    }
}
?>
<?php include 'partials/header.php'; ?>

<h1>Prihlásenie</h1>

<?php if ($error): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST">
    <label>
        Používateľské meno alebo email
        <input type="text" name="login" required>
    </label>

    <label>
        Heslo
        <input type="password" name="password" required>
    </label>

    <button type="submit">Prihlásiť</button>
</form>
  <p>Nemáte ešte účet? <a href="register.php">Zaregistrujte sa</a></p>
</div>
<?php include 'partials/footer.php'; ?>
