<?php require_once __DIR__ . '/../../autoload.php';
use App\Models\Tournament;
use App\Models\Player;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
?>
<?php include __DIR__ . '/partials/header-admin.php'; ?>

<?php
$post = new Post();
$player = new Player();
$tournament = new Tournament();
$category = new Category();
$comment = new Comment();

$articles = $post->all();
$players = $player->all();
$tournaments = $tournament->all();
$categories = $category->all();
$comments = $comment->all();
?>

<h1>Admin Dashboard</h1>
<p>Vitaj v administrácii TennisZone</p>

<div class="admin-stats">
    <div class="stat-card">
        <h3>Články</h3>
        <p class="stat-number"><?php echo count($articles); ?></p>
        <a href="admin-articles.php">Spravovať</a>
    </div>

    <div class="stat-card">
        <h3>Hráči</h3>
        <p class="stat-number"><?php echo count($players); ?></p>
        <a href="admin-players.php">Spravovať</a>
    </div>

    <div class="stat-card">
        <h3>Turnaje</h3>
        <p class="stat-number"><?php echo count($tournaments); ?></p>
        <a href="admin-tournaments.php">Spravovať</a>
    </div>

    <div class="stat-card">
        <h3>Kategórie</h3>
        <p class="stat-number"><?php echo count($categories); ?></p>
    </div>

    <div class="stat-card">
        <h3>Komentáre</h3>
        <p class="stat-number"><?php echo count($comments); ?></p>
        <a href="admin-comments.php">Spravovať</a>
    </div>
</div>

<h2>Rýchle akcie</h2>
<div class="quick-actions">
    <a href="article-create.php" class="btn-primary">+ Nový článok</a>
    <a href="player-create.php" class="btn-primary">+ Nový hráč</a>
    <a href="tournament-create.php" class="btn-primary">+ Nový turnaj</a>
</div>

<h2>Posledné kategórie</h2>
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
                    <form method="POST" action="admin.php" style="display:inline;" onsubmit="return confirm('Naozaj zmazať?')">
                        <input type="hidden" name="action" value="delete-category">
                        <input type="hidden" name="id" value="<?php echo $cat->id; ?>">
                        <button type="submit">Zmazať</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/partials/footer.php'; ?>
