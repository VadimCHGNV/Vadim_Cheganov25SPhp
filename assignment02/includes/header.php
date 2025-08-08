<?php

//  connecting funcs, because show_flash() is used here
require_once 'functions.php'; 

// check if user logged in
$is_logged_in = isset($_SESSION['user_id']);
$dashboard_title = "Product Dashboard"; 
$site_title = "Product Manipulation Site"; 

// detecting title according to current session

$current_page_name = basename($_SERVER['PHP_SELF']);
$page_title_text = '';

switch ($current_page_name) {
    case 'dashboard.php':
        $page_title_text = "Product Dashboard";
        break;
    case 'add_product.php':
        $page_title_text = "Add Product";
        break;
    case 'edit_product.php':
        $page_title_text = "Edit Product";
        break;
    case 'login.php':
        $page_title_text = "Login";
        break;
    case 'register.php':
        $page_title_text = "Register";
        break;
    case 'index.php':
    default:
        $page_title_text = "Product Management System";
        break;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($page_title_text); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- I HAVE TO TURN OFF BOOTSTRAP, BECAUSE IT CAUSES ERRORS AND MY SITE DOESNT REFLECT ANY STYLES. SO NOW IT ONLY RUNS USING ITS STYLES.CSS-->
     <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <div class="header-content"> 
        <?php if ($is_logged_in): ?>
            <h1 class="header-title"><?php echo htmlspecialchars($dashboard_title); ?></h1>
            <div class="header-actions">
                <a href="add_product.php" class="btn btn-secondary btn-sm me-2">Add Product</a>
                <a href="logout.php" class="btn btn-secondary btn-sm">Logout</a>
            </div>
        <?php else: ?>
            <h1 class="header-title"><?php echo htmlspecialchars($site_title); ?></h1>
            <div class="header-actions">
                
            </div>
        <?php endif; ?>
    </div>
</header>
<main class="container mt-4">
    <?php show_flash();?>
