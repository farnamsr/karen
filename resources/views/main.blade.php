<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    @yield("styles")
    <title>Document</title>
</head>
<body>
@yield('navbar')
@yield('content')
@yield('scripts')
<script src="{{asset("js/bootstrap.js")}}"></script>
</body>
</html>
