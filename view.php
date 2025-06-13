<?php
$conn = new mysqli("localhost", "root", "", "student_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Students</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Student Portal</h1>
    <nav><a href="add.php">Add Student</a></nav>
  </header>

  <table>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Grade</th></tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['name'] ?></td>
      <td><?= $row['email'] ?></td>
      <td><?= $row['grade'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>

  <footer>© 2025 Student Portal</footer>
</body>
</html>

<?php $conn->close(); ?>
