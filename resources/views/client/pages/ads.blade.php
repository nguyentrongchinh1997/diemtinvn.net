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

        <!-- Bootstrap -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <!--Animate css-->
        <!-- style css -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css"/>
        <style type="text/css">
            @media all and (max-width: 424px) {
                .title{
                    margin-bottom: 20px;
                }
            }

            .title{
                font-size: 16px; 
                margin-top: 15px; 
                height: 59px; 
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h3 style="padding-left: 15px; padding-right: 15px">
                        Tin tài trợ <span style="float: right; font-weight: normal; font-size: 12px; margin-top: 10px">
                            <a target="_blank" href="{{asset('')}}" style="color: #c90000">diemtin24h.net</a></span>
                </h3>
                @foreach ($postList as $post)
                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                        <a href="">
                            <img src='{{ asset("upload/thumbnails/$post->image") }}' style="height: 155px; width: 100%; object-fit: cover;">
                            <p class="title">
                                {{$post->title}}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
</html>