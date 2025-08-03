<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Homepages/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Global News Network</title>
  <link rel="stylesheet" href="../Homepage/css/normalize.css">
  <link rel="stylesheet" href="../Homepage/css/all.min.css">
  <link rel="stylesheet" href="../Homepage/css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital@0;1&amp;display=swap" rel="stylesheet">
 </head>
  <body>
   
  
  
  <div class="admin-panel">
  <h2 class="main-title admin-title">Admin Dashboard</h2>
  <div class="container">
      <h3>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h3>
      <p class="admin">You are now in the Admin Dashboard.</p>
      <ul class="admin-links">
       <li><a href="manage_articles.php">Manage Articles</a></li>
       <li><a href="../Homepage/logout.php">Logout</a></li>
      </ul>
     </div>
  </div> 
</body>
</html> 

