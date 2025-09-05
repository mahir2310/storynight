<?php
  session_start();
  $errors = $_SESSION['errors'] ?? [];
  $db_error = $_SESSION['db_error'] ?? ["No error"];
  unset($_SESSION['errors']);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../assets/styles/auth.css">
</head>

<body style="background-color:blue">
  <div class="container">
    
    <h2>Forgot Password</h2>
    <form method="POST" onsubmit="return validateEmail(event)" id="forgotPasswordForm">
      
      <input type="email" name="email" placeholder="Enter Your Email" >
      <span class="error" id="emailError"><?php echo $errors['email'] ?? ''; ?></span>

      <button type="submit" name="reset">Send OTP</button>

      <span class="error" id="dbError"><?php echo $errors['forgot_password'] ?? ''; ?></span>
      <a href="login.php">Back to Login</a>

    </form>

    <form method="POST" onsubmit="return validateOTP(event)" id="submitOTPform">

      <input type="text" name="otp" placeholder="Enter Your OTP" >
      <span class="error" id="otpError"><?php echo $errors['otp'] ?? ''; ?></span>

      <button type="submit" name="submitOTP">Submit OTP</button>
      <a href="forgot_password.php">Different Email</a>

    </form>

    <form method="POST" onsubmit="return validatePassword(event)" id="resetPasswordForm" action="../controllers/forgotPasswordController.php">

      <input type="hidden" name="email" id="resetEmail">

      <input type="password" name="newPassword" placeholder="Enter Your New Password" >
      <span class="error" id="newPasswordError"><?php echo $errors['newPassword'] ?? ''; ?></span>

      <input type="password" name="confirmPassword" placeholder="Confirm Your New Password" >
      <span class="error" id="confirmPasswordError"><?php echo $errors['confirmPassword'] ?? ''; ?></span>

      <button type="submit" name="resetPassword">Reset Password</button>
      <span class="error" ><?php echo $errors['forgot_password'] ?? ''; ?></span>
      <a href="login.php">Remembered Password? Go back to Login</a>

    </form>


  </div>

  <script src="../assets/scripts/forgotPass.js"></script>
  
</body>
</html>
