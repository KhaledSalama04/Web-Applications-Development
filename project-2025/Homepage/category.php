<?php
session_start();
include 'db.php';  

$category_name = $_GET['category'] ?? '';

if (!$category_name) {
    header("Location: index.php");
    exit;
}

$stmtCat = $conn->prepare("SELECT category_id FROM categories WHERE category_name = ?");
$stmtCat->execute([$category_name]);
$category = $stmtCat->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    echo "<h2>Category not found.</h2>";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM articles WHERE category_id = ? ORDER BY published_date DESC");
$stmt->execute([$category['category_id']]);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($category_name);?> News - Global News Network</title>
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
        <li><a href="index.php">Home</a></li>
        <li class="categories">
           <a href="#">
           <i class="fa-solid fa-angle-down arrow-down"></i> categories</a>
            <nav>
             <ul class="bransh-nav">
              <li><a href="category.php?category=Politics">Politics</a></li>
              <li><a href="category.php?category=Sports">Sports</a></li>
              <li><a href="category.php?category=Technology">Technology</a></li>
              <li><a href="category.php?category=Entertainment">Entertainment</a></li>
             </ul> 
            </nav>
        </li>
        <li><a href="index.php">About Us</a></li>
        <li><a href="index.php">Contact</a></li>
        <form action="search.php" method="get">
          <i class="fas fa-search sh-bar"></i>
          <input type="search" placeholder="Search">
        </form> 
        <div class="user-actions">
         <a href="login.php" class="btn">Login</a>
         <a href="register.php" class="btn">Sign Up</a>
        </div>  
       </ul> 
     </nav>
    </div>   
  </header>
  <!-- End Header -->


  <h2 class="main-title title-category"><?= htmlspecialchars($category_name) ?> News</h2>
  
  <div class="container category-container">
  <?php if (count($articles) === 0): ?>
    <p class="no-found">No articles found in this category.</p>
  <?php else: ?>
    <?php foreach ($articles as $article): ?>
      <div class="article-card">
        <img src="images/<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
        <div class="content-box">
          <h3><a href="article.php?id=<?= $article['article_id'] ?>">
            <?= htmlspecialchars($article['title']) ?>
          </a></h3>
          <p><?= mb_strimwidth(strip_tags($article['content']), 0, 80,) . '...'; ?></p>
        </div>
        <div class="box">
          <a class="read-more" href="article.php?id=<?php echo $article['article_id']; ?>">Read More</a>
          <span class="article-date"><?php echo date('d M Y - h:i A', strtotime($article['published_date'])); ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

  <!-- Start Footer -->
  <footer>
    <div class="container">
     <a href="#" class="logo">
      <h2>Global News Network</h2>
     </a>
     <ul class="social">
         <li>
          <a href="#" class="facebook"> <i class="fab fa-facebook-f"></i> </a>
         </li>
         <li>
          <a href="#" class="twitter"> <i class="fab fa-twitter"></i> </a>
         </li>
         <li>
          <a href="#" class="youtube"> <i class="fab fa-youtube"></i> </a>
         </li>
     </ul>
     <ul class="links">
       <li><a href="index.php">Home</a></li>
       <li><a href="index.php">About Us</a></li>
       <li><a href="index.php">Contact</a></li>
     </ul>
     <p class="copyright">© 2025 <span>Global News Network</span> All Right Reserved</p>
    </div>
  </footer>
  <!-- Start Footer -->

</body>
</html>
