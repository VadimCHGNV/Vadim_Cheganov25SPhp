<?php
require 'db.php';

try {
    $username = 'admin';
    $hash = password_hash('1234', PASSWORD_DEFAULT);

      $stmt = $pdo->prepare("INSERT INTO userss (username, password) VALUES (?, ?)");
      $stmt->execute([$username, $hash]);

    echo " Admin created. Username: admin, Password: 1234  <-- to login use this";
} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}