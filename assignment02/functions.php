<?php

// common helper functions (all comments lower-case)

require_once 'config.php';

// set a flash message
function set_flash($type, $message) {
    $_SESSION['flash'][$type][] = $message;
}

// show and clear flash messages
function show_flash() {
    if (!isset($_SESSION['flash'])) return;
    foreach ($_SESSION['flash'] as $type => $messages) {
        $class = $type === 'success' ? 'alert-success' : 'alert-danger';
        foreach ($messages as $msg) {
            echo "<div class='alert {$class}' role='alert'>" . htmlspecialchars($msg) . "</div>";
        }
    }
    unset($_SESSION['flash']);
}

// require login redirect
function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header('location: login.php');
        exit;
    }
}

// simple sanitize for output
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
}

// image uploading dsafely, returns filename on success or false on failure and set global $upload_error in case
function handle_image_upload($file_field_name = 'image') {
    global $allowed_ext, $upload_error;
    $allowed_ext = allowed_extensions();

    if (!isset($_FILES[$file_field_name]) || $_FILES[$file_field_name]['error'] === UPLOAD_ERR_NO_FILE) {
        // no file uploaded
         return DEFAULT_IMAGE;
     
        }

    $file = $_FILES[$file_field_name];

    
    if ($file['error'] !== UPLOAD_ERR_OK) {
          $upload_error = 'file upload error';
           return false;
      }

    if ($file['size'] > MAX_FILE_SIZE) {
           $upload_error = 'file too large (max 2mb)';
         return false;
    }

    // check image actually
    $check = @getimagesize($file['tmp_name']);
    
    if ($check === false) {
          $upload_error = 'file is not an image';
           return false;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_ext)) {
        $upload_error = 'invalid file extension';
          return false;
    }

    // create unique file name
    $new_name = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $target = UPLOAD_DIR . $new_name;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        $upload_error = 'failed to move uploaded file';
        return false;
    }

    return $new_name;
}

// removing image file if exists and not default
function remove_image_file($filename) {
    if (!$filename) return;
     if ($filename === DEFAULT_IMAGE) return;
      $path = UPLOAD_DIR . $filename;
    if (file_exists($path)) {
        @unlink($path);
    }
}
?>
