<?php require_once __DIR__ . '/../../autoload.php'; 
use App\Models\Tournament;
?>

<?php
include __DIR__ . '/partials/header.php';

$id = (int) ($_GET['id'] ?? 0);
$tournamentObj = new Tournament();
$tournament = $tournamentObj->find($id);

if (!$tournament) {
    echo '<h1>Turnaj neexistuje</h1>';
    echo '<p><a href="tournaments.php">Späť na turnaje</a></p>';
    include __DIR__ . '/partials/footer.php';
    exit;
}

$prizeMoney = '€' . number_format($tournament->prize_money, 0, ',', ' ');

$today = new DateTime();
$start = new DateTime($tournament->start_date);
$end = new DateTime($tournament->end_date);

if ($today < $start) {
    $statusLabel = 'Prichádzajúci';
    $statusClass = 'status-upcoming';
} elseif ($today >= $start && $today <= $end) {
    $statusLabel = 'Prebieha';
    $statusClass = 'status-live';
} else {
    $statusLabel = 'Ukončený';
    $statusClass = 'status-finished';
}
?>

<div class="tournament-hero" style="background-image: linear-gradient(rgba(26,58,37,0.85), rgba(45,95,63,0.85)), url('<?php echo htmlspecialchars($tournament->image); ?>');">
    <h1><?php echo htmlspecialchars(strtoupper($tournament->name)); ?></h1>
    <p class="tournament-location"><?php echo htmlspecialchars($tournament->location); ?></p>
    <span class="tournament-status <?php echo $statusClass; ?>"><?php echo htmlspecialchars($statusLabel); ?></span>
</div>

<div class="tournament-details">
    <h2>Detaily turnaja</h2>

    <div class="tournament-grid">
        <div class="detail-row">
            <span class="detail-label">Miesto konania</span>
            <span class="detail-value"><?php echo htmlspecialchars($tournament->location); ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Povrch</span>
            <span class="detail-value"><?php echo htmlspecialchars($tournament->surface); ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Prize Money</span>
            <span class="detail-value"><?php echo htmlspecialchars($prizeMoney); ?></span>
        </div>
    </div>

    <div class="tournament-description">
        <h2>O turnaji</h2>
        <p><?php echo nl2br(htmlspecialchars($tournament->description)); ?></p>
    </div>

    <p><a href="tournaments.php">Späť na turnaje</a></p>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
