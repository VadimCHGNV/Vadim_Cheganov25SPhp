<?php
$conn = new mysqli("localhost", "root", "", "student_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);

$grade = (int)$_POST['grade'];

$sql = "INSERT INTO students (name, email, grade) VALUES ('$name', '$email', $grade)";

$conn->query($sql);

$conn->close();

header("Location: view.php");
exit;

?>
