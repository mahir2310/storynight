<?php


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Story Night - Login</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
  <div class="container">
    <h1 style="color:red">StoryNight</h1>
    <h2>Login</h2>
    <form  method="post">
      <input type="email" name="email" placeholder="Enter Email" required>
      <input type="password" name="password" placeholder="Enter Password" required>
      <button type="submit" name="login">Login</button>
    </form>
    <a href="register.php">New user? Register here</a>
    <a href="../views/forgot_password.php">Forgot Password?</a>
  </div>
</body>
</html>
