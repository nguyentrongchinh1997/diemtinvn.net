<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
       
        
          <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137275219-10"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'UA-137275219-10');
        </script>

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
            @media all and (max-width: 426px) {
                .ads-post-item {
                    width: 50% !important;
                }
            }

            .title{
                font-size: 16px; 
                margin-top: 15px; 
                height: 65px;
                overflow: hidden;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h4 style="padding-left: 15px; padding-right: 15px">
                        Tin hot <span style="float: right; font-weight: normal; font-size: 12px; margin-top: 10px">
                            <a target="_blank" href="{{route('client.home')}}" style="color: #c90000">diembao24h.net</a></span>
                </h4>
                @foreach ($postList as $post)
                    <div class="ads-post-item col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <a target="_blank" href="{{route('client.detail', ['cate' => $post->category->slug, 'sub' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id, 'soure' => 'ads'])}}">
                            <img src='{{ asset("$server/thumbnails/$post->image") }}' style="height: 100px; width: 100%; object-fit: cover;">
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