{{-- <header>
    <!-- here header -->
    <div class="header-main">
        <div class="container">

            <a href="#" class="header-logo">
                <img class="logo-img" src="./assets/images/logo/logo.svg" alt="Anon's logo" width="120" height="36">
            </a>
            <div class="header-search-container">
                <input type="search" name="search" class="search-field" placeholder="Enter your product name...">
                <button class="search-btn">
                    <ion-icon name="search-outline"></ion-icon>
                </button>
            </div>

            <div class="header-user-actions">

                <button class="action-btn">
                    <ion-icon name="person-outline"></ion-icon>
                </button>
                <!-- here cart -->
                <button class="action-btn btn-cart">
                    <ion-icon class="md hydrated" name="bag-handle-outline"></ion-icon>
                    <span class="count quantity">0</span>
                </button>
            </div>
        </div>

    </div>
    <!-- here categories -->
    <nav class="desktop-navigation-menu">
        <div class="container">
            <div class="container"></div>

            <ul class="desktop-menu-category-list ul-category">

                <li class="menu-category">
                    <a href="#" class="menu-title">الرئيسية</a>
                </li>
            </ul>

        </div>
        </div>
    </nav>

    <div class="mobile-bottom-navigation">

        <button class="action-btn" data-mobile-menu-open-btn>
            <ion-icon name="menu-outline"></ion-icon>
        </button>

        <button class="action-btn">
            <ion-icon name="bag-handle-outline"></ion-icon>

            <span class="count">0</span>
        </button>
    </div>
</header> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <style>
        {!! Storage::get('stores/' . $name . '/css/style-prefix.css') !!}
    </style>

</head>

<body dir="rtl">
    {!! Storage::get('stores/' . $name . '/header.html') !!}
    @yield('homeStore')
    @yield('list')

</body>
@stack('javaScriptStore')

</html>
