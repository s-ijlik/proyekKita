
<!DOCTYPE html>
<html>
<head>
    <title>LOGIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Shadow Login Form template Responsive, Login form web template,Flat Pricing tables,Flat Drop downs  Sign up Web Templates, Flat Web Templates, Login sign up Responsive web template, SmartPhone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- Custom Theme files -->
    <link href="css/style2.css" rel="stylesheet" type="text/css" media="all" />
    <!-- //Custom Theme files -->
    <!-- web font -->
    <link href="//fonts.googleapis.com/css?family=Cormorant+Garamond:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Arsenal:400,400i,700,700i" rel="stylesheet">
    <!-- //web font -->
</head>
<body>
<!-- main -->
<div class="main-agileinfo slider ">
    <div class="items-group">
        <div class="item agileits-w3layouts">
            <div class="block text main-agileits">
                <span class="circleLight"></span>
                <!-- login form -->
                <div class="login-form loginw3-agile">
                    <div class="agile-row">
                        <h1> Login </h1>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="login-agileits-top">
                            <form action="{{ url('/login') }}" method="post">
                                <p>User Name </p>
                                <input type="text" class="name" name="email" required=""/>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <p>Password</p>
                                <input type="password" class="password" name="password" required=""/>
                                <label class="anim">
                                    <input type="checkbox" class="checkbox" name="remember">
                                    <span> Remember me ?</span>
                                </label>
                                <input type="submit" value="Login">
                            </form>
                        </div>
                        <div class="login-agileits-bottom wthree">
                            <h6><a href="#">Forgot password?</a></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w3lsfooteragileits">
                <!-- <p> &copy; 2017 Shadow Login Form. All Rights Reserved | Design by <a href="http://w3layouts.com" target="=_blank">W3layouts</a></p> -->
            </div>
        </div>
    </div>
</div>
<!-- //main -->
</body>
</html>