<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <section class="container">
        <div class="login-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <h1 class="opacity">USER LOGIN</h1>
                <form action="../member/user.php" method="get">
                    <input type="text" placeholder="MOBILE NUMBER" name="mob" />
                    <input type="password" placeholder="PASSWORD" name="pass"/>
                    <button class="opacity">SUBMIT</button>
                </form>
                <div class="register-forget opacity">
                    <a href="register/register.html">REGISTER</a>
                    <a href="">FORGOT PASSWORD</a>
                </div>
            </div>
            <div class="circle circle-two"></div>
        </div>
        
        <div class="theme-btn-container"></div>
    </section>
    <script src="login.js"></script>
</body>
</html>