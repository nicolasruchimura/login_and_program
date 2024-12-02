<?php
include 'db_connect.php'; // Ensure the DB connection is included

// Initialize variables for error and success messages
$error = '';
$success = '';

// Handle registration
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match!';
    } else {
        // Check if email is already registered
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
            $error = 'Email is already registered!';
        } else {
            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
            if ($stmt->execute(['email' => $email, 'password' => $hashed_password])) {
                $success = 'Registration successful! You can now log in.';
            } else {
                $error = 'An error occurred while registering!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Registration Form -->
    <div class="register-form">
        <form method="POST">
            <h2>Register</h2>
            <?php if ($success) echo "<p class='success'>$success</p>"; ?>
            <?php if ($error) echo "<p class='error'>$error</p>"; ?>
            <label for="register_email">Email:</label>
            <input type="email" name="email" id="register_email" required>
            <label for="register_password">Password:</label>
            <input type="password" name="password" id="register_password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <button type="submit" name="register">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
