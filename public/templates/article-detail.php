<?php
session_start();

require_once __DIR__ . '/../../app/models/Post.php';
require_once __DIR__ . '/../../app/models/Comment.php';
require_once __DIR__ . '/../../app/models/User.php';

$id = (int) ($_GET['id'] ?? 0);

$post = new Post();
$article = $post->find($id);

if (!$article) {
    include __DIR__ . '/partials/header.php';
    echo '<h1>Článok neexistuje</h1>';
    echo '<p><a href="articles.php">Späť na novinky</a></p>';
    include __DIR__ . '/partials/footer.php';
    exit;
}


$user = new User();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$user->isLoggedIn()) {
        header('Location: login.php');
        exit;
    }

    $body = trim($_POST['body'] ?? '');

    if (strlen($body) < 3) {
        $message = 'Komentár musí mať aspoň 3 znaky.';
    } else {
       
        require_once __DIR__ . '/../../app/core/Database.php';
        $database = new Database();
        $db = $database->getConnection();

        $sql = "INSERT INTO comments (article_id, user_id, body, is_approved)
                VALUES (:article_id, :user_id, :body, 1)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'article_id' => $article->id,
            'user_id'    => $_SESSION['user_id'],
            'body'       => $body
        ]);

        header('Location: article-detail.php?id=' . $article->id);
        exit;
    }
}

$comment = new Comment();
$comments = $comment->forArticle($article->id);
?>

<?php include __DIR__ . '/partials/header.php'; ?>

<article class="article-detail">
    <h1><?php echo htmlspecialchars($article->title); ?></h1>

    <div class="article-meta">
        <p>
            <em>Dátum: <?php echo htmlspecialchars($article->created_at); ?></em>
        </p>
    </div>

    <?php if (!empty($article->image)): ?>
        <img src="../assets/images/uploads/<?php echo htmlspecialchars($article->image); ?>"
             alt="<?php echo htmlspecialchars($article->title); ?>"
             class="article-image">
    <?php endif; ?>

    <p class="perex">
        <strong><?php echo htmlspecialchars($article->perex); ?></strong>
    </p>

    <div class="article-body">
        <?php echo nl2br(htmlspecialchars($article->content)); ?>
    </div>
</article>

<section class="comments">
    <h2>Komentáre (<?php echo count($comments); ?>)</h2>

    <?php if ($message): ?>
        <p class="error"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if ($user->isLoggedIn()): ?>
        <form method="POST" action="article-detail.php?id=<?php echo $article->id; ?>">
            <label>
                Tvoj komentár:
                <textarea name="body" rows="4" required></textarea>
            </label>
            <button type="submit">Odoslať komentár</button>
        </form>
    <?php else: ?>
        <p>
            Pre pridanie komentára sa
            <a href="login.php">prihlás</a>
            alebo
            <a href="register.php">zaregistruj</a>.
        </p>
    <?php endif; ?>

    <?php if (count($comments) === 0): ?>
        <p>Buď prvý, kto okomentuje tento článok.</p>
    <?php else: ?>
        <ul class="comment-list">
            <?php foreach ($comments as $c): ?>
                <li class="comment">
                    <strong><?php echo htmlspecialchars($c->username); ?></strong>
                    <small>(<?php echo htmlspecialchars($c->created_at); ?>)</small>
                    <p><?php echo nl2br(htmlspecialchars($c->body)); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p>
        <a href="articles.php">← Späť na novinky</a>
    </p>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
