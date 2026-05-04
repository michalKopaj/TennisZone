<?php include 'partials/header.php'; ?>

<?php
require '../../app/models/Post.php';
$post = new Post();
$articles = $post->all();
?>

<h1>Vitaj v TennisZone</h1>
<p>Najnovšie tenisové novinky</p>

<div class="articles">
    <?php foreach ($articles as $article): ?>
        <div class="article-card">
            <h2><?php echo htmlspecialchars($article->title); ?></h2>
            <p><?php echo htmlspecialchars($article->perex); ?></p>
            <a href="article-detail.php?id=<?php echo $article->id; ?>">Čítať viac</a>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'partials/footer.php'; ?>
