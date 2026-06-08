<?php include __DIR__ . '/partials/header-admin.php'; ?>

<?php
require_once __DIR__ . '/../../app/core/Redirect.php';
require_once __DIR__ . '/../../app/models/Player.php';

$player = new Player();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name'       => trim($_POST['name'] ?? ''),
        'country'    => trim($_POST['country'] ?? ''),
        'ranking'    => $_POST['ranking'] !== '' ? (int) $_POST['ranking'] : null,
        'career_high'=> $_POST['ranking'] !== '' ? (int) $_POST['ranking'] : null,
        'birth_date' => $_POST['birth_date'] ?: null,
        'bio'        => trim($_POST['bio'] ?? ''),
        'image'=> $_POST['ranking'] !== '' ? (int) $_POST['ranking'] : null,

    ];

    if (strlen($data['name']) < 3) {
        $errors[] = 'Meno musí mať aspoň 3 znaky.';
    }

    if (strlen($data['country']) < 2) {
        $errors[] = 'Krajina musí mať aspoň 2 znaky.';
    }

    if (empty($errors)) {
        $player->create($data);
       $redirect = new Redirect('admin-players.php');
       $redirect->redirect();
    }
}
?>

<h1>Nový hráč</h1>

<?php foreach ($errors as $err): ?>
    <p class="error"><?php echo htmlspecialchars($err); ?></p>
<?php endforeach; ?>

<form method="POST" action="player-create.php">
    <label>
        Meno *
        <input type="text" name="name" required minlength="3" maxlength="100"
               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
    </label>

    <label>
        Krajina *
        <input type="text" name="country" required minlength="2" maxlength="50"
               value="<?php echo htmlspecialchars($_POST['country'] ?? ''); ?>">
    </label>

    <label>
        Aktuálny rebríček
        <input type="number" name="ranking" min="1"
               value="<?php echo htmlspecialchars($_POST['ranking'] ?? ''); ?>">
    </label>

    <label>
        Dátum narodenia
        <input type="date" name="birth_date"
               value="<?php echo htmlspecialchars($_POST['birth_date'] ?? ''); ?>">
    </label>

    <label>
        Biografia
        <textarea name="bio" rows="6"><?php echo htmlspecialchars($_POST['bio'] ?? ''); ?></textarea>
    </label>

    <div>
        <a href="admin-players.php">Zrušiť</a>
        <button type="submit">Vytvoriť</button>
    </div>
</form>

<?php include __DIR__ . '/partials/footer-admin.php'; ?>
