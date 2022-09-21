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
                        <a class="js-arrow" href="{{route('users-list')}}">
                            <i class="fas fa-user"></i>Users</a>
                    </li>
                    <li class="active has-sub">
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
                    <li class="active has-sub">
                        <a class="js-arrow" href="{{route('users-list')}}">
                            <i class="fas fa-user"></i>Users</a>
                    </li>
                    <li class="active has-sub">
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
                            <input class="au-input au-input--xl" id="search" type="text" name="search"
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
                        <div class="col-md-12">
                            <!-- DATA TABLE -->
                            <div class="table-data__tool">
                                <div class="table-data__tool-left">
                                    <div class="rs-select2--light rs-select2--sm">
                                        @php
                                            $page = null;
                                            if(isset($_GET['status']))
                                                $page = $_GET['status'];
                                        @endphp
                                        <form method="get">
                                            <div class="table-data__tool-left">
                                                <div class="rs-select2--light rs-select2--md">
                                                    <select class="js-select2" name="status"
                                                            onchange="this.form.submit()">
                                                        <option value="" selected>All Users
                                                        </option>
                                                        <option value="1"@if ($page == "Active")
                                                            <?php echo " selected"; ?>
                                                            @endif >Active
                                                        </option>
                                                        <option value="0" @if ($page == "Inactive")
                                                            <?php echo "selected"; ?>
                                                            @endif >Inactive
                                                        </option>
                                                    </select>
                                                    <div class="dropDownSelect2"></div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                                <div class="table-data__tool-right">
                                    <a href="{{route('add-user')}}" class="btn btn-success">add User</a>
                                </div>
                            </div>
                            @if(count($users) == 0)
                                <h2>No data found</h2>
                            @else
                                <div class="table-responsive table-responsive-data2">
                                    <table class="table table-data2">
                                        <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr class="tr-shadow" id="sid{{$user->id}}">
                                                <td>{{$user->first_name}}</td>
                                                <td>{{$user->last_name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>
                                                    @if ($user->is_active == 1)
                                                        <a href="{{route('approve-user',[$user->id,$user->is_active])}}"
                                                           class="btn btn-sm btn-success">Active</a>
                                                    @else
                                                        <a href="{{route('approve-user',[$user->id,$user->is_active])}}"
                                                           class="btn btn-sm btn-danger"> Inactive</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <a href="{{ route('send-mail',$user->id)}}"
                                                           class="item"
                                                           data-toggle="tooltip" data-placement="top" title="Send Mail">
                                                            <i class="zmdi zmdi-email"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <a href="{{ route('edit-user',$user->id)}}"
                                                           class="item"
                                                           data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <a href="javascript:void(0)" class="item" data-toggle="tooltip"
                                                           data-placement="top"
                                                           onclick="deleteUser({{$user->id}})">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <span>
                                    {{$users->links()}}
                                </span>
                                </div>
                                <!-- END DATA TABLE -->
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
