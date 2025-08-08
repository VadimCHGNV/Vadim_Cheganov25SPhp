<?php

// user login with prepared statements and password verifcation

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
        $error = 'please fill in both fields';
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, password FROM app_users WHERE username = ?");
           mysqli_stmt_bind_param($stmt, 's', $username);
             mysqli_stmt_execute($stmt);
              mysqli_stmt_bind_result($stmt, $id, $hash);
       
              if (mysqli_stmt_fetch($stmt)) {
                if (password_verify($password, $hash)) 
                  {
                 // login success
                $_SESSION['user_id'] = $id;
                  set_flash('success', 'login successful');
                  header('location: dashboard.php');
                exit;
            } 
            else {
                $error = 'invalid credentials';
               }
        }  
        else {
            $error = 'invalid credentials';
           }
        mysqli_stmt_close($stmt);
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
                      <button class="btn btn-primary" type="submit">login</button>
                </form>
                  <p class="mt-3">don't have account? <a href="register.php">register</a></p>
            </div>
          </div>
    </div>

 <?php include 'includes/footer.php'; ?>