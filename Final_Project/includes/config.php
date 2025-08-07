<?php
  // db configuration
  define('DB_HOST', '172.31.22.43'); 
  define('DB_USER', 'Vadim200609007');
  define('DB_PASS', 'WNHOw19UUF');
  define('DB_NAME', 'Vadim200609007'); 

  // file uploading config
  define('UPLOAD_DIR', '/home/Vadim200609007/public_html/Final_Project/uploads/');
   define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
    define('MAX_FILE_SIZE', 2097152); // 2mb in bytes

  // starting  session if not already started
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  // connection to database
  $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if ($db->connect_error)  
       {
       die("Connection failed: " . $db->connect_error);
            }

  // create uploading directory if it doesn't exist
  if (!file_exists(UPLOAD_DIR)) {
      mkdir(UPLOAD_DIR, 0755,  true);
       }
  ?>