<?php
session_start();
require 'db.php';

// If already logged in -> posts
if (isset($_SESSION['user_id'])) {
    header("Location: posts.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic server-side validation
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = "Please fill in both fields.";
    } else {
        // Find user
        $stmt = $pdo->prepare("SELECT id, username, password FROM userss WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Success: set session and redirect
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: posts.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
include 'header.php';
?>
<section class="card">
  <h2>Login</h2>
  <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="post" class="form">
    <label>Username
      <input type="text" name="username" required>
    </label>
    <label>Password
      <input type="password" name="password" required>
    </label>
    <button type="submit">Login</button>
  </form>
</section>
<?php include 'footer.php'; ?>
