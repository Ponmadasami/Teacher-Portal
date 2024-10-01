<?php
session_start();
require 'db.php';

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];

    // Check for existing student
    $stmt = $pdo->prepare("SELECT * FROM students WHERE name = ? AND subject = ?");
    $stmt->execute([$name, $subject]);
    $student = $stmt->fetch();

    if ($student) {
        // Update marks
        $newMarks = $student['marks'] + $marks;
        $stmt = $pdo->prepare("UPDATE students SET marks = ? WHERE id = ?");
        $stmt->execute([$newMarks, $student['id']]);
        echo json_encode(['status' => 'success', 'message' => 'Marks updated successfully']);
    } else {
        // Insert new student
        $stmt = $pdo->prepare("INSERT INTO students (name, subject, marks) VALUES (?, ?, ?)");
        $stmt->execute([$name, $subject, $marks]);
        echo json_encode(['status' => 'success', 'message' => 'New student added successfully']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
