<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Story Night - Register</title>
  <link rel="stylesheet" href="../assets/styles/auth.css">
</head>
<body style="background-color:blue">
  <div class="container">
        <h1>StoryNight</h1>
        <h2>Register</h2>
        <form method="post"  onsubmit="return validateRegister(event)" action ="">
            
        <input type="text" name="name" placeholder="Enter Full Name">
        <span id="nameError" class="error"><?php echo $errors['name'] ?? ''; ?></span>

        <input type="email" name="email" placeholder="Enter Email">
        <span id="emailError" class="error"><?php echo $errors['email'] ?? ''; ?></span>

        <input type="password" name="password" placeholder="Enter Password" >
        <span id="passwordError" class="error"><?php echo $errors['password'] ?? ''; ?></span>

        <input type="password"  name="confirmPassword" placeholder= "re-enter password">
        <span id="confirmError" class="error"><?php echo $errors['confirm'] ?? ''; ?></span>
        
        <button type="submit" name="register">Register</button>

        </form>
        <a href="./login.php">Already have an account? Login</a>
  </div>

  <script src="../assets/scripts/register.js"></script>
</body>
</html>
