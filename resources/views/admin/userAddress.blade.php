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
                    <li class="has-sub">
                        <a class="js-arrow" href="">
                            <i class="fas fa-home"></i>Home</a>
                    </li>
                    <li class="{{ isset($orders) ? 'active' : ''  }} has-sub">
                        <a class="js-arrow" href="{{route('orders-list')}}">
                            <i class="fas fa-cart-plus"></i>Orders</a>
                    </li>
                    <li class="{{ isset($users) ? 'active' : ''  }} has-sub">
                        <a class="js-arrow" href="{{route('users-list')}}">
                            <i class="fas fa-user"></i>Users</a>
                    </li>
                    <li class="{{ isset($products) ? 'active' : ''  }} has-sub">
                        <a class="js-arrow" href="{{route('products-list')}}">
                            <i class="fas fa-shopping-bag"></i>Products</a>
                    </li>
                    <li class="{{ isset($collections) ? 'active' : ''  }} has-sub">
                        <a class="js-arrow" href="{{route('collections-list')}}">
                            <i class="fas fa-shopping-bag"></i>Collections</a>
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
                    <li class="has-sub">
                        <a class="js-arrow" href="{{'dashboard'}}">
                            <i class="fas fa-home"></i>Home</a>
                    </li>
                    <li class="{{ isset($orders) ? 'active' : ''  }} has-sub">
                        <a class="js-arrow" href="{{route('orders-list')}}">
                            <i class="fas fa-cart-plus"></i>Orders</a>
                    </li>
                    <li class="{{ isset($users) ? 'active' : ''  }} has-sub">
                        <a class="js-arrow" href="{{route('users-list')}}">
                            <i class="fas fa-user"></i>Users</a>
                    </li>
                    <li class="{{ isset($products) ? 'active' : ''  }} has-sub">
                        <a class="js-arrow" href="{{route('products-list')}}">
                            <i class="fas fa-shopping-bag"></i>Products</a>
                    </li>
                    <li class="{{ isset($collections) ? 'active' : ''  }} has-sub">
                        <a class="js-arrow" href="{{route('collections-list')}}">
                            <i class="fas fa-shopping-bag"></i>Collections</a>
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
                        @php
                            isset($_GET['search'])?$search=$_GET['search']:$search=''
                        @endphp
                        <form class="form-header" action="" method="get" id="search_form">
                            <input class="au-input au-input--xl" id="search" type="text" name="search"
                                   value="{{$search}}"
                                   placeholder="Search for First Name, Last Name &amp; Email..."/>
                            <button class="au-btn--submit" type="submit">
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
                                            <div class="image">
                                                <img src="" alt="Admin"/>
                                            </div>
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
        {{--        END DELETE CONFIRMATION MODAL--}}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        {{--        END DELETE CONFIRMATION MODAL--}}

        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">

                            <a href="{{route('add-user')}}" class="btn btn-success">Add New Address</a>

                            @if(count($address) == 0)
                                <h2>No data found</h2>
                            @else
                                @foreach($address as $user_address)
                                        <div class="card col-lg-8">
                                            <div class="card-body">
                                                <h5 class="card-title">{{$user_address->first_name.' '.$user_address->last_name}}</h5>
                                                <p class="card-text">Here is your address</p>
                                            </div>
                                        </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
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
    }
</script>
</body>

</html>
<!-- end document-->
