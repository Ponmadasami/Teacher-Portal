<?php
session_start();

// Dummy login logic (replace with your actual authentication logic)
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple authentication check (replace with database check)
    if ($username == 'teacher' && $password == 'password') {
        $_SESSION['loggedin'] = true;
        header('Location: home.php'); // Redirect to home page after login
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Portal</title>
    <link rel="stylesheet" href="loginstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <h1>Login Portal</h1>
        <?php if (isset($error) && !empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" required placeholder="Username">
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" required placeholder="Password">
            </div>
            <a href="#" onclick="showForgotPassword()">Forgot Password?</a>
            <br>
            <button type="submit" class="login">Login</button>
            <br>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
