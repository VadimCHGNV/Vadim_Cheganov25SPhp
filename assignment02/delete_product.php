<?php

// delete product and remove associated image file 

require_once 'config.php';
require_once 'functions.php';
require_login();

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('location: dashboard.php');
    exit;
}

// find product image
$stmt = mysqli_prepare($conn, "SELECT image FROM app_products WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $image);
if (!mysqli_stmt_fetch($stmt)) {
    mysqli_stmt_close($stmt);
    set_flash('danger', 'product not found');
    header('location: dashboard.php');
    exit;
}
mysqli_stmt_close($stmt);

// delete db record
$stmt2 = mysqli_prepare($conn, "DELETE FROM app_products WHERE id = ?");
mysqli_stmt_bind_param($stmt2, 'i', $id);
if (mysqli_stmt_execute($stmt2)) {
    // remove image file
    if ($image && $image !== DEFAULT_IMAGE) {
        remove_image_file($image);
    }
    set_flash('success', 'product deleted');
} else {
    set_flash('danger', 'failed to delete product');
}
mysqli_stmt_close($stmt2);

header('location: dashboard.php');
exit;
