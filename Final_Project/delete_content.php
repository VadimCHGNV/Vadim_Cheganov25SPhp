<?php
// start session and include configuration
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
 requireLogin();

// check if content id is provided
if (!isset($_GET['id'])) 
    {
      header('Location: about.php');
     exit;
}

$content_id = (int)$_GET['id'];

if (!isContentOwner($content_id))
     {
     $_SESSION['error'] = 'Unauthorized to delete this content';
       header('Location: about.php');
             exit;
}

// delete content
$stmt = $db->prepare("DELETE FROM content WHERE id = ?");
$stmt->bind_param("i", $content_id);

if ($stmt->execute()) {
    $_SESSION['message'] = "Content deleted successfully";
}
 else 
    {
    $_SESSION['error'] = "Error deleting content: " . $db->error;
        }

       header('Location: about.php');
                  exit;
?>