<!DOCTYPE html>
<html lang="{{ trans('backLang.code') }}" dir="{{ trans('backLang.direction') }}">
<head>
    @include('frontEnd.includes.head')
    @yield('headInclude')
</head>
<body data-theme="theme-1">
    @include('frontEnd.includes.header')
    
    <div id="content-wrapper">
        
        <div class="blocks-container">           
        @yield('content')
        @include('frontEnd.includes.footer')
            
        </div>
        
    </div>
    @include('frontEnd.includes.foot')
	@yield('footerInclude')
</body>
</html>
