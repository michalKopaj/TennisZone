<?php require_once __DIR__ . '/../../autoload.php';


use App\Models\Player;
?>
<?php include __DIR__ . '/partials/header-admin.php'; ?>
<?php
$player = new Player();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int) ($_POST['id'] ?? 0);
    if ($id > 0) {
        $player->delete($id);
    }
    header('Location: admin-players.php');
    exit;
}

$players = $player->all();
?>

<div class="admin-toolbar">
    <h1>Správa hráčov</h1>
    <a href="player-create.php" class="btn btn-add">+ Nový hráč</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Meno</th>
            <th>Krajina</th>
            <th>Rebríček</th>
            <th>Akcie</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($players as $p): ?>
            <tr>
                <td>#<?php echo $p->id; ?></td>
                <td><?php echo htmlspecialchars($p->name ?? ''); ?></td>
                <td><?php echo htmlspecialchars($p->country ?? ''); ?></td>
                <td><?php echo $p->ranking ? '#' . $p->ranking : '-'; ?></td>
                <td>
                    <a href="player-edit.php?id=<?php echo $p->id; ?>" class="btn btn-edit">Upraviť</a>

                    <form method="POST" style="display:inline;" onsubmit="return confirm('Naozaj zmazať hráča?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $p->id; ?>">
                        <button type="submit" class="btn btn-delete">Zmazať</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/partials/footer.php'; ?>
