<?php
session_start();
include '../Homepage/db.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Homepage/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Article ID is required.");
}

$article_id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM articles WHERE article_id = ?");
$stmt->execute([$article_id]);
$article = $stmt->fetch();

if (!$article) {
    die("Article not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $published_date = $_POST['published_date'];


     if ($published_date === '') {
       $published_date = null;
    }

    $image_url = $article['image_url']; 
    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        $image_dir = "../Homepage/images/";
        $target_path =  $image_dir. $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
        $image_url = $image_name;
    }

    $stmt = $conn->prepare("UPDATE articles SET title = ?, content = ?, category_id = ?, image_url = ?, published_date = ? WHERE article_id = ?");
    $stmt->execute([$title, $content, $category_id, $image_name, $published_date, $article_id]);

    header("Location: manage_articles.php?msg=Article Update Successfully");
    exit;
}

$cat_stmt = $conn->query("SELECT * FROM categories");
$categories = $cat_stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Articles - Manage Articles</title>
  <link rel="stylesheet" href="../Homepage/css/normalize.css">
  <link rel="stylesheet" href="../Homepage/css/all.min.css">
  <link rel="stylesheet" href="../Homepage/css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital@0;1&amp;display=swap" rel="stylesheet">
 </head>
 <body>


<body>
    <div class="container edit-container">
        <form method="post" enctype="multipart/form-data" class="form-edit">
            <h1 class="main-title edit-title">Edit Article</h1>

            <label>Title:</label>
            <input class="title-input" type="text" name="title" value="<?= htmlspecialchars($article['title']) ?>" required>

            <label>Content:</label>
            <textarea name="content" rows="10" required><?= htmlspecialchars($article['content']) ?></textarea>

            <label>Category:</label>
            <select name="category_id" required>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>" 
                        <?= $cat['category_id'] == $article['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['category_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Current Image:</label><br>
            <img src="../Homepage/images/<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="current-img"><br><br>

            <label>Change Image:</label>
            <input type="file" name="image">

            <label>Published Date:</label>
            <input type="datetime-local" name="published_date" value="<?= date('Y-m-d\TH:i', strtotime($article['published_date'])) ?>">

            <br><br>
            <button type="submit" class="edit-btn">Edit</button>
        </form>
    </div>
</body>
</html>

