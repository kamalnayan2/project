<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Society Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;800&display=swap');

    * {
      font-family: 'Poppins', sans-serif;
    }

    .nav-link {
      display: flex;
      align-items: center;
      /* Center align items vertically */
    }

    ul li:hover a {
      color: #fff;
      background-color: #8000ff;
    }
  </style>
</head>

<body>
  <nav class="navbar bg-body-black fixed-top navbar-light" style="background-color: #3c944180;">
    <div class="container-fluid">
      <h5>
        <a class="navbar-brand" href="dashboard.php">
          Society Management System
        </a>
      </h5>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header" style="background-color: #3c944180;">
          <h4 class="offcanvas-title" id="offcanvasNavbarLabel">Society</h4>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" style="background-color: #3c944180;">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="profile.php"><span class="material-icons">person </span> Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="request.php"><span class="material-icons">build </span> Maintenance Requests</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="pay/index.php"><span class="material-icons">payment</span> Pay Maintenance</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="pay/history.php"><span class="material-icons">history</span> Payment History</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../complain/submit_complaint.php"><span class="material-icons">comment</span> Complaints</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="logout.php"><span class="material-icons">logout</span> LogOut</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</body>

</html>