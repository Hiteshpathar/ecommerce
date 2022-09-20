<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>user-management</title>

    <!-- Fontfaces CSS-->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="{{asset('css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{asset('vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{asset('vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    {{-- <link href="{{assets(vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css)}}" rel="stylesheet" media="all"> --}}
    <link href="{{asset('vendor/wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/slick/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{asset('css/theme.css')}}" rel="stylesheet" media="all">

</head>

<body class="animsition">
<div class="page-wrapper">
    <div class="page-content--bge15">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="#">
                            <img src="{{asset("images/icon/logo.png")}}" alt="CoolAdmin">
                        </a>
                    </div>
                    <div class="login-form">
                        <form action="{{route('store-user')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>First Name</label>
                                    <input class="au-input au-input--full" type="text" name="first_name"
                                           placeholder="First Name"><br>
                                    <span style="color: red">@error('first_name'){{$message}}@enderror</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Last Name</label>
                                    <input class="au-input au-input--full" type="text" name="last_name"
                                           placeholder="Last Name"><br>
                                    <span style="color: red">@error('last_name'){{$message}}@enderror</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input class="au-input au-input--full" type="email" name="email"
                                       placeholder="Email"><br>
                                <span style="color: red">@error('email'){{$message}}@enderror</span>
                            </div>
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input class="au-input au-input--full" type="number" name="mobile"
                                       placeholder="Mobile Number"><br>
                                <span style="color: red">@error('email'){{$message}}@enderror</span>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password"
                                           placeholder="Password"><br>
                                    <span style="color: red">@error('password'){{$message}}@enderror</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Confirm Password</label>
                                    <input class="au-input au-input--full" type="password" name="confirm_password"
                                           placeholder="Confirm Password"><br>
                                    <span style="color: red">@error('password'){{$message}}@enderror</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address Line 1</label>
                                <input class="au-input au-input--full" type="text" name="address1"
                                       placeholder="Address Line 1"><br>
                                <span style="color: red">@error('address1'){{$message}}@enderror</span>
                            </div>
                            <div class="form-group">
                                <label>Address Line 2</label>
                                <input class="au-input au-input--full" type="text" name="address2"
                                       placeholder="Address Line 2"><br>
                                <span style="color: red">@error('address2'){{$message}}@enderror</span>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>City</label>
                                    <input class="au-input au-input--full" type="text" name="city"
                                           placeholder="City"><br>
                                    <span style="color: red">@error('city'){{$message}}@enderror</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Postal Code</label>
                                    <input class="au-input au-input--full" type="number" name="postal_code"
                                           placeholder="Postal Code"><br>
                                    <span style="color: red">@error('postal_code'){{$message}}@enderror</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Profile Image</label>
                                <input type="file" name="image"><br>
                                <span style="color: red">@error('image'){{$message}}@enderror</span>
                            </div>
                            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" name="submit">
                                add
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Jquery JS-->
<script src="{{asset('vendor/jquery-3.2.1.min.js')}}"></script>
<!-- Bootstrap JS-->
<script src="{{asset('vendor/bootstrap-4.1/popper.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
<!-- Vendor JS       -->
<script src="{{asset('vendor/slick/slick.min.js')}}">
</script>
<script src="{{asset('vendor/wow/wow.min.js')}}"></script>
<script src="{{asset('vendor/animsition/animsition.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}">
</script>
<script src="{{asset('vendor/counter-up/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('vendor/counter-up/jquery.counterup.min.js')}}">
</script>
<script src="{{asset('vendor/circle-progress/circle-progress.min.js')}}"></script>
<script src="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('vendor/chartjs/Chart.bundle.min.js')}}"></script>
<script src="{{asset('vendor/select2/select2.min.js')}}">
</script>

<!-- Main JS-->
<script src="{{asset('js/main.js')}}"></script>

</body>

</html>
<!-- end document-->
