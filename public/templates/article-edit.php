<?php include __DIR__ . '/partials/header-admin.php'; ?>

<?php
require_once __DIR__ . '/../../app/core/Redirect.php';
require_once __DIR__ . '/../../app/models/Post.php';
require_once __DIR__ . '/../../app/models/Category.php';

$id = (int) ($_GET['id'] ?? 0);

$post = new Post();
$category = new Category();

$article = $post->find($id);

if (!$article) {
    header('Location: admin-articles.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'category_id'  => $_POST['category_id'] === '' ? null : (int) $_POST['category_id'],
        'title'        => trim($_POST['title'] ?? ''),
        'perex'        => trim($_POST['perex'] ?? ''),
        'content'      => trim($_POST['content'] ?? ''),
        'is_published' => isset($_POST['is_published']) ? 1 : 0
    ];

    if (strlen($data['title']) < 5) {
        $errors[] = 'Názov musí mať aspoň 5 znakov.';
    }

    if (strlen($data['perex']) < 10) {
        $errors[] = 'Perex musí mať aspoň 10 znakov.';
    }

    if (strlen($data['content']) < 20) {
        $errors[] = 'Obsah musí mať aspoň 20 znakov.';
    }

    if (empty($errors)) {
        $post->update($id, $data);
        $redirect = new Redirect('admin-players.php');
       $redirect->redirect();
    }
}

$categories = $category->all();
?>

<h1>Upraviť článok</h1>

<?php foreach ($errors as $err): ?>
    <p class="error"><?php echo htmlspecialchars($err); ?></p>
<?php endforeach; ?>

<form method="POST" action="article-edit.php?id=<?php echo $id; ?>">
    <label>
        Názov *
        <input type="text" name="title" required minlength="5" maxlength="200"
               value="<?php echo htmlspecialchars($article->title); ?>">
    </label>

    <label>
        Kategória
        <select name="category_id">
            <option value="">- žiadna -</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?php echo $c->id; ?>"
                    <?php echo $article->category_id == $c->id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($c->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>
        Perex *
        <textarea name="perex" rows="3" minlength="10" maxlength="500" required><?php echo htmlspecialchars($article->perex); ?></textarea>
    </label>

    <label>
        Obsah *
        <textarea name="content" rows="15" minlength="20" required><?php echo htmlspecialchars($article->content); ?></textarea>
    </label>

    <label>
        <input type="checkbox" name="is_published" value="1"
            <?php echo $article->is_published ? 'checked' : ''; ?>>
        Publikovaný
    </label>

    <div>
        <a href="admin-articles.php">Zrušiť</a>
        <button type="submit">Uložiť zmeny</button>
    </div>
</form>

<?php include __DIR__ . '/partials/footer-admin.php'; ?>
