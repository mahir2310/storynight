<?php


if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Story Night - Register</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body style="background-color:blue">
  <div class="container">
    <h1>StoryNight</h1>
    <h2>Register</h2>
    <form method="post">
      <input type="text" name="name" placeholder="Enter Full Name" required>
      <input type="email" name="email" placeholder="Enter Email" required>
      <input type="password" name="password" placeholder="Enter Password" required>
      <input type="password"  name="confirmPassword" placeholder= "re-enter password" required>
      
      <select  id="mahirDropdown" name="role" > 
        <option value="">Select a role</option>
        <option value="customer">Customer</option>
        <option value="manager">Movie Manager</option>
        <option value="admin">Admin</option>
      </select><br>
      <button type="submit" name="register">Register</button>
    </form>
    <a href="loginn.php">Already have an account? Login</a>
  </div>
</body>
</html>
