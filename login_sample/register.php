<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: home.php");
    exit;
}

require 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    if ($username === "" || $password === "" || $confirmPassword === "") {
        $error = "Please fill in all fields.";
    } elseif (strlen($username) > 50) {
        $error = "Username must be 50 characters or fewer.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);

            $_SESSION["user_id"] = $pdo->lastInsertId();
            $_SESSION["username"] = $username;
            session_regenerate_id(true);
            header("Location: home.php");
            exit;
        } catch (PDOException $exception) {
            if ($exception->getCode() === "23000") {
                $error = "That username is already taken.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Create account</h1>

            <?php if ($error): ?>
                <div class="alert"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" maxlength="50" autocomplete="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" minlength="8" autocomplete="new-password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm password</label>
                    <input id="confirm_password" type="password" name="confirm_password" minlength="8" autocomplete="new-password" required>
                </div>

                <button type="submit" class="btn">Register</button>
            </form>
            <p class="auth-link">Already registered? <a href="login.php">Log in</a></p>
        </div>
    </div>
</body>
</html>