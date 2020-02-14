<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', config('app.name', 'Gold Kauri Coast Pizzeria - Management Portal'))</title>
    <!-- General CSS Files -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}"> -->
    <!-- CSS Libraries -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/css/iziToast.min.css') }}"> -->
    <!--link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}"-->
    @stack('styles')
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    <script>
        window.activeLeague = {!! json_encode([
            'csrfToken' => csrf_token(),
            'baseUrl' => url("/")
        ]) !!}
    </script>

    @stack('head_scripts')
</head>
