<?php
 include 'get_articles.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Global News Network</title>
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
        <li><a href="<?php echo $url['index.php']?>">Home</a></li>
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
        <form action="search.php" method="GET">
          <i class="fas fa-search sh-bar"></i>
          <input type="search" name="q" placeholder="Search">
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

  <div class="content-wrapper">
    <!-- Start Main -->
    <main>
      <!-- Start Breking News -->
      <section id="breaking-news">
        <?php foreach ($breaking as $article): ?>
          <article class="breaking-news">
          <h2>Breaking News: </h2>
          <p><span class="breaking-title"><?= htmlspecialchars($article['title']); ?></span> <?= htmlspecialchars(substr($article['content'], 0)); ?></p>
        </article>
      <?php endforeach; ?> 
      </section>
      <!-- End Breking News -->
      
      <!-- Start Featured News -->
      <section id="featured-news">
        <h2 class="main-title">Featured News</h2>
        <div class="container">
          <?php foreach ($featured as $article): ?>
            <article class="featured-article">
              <img src="images/<?php echo htmlspecialchars($article['image_url']);?>" alt="<?php echo htmlspecialchars($article['title']);?>">
              <div class="text-content">
                <h3><?php echo htmlspecialchars($article['title']);?></h3>
                <p><?php echo htmlspecialchars(substr($article['content'], 0, 80)) . '...';?></p>
              </div>
              <div class="box">
                <a class="read-more" href="article.php?id=<?php echo $article['article_id']; ?>">Read More</a>
                <span class="date"><?php echo date('d M Y -h:i A', strtotime($article['published_date'])); ?></span>
              </div>  
            </article>
            <?php endforeach; ?>
          </div>
      </section>
      <!-- End Featured News -->
        
      <!-- Start Latest News -->
      <section id="latest-news">
        <h2 class="main-title">Latest News</h2>
          <?php foreach ($latest as $article): ?>
            <article class="latest-article">
              <img src="images/<?php echo htmlspecialchars($article['image_url']);?>" alt="<?php echo htmlspecialchars($article['title']);?>">
              <div class="text-info">
                <h3><?php echo htmlspecialchars($article['title']);?></h3>
                <p class="desc"><?php echo htmlspecialchars(substr($article['content'], 0, 80)) . '...';?></p>
                <a class="read-more" href="article.php?id=<?php echo $article['article_id']; ?>">Read More</a> 
              </div>
              <span class="date"><?php echo date('d M Y -h:i A', strtotime($article['published_date'])); ?></span>
            </article>
          <?php endforeach; ?>
      </section>
      <!-- End Latest News -->
    
    <!-- Start Category-wise -->
    <section class="category-wise"> 
      <?php foreach ($categoryArticles as $categoryName => $articles): ?>
        <section id="category-<?php echo strtolower($categoryName); ?>">
          <h2 class="main-title"><?php echo $categoryName; ?></h2>
          <div class="container">
            <?php foreach ($articles as $article): ?>
              <article class="<?php echo strtolower($categoryName); ?>-artic">
                <img src="../Homepage/images/<?php echo htmlspecialchars($article['image_url']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" />
                <div class="<?php echo strtolower($categoryName); ?>-text">
                  <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                  <p><?php echo htmlspecialchars(substr(strip_tags($article['content']), 0, 80)) . '...'; ?></p>
                </div>
                <div class="box">
                  <a class="read-more" href="article.php?id=<?php echo $article['article_id']; ?>">Read More</a>
                  <span class="date"><?php echo date('d M Y - h:i A', strtotime($article['published_date'])); ?></span>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        </section>
      <?php endforeach; ?>
    </section> 
     <!-- End Category-wise -->
    </main>
    <!-- End Main -->

    <!-- Start Aside -->
    <aside>
      <div class="trending-news">
        <h2 class="main-title">Trending News</h2>
        <?php foreach ($trending as $article): ?>
          <div class="trend-content">
            <img src="images/<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['title']);?>">
            <h3><?= htmlspecialchars($article['title']) ?></h3>
            <span class="date"><?= date('d M Y - h:i A', strtotime($article['published_date'])); ?></span>
            <a href="article.php?id=<?= $article['article_id'] ?>" class="read-more">Read More</a>
          </div>
        <?php endforeach; ?>
      </div> 
      <div class="advertisement">
        <h2 class="main-title">Advertisement</h2>
        <div class="ad-content">
          <img src="images/Ad.jpeg" alt="Burger Ad">
          <p class="caption">Try Our New Juicy Burger, Only Today</p>
          <a href="#" class="learn-more">Learn More</a>
        </div>
        <div class="ad-content">
          <img src="images/Ad2.jpg" alt="iPhone Ad" class="ad_2">
          <p class="caption-iphone">Experience the Power of iPhone</p>
          <a href="#" class="learn-more">Learn More</a>
          </div>
      </div>
    </aside>
    <!-- End Aside -->
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





