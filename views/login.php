<?php
  session_start();
  $errors = $_SESSION['errors'] ?? [];
  $db_error = $_SESSION['db_error'] ?? ["No error"];
  unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Story Night - Login</title>
  <link rel="stylesheet" href="../assets/styles/auth.css">
</head>
<body>
  <div class="container">
    <h1 style="color:red">StoryNight</h1>
    <h2>Login</h2>
    <form  method="POST" onsubmit="return validateLogin(event)"  action ="../controllers/loginController.php">

      <input type="email" name="email" placeholder="Enter Email ex-abc@email.com"  >
      <span id="emailError" class="error"><?php echo $errors['email'] ?? ''; ?></span>

      <input type="password" name="password" placeholder="Enter Password" >
      <span id="passwordError" class="error"><?php echo $errors['password'] ?? ''; ?></span>

      <button type="submit" name="login">Login</button>

    </form>
    <a href="./register.php">New user? Register here</a>
    <a href="./forgot_password.php">Forgot Password?</a>
  </div>

  <script src="../assets/scripts/login.js"></script>
</body>
</html>
