<?php
require 'auth_guard.php';
require 'db.php';

$error = $msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password2 = trim($_POST['password2'] ?? '');

    if ($username === '' || $password === '' || $password2 === '') {
        $error = "All fields are required.";
    } elseif ($password !== $password2) {
        $error = "Passwords do not match.";
    } else {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO userss (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hash]);
            $msg = "User “" . htmlspecialchars($username) . "” created.";
        } catch (PDOException $e) {
            // Likely duplicate username
            $error = "Could not create user: " . htmlspecialchars($e->getMessage());
        }
    }
}

include 'header.php';
?>
<section class="card">
  <h2>Add User</h2>
  <?php if ($error): ?><div class="alert error"><?= $error ?></div><?php endif; ?>
 
    <?php if ($msg): ?><div class="alert success"><?= $msg ?></div><?php endif; ?>
 
        <form method="post" class="form">
 
        <label>Username
          <input type="text" name="username" required>
            </label>
    <label>Password
      <input type="password" name="password" required minlength="4">
    </label>
    <label>Confirm Password
      <input type="password" name="password2" required minlength="4">
    </label>
     <button type="submit">Create User</button>
      </form>
  </section>
<?php include 'footer.php'; ?>
