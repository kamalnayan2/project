
<head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="../menu/menu.css">

    </head>
<body>
  
  <nav class="navbar bg-body-black fixed-top">
    <div class="container-fluid">
      Society Management System
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Society</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="../login/request.php"><i class="fa fa-building"></i>Maintenance Requests</a>
                </li>


                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#"><i class="fa fa-balance-scale"></i>Financial Records</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="..//razorpay/index.php"><i class="fa fa-paypal"></i>Pay Maintenance</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../admin/generate_bill.php"><i class="fa fa-paypal"></i>generate Maintenance</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="..//complain/complaint.php"><i class="fa fa-comment"></i>Complaints</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../login/logout.php"><i class="fa fa-sign-out"></i>LogOut</a>
                  </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
</body>