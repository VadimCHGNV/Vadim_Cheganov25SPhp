<?php

// database connection and global settings


define('DB_SERVER', '172.31.22.43');
define('DB_USERNAME', 'Vadim200609007');
define('DB_PASSWORD', 'WNHOw19UUF');
define('DB_NAME', 'Vadim200609007');

// upload settings
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_DIR_WEB', 'uploads/'); // web path used in img src
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2 mb
$allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

// default image filename 
define('DEFAULT_IMAGE', 'no_image.png');


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// connect to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die('connection failed: ' . mysqli_connect_error());
}


function allowed_extensions() {
    return ['jpg', 'jpeg', 'png', 'gif'];
}
?>
