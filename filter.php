<?php
/** @var PDO $pdo */
require 'connection.php';

if (isset($_GET['submitButton'], $_GET['commentBodyTitle']) && mb_strlen($_GET['commentBodyTitle']) > 3) {
    $stmt = $pdo->prepare("SELECT p.id, p.title, c.body, c.name FROM posts p INNER JOIN comments c ON p.id=c.postId WHERE c.body LIKE :body");
    $stmt->execute([
        'body' => '%' . $_GET['commentBodyTitle'] . '%',
    ]);
    $posts = $stmt->fetchAll();
    foreach ($posts as $row)
    {
        echo "<hr>";
        echo $row['title'] . "<br>";
        echo $row['name'] . "<br>";
        echo $row['body'] . "<br>";
    }
}
