<?php
// start session and include configuration
session_start();
require_once __DIR__ . '/includes/config.php';
// Include authentication and login requirement
require_once __DIR__ . '/includes/auth.php';
requireLogin();

// prepare and execute SQL query to fetch all users
$stmt = $db->prepare("SELECT id, username, email, image, registration_date FROM users ORDER BY registration_date DESC");
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!-- html structure for user management page -->
<?php include 'includes/header.php'; ?>

<main class="container my-4">
    <section>
        <h1>User Management</h1>
        <?php if (isset($_SESSION['message'])): // display success message if set ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['message']); ?></div>
         
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
       
        <?php if (isset($_SESSION['error'])): // display error message if set ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
            <?php unset($_SESSION['error']); ?>
       
            <?php endif; ?>
        <div class="table-responsive">
       
        <table class="table table-striped">
                <thead>
                    <tr>
                         <th>Image</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Registered</th>
                          <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): // loop through all users to display in table ?>
                        <tr>
                            <td>
                                <img src="/uploads/<?php echo htmlspecialchars($user['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($user['username']); ?>" 
                                     class="rounded-circle" width="50" height="50">
                            </td>
                               <td><?php echo htmlspecialchars($user['username']); ?></td>
                           
                               <td><?php echo htmlspecialchars($user['email']); ?></td>
                           
                                  <td><?php echo date('M j, Y', strtotime($user['registration_date'])); ?></td>
                              <td>
                                  <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                               
                                  <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger"
                                     onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                          
                                </td>
                            </tr>
                     <?php endforeach; ?>
                  </tbody>
            </table>
         </div>
      </section>
</main>

<?php include 'includes/footer.php'; ?>