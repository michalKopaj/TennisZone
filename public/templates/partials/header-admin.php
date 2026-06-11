<?php
session_start();

require_once __DIR__ . '/../../../autoload.php';

use App\Models\User;
use App\Core\Helper;

$user = new User();

if (!$user->isAdmin()) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Admin - <?php echo Helper::getPageTitle(); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<header>
    <div class="container">
        <a href="home.php" class="logo">TennisZone Admin</a>
        <nav>
            <a href="admin.php">Dashboard</a>
            <a href="admin-articles.php">Články</a>
            <a href="admin-players.php">Hráči</a>
            <a href="admin-tournaments.php">Turnaje</a>
            <a href="admin-comments.php">Komentáre</a>
            <a href="home.php">Späť na web</a>
            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php">Odhlásiť</a>
        </nav>
    </div>
</header>

<main class="container">
