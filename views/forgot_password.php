<?php
$email = "";
$emailErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>

<body style="background-color:blue">
  <div class="container">
    
    <h2>Forgot Password</h2>
    <form method="post" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <input type="email" name="email" placeholder="Enter Your Email" >
      <span class="error"><?php echo $emailErr; ?></span>
      <button type="submit" name="reset">Send Reset Link</button>
    </form>
    <a href="loginn.php">Back to Login</a>
  </div>
</body>
</html>
