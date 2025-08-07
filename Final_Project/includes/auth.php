<?php
// include configuration  and сheck if user is logged in
require_once __DIR__ . '/config.php';
 function isLoggedIn() {
   
    return isset($_SESSION['user_id']);
}

// redirecting to login if not authenticated
function requireLogin() {
    if (!isLoggedIn()) {
  
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
          header('Location: login.php');
              exit;
    }
}

//  user authntication
function loginUser($email, $password) {
    global $db;
        $stmt = $db->prepare("SELECT id, username, password, image FROM users WHERE email = ?");
         $stmt->bind_param("s", $email);
          $stmt->execute();
     $result = $stmt->get_result();
    if ($result->num_rows === 1) 
         {
               $user = $result->fetch_assoc();
               if (password_verify($password, $user['password']))
                
                {
            $_SESSION['user_id'] = $user['id'];
               $_SESSION['username'] = $user['username'];
                $_SESSION['user_image'] = $user['image'];
                
                return true;
        }
    }
    return false;
    }

// log out user func
function logout() {
     session_unset();
      session_destroy();
      header('Location: index.php');
         exit;
      }

// check if user is content owner so he can or cant make changes
function isContentOwner($content_id) {
    
    global $db;
    if (isLoggedIn()) {
        $stmt = $db->prepare("SELECT user_id FROM content WHERE id = ?");
      
        $stmt->bind_param("i", $content_id);
         $stmt->execute();
          $result = $stmt->get_result();
          $content = $result->fetch_assoc();
          return $content['user_id'] == $_SESSION['user_id'];
             }
    return false;
         }
?>