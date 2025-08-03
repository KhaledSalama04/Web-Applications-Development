<?php
session_start();
include '../Homepage/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Homepage/login.php");
    exit;
}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $article_id = (int) $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM articles WHERE article_id = :id");
        $stmt->bindParam(':id', $article_id, PDO::PARAM_INT);
        // $stmt->execute([':id' => $article_id]);

        if ($stmt->execute()) {
            header("Location: manage_articles.php?msg=Article Deleted Successfully");
            exit;
        } else {
            echo "An error occurred while deleting the article.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "No valid article ID was provided.";
}
?>


