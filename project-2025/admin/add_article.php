<?php
session_start();
include '../Homepage/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Homepage/login.php");
    exit;
}

$categories = $conn->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = $_POST['category_id'];
    $author_id = $_SESSION['user_id']; 
    $image_url = null;
    $published_date = $_POST['published_date'] ?? null;
    if ($published_date === '') {
        $published_date = null; 
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "../Homepage/images/";
        $target_path = $target_dir . $image_name;

        if (move_uploaded_file($image_tmp, $target_path)) {
            $image_url = $image_name; 
        }
    }

     if ($published_date) {
      $sql = "INSERT INTO articles (title, content, image_url, category_id, author_id, published_date) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$title, $content, $image_url, $category_id, $author_id, $published_date]);
    } else {
      $sql = "INSERT INTO articles (title, content, image_url, category_id, author_id) VALUES (?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$title, $content, $image_url, $category_id, $author_id]);
    }

    header("Location: manage_articles.php");
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Articles - Manage Articles</title>
  <link rel="stylesheet" href="../Homepage/css/normalize.css">
  <link rel="stylesheet" href="../Homepage/css/all.min.css">
  <link rel="stylesheet" href="../Homepage/css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital@0;1&amp;display=swap" rel="stylesheet">
 </head>
 <body>





    <div class="container add-container">
      
      <form action="" method="post" enctype="multipart/form-data" class="form-add">
        <h1 class="main-title edit-title">Add New Article</h1>
        <label>Title:</label>
        <input class="title-input" type="text" name="title" required>

        <label>Content:</label>
        <textarea  name="content" rows="10" required></textarea>

        <label>Category:</label>
        <select name="category_id" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
        <?php endforeach; ?>
        </select>

        <label>Image:</label>
        <input type="file" name="image">

        <label>Published Date:</label>
        <input type="datetime-local" name="published_date">

        
        <button class="add-btn" type="submit">Add Article</button>
      </form>
 </div> 
</body>
</html>
