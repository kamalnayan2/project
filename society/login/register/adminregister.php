<?php
$host = "localhost";
$dbname = "society";
$user = "postgres";
$password = "kamal";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
if (!$conn) {
  die("Error in connection: " . pg_last_error());
}

$showAlert = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["fname"];
  $uname = $_POST['uname'];
  $email = $_POST["email"];
  $phone = $_POST["pno"];
  $address = $_POST["gender"];
  $password = $_POST["pass"];
  $cpassword = $_POST["cpass"];

  // Check if passwords match
  if ($password == $cpassword) {
      // Check if username or email already exists
      $checkQuery = "SELECT * FROM admine WHERE username = '$uname' OR email = '$email'";
      $result = pg_query($conn, $checkQuery);
      
      if (pg_num_rows($result) > 0) {
          $showError = "Username or email already exists.";
      } else {
          // Hash the password
          $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
          
          // Prepare the insert statement
          $sql = "INSERT INTO admine (username, password, address, mobileno, name, email) VALUES ('$uname', '$hashedPassword', '$address', '$phone', '$name', '$email')";
          $result = pg_query($conn, $sql);
          
          if ($result) {
              $showAlert = true;
          } else {
              $showError = "Error in registration: " . pg_last_error($conn);
          }
      }
  } else {
      $showError = "Passwords do not match.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
  body {
    display: block;
  }
</style>
  </head>
<body>
<?php
if($showAlert)
{

  echo '<div class="alert alert-success" role="alert">
   <h4 class="alert-heading">Well done!</h4>
  <p> you have successfully register .</p>
  </div>';
}
?>
    <div class="container">
      <!-- Title section -->
      <div class="title">Registration</div>
      <div class="content">
        <!-- Registration form -->
        <form action="adminregister.php" method="post">
          <div class="user-details">
            <!-- Input for Full Name -->
            <div class="input-box">
              <span class="details">Full Name</span>
              <input type="text" placeholder="Enter your full name" required name="fname">
             </div>
          <!-- Input for Username -->
          <div class="input-box">
            <span class="details">Username</span>
            <input type="text" placeholder="Enter your username" required name="uname">
          </div>
          <!-- Input for Email -->
          <div class="input-box">
            <span class="details">Email</span>
            <input type="text" placeholder="Enter your email" required name="email">
          </div>
            <!-- Input for Phone Number -->
            <div class="input-box">
              <span class="details">Phone Number</span>
              <input type="text" placeholder="Enter your number" required name="pno">
            </div>
            <!-- Input for Password -->
            <div class="input-box">
              <span class="details">Password</span>
              <input type="text" placeholder="Enter your password" required name="pass">
            </div>
            <!-- Input for Confirm Password -->
            <div class="input-box">
              <span class="details">Confirm Password</span>
              <input type="text" placeholder="Confirm your password" required name="cpass">
            </div>
          </div>
          <div class="gender-details">
            <!-- Radio buttons for gender selection -->
            <input type="radio" name="gender" id="dot-1" value="male">
            <input type="radio" name="gender" id="dot-2" value="female">
            <input type="radio" name="gender" id="dot-3"value="non">
            <span class="gender-title">Gender</span>
            <div class="category">
              <!-- Label for Male -->
              <label for="dot-1">
                <span class="dot one"></span>
                <span class="gender">Male</span>
              </label>
              <!-- Label for Female -->
              <label for="dot-2">
                <span class="dot two"></span>
                <span class="gender">Female</span>
              </label>
              <!-- Label for Prefer not to say -->
              <label for="dot-3">
                <span class="dot three"></span>
                <span class="gender">Prefer not to say</span>
              </label>
            </div>
          </div>
          <!-- Submit button -->
          <div class="button">
            <input type="submit" value="Register">
          </div>
        </form>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>