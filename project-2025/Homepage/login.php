<?php

session_start();

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userInput = trim($_POST['user_input'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$userInput || !$password) {
        $error = "Please enter username/email and password.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE BINARY username = ? OR BINARY email = ?");
        $stmt->execute([$userInput, $userInput]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {

                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: ../admin/dashboard.php");
                    exit;
                } else {
                    header("Location: index.php");
                    exit;
                }

            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Global News Network</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital@0;1&amp;display=swap" rel="stylesheet">
<body>




  <div class="form-login">
    <h2 class="h-login">Login Your Account</h2>
    <div class="container loginpage">

      <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error); ?></p>
      <?php endif; ?>

      <form action="login.php" method="POST" class="login-form">
        <input class="input-login" type="text" name="user_input" placeholder="Username or Email" required><br/><br/>
        <input class="input-login" type="password" name="password" placeholder="Password" required><br/><br/>
        <button type="submit">Login</button>
      </form>
      <p class="login-link">Don't have an account?<a href="register.php" class="login-php">Sign Up</a></p>
    </div>
  </div>
</body>
</html>


