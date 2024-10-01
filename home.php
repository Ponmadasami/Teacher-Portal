<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

require 'db.php';

$studentToEdit = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];

    // Check for existing student with the same name and subject
    $stmt = $pdo->prepare("SELECT * FROM students WHERE name = ? AND subject = ?");
    $stmt->execute([$name, $subject]);
    $existingStudent = $stmt->fetch();

    if ($existingStudent) {
        // Update marks if a matching student is found
        echo "<script>alert('Student already exists.');</script>";
        $newMarks = + $marks;
        $id = $existingStudent['id'];
        $updateStmt = $pdo->prepare("UPDATE students SET marks = ? WHERE id = ?");
        $updateStmt->execute([$newMarks, $id]);
      
    } else {
        // Insert new student if no matching record is found
        $insertStmt = $pdo->prepare("INSERT INTO students (name, subject, marks) VALUES (?, ?, ?)");
        $insertStmt->execute([$name, $subject, $marks]);
    }
}

// Fetching students for listing
$stmt = $pdo->query("SELECT * FROM students");
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Portal</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
<div class="header">
  <h3>Welcome To Teacher Portal</h3>
  <div class="header-right">
    <a class="active" href="home.php">Home</a>
    <a href="login.php">logout</a>
  </div>
</div>

    <div id="studentList">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Marks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr data-id="<?= $student['id'] ?>">
                        <td contenteditable="false" class="name"><?= htmlspecialchars($student['name']) ?></td>
                        <td contenteditable="false" class="subject"><?= htmlspecialchars($student['subject']) ?></td>
                        <td contenteditable="false" class="marks"><?= htmlspecialchars($student['marks']) ?></td>
                        <td>
                            <button class="editBtn">Edit</button>
                            <button class="deleteBtn">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button id="addStudentBtn" class="addStudentBtn">Add Student</button>
    </div>

    <div id="modal" class="modal">
        <form method="POST" id="studentForm">
            <h3 id="modalTitle">Add New Student</h3>
            <input type="hidden" name="id" id="studentId">
            <input type="text" name="name" id="studentName" placeholder="Name" required>
            <input type="text" name="subject" id="studentSubject" placeholder="Subject" required>
            <input type="number" name="marks" id="studentMarks" placeholder="Marks" required>
            <button type="submit" class="add">Save</button>
            <button type="button" class="closeModal" id="closeModal">Close</button>
        </form>
    </div>

</body>
</html>
