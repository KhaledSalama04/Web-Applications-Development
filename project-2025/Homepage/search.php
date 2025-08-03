<?php
include 'db.php';

$searchQuery = $_GET['q'] ?? '';

if ($searchQuery) {
    $sql = "SELECT articles.*, categories.category_name, users.username
            FROM articles
            JOIN categories ON articles.category_id = categories.category_id
            JOIN users ON articles.author_id = users.user_id
            WHERE articles.title LIKE :q OR articles.content LIKE :q
            ORDER BY published_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['q' => "%$searchQuery%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $results = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Result Of Search"<?= htmlspecialchars($searchQuery);?>"</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital@0;1&amp;display=swap" rel="stylesheet">
</head>
<body>
  
  <main class="container search-container">
    <h2 class="search-title">Result Of Search: <span class="search-Query"><?= htmlspecialchars($searchQuery) ?></span></h2>

    <?php if ($results): ?>
      <div class="search-article">
        <?php foreach ($results as $article): ?>
          <div class="article-search">
            <img src="images/<?= htmlspecialchars($article['image_url']) ?>" alt="">
           <div class="content-box">
            <h3><?= htmlspecialchars($article['title']) ?></h3>
            <p><?= substr(strip_tags($article['content']), 0, 120) ?>...</p>
           </div> 
           <div class="box"> 
            <a class="read-more" href="article.php?id=<?php echo $article['article_id']; ?>">Read More</a>
            <span class="article-date"><?php echo date('d M Y -h:i A', strtotime($article['published_date'])); ?></span>
           </div> 
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="no-search">Not Found Your Search.</p>
    <?php endif; ?>
  </main>

</body>
</html>