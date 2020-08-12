        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 footer-box">
                        <div class="about-inner">
                            <img src="{{asset('images/diembao24_logo.png')}}" style="border: 0px" class="img-responsive logo-footer" alt=""/>
                            <p class="intro-footer">Trang tin tức tổng hợp mới nhất 24h </p>
                            <br>
                        </div>
                    </div>
                    <div class="col-sm-3 footer-box">
                        <div class="twitter-inner">
                            <h3 class="wiget-title">Cơ quản chủ quản</h3>
                            <ul>
                                <li><i class="ti-location-arrow"></i> Công ty cổ phần VSNews, Địa chỉ 458 Bạch Mai - Hai Bà Trưng Hà Nội. Chịu trách nhiệm nội dung: Trần Văn Dũng</li>
                                <li><i class="ti-mobile"></i> 0963 108 272</li>
                                <li><i class="ti-email"></i> contact@diembao24h.net</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2 footer-box">
                        <h3 class="wiget-title">Chuyên mục</h3>
                        <ul class="menu-services">
                            @foreach ($categoryShare as $categoryFooter)
                                <li>
                                    <a style="text-transform: capitalize;" href="{{ route('client.category', ['slug' => $categoryFooter->slug]) }}">{{ $categoryFooter->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4 footer-box">
                        <h3 class="wiget-title">Tin mới</h3>
                        <div class="footer-news-grid">
                            @php $dem = 0; @endphp
                            @foreach ($newPostsSidebar as $postFooter)
                                @if ($dem++ < 3)
                                    <div class="news-list-item">
                                        <div class="img-wrapper">
                                            <a href="{{ route('client.detail', ['cate' => $postFooter->category->slug, 'sub' => $postFooter->subCategory->slug, 'title' => $postFooter->slug, 'p' => $postFooter->id]) }}" class="thumb">
                                                <img src='{{asset("$server/thumbnails/$postFooter->image")}}' alt="{{ $postFooter->title }}" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="post-info-2">
                                            <h5>
                                                <a href="{{ route('client.detail', ['cate' => $postFooter->category->slug, 'sub' => $postFooter->subCategory->slug, 'title' => $postFooter->slug, 'p' => $postFooter->id]) }}" class="title">
                                                    {{ $postFooter->title }}
                                                </a>
                                            </h5>
                                            <ul class="authar-info">
                                                <li><i class="ti-timer"></i> {{getWeekday($postFooter->date)}}, {{ date('d/m/Y', strtotime($postFooter->date)) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="sub-footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div style="text-align: center" class="copy">Copyright@ {{date('Y')}} Diembao24h.net</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- *** END OF /. SUB FOOTER *** -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        

        <script src="{{ asset('assets/js/jquery.min.js') }}" type="text/javascript"></script>
        <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
        <script src="{{asset('slick/slick.js')}}" type="text/javascript" charset="utf-8"></script>
        <!-- jquery ui js -->
        <script src="{{ asset('assets/js/jquery-ui.min.js') }}" type="text/javascript"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <!-- Bootsnav js -->
        <script src="{{ asset('assets/bootsnav/js/bootsnav.js') }}" type="text/javascript"></script>
        <!-- theia sticky sidebar -->
        <script src="{{ asset('assets/js/theia-sticky-sidebar.js') }}" type="text/javascript"></script>
        <!-- youtube js -->
        <script src="{{ asset('assets/js/RYPP.js') }}" type="text/javascript"></script>
        <!-- owl include js plugin -->
        <script src="{{ asset('assets/owl-carousel/owl.carousel.min.js') }}" type="text/javascript"></script>
        <!-- custom js -->
        <script src="{{ asset('assets/js/custom.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/client/client.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/client/lazyload/jquery.lazy.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/client/lazyload/jquery.lazy.plugins.min.js') }}"></script>
        @yield('script')
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0&appId=2581255835435003&autoLogAppEvents=1"></script>
        <script type="text/javascript">
            $(function() {
                $('.lazy').Lazy();
            });
        </script>        
        <script type="text/javascript">
            $(document).on('ready', function() {
                $('.responsive').slick({
                  dots: true,
                  infinite: false,
                  speed: 300,
                  slidesToShow: 4,
                  slidesToScroll: 2,
                  responsive: [
                    {
                      breakpoint: 1024,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                      }
                    },
                    {
                      breakpoint: 600,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                      }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                      }
                    }
                  ]
                });
            });
        </script>
    </body>

<!-- Mirrored from inews.themepk.com/news/inews_v1.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 Mar 2020 23:49:57 GMT -->
</html>