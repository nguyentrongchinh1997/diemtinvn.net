<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
        <meta content="@yield('image')" property="og:image"/>

        <base href="{{ asset('/') }}">
        @yield('json')
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="{{asset('images/diembao24_short_cut.png')}}" type="image/x-icon">
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
        <div class="container">
            <div class="row">
                {{-- @if ($rand % 2 == 0) --}}
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <img src='{{ asset("upload/thumbnails/$post->image") }}' width="100%">
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <p style="text-align: right; margin-bottom: 0px; font-size: 12px">QC</p>
                        <h3 style="margin: 0px 0px 10px 0px">
                            <a href="">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="hidden-xs" style="height: 40px; overflow: hidden;">
                            {!! $post->summury !!}
                        </p>
                    </div>
                {{-- @else
                @endif --}}
            </div>
        </div>
    </body>
</html>