<?php
// includes configuration file for database settings and authentication logic
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

// handle logout request by calling logout function
if (isset($_GET['logout'])) {
       logout();
       }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- responsive viewport meta tags -->
     <meta name="Vadim Cheganov" content="Final Project">
     <meta name="keywords" content="filal project, phpFianlProject, hardworking">
     <meta charset="UTF-8">
   
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Final Project Site</title>
                    <!-- bootstrap  -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
                 
          <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <!-- navigation bar component -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php"> VADIM </a>
         
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
               
                    <span class="navbar-toggler-icon"></span>
            </button>
       
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
        
                <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
        
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
        
                    <li class="nav-item">
                        <a class="nav-link" href="content.php">Content</a>
                    </li>
        
                    <?php if (isLoggedIn()): // conditional block for logged-in users ?>
                        <li class="nav-item">
                             <a class="nav-link" href="users.php">Users</a>
                          </li>
                        <li class="nav-item">
                                 <a class="nav-link" href="add.php">Add Content</a>
                            </li>
                        <?php endif; ?>
                </ul>
           
           
                <?php if (isLoggedIn()): // display user info and logout for logged-in users ?>
                    <div class="d-flex align-items-center text-white">
                        <img src="/uploads/<?php echo htmlspecialchars($_SESSION['user_image']); ?>" 
                 
                        alt="Profile" class="rounded-circle me-2" width="30" height="30">
                 
                          <span class="me-3">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span> <!-- welcome to logged-in user-->

                           <a href="?logout=true" class="btn btn-outline-light">Logout</a>
                    </div>
                <?php else: // display login form for non-logged-in users ?>
                    <form class="d-flex" method="post" action="login.php">
                        <input type="email" name="email" class="form-control me-2" placeholder="Email" required>
                          <input type="password" name="password" class="form-control me-2" placeholder="Password" required>
                           <button type="submit" name="login" class="btn btn-outline-light">Login</button>
                        <a href="register.php" class="btn btn-outline-light ms-2">Register</a>
                     </form>
                  <?php endif; ?>
                  </div>
            </div>
            </nav>
    <!-- main content container -->
    <div class="container my-4">