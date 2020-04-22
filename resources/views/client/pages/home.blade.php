@extends('client.layouts.index')

@section('title', 'Tổng hợp tin tức trong ngày nhanh nhất')

@section('content')
<main class="page_main_wrapper">
    {{-- <section class="slider-inner" style="margin-top: 20px">
        <div class="container">
            <div class="row thm-margin"> --}}
                {{-- <div class="col-xs-12 col-sm-8 col-md-8 thm-padding">
                    <div class="slider-wrapper">
                        <div id="owl-slider" class="owl-carousel owl-theme">
                            @foreach ($postSlideHome as $post)
                                <div class="item">
                                    <div class="slider-post post-height-1">
                                        <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="news-image"><img src='{{ asset("upload/og_images/$post->image") }}' alt="{{$post->title}}" class="img-responsive"></a>
                                        <div class="post-text">
                                            <span class="post-category hidden-xs">{{ $post->subCategory->name }}</span>
                                            <h2 title="{{ $post->title }}">
                                                <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}">{{ $post->title }}</a>
                                            </h2>
                                            <ul class="authar-info">
                                                <li class="date">{{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-xs-12 col-sm-4 col-md-4 thm-padding">
                    <div class="row slider-right-post thm-margin">
                        @foreach ($postRightSlide as $post)
                            <div class="col-xs-6 col-sm-12 col-md-12 thm-padding">
                                <div class="slider-post post-height-2">
                                    <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="news-image"><img src='{{ asset("upload/og_images/$post->image") }}' alt="{{ $post->title }}" class="img-responsive"></a>
                                    <div class="post-text">
                                        <span class="post-category hidden-xs">{{ $post->subCategory->name }}</span>
                                        <h2 style="font-size: 18px" title="{{ $post->title }}">
                                            <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}">{{ $post->title }}</a>
                                        </h2>
                                        <ul class="authar-info">
                                            <li class="date">{{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> --}}
            {{-- </div>
        </div>
    </section> --}}
    <div class="container">
        <div class="row row-m" style="margin-top: 20px">
            <div class="col-sm-8 col-p main-content">
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-md-7">
                        <img width="100%" alt="{{$postSlideHome->title}}" src='{{asset("upload/og_images/$postSlideHome->image")}}'>
                    </div>
                    <div class="col-md-5">
                        <h2 style="margin-top: 0px; line-height: 20px">
                            <a href="{{ route('client.detail', ['category' => $postSlideHome->subCategory->slug, 'title' => $postSlideHome->slug, 'id' => $postSlideHome->id]) }}" style="font-size: 20px">
                                {{ $postSlideHome->title }}
                            </a>
                        </h2>
                        <p style="color: #777">
                            {{ $postSlideHome->summury }} 
                        </p>
                        <p style="color: #777">
                            {{ getWeekday($postSlideHome->date) }}, {{ date('d/m/Y H:i', strtotime($postSlideHome->date)) }} GMT+7
                        </p>
                        <p>
                            <a href="{{ route('client.sub_cate', ['cate' => $postSlideHome->category->slug, 'sub_cate' => $postSlideHome->subCategory->slug]) }}"><strong style="text-transform: capitalize; color: #4f4f4f">{{ $postSlideHome->subCategory->name }}</strong></a> | <a href="{{ route('client.news_soure', ['web' => $postSlideHome->web]) }}" style="color: #777">{{ $postSlideHome->web }}</a>
                        </p>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-sm-12">
                        <div class="featured-inner" style="padding: 0px">
                            <div id="featured-owl" class="owl-carousel">
                                @foreach ($postRightSlide as $post)
                                    <div class="item">
                                        <div class="featured-post">
                                            <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="news-image">
                                                <img title="{{$post->title}}" src='{{asset("upload/og_images/$post->image")}}' alt="{{$post->title}}" class="img-responsive" style="height: 100px; object-fit: cover; width: 100%">
                                            </a>
                                            <h4>
                                                <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}">
                                                    {{ $post->title }}
                                                </a>
                                            </h4>
                                            <p>
                                                <a style="text-transform: capitalize; color: #727272" href="{{ route('client.sub_cate', ['cate' => $post->category->slug, 'sub_cate' => $post->subCategory->slug]) }}"><strong>{{ $post->subCategory->name }}</strong></a> | 
                                                <a style="color: #777" href="{{ route('client.news_soure', ['web' => $post->web]) }}">{{ $post->web }}</a>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row" style="margin-bottom: 20px">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <a href="">
                            <img width="100%" src="http://localhost/news/public/upload/og_images/uefa-quyet-hoan-tat-champions-league-mua-giai-nay.jpg">
                            Cách hết chức vụ trong Đảng đối với Phó Chủ tịch HĐND huyện Hớn Quản, Bình Phước
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <a href="">
                            <img width="100%" src="http://localhost/news/public/upload/og_images/uefa-quyet-hoan-tat-champions-league-mua-giai-nay.jpg">
                            Cách hết chức vụ trong Đảng đối với Phó Chủ tịch HĐND huyện Hớn Quản, Bình Phước
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <a href="">
                            <img width="100%" src="http://localhost/news/public/upload/og_images/uefa-quyet-hoan-tat-champions-league-mua-giai-nay.jpg">
                            Cách hết chức vụ trong Đảng đối với Phó Chủ tịch HĐND huyện Hớn Quản, Bình Phước
                        </a>
                    </div>
                </div> --}}
                <div>
                    <div class="post-inner">
                        <div class="post-head" style="padding-left: 0px">
                            <h1 class="title"><strong>Xã Hội</strong></h1>
                            <div class="filter-nav">
                                <ul>
                                    @foreach ($subCateXaHoi as $subCate)
                                        <li>
                                            <a href="{{ route('client.sub_cate', ['category' => $subCate->category->slug, 'sub' => $subCate->slug]) }}" >{{ $subCate->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- post body -->
                        <div class="post-body" style="padding: 15px 15px 15px 0px">
                            <div id="post-slider" class="owl-carousel owl-theme">
                                <!-- item one -->
                                <div class="item">
                                    <div class="row">
                                        <div class="col-sm-6 main-post-inner">
                                            <article>
                                                <figure>
                                                    <a href="{{ route('client.detail', ['category' => $firstPostXaHoi->subCategory->slug, 'title' => $firstPostXaHoi->slug, 'id' => $firstPostXaHoi->id]) }}"><img src='{{ asset("upload/thumbnails/$firstPostXaHoi->image") }}' alt="{{ $firstPostXaHoi->title }}' height="242" width="345" alt="" class="img-responsive"></a>
                                                </figure>
                                                <div class="post-info">
                                                    <h3 title="{{ $firstPostXaHoi->title }}">
                                                        <a href="{{ route('client.detail', ['category' => $firstPostXaHoi->subCategory->slug, 'title' => $firstPostXaHoi->slug, 'id' => $firstPostXaHoi->id]) }}">{{ $firstPostXaHoi->title }}</a>
                                                    </h3>
                                                    <ul class="authar-info">
                                                        <li><i class="ti-timer"></i> {{ getWeekday($firstPostXaHoi->date) }}, {{ date('H:i d/m/Y', strtotime($firstPostXaHoi->date)) }}</li>
                                                    </ul>
                                                    <p>{{ $firstPostXaHoi->summury }}</p>
                                                    <p style="margin-bottom: 0px; color: #adb5bd">
                                                        <a style="font-weight: bold; color: #adb5bd; text-transform: capitalize;" href="{{ route('client.sub_cate', ['category' => $firstPostXaHoi->subCategory->category->slug, 'sub_cate' => $firstPostXaHoi->subCategory->slug]) }}">{{ $firstPostXaHoi->subCategory->name }}</a> | 
                                                        <a class="web" href="{{ route('client.news_soure', ['web' => urldecode($firstPostXaHoi->web)]) }}">{{ $firstPostXaHoi->web }}</a>
                                                    </p>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="col-sm-6 border-left">
                                            <div class="news-list">
                                                @foreach ($listPostXaHoi as $post)
                                                    <div class="news-list-item">
                                                        <div class="img-wrapper">
                                                            <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="thumb">
                                                                <img src='{{ asset("upload/og_images/$post->image") }}' alt="{{ $post->title }}' alt="{{ $post->title }}" class="img-responsive">
                                                            </a>
                                                        </div>
                                                        <div class="post-info-2">
                                                            <h5 title="{{ $post->title }}">
                                                                <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="title">{{ $post->title }}</a>
                                                            </h5>
                                                            <ul class="authar-info">
                                                                <li><i class="ti-timer"></i> {{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
                                                            </ul>
                                                            <p style="margin-bottom: 0px; color: #adb5bd; font-size: 13px">
                                                                <a class="web" href="{{ route('client.news_soure', ['web' => urldecode($post->web)]) }}">{{ $post->web }}</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END OF /. POST CATEGORY STYLE ONE (Popular news) -->
                    <!-- START ADVERTISEMENT -->
                    <div class="add-inner" style="padding-left: 0px">
                        <img src="https://docbaothayban.com/wp-content/themes/thaytoidocbao/image/banner1.png" class="img-responsive" alt="">
                    </div>
                    <!-- END OF /. ADVERTISEMENT -->
                    <!-- START POST CATEGORY STYLE TWO (Travel news) -->
                    <div class="post-inner post-inner-2">
                        <!--post header-->
                        <div class="post-head" style="padding-left: 0px">
                            <h2 class="title"><strong>Đời Sống</strong></h2>
                            <div class="filter-nav">
                                <ul>
                                    @foreach ($subCateDoiSong as $subCate)
                                        <li>
                                            <a href="{{ route('client.sub_cate', ['category' => $subCate->category->slug, 'sub' => $subCate->slug]) }}" >{{ $subCate->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- post body -->
                        <div class="post-body">
                            <div id="post-slider-2" class="owl-carousel owl-theme">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-sm-6 main-post-inner">
                                            <article>
                                                <figure>
                                                    <a href="{{ route('client.detail', ['category' => $firstPostDoiSong->subCategory->slug, 'title' => $firstPostDoiSong->slug, 'id' => $firstPostDoiSong->id]) }}"><img src='{{ asset("upload/og_images/$firstPostDoiSong->image") }}' alt="{{ $firstPostDoiSong->title }}' height="242" width="345" alt="" class="img-responsive"></a>
                                                </figure>
                                                <div class="post-info">
                                                    <h3 title="{{ $firstPostDoiSong->title }}">
                                                        <a href="{{ route('client.detail', ['category' => $firstPostDoiSong->subCategory->slug, 'title' => $firstPostDoiSong->slug, 'id' => $firstPostDoiSong->id]) }}">{{ $firstPostDoiSong->title }}</a>
                                                    </h3>
                                                    <ul class="authar-info">
                                                        <li><i class="ti-timer"></i> {{ getWeekday($firstPostDoiSong->date) }}, {{ date('H:i d/m/Y', strtotime($firstPostDoiSong->date)) }}</li>
                                                    </ul>
                                                    <p>{{ $firstPostDoiSong->summury }}</p>
                                                    <p style="margin-bottom: 0px; color: #adb5bd">
                                                        <a style="font-weight: bold; color: #adb5bd; text-transform: capitalize;" href="{{ route('client.sub_cate', ['category' => $firstPostDoiSong->subCategory->category->slug, 'sub_cate' => $firstPostDoiSong->subCategory->slug]) }}">{{ $firstPostDoiSong->subCategory->name }}</a> | 
                                                        <a class="web" href="{{ route('client.news_soure', ['web' => $firstPostDoiSong->web]) }}">{{ $firstPostDoiSong->web }}</a>
                                                    </p>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="col-sm-6 border-left">
                                            <div class="news-list">
                                                @foreach ($listPostDoiSong as $post)
                                                    <div class="news-list-item">
                                                        <div class="img-wrapper">
                                                            <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="thumb">
                                                                <img src='{{ asset("upload/og_images/$post->image") }}' alt="{{ $post->title }}' alt="{{ $post->title }}" class="img-responsive">
                                                            </a>
                                                        </div>
                                                        <div class="post-info-2">
                                                            <h5 title="{{ $post->title }}">
                                                                <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="title">{{ $post->title }}</a>
                                                            </h5>
                                                            <ul class="authar-info">
                                                                <li><i class="ti-timer"></i> {{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
                                                            </ul>
                                                            <p style="margin-bottom: 0px; color: #adb5bd; font-size: 13px">
                                                                <a class="web" href="{{ route('client.news_soure', ['web' => urldecode($post->web)]) }}">{{ $post->web }}</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  END OF /. POST CATEGORY STYLE TWO (Travel news) -->
                </div>
            </div>
            <!-- END OF /. MAIN CONTENT -->
            <!-- START SIDE CONTENT -->
            <div class="col-sm-4 col-p rightSidebar">
                <div class="theiaStickySidebar">
                    <!-- START WEATHER -->
                    @include('client.includes.weather')
                    <!-- END OF /. WEATHER -->
                    <!-- START SOCIAL ICON -->
                    <div class="social-media-inner">
                        <table class="sidebar-oil">
                            <tr style="background: #2c3442">
                                <td style="color: #fff; text-align: center;" colspan="3">Giá bán lẻ xăng dầu</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; color: #c90000">
                                    Sản phẩm
                                </td>
                                <td style="font-weight: bold; color: #c90000">Vùng 1</td>
                                <td style="font-weight: bold; color: #c90000">Vùng 2</td>
                            </tr>
                            @foreach ($oils as $oil)
                            <tr>
                                <td>{{ $oil->oil_name }}</td>
                                <td>
                                    {{ $oil->price_1 }}
                                </td>
                                <td>{{ $oil->price_2 }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td style="text-align: right;" colspan="3">
                                    Chi tiết xem <a href="https://tygiahomnay.net/gia-xang-dau/petrolimex" target="_blank" style="font-weight: bold; color: #c90000">tại đây</a>
                                </td>
                            </tr>
                        </table> 
                    </div>
                    <br><br>
                    <div class="social-media-inner">
                        <table class="sidebar-oil">
                            <tr style="background: #2c3442">
                                <td style="color: #fff; text-align: center;" colspan="4">Giá vàng hôm nay</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; color: #c90000">
                                    Loại vàng
                                </td>
                                <td style="font-weight: bold; color: #c90000">Mua vào</td>
                                <td style="font-weight: bold; color: #c90000">Bán ra</td>
                            </tr>
                            @foreach ($golds as $gold)
                            <tr>
                                <td>{{ $gold->type }}</td>
                                <td>
                                    {{ $gold->buy }}
                                </td>
                                <td>{{ $gold->sell }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td style="text-align: right;" colspan="4">
                                    Chi tiết xem <a href="https://tygiahomnay.net/gia-xang-dau/petrolimex" target="_blank" style="font-weight: bold; color: #c90000">tại đây</a>
                                </td>
                            </tr>
                        </table> 
                    </div>
                    <!-- END OF /. SOCIAL ICON -->
                    <!-- START ADVERTISEMENT -->
                    <div class="add-inner">
                        <img src="assets/images/add320x270-1.jpg" class="img-responsive" alt="">
                    </div>
                    <!-- END OF /. ADVERTISEMENT -->
                </div>
            </div>
            <!-- END OF /. SIDE CONTENT -->
        </div>
    </div>
    <!-- START FEATURED NEWS -->
{{--     <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="featured-inner">
                    <div id="featured-owl" class="owl-carousel">
                        <div class="item">
                            <div class="featured-post">
                                <a href="#" class="news-image"><img src="assets/images/featured-620x370-1.jpg" alt="" class="img-responsive"></a>
                                <div class="reatting">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="post-text">
                                    <span class="post-category">Business</span>
                                    <h4>Lorem Ipsum is simply dummy text of the printing </h4>
                                    <ul class="authar-info">
                                        <li><i class="ti-timer"></i> May 15, 2016</li>
                                        <li class="like"><a href="#"><i class="ti-thumb-up"></i>15 likes</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="featured-post">
                                <a href="#" class="news-image"><img src="assets/images/featured-620x370-2.jpg" alt="" class="img-responsive"></a>
                                <div class="reatting">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="post-text">
                                    <span class="post-category">Business</span>
                                    <h4>Lorem Ipsum is simply dummy text of the printing </h4>
                                    <ul class="authar-info">
                                        <li><i class="ti-timer"></i> May 15, 2016</li>
                                        <li class="like"><a href="#"><i class="ti-thumb-up"></i>15 likes</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="featured-post">
                                <a href="#" class="news-image"><img src="assets/images/featured-620x370-3.jpg" alt="" class="img-responsive"></a>
                                <div class="reatting">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="post-text">
                                    <span class="post-category">Business</span>
                                    <h4>Lorem Ipsum is simply dummy text of the printing </h4>
                                    <ul class="authar-info">
                                        <li><i class="ti-timer"></i> May 15, 2016</li>
                                        <li class="like"><a href="#"><i class="ti-thumb-up"></i>15 likes</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="featured-post">
                                <a href="#" class="news-image"><img src="assets/images/featured-620x370-4.jpg" alt="" class="img-responsive"></a>
                                <div class="reatting">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="post-text">
                                    <span class="post-category">Business</span>
                                    <h4>Lorem Ipsum is simply dummy text of the printing </h4>
                                    <ul class="authar-info">
                                        <li><i class="ti-timer"></i> May 15, 2016</li>
                                        <li class="like"><a href="#"><i class="ti-thumb-up"></i>15 likes</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="featured-post">
                                <a href="#" class="news-image"><img src="assets/images/featured-620x370-5.jpg" alt="" class="img-responsive"></a>
                                <div class="reatting">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="post-text">
                                    <span class="post-category">Business</span>
                                    <h4>Lorem Ipsum is simply dummy text of the printing </h4>
                                    <ul class="authar-info">
                                        <li><i class="ti-timer"></i> May 15, 2016</li>
                                        <li class="like"><a href="#"><i class="ti-thumb-up"></i>15 likes</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container">
        <div class="add-inner" style="padding-left: 0px">
        <img src="https://docbaothayban.com/wp-content/themes/thaytoidocbao/image/banner_antivirut.png" class="img-responsive" alt="">
    </div>
    </div>
    
    <!-- END OF /. FEATURED NEWS -->
    <!-- START YOUTUBE VIDEO -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="youtube-wrapper">
                    <div class="playlist-title">
                        <h4>Video mới nhất</h4>
                    </div>
                    <div class="RYPP r16-9"  data-ids="cIyVNoY3_L4,PQEX8QQ1fWg,3WWlhPmqXQI,kssD4L2NBw0,YcwrRA2BIlw,HMpmI2F2cMs,intentionally_erroneus">
                        <div class="RYPP-video">
                            <div class="RYPP-video-player">
                                <iframe width="100%" height="315" src="https://www.youtube.com/embed/{{ $video->code }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="RYPP-playlist" style="background: #fff">
                            <header style="cursor: pointer;">
                                <h4 style="margin-top: 0px">
                                    <a style="color: #111" href="{{ route('client.video.detail', ['slug' => $video->slug, 'id' => $video->id]) }}">
                                        {{ $video->title }}
                                    </a>
                                </h4>
                                <p>
                                    {{ $video->description }}
                                </p>
                                <p class="date" style="color: #777">
                                    {{ getWeekday($video->created_at) }}, {{date('d/m/Y', strtotime($video->created_at))}}
                                </p>
                                <p>
                                    <a href="{{ route('client.video') }}">
                                        <button class="btn btn-success">Xem thêm</button>
                                    </a>
                                </p>
                            </header>
                            {{-- <div class="RYPP-items"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF /. YOUTUBE VIDEO -->
    <div class="container">
        <div class="row row-m">
            <!-- START MAIN CONTENT -->
            <div class="col-sm-8 col-p main-content">
                <div class="theiaStickySidebar">
                    <!-- START POST CATEGORY STYLE ONE (Popular news) -->
                    <div class="post-inner">
                        <!--post header-->
                        <div class="post-head" style="padding-left: 0px">
                            <h1 class="title"><strong>Kinh Tế</strong></h1>
                            <div class="filter-nav">
                                <ul>
                                    @foreach ($subCateKinhTe as $subCate)
                                        <li>
                                            <a href="{{ route('client.sub_cate', ['category' => $subCate->category->slug, 'sub' => $subCate->slug]) }}" >{{ $subCate->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- post body -->
                        <div class="post-body" style="padding: 15px 15px 15px 0px">
                            <div id="post-slider">
                                <!-- item one -->
                                <div class="item">
                                    <div class="row">
                                        <div class="col-sm-6 main-post-inner">
                                            <article>
                                                <figure>
                                                    <a href="{{ route('client.detail', ['category' => $fistPostKinhTe->subCategory->slug, 'title' => $fistPostKinhTe->slug, 'id' => $fistPostKinhTe->id]) }}">
                                                        <img src='{{ asset("upload/og_images/$fistPostKinhTe->image") }}' alt="{{ $fistPostKinhTe->title }}' height="242" width="345" alt="" class="img-responsive"></a>
                                                </figure>
                                                <div class="post-info">
                                                    <h3 title="{{ $fistPostKinhTe->title }}">
                                                        <a href="{{ route('client.detail', ['category' => $fistPostKinhTe->subCategory->slug, 'title' => $fistPostKinhTe->slug, 'id' => $fistPostKinhTe->id]) }}">{{ $fistPostKinhTe->title }}</a></h3>
                                                    <ul class="authar-info">
                                                        <li><i class="ti-timer"></i> {{ getWeekday($fistPostKinhTe->date) }}, {{ date('H:i d/m/Y', strtotime($fistPostKinhTe->date)) }}</li>
                                                    </ul>
                                                    <p>{{ $fistPostKinhTe->summury }}</p>
                                                    <p style="margin-bottom: 0px; color: #adb5bd">
                                                        <a style="font-weight: bold; color: #adb5bd; text-transform: capitalize;" href="{{ route('client.sub_cate', ['category' => $fistPostKinhTe->subCategory->category->slug, 'sub_cate' => $fistPostKinhTe->subCategory->slug]) }}">{{ $fistPostKinhTe->subCategory->name }}</a> | 
                                                        <a class="web" href="{{ route('client.news_soure', ['web' => $fistPostKinhTe->web]) }}">{{ $fistPostKinhTe->web }}</a>
                                                    </p>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="col-sm-6 border-left">
                                            <div class="news-list">
                                                @foreach ($listPostXaHoi as $post)
                                                    <div class="news-list-item">
                                                        <div class="img-wrapper">
                                                            <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="thumb">
                                                                <img src='{{ asset("upload/og_images/$post->image") }}' alt="{{ $post->title }}' alt="{{ $post->title }}" class="img-responsive">
                                                            </a>
                                                        </div>
                                                        <div class="post-info-2">
                                                            <h5 title="{{ $post->title }}">
                                                                <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="title">{{ $post->title }}</a>
                                                            </h5>
                                                            <ul class="authar-info">
                                                                <li><i class="ti-timer"></i> {{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
                                                            </ul>
                                                            <p style="margin-bottom: 0px; color: #adb5bd; font-size: 13px">
                                                                <a class="web" href="{{ route('client.news_soure', ['web' => urlencode($post->web)]) }}">{{ $post->web }}</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END OF /. POST CATEGORY STYLE ONE (Popular news) -->
                    <!-- START ADVERTISEMENT -->
                    <div class="add-inner" style="padding-left: 0px">
                        <img src="https://docbaothayban.com/wp-content/themes/thaytoidocbao/image/banner1.png" class="img-responsive" alt="">
                    </div>
                    <!-- END OF /. ADVERTISEMENT -->
                    <!-- START POST CATEGORY STYLE TWO (Travel news) -->
                    <div class="post-inner post-inner-2">
                        <!--post header-->
                        <div class="post-head" style="padding-left: 0px">
                            <h2 class="title"><strong>Giáo Dục</strong></h2>
                            <div class="filter-nav">
                                <ul>
                                    @foreach ($subCateGiaoDuc as $subCate)
                                        <li>
                                            <a href="{{ route('client.sub_cate', ['category' => $subCate->category->slug, 'sub' => $subCate->slug]) }}" >{{ $subCate->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- post body -->
                        <div class="post-body">
                            <div id="post-slider-2">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-sm-6 main-post-inner">
                                            <article>
                                                <figure>
                                                    <a href="{{ route('client.detail', ['category' => $firstPostGiaoDuc->subCategory->slug, 'title' => $firstPostGiaoDuc->slug, 'id' => $firstPostGiaoDuc->id]) }}"><img src='{{ asset("upload/og_images/$firstPostGiaoDuc->image") }}' alt="{{ $firstPostGiaoDuc->title }}' height="242" width="345" alt="" class="img-responsive"></a>
                                                </figure>
                                                <div class="post-info">
                                                    <h3 title="{{ $firstPostGiaoDuc->title }}">
                                                        <a href="{{ route('client.detail', ['category' => $firstPostGiaoDuc->subCategory->slug, 'title' => $firstPostGiaoDuc->slug, 'id' => $firstPostGiaoDuc->id]) }}">{{ $firstPostGiaoDuc->title }}</a>
                                                    </h3>
                                                    <ul class="authar-info">
                                                        <li><i class="ti-timer"></i> {{ getWeekday($firstPostGiaoDuc->date) }}, {{ date('H:i d/m/Y', strtotime($firstPostGiaoDuc->date)) }}</li>
                                                    </ul>
                                                    <p>{{ $firstPostGiaoDuc->summury }}</p>
                                                    <p style="margin-bottom: 0px; color: #adb5bd">
                                                        <a style="font-weight: bold; color: #adb5bd; text-transform: capitalize;" href="{{ route('client.sub_cate', ['category' => $firstPostGiaoDuc->subCategory->category->slug, 'sub_cate' => $firstPostGiaoDuc->subCategory->slug]) }}">{{ $firstPostGiaoDuc->subCategory->name }}</a> | 
                                                        <a class="web" href="{{ route('client.news_soure', ['web' => $firstPostGiaoDuc->web]) }}">{{ $firstPostGiaoDuc->web }}</a>
                                                    </p>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="col-sm-6 border-left">
                                            <div class="news-list">
                                                @foreach ($listPostGiaoDuc as $post)
                                                    <div class="news-list-item">
                                                        <div class="img-wrapper">
                                                            <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="thumb">
                                                                <img src='{{ asset("upload/og_images/$post->image") }}' alt="{{ $post->title }}' alt="{{ $post->title }}" class="img-responsive">
                                                            </a>
                                                        </div>
                                                        <div class="post-info-2">
                                                            <h5 title="{{ $post->title }}">
                                                                <a href="{{ route('client.detail', ['category' => $firstPostGiaoDuc->subCategory->slug, 'title' => $firstPostGiaoDuc->slug, 'id' => $firstPostGiaoDuc->id]) }}" class="title">{{ $post->title }}</a>
                                                            </h5>
                                                            <ul class="authar-info">
                                                                <li><i class="ti-timer"></i> {{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
                                                            </ul>
                                                            <p style="margin-bottom: 0px; color: #adb5bd; font-size: 13px">
                                                                <a class="web" href="{{ route('client.news_soure', ['web' => urlencode($post->web)]) }}">{{ $post->web }}</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  END OF /. POST CATEGORY STYLE TWO (Travel news) -->
                </div>
            </div>
            <!-- END OF /. MAIN CONTENT -->
            <!-- START SIDE CONTENT -->
            <div class="col-sm-4 col-p sidebar">
                @include('client.includes.best_view')
            </div>
            <!-- END OF /. SIDE CONTENT -->
        </div>
    </div>
    <section class="articles-wrapper">
        <div class="container">
            <div class="row row-m">
                <div class="col-sm-8 main-content col-p">
                    <div class="theiaStickySidebar">
                        <!-- START POST CATEGORY STYLE FOUR (Latest articles ) -->
                        <div class="post-inner">
                            <!--post header-->
                            <div class="post-head">
                                <h2 class="title"><strong>Tin tức</strong> mới nhất</h2>
                            </div>
                            <!-- post body -->
                            <div class="post-body post-list-category">
                                @foreach ($postLatest as $post)
                                    <div class="news-list-item articles-list">
                                        <div class="img-wrapper">
                                            <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="thumb">
                                                <img data-src="{{ asset("upload/og_images/$post->image") }}" alt="{{ $post->title }}" class="lazy img-responsive">
                                            </a>
                                        </div>
                                        <div class="post-info-2">
                                            <h4 title="{{ $post->title }}"><a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="title">{{ $post->title }}</a></h4>
                                            <ul class="authar-info">
                                                <li><i class="ti-timer"></i> {{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
                                            </ul>
                                            <p class="description hidden-sm" style="margin-bottom: 10px">{{ $post->summury }}</p>
                                            <p style="margin-bottom: 0px; color: #adb5bd">
                                                <a style="font-weight: bold; color: #adb5bd; text-transform: capitalize;" href="{{ route('client.sub_cate', ['category' => $post->subCategory->category->slug, 'sub_cate' => $post->subCategory->slug]) }}">{{ $post->subCategory->name }}</a> | <a href="{{ route('client.news_soure', ['web' => urlencode($post->web)]) }}">{{ $post->web }}</a>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div> <!-- /. post body -->
                        </div>
                            <!-- END OF /. POST CATEGORY STYLE FOUR (Latest articles ) -->
                        </div>
                    </div>
                    <div class="col-sm-4 col-p">
                        <div class="theiaStickySidebar">
                            <!-- END OF /. POLL WIDGET -->
                            <!-- START TAGS -->
                            <div class="panel_inner">
                                <div class="panel_header">
                                    <h4><strong>Chuyên mục </strong></h4>
                                </div>
                                <div class="panel_body">
                                    <div class="tags-inner">
                                        @foreach ($subCates as $cate)
                                            <a style="text-transform: capitalize; margin-bottom: 10px; margin-right: 10px" href="{{ route('client.sub_cate', ['category' => $cate->category->slug, 'subCategory' => $cate->slug]) }}" class="ui tag">{{ $cate->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- END OF /. TAGS -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
        <!-- *** END OF /. PAGE MAIN CONTENT *** -->
@endsection