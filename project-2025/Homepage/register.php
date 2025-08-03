<?php
 include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$email || !$password) {
        $error = "All fields are required.";
        
      } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";

      } elseif (strlen($password) <= 6) {
        $error = "Password must be greater than 6 characters.";

    }  else {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $error = "Username or email already exists.";
        }  else {
         $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
         $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
         $inserted = $stmt->execute([$username, $email, $hashedPassword]);
        
         if ($inserted) {
          $success = "Registration successful! You can now log in.";
         } else {
          $error = "An error occurred during registration. Please try again.";
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
  <title>Register - Global News Network</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital@0;1&amp;display=swap" rel="stylesheet">
</head>
<body>



  <div class="form-rehister">
    <h2 class="h-register">Create A New Account</h2>
    <div class="container registerpage">

      <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error);?></p>
      <?php endif; ?>

      <?php if (!empty($success)): ?>
        <p class="success"><?= htmlspecialchars($success);?></p>
      <?php endif; ?>

        <form action="register.php" method="POST" class="register-form">
         <input class="input" type="text" name="username" placeholder="Username" required><br/><br/>

         <input class="input" type="email" name="email" placeholder="Email" required><br/><br/>

         <input class="input" type="password" name="password" placeholder="Password" required><br/><br/>

         <button type="submit">Sign Up</button>
       </form>
       <p class="register-link">Have an account?<a href="login.php" class="login-php">Login</a></p>
    </div>
  </div> 
</body>
</html>

