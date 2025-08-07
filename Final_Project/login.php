<?php
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

// redirection if already logged in
if (isLoggedIn()) {
     header('Location: index.php');
          exit;
     }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) 
    {
    if (loginUser($_POST['email'], $_POST['password'])) {
         $redirect = $_SESSION['redirect_url'] ?? 'index.php';
          unset($_SESSION['redirect_url']);
          header('Location: ' . $redirect);
         exit;
    } 
    else
         {
         $error = 'Invalid email or password';
         }
        }
?>

<!-- html structure for login page -->
<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
          
        <div class="card">
                <div class="card-header">
                    <h3>Login</h3>
                </div>
              
                <div class="card-body">             
                <?php if ($error): ?>
              
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>      
                          <?php endif; ?>
              
                    <form method="POST">
                        <div class="mb-3">
                            <label>Email</label>
            
                            <input type="email" name="email" class="form-control" required>
                        </div>
           
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
            
                        </div>
                        <button type="submit" name="login" class="btn btn-primary">Login</button>
            
                        <a href="register.php" class="btn btn-link">Register</a>
                    </form>
                  </div>
              </div>
         </div>
          </div>
</div>

<?php include 'includes/footer.php'; ?>