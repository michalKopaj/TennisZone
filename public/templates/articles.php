<?php 
require_once __DIR__ . '/../../autoload.php'; ?>

<?php
use App\Models\Post; 
use App\Models\Category;
?>
<?php include __DIR__ . '/partials/header.php'; 
$post = new Post();
$category = new Category();
$articles = $post->all();
$categories = $category ->all();
$selectedCategory = isset($_GET['category']) && $_GET['category'] !== '' ? (int) $_GET['category'] : null;

if ($selectedCategory) {
    $articles = $post->byCategory($selectedCategory);
} else {
    $articles = $post->all();
}
?>

<h1>Novinky</h1>
<p>Všetky tenisové novinky a články</p>
<form method="GET" action="articles.php" class="category-filter">
    <label for="category">Kategória:</label>
    <select name="category" id="category" onchange="this.form.submit()">
        <option value="">Všetky kategórie</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?php echo $cat->id; ?>" <?php echo $selectedCategory == $cat->id ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cat->name); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <noscript><button type="submit">Filtrovať</button></noscript>
</form>
<div class="articles">
    <?php if (count($articles) === 0): ?>
        <p>V tejto kategórii zatiaľ nie sú žiadne články.</p>
    <?php else: ?>

<div class="articles">
    <?php foreach ($articles as $article): ?>
        <div class="article-card">
            <h2><?php echo htmlspecialchars($article->title); ?></h2>
            <p><?php echo htmlspecialchars($article->perex); ?></p>
            <a href="article-detail.php?id=<?php echo $article->id; ?>">Čítať viac</a>
        </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>