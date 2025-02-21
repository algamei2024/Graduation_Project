<!DOCTYPE html>
<html lang="zxx">

<head>
    @include('frontend.layouts.head')
</head>
{{-- @if (App::getlocale() == 'ar') --}}

<body style="direction: rtl;text-align:right" class="js">
    {{-- @else

        <body class="js">
@endif --}}


    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <!-- End Preloader -->

    {{-- لفحص ان المسار خالي من كلمة loginاو كلمة register --}}
    {{-- @if (strpos(request()->path(), 'login') === false && strpos(request()->path(), 'register') === false)
        @include('frontend.layouts.notification')
        <!-- Header -->
        @include('frontend.layouts.header')
        <!--/ End Header -->
    @endif --}}

    @yield('main-content')

    @include('frontend.layouts.footer')

</body>

</html>
