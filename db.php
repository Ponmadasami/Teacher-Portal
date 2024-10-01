<?php
$host = 'localhost';
$db = 'teacher_portal'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}


if (isset($_POST['deleteBtn'])) {
    // Assuming you have a database connection already established
    $studentId = $_POST['studentId']; // The ID to delete, passed from the front-end
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$studentId]);

    // Optionally, redirect or provide feedback
}

?>
