<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>User Management</title>

    <!-- Fontfaces CSS-->
    {{--    <link rel="stylesheet" href="{{asset('css/style.css')}}">--}}
    <link href="{{asset('css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{asset('vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{asset('vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet"
          media="all">
    <link href="{{asset('vendor/wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/slick/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{asset('css/theme.css')}}" rel="stylesheet" media="all">
    {{-- Toaster --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet"/>
    <style>
        .table-data2.table tbody tr td {
            vertical-align: baseline !important;
        }
    </style>
</head>

<body class="animsition">
<div>
    <!-- HEADER MOBILE-->
    <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a href="#">
                        <img src="{{asset("images/icon/logo.png")}}" alt="Cool Admin"/>
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">
                    <li class="{{ isset($users) ? 'active' : ''  }} has-sub">
                        <a class="js-arrow" href="{{route('users-list')}}">
                            <i class="fas fa-user"></i>Users</a>
                    </li>
                    <li class="{{ isset($products) ? 'active' : ''  }} has-sub">
                        <a class="js-arrow" href="{{route('products-list')}}">
                            <i class="fas fa-user"></i>Products</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- END HEADER MOBILE-->

    <!-- MENU SIDEBAR-->
    <aside class="menu-sidebar d-none d-lg-block">
        <div class="logo">
            <a href="#">
                <img src="{{asset("images/icon/logo.png")}}" alt="Cool Admin"/>
            </a>
        </div>
        <div class="menu-sidebar__content js-scrollbar1">
            <nav class="navbar-sidebar">
                <ul class="list-unstyled navbar__list">
                    <li class="{{ isset($users) ? 'active' : ''  }} has-sub">
                        <a class="js-arrow" href="{{route('users-list')}}">
                            <i class="fas fa-user"></i>Users</a>
                    </li>
                    <li class="{{ isset($products) ? 'active' : ''  }} has-sub">
                        <a class="js-arrow" href="{{route('products-list')}}">
                            <i class="fas fa-user"></i>Products</a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <!-- END MENU SIDEBAR-->

    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="header-wrap">
                        <form class="form-header" action="" method="get" id="search_form">
                            <input class="au-input au-input--xl" id="search" type="text" name="search" value=""
                                   placeholder="Search for datas &amp; reports..."/>
                            <button class="au-btn--submit" type="submit" name="searching">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                        </form>
                        <div class="header-button">
                            {{--                                <div class="noti-wrap">--}}
                            {{--                                    <div class="noti__item js-item-menu">--}}
                            {{--                                        <i class="zmdi zmdi-notifications"></i>--}}
                            {{--                                        <span class="quantity">{{$totalPendingRequests}}</span>--}}
                            {{--                                        <div class="notifi-dropdown js-dropdown">--}}
                            {{--                                            <div class="notifi__title">--}}

                            {{--                                                <p>You have {{$totalPendingRequests}} pending requests</p>--}}
                            {{--                                            </div>--}}
                            {{--                                            @foreach($students as $student)--}}
                            {{--                                                @if($student->is_approved == 0)--}}
                            {{--                                                    <div class="notifi__item">--}}
                            {{--                                                        <div class="bg-c1 img-cir img-40">--}}
                            {{--                                                            <a href="{{route('approve-student',[$student->id,$student->is_approved])}}"><i--}}
                            {{--                                                                    class="fa fa-check" aria-hidden="true"></i></a>--}}
                            {{--                                                        </div>--}}
                            {{--                                                        <div class="content">--}}
                            {{--                                                            {{$student->first_name.' '.$student->last_name}} wants to--}}
                            {{--                                                            login--}}
                            {{--                                                        </div>--}}
                            {{--                                                    </div>--}}
                            {{--                                                @endif--}}
                            {{--                                            @endforeach--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            <div class="account-wrap">
                                <div class="account-item clearfix js-item-menu">
                                    <div class="content">
                                        <a class="js-acc-btn" href="#">{{session('admin')->first_name}}</a>
                                    </div>
                                    <div class="account-dropdown js-dropdown">
                                        <div class="info clearfix">
                                            <div class="content">
                                                <h5 class="name">
                                                    <a href="#">{{session('admin')->first_name}}</a>
                                                </h5>
                                                <span class="email">{{session('admin')->email}}</span>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__body">
                                            <div class="account-dropdown__item">
                                                <a href="{{ route('edit-admin-profile',session('admin')) }}">
                                                    <i class="zmdi zmdi-account"></i>Account</a>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__body">
                                            <div class="account-dropdown__item">
                                                <a href="{{route('reset-admin-password')}}">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Reset
                                                    Password</a>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__footer">
                                            <a href="{{route('admin-logout')}}">
                                                <i class="zmdi zmdi-power"></i>Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class=" card-header login-logo">
                                    <a href="#">
                                        <img src="{{asset('images/icon/logo.png')}}" alt="CoolAdmin">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="login-form">

                                        <form action="{{route('store-product')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-lg-6">
                                                    <label>Title</label>
                                                    <input class="au-input au-input--full" type="text" name="titile"
                                                           placeholder="Short sleeve t-shirt"><br>
                                                    <span style="color: red">@error('title'){{$message}}@enderror</span>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label>Price</label>
                                                    <input class="au-input au-input--full" type="text" name="price"
                                                           placeholder="₹ 0.00"><br>
                                                    <span style="color: red">@error('price'){{$message}}@enderror</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Descritpion</label>
                                                <textarea class="form-control" rows="3"
                                                          placeholder="Product Details"></textarea>
                                                <span
                                                    style="color: red">@error('description'){{$message}}@enderror</span>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-4">
                                                    <label>Quantity</label>
                                                    <input class="au-input au-input--full" type="number" name="quantity"
                                                           value="0"><br>
                                                    <span
                                                        style="color: red">@error('quantity'){{$message}}@enderror</span>
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <label for="sel1">Status</label>
                                                    <select class="form-control" id="sel1">
                                                        <option>Active</option>
                                                        <option>Draft</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <label for="sel1">Type</label>
                                                    <select class="form-control" id="sel1">
                                                        @foreach($categories as $category)
                                                            <option>{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Media</label>
                                                <input type="file" name="image" class="form-control" multiple><br>
                                                <span style="color: red">@error('image'){{$message}}@enderror</span>
                                            </div>
                                            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit"
                                                    name="submit">
                                                SAVE
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
{{-- Toaster --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>

<script>
    $(document).ready(function () {
        toastr.options.timeOut = 2500;
        @if (Session::has('error'))
        toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
        toastr.success('{{ Session::get('success') }}');
        @endif
    });
</script>
<script type="text/javascript">
    function deleteUser(id) {
        var url = "{{ route('delete-user', ":id") }}";
        url = url.replace(':id', id);
        // if(confirm('Do you really want to delete this record?')){
        $.ajax({
            url: url,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                '_method': 'DELETE'
            },
            success: function (response) {
                toastr.success(response.success)
                $('#sid' + id).remove();
            }
        })
        // }
    }
</script>
</body>

</html>
<!-- end document-->
