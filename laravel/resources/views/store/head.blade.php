<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $name }}</title>
    <style>
        {!! Storage::get('stores/one/header/1.css') !!} {!! Storage::get('stores/one/card/1.css') !!} {!! Storage::get('stores/one/footer/2.css') !!}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body dir="rtl">
    @yield('store')
</body>
@stack('javaScript')

</html>
