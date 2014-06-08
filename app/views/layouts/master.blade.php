@extends('layouts.static')
<!DOCTYPE html>
<html>
<header>
    <title>@yield('title') -- 透视宝</title>
    @yield('common_meta')
    @yield('common_css')
    @yield('app_css')
    @yield('common_js_header')
</header>
<body>
@yield('common_js_config')
@include('layouts.tsb_head')

@yield('tsb_left')
@yield('content')
@yield('common_js_footer')
@yield('app_js')
</body>
</html>