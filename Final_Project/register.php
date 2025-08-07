<?php
// enabling error reporting for debuging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// start session for user data
session_start();
require_once __DIR__ . '/includes/config.php';

$errors = [];
$username = $email = '';
$image = 'default.jpg'; // default image if none uploaded

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $username = trim($_POST['username']);
       $email = trim($_POST['email']);
       $password = $_POST['password'];

    // validate input fields
    if (empty($username) || empty($email) || empty($password))
         {
        $errors[] = "All fields are required!";
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
       }
     elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 chars long!!.";
      }

    // check for unique email address
    if (empty($errors)) {
          $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
          $stmt->bind_param("s", $email);
         $stmt->execute();
         if 
         ($stmt->get_result()->num_rows > 0) {
            $errors[] = "Email is already registered.";
            }
     }

    // handle image upload if a file is provided
    if (!empty($_FILES['image']['name'])) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            if ($_FILES['image']['size'] > MAX_FILE_SIZE) {
                $errors[] = "File size exceeds 2MB.";
            } 
            elseif (!in_array($_FILES['image']['type'], ALLOWED_TYPES)) {
                $errors[] = "Invalid image type. Use JPG, PNG, or GIF.";
            }
             else {
                  $image = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                  $destination = UPLOAD_DIR . $image;
                 error_log("Attempting to move to: " . $destination);
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $errors[] = "Failed to upload image. Check permissions for: " . UPLOAD_DIR;
                    error_log("MOVE ERROR: From " . $_FILES['image']['tmp_name'] . " to " . $destination . " - " . error_get_last()['message']);
                  }
                 else {
                    error_log("File moved successfully to: " . $destination);
                  }
                 }
        } 
        else {
          
            $errors[] = "Image upload failed. Error code: " . $_FILES['image']['error'];
            }
    }

    // register user if no validation errors
    if (empty($errors)) {
           $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
           $stmt = $db->prepare("INSERT INTO users (username, email, password, image) VALUES (?, ?, ?, ?)");
           $stmt->bind_param("ssss", $username, $email, $hashedPassword, $image);
        if ($stmt->execute()) 
            {
             $_SESSION['user_id'] = $db->insert_id;
             $_SESSION['username'] = $username;
              $_SESSION['user_image'] = $image;
               header("Location: index.php");
             exit;
        } else {
            $errors[] = "Registration failed: " . $db->error;
            } 
        }
  }
?>

<!-- html structure for registration page -->
<?php include 'includes/header.php'; ?>

<main class="container my-4">
    <section class="row justify-content-center">
         <div class="col-md-6"> 
              <div class="glass-container">
                <div class="card">
                     <div class="card-header"><h3>Register</h3></div>
                      <div class="card-body">
                        <?php if (isset($errors) && !empty($errors)): // display validation errors if any ?>
                              <div class="alert alert-danger">
                                <?php foreach ($errors as $err): ?>
                                      <p><?php echo htmlspecialchars($err); ?></p>
                                  <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                       
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                       
                            <label class="form-label">Username</label>
                       
                            <input type="text" name="username" class="form-control" required value="<?php echo htmlspecialchars($username); ?>">
                             </div>
                       
                             <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                       
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                       
                            <div class="mb-3">
                                <label class="form-label">Profile Image (optional)</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                       
                            <button type="submit" class="btn btn-primary">Register</button>
                            <a href="login.php" class="btn btn-link">Login</a>
                         </form>
                    </div>
                    </div>
               </div>
          </div>
         </section>
</main>

<?php include 'includes/footer.php'; ?>