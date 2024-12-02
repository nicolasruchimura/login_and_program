<?php
include 'db_connect.php'; // Ensure the DB connection is included

// Initialize variables for error messages
$error = '';

// Handle login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Check if email exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        header('Location: dashboard.php');
    } else {
        $error = 'Invalid login credentials!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Login Form -->
    <div class="login-form">
        <form method="POST">
            <h2>Login</h2>
            <?php if ($error) echo "<p class='error'>$error</p>"; ?>
            <label for="login_email">Email:</label>
            <input type="email" name="email" id="login_email" required>
            <label for="login_password">Password:</label>
            <input type="password" name="password" id="login_password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
