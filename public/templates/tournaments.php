<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>


<?php include __DIR__ . '/partials/header.php'; ?>

<?php
require_once __DIR__ . '/../../app/models/Tournament.php';

$tournament = new Tournament();
$tournaments = $tournament->all();
?>

<h1>Turnaje</h1>
<p>Aktuálne tenisové turnaje</p>

<div class="articles">
    <?php foreach ($tournaments as $t): ?>
        <div class="article-card">
            <h2><?php echo htmlspecialchars($t->name); ?></h2>
            <p>Miesto: <?php echo htmlspecialchars($t->location); ?></p>
            <p>Začiatok: <?php echo htmlspecialchars($t->start_date); ?></p>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
