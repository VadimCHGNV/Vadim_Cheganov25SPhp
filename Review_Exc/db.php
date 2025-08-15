<?php

$host = '172.31.22.43';     
$dbname = 'Vadim200609007';     
$username = 'Vadim200609007'; 
 $password = 'WNHOw19UUF';  

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    //  exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500);
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}
