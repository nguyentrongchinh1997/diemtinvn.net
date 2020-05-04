<!-- *** START FOOTER *** -->
        <footer>
            <div class="container">
                <div class="row">
                    <!-- START FOOTER BOX (About) -->
                    <div class="col-sm-3 footer-box">
                        {{-- <h3 class="wiget-title">Giới thiệu</h3> --}}
                        <div class="about-inner">
                            <img src="assets/images/logo.png" class="img-responsive" alt=""/>
                            <p>Website tổng hợp tin tức từ nhiều trang báo uy tín, cập nhật tin tức mới nhất </p>
                            
                            <br>
                        </div>
                    </div>
                    <!--  END OF /. FOOTER BOX (About) -->
                    <!-- START FOOTER BOX (Twitter feeds) -->
                    <div class="col-sm-3 footer-box">
                        <div class="twitter-inner">
                            <h3 class="wiget-title">Liên hệ</h3>
                            <ul>
                                <li><i class="ti-location-arrow"></i> Hai Bà Trưng, HN</li>
                                <li><i class="ti-mobile"></i> 0963 108 272</li>
                                <li><i class="ti-email"></i> contact@safedownload.net</li>
                            </ul>
                        </div>
                    </div>
                    <!-- END OF /. FOOTER BOX (Twitter feeds) -->
                    <!-- START FOOTER BOX (Category) -->
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
                    <!-- END OF /. FOOTER BOX (Category) -->
                    <!-- START FOOTER BOX (Recent Post) -->
                    <div class="col-sm-4 footer-box">
                        <h3 class="wiget-title">Bài viết mới</h3>
                        <div class="footer-news-grid">
                            @php $dem = 0; @endphp
                            @foreach ($newPostsSidebar as $postFooter)
                                @if ($dem++ < 3)
                                <div class="news-list-item">
                                    <div class="img-wrapper">
                                        <a href="{{ route('client.detail', ['title' => $postFooter->slug, 'p' => $postFooter->id]) }}" class="thumb">
                                            <img src='{{asset("upload/thumbnails/$postFooter->image")}}' alt="{{ $postFooter->title }}" class="img-responsive">
                                        </a>
                                    </div>
                                    <div class="post-info-2">
                                        <h5>
                                            <a href="{{ route('client.detail', ['title' => $postFooter->slug, 'p' => $postFooter->id]) }}" class="title">
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
                    <!-- END OF /. FOOTER BOX (Recent Post) -->
                </div>
            </div>
        </footer>
        <!-- *** END OF /. FOOTER *** -->
        <!-- *** START SUB FOOTER *** -->
        <div class="sub-footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5 col-md-5">
                        <div class="copy">Copyright@2017 I-News Inc.</div>
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-7">
                        <ul class="footer-nav">
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Donation</a></li>
                            <li><a href="#">F.A.Q</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- *** END OF /. SUB FOOTER *** -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('assets/js/jquery.min.js') }}" type="text/javascript"></script>
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
    </body>

<!-- Mirrored from inews.themepk.com/news/inews_v1.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 Mar 2020 23:49:57 GMT -->
</html>