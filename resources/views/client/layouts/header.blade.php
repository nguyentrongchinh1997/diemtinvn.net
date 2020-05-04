<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
        <meta content="@yield('image')" property="og:image"/>

        <base href="{{ asset('/') }}">
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/images/ico/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('assets/images/ico/apple-touch-icon-57-precomposed.png') }}">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{ asset('assets/images/ico/apple-touch-icon-72-precomposed.png') }}">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{ asset('assets/images/ico/apple-touch-icon-114-precomposed.png') }}">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{ asset('assets/images/ico/apple-touch-icon-144-precomposed.png') }}">

        <!-- jquery ui css -->
        <link href="{{ asset('assets/css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <!--Animate css-->
        <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Navigation css-->
        <link href="{{ asset('assets/bootsnav/css/bootsnav.css') }}" rel="stylesheet" type="text/css"/>
        <!-- youtube css -->
        <link href="{{ asset('assets/css/RYPP.css') }}" rel="stylesheet" type="text/css"/>
        <!-- font awesome -->
        <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
        <!-- themify-icons -->
        <link href="{{ asset('assets/themify-icons/themify-icons.css') }}" rel="stylesheet" type="text/css"/>
        <!-- weather-icons -->
        <link href="{{ asset('assets/weather-icons/css/weather-icons.min.css') }}" rel="stylesheet" type="text/css"/>
        <!-- flat icon -->
        <link href="{{ asset('assets/css/flaticon.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Important Owl stylesheet -->
        <link href="{{ asset('assets/owl-carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Default Theme -->
        <link href="{{ asset('assets/owl-carousel/owl.theme.css') }}" rel="stylesheet" type="text/css"/>
        <!-- owl transitions -->
        <link href="{{ asset('assets/owl-carousel/owl.transitions.css') }}" rel="stylesheet" type="text/css"/>
        <!-- style css -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/custome.css') }}" rel="stylesheet" type="text/css"/>
        <link href="//db.onlinewebfonts.com/c/ac6286065aab4824af64a06aa5467f04?family=Swiss+721" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <!-- PAGE LOADER -->
        <div class="se-pre-con"></div>
        <!-- *** START PAGE HEADER SECTION *** -->
        <header>
            <!-- START HEADER TOP SECTION -->
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                            <!-- Start header social -->
                            <div class="header-social">
                                <ul>
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-vk"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    <li class="hidden-xs"><a href="#"><i class="fa fa-youtube-play"></i></a></li>
                                    <li class="hidden-xs"><a href="#"><i class="fa fa-vimeo"></i></a></li>
                                </ul>
                            </div>
                            <!-- End of /. header social -->
                            <!-- Start top left menu -->
                            <div class="top-left-menu">
                                <ul>
                                    <li><a href="#">Liên hệ</a></li>
                                    <li><a href="#">Donation</a></li>
                                </ul>
                            </div>
                            <!-- End of /. top left menu -->
                        </div>
                        <!-- Start header top right menu -->
                        <div class="hidden-xs col-md-6 col-sm-6 col-lg-6">
                            <div class="header-right-menu">
                                <ul>
                                    <li> <a href="#"><i class="fa fa-lock"></i> Đăng Ký </a>or<a href="#">   Đăng Nhập</a></li>
                                </ul>
                            </div>
                        </div> <!-- end of /. header top right menu -->
                    </div> <!-- end of /. row -->
                </div> <!-- end of /. container -->
            </div>
            <!-- END OF /. HEADER TOP SECTION -->
            <!-- START MIDDLE SECTION -->
            <div class="header-mid hidden-xs">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="logo">
                                <a href="index.html"><img src="assets/images/logo.png" class="img-responsive" alt=""></a>

                            </div>
                        </div>
                        <div class="col-sm-8">
                            <a href="#"><img src="https://docbaothayban.com/wp-content/themes/thaytoidocbao/image/banner1.png" class="img-responsive" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END OF /. MIDDLE SECTION -->
            <!-- START NAVIGATION -->
            <nav class="navbar navbar-default navbar-sticky navbar-mobile bootsnav">
                <!-- Start Top Search -->
                <div class="top-search">
                    <div class="container">
                        <form method="GET" action="{{route('client.search')}}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <input type="text" name="key" class="form-control" placeholder="Nhập từ khóa tại đây...">
                                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Top Search -->
                <div class="container">            
                    <!-- Start Atribute Navigation -->
                    <div class="attr-nav">
                        <ul>
                            <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                        </ul>
                    </div>
                    <div class="navbar-header">
                        {{-- <button type="button" class="navbar-toggle"> --}}
                            <i class="ti-align-justify open-menu-mobile"></i>
                        {{-- </button> --}}
                        <a class="navbar-brand hidden-sm hidden-md hidden-lg" href="#brand"><img src="assets/images/logo.png" class="logo" alt=""></a>
                    </div>
                    
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <ul class="nav navbar-nav navbar-left" data-in="" data-out="">
                            <li class="dropdown home active-color">
                                <a href="{{ route('client.home') }}" style="padding-top: 3px"><i style="color: #fff; font-size: 17px" class="ti-home"></i></a>
                            </li>
                            @foreach ($firstCategoryShare as $category)
                                <li class="{{$category->slug}}{{$category->id}} dropdown" value="{{$category->id}}">
                                    <a class="dropdown-toggle dropdown-toggle-item" data-toggle="dropdown" href="{{ route('client.category', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
                                    <ul class="dropdown-menu">
                                        @foreach ($category->subCategory as $subCate)
                                            <li>
                                                <a href="{{ route('client.sub_cate', ['category' => $subCate->category->slug, 'sub_cate' => $subCate->slug]) }}">{{$subCate->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                            <li>
                                <a href="{{ route('client.video') }}">Video</a>
                            </li>
                            <li class="dropdown megamenu-fw">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Xem thêm</a>
                                <ul class="dropdown-menu megamenu-content" role="menu">
                                    <li>
                                        <div class="row">
                                            @foreach ($categoryShare as $category)
                                                <div class="col-menu col-md-3" style="margin-bottom: 25px">
                                                    <h6 class="title" style="text-transform: uppercase;">
                                                        <a style="color: #c90000" href="{{ route('client.category', ['slug' => $category->slug]) }}">
                                                            {{ $category->name }}
                                                        </a>
                                                    </h6>
                                                    <div class="content">
                                                        <ul class="menu-col">
                                                            @foreach ($category->subCategory as $subCategory)
                                                                <li>
                                                                    <a style="text-transform: capitalize;" href="{{ route('client.sub_cate', ['category' => $subCategory->category->slug, 'sub_cate' => $subCategory->slug]) }}">{{ $subCategory->name }}</a>    
                                                                </li>
                                                            @endforeach                                                    
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="menu-mobile-list">
                <ul>
                    <i class="ti-close close-menu"></i>
                    <li style="padding-left: 0px">
                        <img style="border: 0px" src="assets/images/logo.png" class="img-responsive">
                    </li>
                    <li>
                        <a href=""><i class="ti-home"></i> Trang chủ</a>
                    </li>
                    @foreach ($categoryShare as $category)
                        <li class="dropdown">
                            <a href="{{ route('client.category', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
                            <span>
                                <i class="ti-angle-down"></i>
                            </span>
                            <ul>
                                @foreach ($category->subCategory as $subCate)
                                    <li>
                                        <i class="ti-angle-right" style="padding-right: 5px; font-size: 10px"></i><a href="{{ route('client.sub_cate', ['category' => $subCate->category->slug, 'sub_cate' => $subCate->slug]) }}">{{$subCate->name}}</a>
                                        
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </header>
