@extends('layouts.static')
<html>
<header>
    @yield('title')
    @yield('common_meta')
    @yield('common_css')
    @yield('app_css')
    @yield('common_js_header')
</header>
<body>
@yield('head')
@yield('leftMenu')
@yield('content')
@yield('common_js_footer')
@yield('app_js')
</body>
</html>