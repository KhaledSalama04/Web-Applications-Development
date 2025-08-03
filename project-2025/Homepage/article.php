<?php
 include 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $article_id = $_GET['id'];

    $stmt = $conn->prepare("
        SELECT articles.*, categories.category_name, users.username
        FROM articles
        JOIN categories ON articles.category_id = categories.category_id
        JOIN users ON articles.author_id = users.user_id
        WHERE articles.article_id = ?
    ");
    $stmt->execute([$article_id]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$article) {
        echo "<h2>Article not found!</h2>";
        exit;
    }
} else {
    echo "<h2>Invalid article ID</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Article - Global News Network</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital@0;1&amp;display=swap" rel="stylesheet">
</head>
<body>

  <!-- Start Header -->
  <header>
    <div class="container">
      <a href="#" class="logo">
        <img src="images/Global News.png" alt="News Logo">
        <h2>Global News Network</h2>
      </a>
      <nav>
       <ul class="main-nav">
        <li><a href="#">Home</a></li>
        <li class="categories">
           <a href="#">
           <i class="fa-solid fa-angle-down arrow-down"></i> categories</a>
            <nav>
             <ul class="bransh-nav">
              <li><a href="#category-politics">Politics</a></li>
              <li><a href="#category-sports">Sports</a></li>
              <li><a href="#category-tech">Technology</a></li>
              <li><a href="#entertainment">Entertainment</a></li>
             </ul> 
            </nav>
        </li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Contact</a></li>
        <form action="">
          <i class="fas fa-search sh-bar"></i>
          <input type="search" placeholder="Search">
        </form> 
        <button class="btn">Login</button>
       </ul> 
      </nav>
    </div>   
  </header>
  <!-- End Header -->

  <!-- article.php -->
  <main class="article-page">
    <div class="container">
      <h1 class="article-title"><?= htmlspecialchars($article['title']);?></h1>
      <img src="images/<?= htmlspecialchars($article['image_url']); ?>" alt="<?= htmlspecialchars($article['title']);?>" class="article-image">
      <div class="article-content">
      <p><?= nl2br(htmlspecialchars($article['content']));?>.</p>
      </div>
      <div class="article-meta">
      <div class="article-info">
        <span class="author">By <mark><b><?= htmlspecialchars($article['username']);?></b></mark></span> 
        <span class="category">In<em><b> <?= htmlspecialchars($article['category_name']);?></b></em></span> 
        </div> 
      <span class="date"> <?= htmlspecialchars($article['published_date']) ?></span>
      </div>
    </div>
  </main>
  <!-- article.php -->

