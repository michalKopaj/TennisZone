<?php require_once __DIR__ . '/../../autoload.php'; 
use App\Models\Comment;?>
<?php include __DIR__ . '/partials/header-admin.php'; ?>

<?php
$comment = new Comment();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if ($id > 0) {
        if ($action === 'toggle') {
            $comment->toggleApproval($id);
        }
        if ($action === 'delete') {
            $comment->delete($id);
        }
    }

    header('Location: admin-comments.php');
    exit;
}

$comments = $comment->all();
?>

<h1>Správa komentárov</h1>

<?php if (count($comments) === 0): ?>
    <p>Žiadne komentáre.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Autor</th>
                <th>Článok</th>
                <th>Obsah</th>
                <th>Dátum</th>
                <th>Schválený</th>
                <th>Akcie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $c): ?>
                <tr>
                    <td>#<?php echo $c->id; ?></td>
                    <td><?php echo htmlspecialchars($c->username); ?></td>
                    <td><?php echo htmlspecialchars(substr($c->article_title, 0, 40)); ?>...</td>
                    <td><?php echo htmlspecialchars(substr($c->body, 0, 100)); ?></td>
                    <td><?php echo date('d.m.Y', strtotime($c->created_at)); ?></td>
                    <td><?php echo $c->is_approved ? 'Áno' : 'Čaká'; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="toggle">
                            <input type="hidden" name="id" value="<?php echo $c->id; ?>">
                            <button type="submit"><?php echo $c->is_approved ? 'Skryť' : 'Schváliť'; ?></button>
                        </form>

                        <form method="POST" style="display:inline;" onsubmit="return confirm('Naozaj zmazať komentár?')">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $c->id; ?>">
                            <button type="submit">Zmazať</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include __DIR__ . '/partials/footer.php'; ?>
