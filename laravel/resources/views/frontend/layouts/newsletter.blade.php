
<!-- Start Shop Newsletter  -->
<section class="shop-newsletter section">
    <div class="container">
        <div class="inner-top">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <!-- Start Newsletter Inner -->
                    <div class="inner">
                        <h4>{{trans('footer.news_letter')}}</h4>
                        <p>{{trans('footer.news_msg1')}}  <span>10%</span> {{trans('footer.news_msg2')}} </p>
                        <form action="{{route('subscribe')}}" method="post" class="newsletter-inner">
                            @csrf
                            <input name="email" placeholder="{{trans('footer.email')}}" required="" type="email">
                            <button class="btn" type="submit">{{trans('footer.subscribe')}}</button>
                        </form>
                    </div>
                    <!-- End Newsletter Inner -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Newsletter -->