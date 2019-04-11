<!-- Footer-->
<footer id="Footer" class="clearfix">

    <div class="widgets_wrapper">
        <div class="container">
            <div class="one-second column">
                <!-- Text Area -->
                <aside id="text-7" class="widget widget_text">
                    <div class="textwidget"><img width="250px" src="{{ asset('frontend/immagini/logo-wexplore-bianco.png') }}" alt="" />
                        <p>
                            <span class="big">Wexplore is the only career service that supports you<br>in finding your dream job abroad.</span>
                        </p>
                            <br>                   
                            <!--<a href="{{ isset($settings->facebook_url) ? $settings->facebook_url : ""}}" class="icon_bar icon_bar_facebook icon_bar_small"><span class="t"><i class="icon-facebook"></i></span><span class="b"><i class="icon-facebook"></i></span></a><a href="{{ isset($settings->google_plus_url) ? $settings->google_plus_url : ""}}" class="icon_bar icon_bar_google icon_bar_small"><span class="t"><i class="icon-gplus"></i></span><span class="b"><i class="icon-gplus"></i></span></a><a href="{{ isset($settings->twitter_url) ? $settings->twitter_url : ""}}" class="icon_bar icon_bar_twitter icon_bar_small"><span class="t"><i class="icon-twitter"></i></span><span class="b"><i class="icon-twitter"></i></span></a>{{--<a href="" class="icon_bar icon_bar_vimeo icon_bar_small"><span class="t"><i class="icon-vimeo"></i></span><span class="b"><i class="icon-vimeo"></i></span></a><a href="#" class="icon_bar icon_bar_youtube icon_bar_small"><span class="t"><i class="icon-play"></i></span><span class="b"><i class="icon-play"></i></span></a>--}}-->
                    </div>
                </aside>
            </div>


            <!--div class="one-fourth column">
                <aside id="text-8" class="widget widget_text">
                    <h4>Wexplore</h4>
                    <div class="textwidget">
                        <ul class="list_mixed">
                            <li class="list_check">
                                <a style="color:#ffffff;" href="services">Services</a>
                            </li>
                            <li class="list_check">
                                <a style="color:#ffffff;" href="about-us">About</a>
                            </li>
                            <li class="list_check">
                                <a style="color:#ffffff;" href="contact-us">Contacts</a>
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
            
            <div class="one-fourth column">
                <aside id="text-8" class="widget widget_text">
                    <h4><br></h4>
                    <div class="textwidget">
                        <ul class="list_mixed">
                            <li class="list_check">
                                 <a style="color:#ffffff;" href="terms-service">Terms Of Service</a>
                            </li>
                            <li class="list_check">
                                <a style="color:#ffffff;" href="privacy-policy">Privacy Policy</a>
                            </li>
                            <li class="list_check">
                                <a style="color:#ffffff;" href="cookies-policy">Cookie Policy</a>
                            </li>
                            <li class="list_check">
                                <a style="color:#ffffff;" href="code-ethics">Code of Ethics</a>
                            </li>
                        </ul>
                    </div>
                </aside>
            </div-->
        </div>
    </div>
    <!-- Footer copyright-->
    <div class="container">
        <div class="footer_copy" style="border-top:none !important;">
            <div class="column one">  
                <div class="copyright">
                    &copy; {{ date('Y') }} Wexplore
                </div>
                <!--Social info area-->
                <a id="back_to_top" href="#" class="button button_left button_js"> <span class="button_icon"> <i class="icon-up-open-big"></i> </span> </a>
                <!--   <ul class="social">
                    @if(isset($settings))
                        @if($settings->facebook_active)
                            <li class="facebook">
                                <a href="{{ $settings->facebook_url }}" title="Facebook"><i class="icon-facebook"></i></a>
                            </li>
                        @endif
                        @if($settings->twitter_active)
                            <li><a title="Twitter" href="{{ $settings->twitter_url }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        @endif
                        @if($settings->google_plus_active)
                            <li class="googleplus">
                                <a href="{{ $settings->google_plus_url }}" title="Google+"><i class="icon-gplus"></i></a>
                            </li>
                        @endif
                        @if($settings->behance_active)
                            <li><a title="Behance" href="{{ $settings->behance_url }}" target="_blank"><i class="fa fa-behance"></i></a></li>
                        @endif
                        @if($settings->linkedin_active)
                            <li><a title="Linkedin" href="{{ $settings->linkedin_url }}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        @endif
                    @endif
                </ul> -->
            </div>
        </div>
    </div>
</footer>
