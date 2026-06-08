<?php include __DIR__ . '/partials/header.php'; ?>

<?php
require_once __DIR__ . '/../../app/models/Tournament.php';


$tournament = new Tournament();
$tournaments = $tournament->all();
?>
<h1>Turnaje</h1>
<p>Aktuálne tenisové turnaje</p>
<?php if(count($tournaments)===0): ?>
    <p>Zatial ziadne turnaje nie su</p>
    <?php else: ?>
<div class="articles">
    <?php foreach ($tournaments as $t): ?>
        <a href="tournament-detail.php?id=<?php echo $t->id; ?>" class="player-card-link">
        <div class="article-card">
            <h2><?php echo htmlspecialchars($t->name); ?></h2>
            <p>Miesto: <?php echo htmlspecialchars($t->location); ?></p>
            <p>Povrch: <?php echo htmlspecialchars($t->surface); ?></p>
            <p>Začiatok: <?php echo htmlspecialchars($t->start_date); ?></p>
            <p>Koniec: <?php echo htmlspecialchars($t->end_date); ?></p>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php include __DIR__ . '/partials/footer.php'; ?>
