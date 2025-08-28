<?php
$email = $password = "";
$emailErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } elseif (strlen($_POST["password"]) < 8) {
        $passwordErr = "Password must be at least 8 characters";
    } else {
        $password = htmlspecialchars($_POST["password"]);
    }
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
    <form  method="POST" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <input type="email" name="email" placeholder="Enter Email ex-abc@email.com"  >
      <span class="error"><?php echo $emailErr; ?></span>
      <input type="password" name="password" placeholder="Enter Password" >
      <span class="error"><?php echo $passwordErr; ?></span>
      <button type="submit" name="login">Login</button>
    </form>
    <a href="register.php">New user? Register here</a>
    <a href="forgot_password.php">Forgot Password?</a>
  </div>
</body>
</html>
