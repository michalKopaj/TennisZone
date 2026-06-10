<?php
include __DIR__ . '/partials/header.php';

require_once __DIR__ . '/../../app/models/Player.php';

$id = (int) ($_GET['id'] ?? 0);
$playerObj = new Player();
$player = $playerObj->find($id);

if (!$player) {
    echo '<h1>Hráč neexistuje</h1>';
    echo '<p><a href="players.php">Späť na hráčov</a></p>';
    include __DIR__ . '/partials/footer.php';
    exit;
}

$age = '';
if (!empty($player->birth_date)) {
    $birth = new DateTime($player->birth_date);
    $today = new DateTime();
    $age = $today->diff($birth)->y;
}

$initials = '';
foreach (explode(' ', $player->name) as $part) {
    if ($part !== '') $initials .= strtoupper(substr($part, 0, 1));
}
?>

<div class="player-profile">
    <div class="player-header">
        <div class="player-avatar">
            <?php if (!empty($player->image)): ?>
                <img src="../assets/images/players/<?php echo htmlspecialchars($player->image); ?>"
                     alt="<?php echo htmlspecialchars($player->name); ?>">
            <?php endif; ?>
        </div>

        <div class="player-info">
            <h1><?php echo htmlspecialchars($player->name); ?></h1>
            <div class="player-meta">
                <span class="badge-tour">ATP</span>
                <?php if (!empty($player->country)): ?>
                    <span class="meta-item">Krajina: <?php echo htmlspecialchars($player->country); ?></span>
                <?php endif; ?>
                <?php if (!empty($player->birth_date)): ?>
                    <span class="meta-item">Narodený: <?php echo date('d.m.Y', strtotime($player->birth_date)); ?> (<?php echo $age; ?> rokov)</span>
                <?php endif; ?>
                <span class="meta-item">Pravák</span>
            </div>
        </div>
    </div>

    <div class="player-stats">
        <div class="tennis-stat">
            <div class="stat-value">#<?php echo htmlspecialchars($player->ranking ?? '-'); ?></div>
            <div class="stat-label">Aktuálny rebríček</div>
        </div>
        <div class="tennis-stat">
            <div class="stat-value"><?php echo htmlspecialchars($player->career_high ?? '-'); ?></div>
            <div class="stat-label">Career High</div>
        </div>
        <div class="tennis-stat">
            <div class="stat-value"><?php echo htmlspecialchars($player->titles ?? '-'); ?></div>
            <div class="stat-label">Tituly</div>
        </div>
        <div class="tennis-stat">
            <div class="stat-value"><?php echo htmlspecialchars($player->prize_money ?? '-'); ?></div>
            <div class="stat-label">Prize money</div>
        </div>
        <div class="tennis-stat">
            <div class="stat-value"><?php echo htmlspecialchars($player->matches_played ?? '-'); ?></div>
            <div class="stat-label">Odohrané zápasy</div>
        </div>
        <div class="tennis-stat">
            <div class="stat-value"><?php echo htmlspecialchars($player->matches_won ?? '-'); ?></div>
            <div class="stat-label">Úspešnosť</div>
        </div>
    </div>

    <?php if (!empty($player->bio)): ?>
        <div class="player-bio">
            <h2>O hráčovi</h2>
            <p><?php echo nl2br(htmlspecialchars($player->bio)); ?></p>
        </div>
    <?php endif; ?>

    <p><a href="players.php">Späť na hráčov</a></p>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
