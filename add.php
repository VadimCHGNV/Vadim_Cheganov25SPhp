<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Student</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Student Portal</h1>
    <nav><a href="view.php">View Students</a></nav>
  </header>

  <form action="process.php" method="POST">
    <label>Full Name: <input type="text" name="name" required></label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Grade: <input type="number" name="grade" min="0" max="100" required></label><br>
    <button type="submit">Submit</button>
  </form>

  <footer>© 2025 Student Portal</footer>
</body>
</html>
