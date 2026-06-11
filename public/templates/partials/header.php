<?php
if (session_status()===PHP_SESSION_NONE){
    session_start();
}

require_once __DIR__ . '/../../../autoload.php';

use App\Models\User;
use App\Core\Helper;

$user = new User();
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title><?php echo Helper::getPageTitle(); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
    <div class="container">
        <a href="home.php" class="logo">TennisZone</a>
        <nav>
            <a href="home.php">Domov</a>
            <a href="articles.php">Novinky</a>
            <a href="players.php">Hráči</a>
            <a href="tournaments.php">Turnaje</a>

            <?php if ($user->isLoggedIn()): ?>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <?php if ($user->isAdmin()): ?>
                    <a href="admin.php">Admin</a>
                <?php endif; ?>
                <a href="logout.php">Odhlásiť</a>
            <?php else: ?>
                <a href="login.php">Prihlásiť</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="container">
