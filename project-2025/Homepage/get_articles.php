<?php
include 'db.php';

function fetchArticles($conn, $usedIds, $limit, $extraWhere = "", $extraParams = []) {
    $placeholders = implode(',', array_fill(0, count($usedIds), '?'));
    $notInClause = $usedIds ? "AND articles.article_id NOT IN ($placeholders)" : "";

    $sql = "SELECT articles.*, categories.category_name, users.username 
            FROM articles 
            JOIN categories ON articles.category_id = categories.category_id 
            JOIN users ON articles.author_id = users.user_id 
            WHERE 1=1 $notInClause $extraWhere
            ORDER BY articles.article_id ASC
            LIMIT $limit";

    $params = array_merge($usedIds, $extraParams);
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$usedArticleIds = [];

// === 1. Breaking  ===
$breaking = fetchArticles($conn, $usedArticleIds, 1);
foreach ($breaking as $article) {
    $usedArticleIds[] = $article['article_id'];
}

// === 2. Featured  ===
$featured = fetchArticles($conn, $usedArticleIds, 6);
foreach ($featured as $article) {
    $usedArticleIds[] = $article['article_id'];
}

// === 3. Latest  ===
$latest = fetchArticles($conn, $usedArticleIds, 5);
foreach ($latest as $article) {
    $usedArticleIds[] = $article['article_id'];
}

// === 4. Category-wise  ===
$categoryArticles = [];

$categoryStmt = $conn->query("SELECT * FROM categories");
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($categories as $category) {
    $catId = $category['category_id'];
    $catName = $category['category_name'];

    $articles = fetchArticles($conn, $usedArticleIds, 3, "AND articles.category_id = ?", [$catId]);
    foreach ($articles as $article) {
        $usedArticleIds[] = $article['article_id'];
    }

    $categoryArticles[$catName] = $articles;
}

// === 5. Trending ===
$trending = fetchArticles($conn, $usedArticleIds, 3);
foreach ($trending as $article) {
    $usedArticleIds[] = $article['article_id'];
}

?>



