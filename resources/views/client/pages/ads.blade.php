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
    </head>
    <body>
        <div class="container">
            <div class="row">
                {{-- @if ($rand % 2 == 0) --}}
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <a target="_blank" href="{{route('client.detail', ['cate' => $post->category->slug, 'sub' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id])}}">
                            <img src='{{ asset("upload/thumbnails/$post->image") }}' width="100%">
                        </a>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <p style="text-align: right; margin-bottom: 0px; font-size: 12px">QC</p>
                        <h3 style="margin: 0px 0px 10px 0px">
                            <a target="_blank" href="{{route('client.detail', ['cate' => $post->category->slug, 'sub' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id])}}">
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