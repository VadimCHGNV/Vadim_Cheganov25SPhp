<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  
  <meta name="description" content="Add new student records to the student portal database.">
  
  <meta name="keywords" content="student portal, add student, new student, register student, student form">
  
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

  <footer>© 2025 Student Portl</footer>
</body>
</html>
