<?php
// simple home page  redirect to dashboard if logged in

require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    header('location: dashboard.php');
    exit;
}
?>

<?php include 'includes/header.php'; ?>

    <div class="row justify-content-center">
         <div class="col-md-6">
             <div class="card p-4 text-center">
                <h2>welcome</h2>
    
                <p>please <a href="login.php">login</a> or <a href="register.php">register</a> to manage products.</p>
    
            </div>
        </div>
    
    </div>

<?php include 'includes/footer.php'; ?>
