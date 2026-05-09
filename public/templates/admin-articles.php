<?php include __DIR__ . '/partials/header-admin.php'; ?>

<?php
require_once __DIR__ . '/../../app/models/Post.php';

$post = new Post();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int) ($_POST['id'] ?? 0);
    if ($id > 0) {
        $post->delete($id);
    }
    header('Location: admin-articles.php');
    exit;
}

$articles = $post->all();
?>

<div class="admin-toolbar">
    <h1>Správa článkov</h1>
    <a href="article-create.php" class="btn btn-add">+ Nový článok</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Názov</th>
            <th>Stav</th>
            <th>Vytvorený</th>
            <th>Akcie</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $a): ?>
            <tr>
                <td>#<?php echo $a->id; ?></td>
                <td><?php echo htmlspecialchars($a->title ?? ''); ?></td>
                <td><?php echo isset($a->is_published) && $a->is_published ? 'Publikovaný' : 'Koncept'; ?></td>
                <td><?php echo $a->created_at ? date('d.m.Y', strtotime($a->created_at)) : '-'; ?></td>
                <td>
                    <a href="article-edit.php?id=<?php echo $a->id; ?>" class="btn btn-edit">Upraviť</a>

                    <form method="POST" style="display:inline;" onsubmit="return confirm('Naozaj zmazať článok?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $a->id; ?>">
                        <button type="submit" class="btn btn-delete">Zmazať</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/partials/footer.php'; ?>
