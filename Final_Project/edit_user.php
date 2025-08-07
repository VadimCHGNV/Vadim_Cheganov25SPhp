<?php
// start session and include configuration
session_start();
require_once __DIR__ . '/includes/config.php';
 require_once __DIR__ . '/includes/auth.php';
  requireLogin();

$user_id = $_GET['id'] ?? 0;
$errors = [];
 $user = [];

// fetch user data
$stmt = $db->prepare("SELECT id, username, email, image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user)  
          {
         $_SESSION['error'] = 'User not found';
         header('Location: users.php');
         exit;
   }

// handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $username = trim($_POST['username']);
     $email = trim($_POST['email']);
      $password = $_POST['password'];
    
     if (empty($username)) $errors[] = 'Username is required';
       if (empty($email)) $errors[] = 'Email is required';
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format';
    
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
     $stmt->bind_param("si", $email, $user_id);
      $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) 
        {
        $errors[] = 'Email already taken';
          }
    
    if (empty($errors)) 
        {
        $sql = "UPDATE users SET username = ?, email = ?";
          $params = [$username, $email];
          $types = "ss";
        
        if (!empty($password)) {
            $sql .= ", password = ?";
              $params[] = password_hash($password, PASSWORD_DEFAULT);
                $types .= "s";
               }
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK)
             {
            if ($_FILES['image']['size'] > MAX_FILE_SIZE)
                 {
                $errors[] = 'File size exceeds 2MB';
            } 
             elseif (!in_array($_FILES['image']['type'], ALLOWED_TYPES)) {
                $errors[] = 'Invalid image type';
               } 
              else {
                   $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $new_image = uniqid() . '.' . $ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR . $new_image);
                
                if ($user['image'] !== 'default.jpg')
                     {
                      @unlink(UPLOAD_DIR . $user['image']);
                      }
                 $sql .= ", image = ?";
                     $params[] = $new_image;
                  $types .= "s";
                    }
                 }
        
         $sql .= " WHERE id = ?";
          $params[] = $user_id;
          $types .= "i";
        
         $stmt = $db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
              $_SESSION['message'] = 'User updated successfully';
               header('Location: users.php');
               exit;
        }
         else {
              $errors[] = 'Update failed: ' . $db->error;
           }
    }
} 
?>

<!-- html structure for editing user -->
<?php include 'includes/header.php'; ?>

<main class="container my-4">
    <section>
        <h1>Edit User</h1>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
        
                <input type="text" class="form-control" id="username" name="username" 
                       value="<?php echo htmlspecialchars($user['username']); ?>" required>
                  </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
         
                <input type="email" class="form-control" id="email" name="email" 
         
                value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
         
            <div class="mb-3">
                <label for="password" class="form-label">New Password (leave blank to keep current)</label>
        
                <input type="password" class="form-control" id="password" name="password">
            </div>
          
            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
          
                <img src="/uploads/<?php echo htmlspecialchars($user['image']); ?>" 
          
                alt="Current image" class="rounded-circle" width="100" height="100">
            </div>
          
            <div class="mb-3">
                <label for="image" class="form-label">New Image (optional, JPG/PNG/GIF)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
          
            <button type="submit" name="update" class="btn btn-primary">Update</button>
          
            <a href="users.php" class="btn btn-secondary">Cancel</a>
        
        </form>
    </section>
</main>

<?php include 'includes/footer.php'; ?>