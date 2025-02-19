<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
    integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="../menu/menu.css">
  <style>
    .nav-link {
      display: flex;
      align-items: center; /* Center align items vertically */
    }
    .nav-link .material-icons {
      margin-right: 8px; /* Space between icon and text */
    }
  </style>
</head>

<body>
  <nav class="navbar bg-body-black fixed-top navbar-light" style="background-color:#3c944180;color: #092c0a;">
    <div class="container-fluid">
      <h5>
        <a class="navbar-brand" href="index.html">
          Society Management System
        </a>
      </h5>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header" style="background-color:#3c944180">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Society</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" style="background-color:#3c944180">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../login/request.php"><span class="material-icons">build</span> Maintenance Requests</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../financial.php"><span class="material-icons">account_balance</span> Financial Records</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../razorpay/index.php"><span class="material-icons">payment</span> Pay Maintenance</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../razorpay/history.php"><span class="material-icons">history</span> Payment History</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../admin/generate_bill.php"><span class="material-icons">receipt</span> Generate Maintenance</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../complain/complaint.php"><span class="material-icons">comment</span> Complaints</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../login/logout.php"><span class="material-icons">logout</span> LogOut</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav><br><br><br>
</body>