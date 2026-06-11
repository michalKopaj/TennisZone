<?php include __DIR__ . '/../../autoload.php'; ?>

<?php
use App\Core\Redirect;
use App\Models\Player; ?>
<?php include __DIR__ . '/partials/header-admin.php'; 
$id = (int) ($_GET['id'] ?? 0);

$player = new Player();
$p = $player->find($id);

if (!$p) {
    header('Location: admin-players.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name'       => trim($_POST['name'] ?? ''),
        'country'    => trim($_POST['country'] ?? ''),
        'ranking'    => $_POST['ranking'] !== '' ? (int) $_POST['ranking'] : null,
        'birth_date' => $_POST['birth_date'] ?: null,
        'bio'        => trim($_POST['bio'] ?? ''),
        'image'      => null
    ];

    if (strlen($data['name']) < 3) {
        $errors[] = 'Meno musí mať aspoň 3 znaky.';
    }

    if (strlen($data['country']) < 2) {
        $errors[] = 'Krajina musí mať aspoň 2 znaky.';
    }

    if (isset($_FILES['image'])&& $_FILES['image']['error'] === UPLOAD_ERR_OK){
         $fileTmpPath= $_FILES['image']['tmp_name'];
         $fileName = $_FILES['image']['name'];
         $fileSize = $_FILES['image']['size'];
         $fileType= $_FILES['image']['type'];
         $fileNameCmps= explode(".",$fileName);
         $fileExtension = strtolower(end($fileNameCmps));


         $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    }
    if (empty($errors)) {
        $player->update($id, $data);
        $redirect = new Redirect('admin-players.php');
        $redirect->redirect();
    }
}
?>

<h1>Upraviť hráča</h1>

<?php foreach ($errors as $err): ?>
    <p class="error"><?php echo htmlspecialchars($err); ?></p>
<?php endforeach; ?>

<form method="POST" action="player-edit.php?id=<?php echo $id; ?>">
    <label>
        Meno *
        <input type="text" name="name" required minlength="3" maxlength="100"
               value="<?php echo htmlspecialchars($p->name); ?>">
    </label>

    <label>
        Krajina *
        <input type="text" name="country" required minlength="2" maxlength="50"
               value="<?php echo htmlspecialchars($p->country ?? ''); ?>">
    </label>

    <label>
        Aktuálny rebríček
        <input type="number" name="ranking" min="1"
               value="<?php echo htmlspecialchars($p->ranking ?? ''); ?>">
    </label>

    <label>
        Dátum narodenia
        <input type="date" name="birth_date"
               value="<?php echo htmlspecialchars($p->birth_date ?? ''); ?>">
    </label>

    <label>
        Biografia
        <textarea name="bio" rows="6"><?php echo htmlspecialchars($p->bio ?? ''); ?></textarea>
    </label>

    <div>
        <a href="admin-players.php">Zrušiť</a>
        <button type="submit">Uložiť zmeny</button>
    </div>
</form>

<?php include __DIR__ . '/partials/footer-admin.php'; ?>
