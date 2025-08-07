<?php
// start session and include configuration
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

// ensure ID is provided
if (!isset($_GET['id'])) {
    header('Location: users.php');
    exit;
 }

$user_id = (int)$_GET['id'];

// Prevent self-deletion
if ($user_id === $_SESSION['user_id']) {
     $_SESSION['error'] = "You cannot delete yourself";
      header('Location: users.php');
       exit;
 }

// fetch user image for deletion
  $stmt = $db->prepare("SELECT image FROM users WHERE id = ?");
  $stmt->bind_param("i", $user_id);
 $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

        // delete user
$stmt = $db->prepare("DELETE FROM users WHERE id = ?");
  $stmt->bind_param("i", $user_id);

if ($stmt->execute())
     {
    if ($user && $user['image'] !== 'default.jpg') {
        @unlink(UPLOAD_DIR . $user['image']);
    }
    $_SESSION['message'] = "User deleted successfully";
    } 
else {
    $_SESSION['error'] = "Error deleting user: " . $db->error;
       }

    header('Location: users.php');
exit;
?>