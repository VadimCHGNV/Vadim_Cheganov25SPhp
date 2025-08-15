<?php
require 'auth_guard.php';
require 'db.php';

$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    // Optional: also delete image file if exists
    $stmt = $pdo->prepare("SELECT image FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    $del = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $del->execute([$id]);

    if ($row && !empty($row['image'])) {
        $path = __DIR__ . "/uploads/" . $row['image'];
        if (is_file($path)) @unlink($path);
    }
}

header("Location: posts.php");
exit;
