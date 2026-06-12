<?php include __DIR__ . '/../../autoload.php'; ?>
<?php
use App\Core\Redirect;
use App\Models\Player;
?>
<?php include __DIR__ . '/partials/header-admin.php'; ?>
<?php
$id = (int) ($_GET['id'] ?? 0);

$player = new Player();
$p = $player->find($id);

if (!$p) {
    header('Location: admin-players.php');
    exit;
}
$errors = [];
$uploadDir = __DIR__ . '/../assets/images/players/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name'       => trim($_POST['name'] ?? ''),
        'country'    => trim($_POST['country'] ?? ''),
        'ranking'    => $_POST['ranking'] !== '' ? (int) $_POST['ranking'] : null,
        'birth_date' => $_POST['birth_date'] ?: null,
        'bio'        => trim($_POST['bio'] ?? ''),
        'image'      => $p->image,   
    ];

    if (strlen($data['name']) < 3) {
        $errors[] = 'Meno musí mať aspoň 3 znaky.';
    }
    if (strlen($data['country']) < 2) {
        $errors[] = 'Krajina musí mať aspoň 2 znaky.';
    }
    $hasUpload = isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK;
    $allowed   = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $imageExt  = null;

    if ($hasUpload) {
        $mime = mime_content_type($_FILES['image']['tmp_name']);
        if (!isset($allowed[$mime])) {
            $errors[] = 'Povolené sú len obrázky JPG, PNG alebo WEBP.';
        } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Obrázok môže mať najviac 2 MB.';
        } else {
            $imageExt = $allowed[$mime];
        }
    }

    if (empty($errors)) {
        if ($hasUpload && $imageExt) {
            $filename = uniqid('player_', true) . '.' . $imageExt;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                $data['image'] = $filename;  
            }
        }
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

<form method="POST" action="player-edit.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
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

    <label>
        Fotka hráča
        <?php if (!empty($p->image)): ?>
            <span>Aktuálna: <?php echo htmlspecialchars($p->image); ?> (nechaj prázdne, ak ju nechceš meniť)</span>
        <?php endif; ?>
        <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
    </label>

    <div>
        <a href="admin-players.php">Zrušiť</a>
        <button type="submit">Uložiť zmeny</button>
    </div>
</form>

<?php include __DIR__ . '/partials/footer-admin.php'; ?>