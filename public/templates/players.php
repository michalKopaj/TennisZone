<?php include __DIR__ . '/partials/header.php'; ?>

<?php
require_once __DIR__ . '/../../app/models/Player.php';

$player = new Player();
$players = $player->all();
?>

<h1>Hráči</h1>
<p>Najlepší tenisoví hráči sveta</p>

<div class="articles">
    <?php foreach ($players as $p): ?>
        <div class="article-card">
            <h2><?php echo htmlspecialchars($p->name); ?></h2>
            <p>Krajina: <?php echo htmlspecialchars($p->country); ?></p>
            <p>Ranking: <?php echo htmlspecialchars($p->ranking); ?></p>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
