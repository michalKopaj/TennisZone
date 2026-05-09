<?php include __DIR__ . '/partials/header-admin.php'; ?>

<?php
require_once __DIR__ . '/../../app/core/Redirect.php';
require_once __DIR__ . '/../../app/models/Tournament.php';

$tournament = new Tournament();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name'        => trim($_POST['name'] ?? ''),
        'location'    => trim($_POST['location'] ?? ''),
        'surface'     => $_POST['surface'] ?? 'Tvrdý povrch',
        'start_date'  => $_POST['start_date'] ?? '',
        'end_date'    => $_POST['end_date'] ?? '',
        'prize_money' => $_POST['prize_money'] !== '' ? (int) $_POST['prize_money'] : null,
        'description' => trim($_POST['description'] ?? '')
    ];

    if (strlen($data['name']) < 3) {
        $errors[] = 'Názov musí mať aspoň 3 znaky.';
    }

    if (strlen($data['location']) < 2) {
        $errors[] = 'Miesto musí mať aspoň 2 znaky.';
    }

    if ($data['start_date'] > $data['end_date']) {
        $errors[] = 'Dátum začiatku musí byť pred koncom.';
    }

    if (empty($errors)) {
        $tournament->create($data);
         $redirect = new Redirect('admin-players.php');
       $redirect->redirect();
    }
}
?>

<h1>Nový turnaj</h1>

<?php foreach ($errors as $err): ?>
    <p class="error"><?php echo htmlspecialchars($err); ?></p>
<?php endforeach; ?>

<form method="POST" action="tournament-create.php">
    <label>
        Názov *
        <input type="text" name="name" required minlength="3" maxlength="120"
               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
    </label>

    <label>
        Miesto *
        <input type="text" name="location" required minlength="2" maxlength="100"
               value="<?php echo htmlspecialchars($_POST['location'] ?? ''); ?>">
    </label>

    <label>
        Povrch *
        <select name="surface" required>
            <option value="Tvrdý povrch">Tvrdý povrch</option>
            <option value="Antuka">Antuka</option>
            <option value="Tráva">Tráva</option>
            <option value="Tvrdý povrch (hala)">Tvrdý povrch (hala)</option>
        </select>
    </label>

    <label>
        Začiatok *
        <input type="date" name="start_date" required
               value="<?php echo htmlspecialchars($_POST['start_date'] ?? ''); ?>">
    </label>

    <label>
        Koniec *
        <input type="date" name="end_date" required
               value="<?php echo htmlspecialchars($_POST['end_date'] ?? ''); ?>">
    </label>

    <label>
        Prize money (USD)
        <input type="number" name="prize_money" min="0"
               value="<?php echo htmlspecialchars($_POST['prize_money'] ?? ''); ?>">
    </label>

    <label>
        Popis
        <textarea name="description" rows="5"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
    </label>

    <div>
        <a href="admin-tournaments.php">Zrušiť</a>
        <button type="submit">Vytvoriť</button>
    </div>
</form>

<?php include __DIR__ . '/partials/footer-admin.php'; ?>
