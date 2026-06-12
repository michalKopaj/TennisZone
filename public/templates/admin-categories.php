<?php require_once __DIR__ . '/../../autoload.php';

use App\Models\Category;
?>
<?php include __DIR__ . '/partials/header-admin.php'; ?>
<?php
$category = new Category();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $name = trim($_POST['name'] ?? '');
        if (strlen($name) < 2) {
            $error = 'Názov kategórie musí mať aspoň 2 znaky.';
        } else {
            $category->create($name);
            header('Location: admin-categories.php');
            exit;
        }
    }

    if ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $category->delete($id);
        }
        header('Location: admin-categories.php');
        exit;
    }
}

$categories = $category->all();
?>

<div class="admin-toolbar">
    <h1>Správa kategórií</h1>
</div>

<?php if ($error !== ''): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="admin-categories.php">
    <label>
        Nová kategória
        <input type="text" name="name" placeholder="Napr. ATP" required maxlength="100">
    </label>
    <input type="hidden" name="action" value="create">
    <button type="submit" class="btn btn-add">+ Pridať kategóriu</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Názov</th>
            <th>Slug</th>
            <th>Akcie</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $cat): ?>
            <tr>
                <td>#<?php echo $cat->id; ?></td>
                <td><?php echo htmlspecialchars($cat->name); ?></td>
                <td><?php echo htmlspecialchars($cat->slug); ?></td>
                <td>
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Naozaj zmazať kategóriu?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $cat->id; ?>">
                        <button type="submit" class="btn btn-delete">Zmazať</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/partials/footer.php'; ?>