<?php
$name = $email = $password = $confirm = $role = "";
$nameErr = $emailErr = $passwordErr = $confirmErr = $roleErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $_POST["name"])) {
        $nameErr = "Only letters and spaces allowed";
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }


    if (empty($_POST["password"])) {
        $passwordErr = "*Password is required";
    } elseif (strlen($_POST["password"]) < 8) {
        $passwordErr = "Password must be at least 8 characters";
    } else {
        $password = $_POST["password"];
    }


    if (empty($_POST["confirmPassword"])) {
        $confirmErr = "Please confirm password";
    } elseif ($_POST["confirmPassword"] !== $_POST["password"]) {
        $confirmErr = "Passwords do not match";
    }

    
    if (empty($_POST["role"])) {
        $roleErr = "Please select a role";
    } else {
        $role = $_POST["role"];
    }
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
    <form method="post" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <input type="text" name="name" placeholder="Enter Full Name" value="<?php echo $name; ?>">
      <span class="error"><?php echo $nameErr; ?></span>
      <input type="email" name="email" placeholder="Enter Email"value="<?php echo $email; ?>" >
      <span class="error"><?php echo $emailErr; ?></span>
      <input type="password" name="password" placeholder="Enter Password" >
      <span class="error"><?php echo $passwordErr; ?></span>
      <input type="password"  name="confirmPassword" placeholder= "re-enter password">
      <span class="error"><?php echo $confirmErr; ?></span>
      
      <select  id="mahirDropdown" name="role" > 
        <option value="">Select a role</option>
        <option value="customer" <?php if($role=="customer") echo "selected";?>>Customer</option>
        <option value="manager" <?php if($role=="manager") echo "selected";?>>Movie Manager</option>
        <option value="admin" <?php if($role=="admin") echo "selected";?>>Admin</option>
      </select><br>
      <span class="error"><?php echo $roleErr; ?></span>
      <button type="submit" name="register">Register</button>
    </form>
    <a href="loginn.php">Already have an account? Login</a>
  </div>
</body>
</html>
