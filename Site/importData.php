<?php
/** @var PDO $pdo */
require 'connection.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$config = require 'config.php';
$config = $config['import'];

$posts = importJson($config['posts']);
$comments = importJson($config['comments']);

$countPosts = 0;
foreach ($posts as $post) {
    $stmt = $pdo->prepare('INSERT INTO posts VALUES (:id, :userId, :title, :body)');
    $isLoaded = $stmt->execute([
        'id' => $post->id,
        'userId' => $post->userId,
        'title' => $post->title,
        'body' => $post->body,
    ]);

    if ($isLoaded) {
        $countPosts++;
    }
}

$countComments = 0;
foreach ($comments as $comment) {
    $stmt = $pdo->prepare('INSERT INTO comments VALUES (:id, :postId, :name, :email, :body)');
    $isLoaded = $stmt->execute([
        'id' => $comment->id,
        'postId' => $comment->postId,
        'name' => $comment->name,
        'email' => $comment->email,
        'body' => $comment->body,
    ]);

    if ($isLoaded) {
        $countComments++;
    }
}

echo "Загружено $countPosts записей и $countComments комментариев.";

function importJson ($url)
{
    $data = file_get_contents($url);

    if (empty($data)) {
        return null;
    }

    return json_decode($data);
}


