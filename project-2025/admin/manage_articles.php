<?php
session_start();
include '../Homepage/db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Homepage/login.php");
    exit;
}


$sql = "SELECT a.*, 
               c.category_name AS category_name, 
               u.username AS author_name
        FROM articles a
        LEFT JOIN categories c ON a.category_id = c.category_id
        LEFT JOIN users u ON a.author_id = u.user_id
        ORDER BY a.article_id ASC";

$stmt = $conn->query($sql);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Articles - Admin Dashboard</title>
  <link rel="stylesheet" href="../Homepage/css/normalize.css">
  <link rel="stylesheet" href="../Homepage/css/all.min.css">
  <link rel="stylesheet" href="../Homepage/css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital@0;1&amp;display=swap" rel="stylesheet">
 </head>
  <body>
   


  <div class="container">
    <h1 class="main-title manage-title">Manage Articles</h1>
    <a href="add_article.php" class="add-article">Add New Article</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Thumbnail</th>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Published</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($articles as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['article_id']) ?></td>
                <td>
                    <?php if (!empty($row['image_url'])): ?>
                        <img src="../Homepage/images/<?= htmlspecialchars($row['image_url']);?>" alt="<?= htmlspecialchars($row['title']);?>">
                    <?php else: ?>
                        No image
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['category_name'] ?? 'Unknown') ?></td>
                <td><?= htmlspecialchars($row['author_name'] ?? 'Unknown') ?></td>
                <td><?= htmlspecialchars(date('d-m-Y - h:i A', strtotime($row['published_date'])));?></td>
                <td>
                    <a href="edit_article.php?id=<?= $row['article_id'] ?> " class="edit-article"><i class="fa-solid fa-pencil edit-pen"></i>Edit</a> 
                    <a href="delete_article.php?id=<?= $row['article_id'] ?>"class="del-article" onclick="return confirm('Are you sure?');"><i class="fa-solid fa-trash delete"></i>Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
   </div> 
  

</body>
</html>