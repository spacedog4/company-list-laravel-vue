<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Styles -->
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
</head>
<body id="app">
    <company-header></company-header>
    @yield('content')
</body>
</html>
