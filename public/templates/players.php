<?php

include __DIR__ . '/partials/header.php'; ?>

<?php
require_once __DIR__ . '/../../app/models/Player.php';

$player = new Player();
$players = $player->all();

?>

<h1>Hráči</h1>
<p>Ranking Hracov</p>

<?php if (count($players) === 0): ?>
    <p>Zatiaľ žiadni hráči v databáze.</p>
<?php else: ?>
    <div class="articles">
        <?php foreach ($players as $p): ?>
           <a href="player-detail.php?id=<?php echo $p->id; ?>" class="player-card-link">
            <div class="article-card">
                <h2><?php echo htmlspecialchars($p->name); ?></h2>
                <p>Krajina: <?php echo htmlspecialchars($p->country ?? '–'); ?></p>
                <p>Ranking: #<?php echo htmlspecialchars($p->ranking ?? '–'); ?></p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php include __DIR__ . '/partials/footer.php'; ?>