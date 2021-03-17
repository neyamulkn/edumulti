<section class="footer-area section-bg-2 padding-top-100px padding-bottom-40px">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 column-td-half">
                <div class="footer-widget">
                    <a href="index.html">
                        <img src="{{ asset('upload/images/logo/'.Config::get('siteSetting.logo') )}}" alt="footer logo" class="footer__logo">
                    </a>
                    <p>{{Config::get('siteSetting.footer')}}</p>
                    <ul class="list-items footer-address">
                        <li><a href="tel:>{{Config::get('siteSetting.phone')}}">>{{Config::get('siteSetting.phone')}}</a></li>
                        <li><a href="mailto:{{Config::get('siteSetting.email')}}" class="mail">{{Config::get('siteSetting.email')}}</a></li>
                        <li>{{Config::get('siteSetting.address')}}</li>
                    </ul>
                    <h3 class="widget-title font-size-17 mt-4">We are on</h3>
                    @php
                      if(!Session::has('socialLists')){
                          Session::put('socialLists', App\Models\Social::where('status', 1)->get());
                      }
                    @endphp
                    <ul class="social-profile">
                         @foreach(Session::get('socialLists') as $social)
                        <li><a href="{{$social->link}}"><i style="background:{{$social->background}}; color:{{$social->text_color}}" class="fa fa {{$social->icon}}"></i></a></li>
                        @endforeach
                    </ul>
                </div><!-- end footer-widget -->
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 column-td-half">
                <div class="footer-widget">
                    <h3 class="widget-title">Company</h3>
                    <span class="section-divider"></span>
                    <ul class="list-items">
                        <li><a href="{{route('aboutUs')}}">about us</a></li>
                        <li><a href="#">contact us</a></li>
                        <li><a href="#">become a Teacher</a></li>
                        <li><a href="#">support</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">blog</a></li>
                    </ul>
                </div><!-- end footer-widget -->
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 column-td-half">
                <div class="footer-widget">
                    <h3 class="widget-title">Courses</h3>
                    <span class="section-divider"></span>
                    <ul class="list-items">
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Hacking</a></li>
                        <li><a href="#">PHP Learning</a></li>
                        <li><a href="#">Spoken English</a></li>
                        <li><a href="#">Self-Driving Car</a></li>
                        <li><a href="#">Garbage Collectors</a></li>
                    </ul>
                </div><!-- end footer-widget -->
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 column-td-half">
                <div class="footer-widget">
                    <h3 class="widget-title">Download App</h3>
                    <span class="section-divider"></span>
                    <ul class="btn-box">
                        <li>
                            <a href="#" class="theme-btn">
                                <i class="la la-apple icon-element"></i>
                                <span class="app-titles">
                                    <span class="app__subtitle">Download on the</span>
                                    <span class="app__title">App Store</span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="theme-btn">
                                <i class="la la-android icon-element"></i>
                                <span class="app-titles">
                                    <span class="app__subtitle">Get in on</span>
                                    <span class="app__title">Google Play</span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div><!-- end footer-widget -->
            </div><!-- end col-lg-3 -->
        </div><!-- end row -->
        <div class="copyright-content">
            <div class="row align-items-center">
                <div class="col-lg-10">
                    <p class="copy__desc">&copy; 2020 Aduca. All Rights Reserved. by <a href="https://themeforest.net/user/techydevs/portfolio">TechyDevs.</a></p>
                </div><!-- end col-lg-9 -->
                
            </div><!-- end row -->
        </div><!-- end copyright-content -->
    </div><!-- end container -->
</section>
<!-- end footer-area -->
