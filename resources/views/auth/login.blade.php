<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ADSHOUSE</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/font-awesome.css" type="text/css">
    <link rel="stylesheet" href="assets/css/aos.css" type="text/css">
    <link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">

</head>

<body class="login-style">

    <div id="wrapper-login">
        <div class="container">
            <div id="login" style="margin-top:15.5em; float: right;">



                <div style="padding-top:55px">
                    <label style="color:red">{{session('status')}}</label>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">

                        {{ csrf_field() }}

                        <span class="fa fa-user fa-2" style="height: 40px;font-size:16px;"></span>
                        <input type="text" id="email" style="height: 40px;font-size:14px;" name="email" style="" placeholder="Email">

                        <span class="fa fa-lock fa-2" style="height: 40px;font-size:16px;"></span>
                        <input type="password" id="password" style="height: 40px;font-size:14px;" name="password" style="font-size:12px;" placeholder="Password">

                        <div class="submit">
                            <input type="submit" style="height: 35px;font-size:14px;" value="login" class="submit">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-login">
        <div class="container text-center">
            <p><i class="fa fa-copyright"></i> Copyright 2019 - All right Reserved</p>
        </div>
    </footer>

    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/js/aos.js"></script>
</body>
</html>
