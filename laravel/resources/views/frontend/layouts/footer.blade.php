<!-- Start Footer Area -->
{{-- <footer class="footer">
		<!-- Footer Top -->
		<div class="footer-top section">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer about">
							<div class="logo">
								<a href="index.html"><img src="{{asset('backend/img/logo2.png')}}" alt="#"></a>
							</div>
							@php
								$settings=DB::table('settings')->get();
							@endphp
							<p class="text">
								@if (App::getLocale() == 'ar')
								متجرنا الإلكتروني هو وجهتك الأولى لشراء المنتجات الإلكترونية بأفضل الأسعار. نقدم تشكيلة واسعة من الأجهزة الإلكترونية، من الهواتف الذكية وأجهزة الكمبيوتر المحمولة إلى سماعات الرأس والألعاب. نحرص على تقديم منتجات عالية الجودة مع خدمة عملاء ممتازة. نوفر لك تجربة تسوق سلسة وآمنة مع خيارات دفع متعددة. اكتشف عالم الإلكترونيات معنا!
								@else
								@foreach ($settings as $data) {{$data->short_des}} @endforeach

								@endif
							</p>
							<p class="call">{{trans('footer.call_us')}}<span><a href="tel:123456789">@foreach ($settings as $data) {{$data->phone}} @endforeach</a></span></p>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>{{trans('footer.information')}}</h4>
							<ul>
								<li><a href="{{route('about-us')}}">{{trans('footer.about_us')}}</a></li>
								<li><a href="#">{{trans('footer.faq')}}</a></li>
								<li><a href="#">{{trans('footer.team&cond')}}</a></li>
								<li><a href="{{route('contact')}}">{{trans('footer.contact_us')}}</a></li>
								<li><a href="#">{{trans('footer.help')}}</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>{{trans('footer.cust_service')}}</h4>
							<ul>
								<li><a href="#">{{trans('footer.pay_method')}}</a></li>
								<li><a href="#">{{trans('footer.mony_back')}}</a></li>
								<li><a href="#">{{trans('footer.returns')}}</a></li>
								<li><a href="#">{{trans('footer.shipping')}}</a></li>
								<li><a href="#">{{trans('footer.privacy_policy')}}</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer social">
							<h4>{{trans('footer.get_in_tuch')}}</h4>
							<!-- Single Widget -->
							<div class="contact">
								<ul>
									<li>@foreach ($settings as $data) {{$data->address}} @endforeach</li>
									<li>@foreach ($settings as $data) {{$data->email}} @endforeach</li>
									<li>@foreach ($settings as $data) {{$data->phone}} @endforeach</li>
								</ul>
							</div>
							<!-- End Single Widget -->
							<div class="sharethis-inline-follow-buttons"></div>
						</div>
						<!-- End Single Widget -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer Top -->
		<div class="copyright">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div class="left">
								<p>Copyright © {{date('Y')}} <a href="https://github.com/Prajwal100" target="_blank">IT4 programmer</a>  -  All Rights Reserved.</p>
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<div class="right">
								<img src="{{asset('backend/img/payments.png')}}" alt="#">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer> --}}
<!-- /End Footer Area -->

<!-- Jquery -->
<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery-migrate-3.0.0.js') }}"></script>
<script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
<!-- Popper JS -->
<script src="{{ asset('frontend/js/popper.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<!-- Color JS -->
<script src="{{ asset('frontend/js/colors.js') }}"></script>
<!-- Slicknav JS -->
<script src="{{ asset('frontend/js/slicknav.min.js') }}"></script>
<!-- Owl Carousel JS -->
<script src="{{ asset('frontend/js/owl-carousel.js') }}"></script>
<!-- Magnific Popup JS -->
<script src="{{ asset('frontend/js/magnific-popup.js') }}"></script>
<!-- Waypoints JS -->
<script src="{{ asset('frontend/js/waypoints.min.js') }}"></script>
<!-- Countdown JS -->
<script src="{{ asset('frontend/js/finalcountdown.min.js') }}"></script>
<!-- Nice Select JS -->
<script src="{{ asset('frontend/js/nicesellect.js') }}"></script>
<!-- Flex Slider JS -->
<script src="{{ asset('frontend/js/flex-slider.js') }}"></script>
<!-- ScrollUp JS -->
<script src="{{ asset('frontend/js/scrollup.js') }}"></script>
<!-- Onepage Nav JS -->
<script src="{{ asset('frontend/js/onepage-nav.min.js') }}"></script>
{{-- Isotope --}}
<script src="{{ asset('frontend/js/isotope/isotope.pkgd.min.js') }}"></script>
<!-- Easing JS -->
<script src="{{ asset('frontend/js/easing.js') }}"></script>

<!-- Active JS -->
<script src="{{ asset('frontend/js/active.js') }}"></script>


@stack('scripts')
<script>
    setTimeout(function() {
        $('.alert').slideUp();
    }, 5000);
    $(function() {
        // ------------------------------------------------------- //
        // Multi Level dropdowns
        // ------------------------------------------------------ //
        $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
            event.preventDefault();
            event.stopPropagation();

            $(this).siblings().toggleClass("show");


            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                $('.dropdown-submenu .show').removeClass("show");
            });

        });
    });
</script>
