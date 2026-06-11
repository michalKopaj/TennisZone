<?php require_once __DIR__ . '/../../autoload.php';
 
use App\Models\Tournament;
?>
<?php include __DIR__ . '/partials/header-admin.php';?>
<?php



$tournament = new Tournament();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int) ($_POST['id'] ?? 0);
    if ($id > 0) {
        $tournament->delete($id);
    }
    header('Location: admin-tournaments.php');
    exit;
}

$tournaments = $tournament->all();
?>

<div class="admin-toolbar">
    <h1>Správa turnajov</h1>
    <a href="tournament-create.php" class="btn btn-add">+ Nový turnaj</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Názov</th>
            <th>Miesto</th>
            <th>Povrch</th>
            <th>Termín</th>
            <th>Akcie</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tournaments as $t): ?>
            <tr>
                <td>#<?php echo $t->id; ?></td>
                <td><?php echo htmlspecialchars($t->name ?? ''); ?></td>
                <td><?php echo htmlspecialchars($t->location ?? ''); ?></td>
                <td><?php echo htmlspecialchars($t->surface ?? ''); ?></td>
                <td>
                    <?php echo $t->start_date ? date('d.m.Y', strtotime($t->start_date)) : '-'; ?>
                    -
                    <?php echo $t->end_date ? date('d.m.Y', strtotime($t->end_date)) : '-'; ?>
                </td>
                <td>
                    <a href="tournament-edit.php?id=<?php echo $t->id; ?>" class="btn btn-edit">Upraviť</a>

                    <form method="POST" style="display:inline;" onsubmit="return confirm('Naozaj zmazať turnaj?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $t->id; ?>">
                        <button type="submit" class="btn btn-delete">Zmazať</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/partials/footer.php'; ?>
