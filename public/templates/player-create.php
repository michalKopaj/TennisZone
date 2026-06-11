<?php include __DIR__ . '/../../autoload.php'; 

use App\Models\Player;
use App\Core\Redirect;
?>
 <?php include __DIR__ . '/partials/header-admin.php'; ?>
<?php include __DIR__ . '/partials/header-admin.php'; 


$player = new Player();
$errors = [];
$uploadDir = __DIR__.'/../assets/images/players/';
$uploadUrl = 'images/players/';
if(!is_dir($uploadDir)){
    mkdir($uploadDir,0755,true);


}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name'       => trim($_POST['name'] ?? ''),
        'country'    => trim($_POST['country'] ?? ''),
        'ranking'    => $_POST['ranking'] !== '' ? (int) $_POST['ranking'] : null,
        'career_high'=> $_POST['ranking'] !== '' ? (int) $_POST['ranking'] : null,
        'birth_date' => $_POST['birth_date'] ?: null,
        'bio'        => trim($_POST['bio'] ?? ''),
        'image'      =>  null,

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
    <label>
        Fotka hráča
        <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
    </label>
    <div>
        <a href="admin-players.php">Zrušiť</a>  
        <button type="submit">Vytvoriť</button>
    </div>
</form>

<?php include __DIR__ . '/partials/footer-admin.php'; ?>
