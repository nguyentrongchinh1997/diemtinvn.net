@extends('client.layouts.index')

@section('title', 'Diembao24h.net - Trang Web tổng hợp tin tức mới nhất 24h | Đọc báo Online')
@section('description', 'Cập nhật tin tức, sự kiện mới nhất 24h qua. Tin nhanh Việt Nam và Thế giới. Đọc báo mới Online, tin tức trong ngày mới nhất. Thông tin Kinh tế, Thể thao, Văn hóa, Giải trí, Công nghệ')
@section('keywords', 'báo mới, tin mới, tin hot, báo điện tử, tin nhanh, tin nóng, tin tức, điểm tin, điểm báo')

@section('content')
<main class="page_main_wrapper">
    <div class="container">
        <div class="row row-m" style="margin-top: 20px">
             <div class="col-sm-2 col-p main-content hidden-xs" style="background-color:#EBEBEB;">
                 <br>
                 <h3 class="title-sidebar">Chuyên mục</h3>
                                <div class="panel_body">
                                    <ul style="padding-left: 0px; list-style-type: none;">
                                        @foreach ($subCates as $cate)
                                            <li>
                                                <a href="{{ route('client.sub_cate', ['category' => $cate->category->slug, 'sub-cate' => $cate->slug]) }}">
                                                    {{ $cate->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
           </div>
            <div class="col-sm-6 col-p main-content">
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
                                        <div class="row" style="margin: 0px">
                                            <div class="col-xs-5 col-sm-4 col-md-4 col-lg-4 news-list-item-left">
                                                <a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="thumb">
                                                    <img data-src="{{ asset("upload/thumbnails/$post->image") }}" alt="{{ $post->title }}" class="lazy img-responsive">
                                                </a>
                                            </div>
                                            <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8 news-list-item-right">
                                                <h4 title="{{ $post->title }}"><a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="title">{{ $post->title }}</a></h4>
                                                <ul class="authar-info">
                                                    <li><i class="ti-timer"></i> {{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
                                                </ul>
                                                <p class="description hidden-sm" style="margin-bottom: 10px">{{ $post->summury }}</p>
                                                <p style="margin-bottom: 0px; color: #adb5bd">
                                                    <a class="sub-category" href="{{ route('client.sub_cate', ['category' => $post->subCategory->category->slug, 'sub_cate' => $post->subCategory->slug]) }}">{{ $post->subCategory->name }}</a>
                                                     | 
                                                     <a class="soure" href="{{ route('client.news_soure', ['web' => urlencode($post->web)]) }}">{{ $post->web }}</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div> <!-- /. post body -->
                        </div>
                            <!-- END OF /. POST CATEGORY STYLE FOUR (Latest articles ) -->
                        
                    </div>
                
                {{-- <div class="row" style="margin-bottom: 20px">
                    <div class="col-sm-12">
                        <div class="loop news-slide">
                            @foreach ($postRightSlide as $post)
                                <div class="item">
                                    <div class="featured-post">
                                        <a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="news-image">
                                            <img title="{{$post->title}}" src='{{asset("upload/og_images/$post->image")}}' alt="{{$post->title}}" class="img-responsive">
                                        </a>
                                        <h4>
                                            <a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}">
                                                {{ $post->title }}
                                            </a>
                                        </h4>
                                        <p>
                                            <a class="sub-category" href="{{ route('client.sub_cate', ['cate' => $post->category->slug, 'sub_cate' => $post->subCategory->slug]) }}">{{ $post->subCategory->name }}</a>
                                        </p>
                                        <p>
                                            <a class="soure" href="{{ route('client.news_soure', ['web' => $post->web]) }}">{{ $post->web }}</a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div> --}}
                
               
            </div>
            <!-- END OF /. MAIN CONTENT -->
            <!-- START SIDE CONTENT -->
            <div class="col-sm-4 col-p rightSidebar hidden-xs">
                  <div style="padding:20px; background-color:#FAFAFA; margin-bottom:20px">
			        <center>Độc giả cùng làm báo. Nếu bạn đam mê báo chí và muốn chia sẻ tin tức cập nhật tới mọi người
			        <br><br>
			        <a href="mailto:contact@diembao24h.net" class="btn btn-danger">Gửi Bài</a>
			        </center>
			    </div>
			    
                <div class="theiaStickySidebar">
                    @include('client.includes.weather')
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
                </div>
            </div>
            <!-- END OF /. SIDE CONTENT -->
        </div>
    </div>
    
    </main>
        <!-- *** END OF /. PAGE MAIN CONTENT *** -->
@endsection