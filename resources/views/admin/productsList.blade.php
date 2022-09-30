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
    <title>Product Management</title>

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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
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
                    <a class="logo" href="/">
                        <img src="images/icon/logo.png" alt="CoolAdmin"/>
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
                        <form class="form-header" action="" method="get">
                            <input class="au-input au-input--xl" type="text" name="search"
                                   placeholder="Search for datas &amp; reports..."/>
                            <button class="au-btn--submit" type="submit" name="searching">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                        </form>
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
                                            isset($_GET['status'])?$status=$_GET['status']:$status='all'
                                        @endphp
                                        <form method="get">
                                            <div class="table-data__tool-left">
                                                <div class="rs-select2--light rs-select2--md">
                                                    <select class="js-select2" name="status"
                                                            onchange="this.form.submit()">
                                                        <option value="" {{ $status =='all' ? 'selected' : ''  }}>
                                                            All Products
                                                        </option>
                                                        <option value="1"{{ $status ==1 ? 'selected' : ''  }} >
                                                            Active
                                                        </option>
                                                        <option value="0" {{ $status ==0 ? 'selected' : ''  }} >
                                                            Inactive
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
                                    <a href="{{route('add-product')}}" class="btn btn-success">add Product</a>
                                </div>
                            </div>
                            @if(count($products) == 0)
                                <h2>No data found</h2>
                            @else
                                <div class="table-responsive table-responsive-data2">
                                    <table class="table table-data2">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Inventory</th>
                                            <th>Type</th>
                                            <th>Discount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $product)
                                            <tr class="tr-shadow" id="sid{{$product->id}}">
                                                @php
                                                    $image=explode(',',$product->images);
                                                @endphp
                                                <td>
                                                <a href="#">
                                                    <img src="{{asset('photos/'.$image[0])}}" height="70" width="70"/>
                                                </a>
                                                </td>
                                                <td>{{$product->title}}</td>
                                                <td>
                                                    @if ($product->is_active == 1)
                                                        <span class="status--process">Active</span>
                                                    @else
                                                        <span class="status--denied">InActive</span>
                                                    @endif
                                                </td>
                                                <td>{{$product->inventory?$product->inventory.' in stock':'Inventory not tracked'}}</td>
                                                <td>{{$product->category->name??''}}</td>
                                                <td>{{$product->discount[0]->discount_percent}} %</td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <a href="{{ route('edit-product',$product->id)}}"
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
                                                           onclick="deleteProduct({{$product->id}})">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <span>
                                    {{$products->links()}}
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

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
    function deleteProduct(id) {

        var url = "{{ route('delete-product', ":id") }}";
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
    }
    $(document).ready(function () {
        $('#table-data2').DataTable({
            order: [[3, 'desc']],
        });
    });
</script>
</body>

</html>
<!-- end document-->
