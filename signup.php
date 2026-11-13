<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "config.php";

    $username = trim($_POST["username"]);
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO users (username, fullname, email, password) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $username, $fullname, $email, $password);

    if ($stmt->execute()) {
        $message = "Signup successful! You can now log in.";
    } else {
        $message = "Error: Username or email may already exist.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CAT2 - Sign Up</title>
</head>
<body>

    <h2>Create an Account</h2>

    <?php if ($message != ""): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Full Name:</label><br>
        <input type="text" name="fullname" required><br><br>

        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Sign Up</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>

</body>
</html>
