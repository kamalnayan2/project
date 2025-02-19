<?php
include "../partials/db_connect.php";

$showAlert = false;
$showError = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["fn"];
  $flatno = $_POST["rno"];
  $area=$_POST["rty"];
  $phone = $_POST["pno"];
  $gender = $_POST["gender"];
  $password = $_POST["pass"];
  $cpassword = $_POST["cpass"];


  // Check if passwords match
  if ($password == $cpassword) {
    // Check if username or email already exists
    $checkQuery = "SELECT * FROM member WHERE flatno = '$flatno'";
    $result = pg_query($conn, $checkQuery);

    if (pg_num_rows($result) > 0) {
      $showError = "Username or flatno already exists.";
    } else {
      $sql = "INSERT INTO member (name, flatno, mobileno, password,area) VALUES ('$name','$flatno','$phone','$password','$area')";
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
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body {
      display: block;
    }
  </style>
</head>

<body>
  <?php
  if ($showAlert) {
    echo '<div class="alert alert-success" role="alert">
   <h4 class="alert-heading">Well done!</h4>
  <p> you have successfully register .</p>
  </div>';
  } elseif ($showError) {
    echo '<div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">' . $showError . '</h4>
  </div>';
  }
  ?>

  <div class="container">
    <!-- Title section -->
    <div class="title">Member Registration</div>
    <div class="content">
      <!-- Registration form -->
      <form action="add.php" method="post">
        <div class="user-details">
          <!-- Input for First Name -->
          <div class="input-box">
            <span class="details">Name</span>
            <input type="text" placeholder="Enter your first name" name='fn' required>
          </div>
          <!-- Input for Roomno -->
          <div class="input-box">
            <span class="details">Room No</span>
            <input type="text" placeholder="Enter your name" name='rno' required>
          </div>
          <!-- Input for Room Type -->
          <div class="input-box">
            <span class="details">Flat Type</span>
            <select class="form-select form-select-lg mb-1" aria-label="select Room type" name="rty">
              <option selected>Select Flat Type</option>
              <option value="760">1BHK</option>
              <option value="1070">2BHK</option>
              <option value="1300">3BHK</option>
            </select>

          </div>
          <!-- Input for Phone Number -->
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="text" placeholder="Enter your number" name="pno" required>
          </div>
          <!-- Input for Password -->
          <div class="input-box">
            <span class="details">Password</span>
            <input type="text" placeholder="Enter your password" name="pass" required>
          </div>
          <!-- Input for Confirm Password -->
          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="text" placeholder="Confirm your password" name="cpass" required>
          </div>
        </div>
        <div class="gender-details">
          <!-- Radio buttons for gender selection -->
          <input type="radio" name="gender" id="dot-1" value="Male">
          <input type="radio" name="gender" id="dot-2" value="Female">
          <input type="radio" name="gender" id="dot-3" value="non">
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