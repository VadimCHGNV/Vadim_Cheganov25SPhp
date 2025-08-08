<?php

// user registration with prepared statements and password hashing

require_once 'config.php';
 require_once 'functions.php';

if (isset($_SESSION['user_id'])) {
    header('location: dashboard.php');
    exit;
  }

 $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
     $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'please fill in all fields';
        } 
        else {
        // check if username exists
        $stmt = mysqli_prepare($conn, "SELECT id FROM app_users WHERE username = ?");
         mysqli_stmt_bind_param($stmt, 's', $username);
          mysqli_stmt_execute($stmt);
           mysqli_stmt_store_result($stmt);
        
           if (mysqli_stmt_num_rows($stmt) > 0) {
        
            $error = 'username already taken';
                 }
         else {
            mysqli_stmt_close($stmt);
            // create user
            $hash = password_hash($password, PASSWORD_DEFAULT);
              $stmt2 = mysqli_prepare($conn, "INSERT INTO app_users (username, password) VALUES (?, ?)");
              mysqli_stmt_bind_param($stmt2, 'ss', $username, $hash);
            if (mysqli_stmt_execute($stmt2)) 
                {
                 set_flash('success', 'registration successful. please login.');
                  header('location: login.php');
                   exit;
            }   else {
                $error = 'registration failed';
                }
            mysqli_stmt_close($stmt2);
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

    <div class="row justify-content-center">
         <div class="col-md-6">
         
         <?php show_flash(); ?>
          
         <?php if ($error) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
         
          <div class="card p-4">
                <form method="post" action="">
                      <div class="mb-3">
                        <label for="username" class="form-label">username</label>
                            <input id="username" name="username" class="form-control" required>
                    </div>
                      <div class="mb-3">
                          <label for="password" class="form-label">password</label>
                             <input id="password" name="password" type="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary" type="submit">register</button>
                </form>
                <p class="mt-3">already have account? <a href="login.php">login</a></p>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>
