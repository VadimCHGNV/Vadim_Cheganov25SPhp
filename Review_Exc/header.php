<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vadim Cheganov</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">

</head>

<body>

<header class="site-header">
  <h1>Mini Blog Panel</h1>
  <nav>
       <a href="posts.php">Pots</a>
        <a href="create_post.php">Create</a>
         <a href="external_posts.php">API Posts</a>
   
         <?php session_start(); if (isset($_SESSION['user_id'])): ?>
      <a href="register.php">Add User</a>
      <a href="logout.php" class="danger">Logout</a>
   
      <?php else: ?>
      <a href="login.php">Login</a>
   
      <?php endif; ?>
  </nav>
</header>
<main class="container">
