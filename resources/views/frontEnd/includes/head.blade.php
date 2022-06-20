	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="{{$PageDescription}}"/>
    <meta name="keywords" content="{{$PageKeywords}}"/>
    <meta name="author" content="{{ URL::to('') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ URL::asset('frontEnd/css/bootstrap.min.cs') }}s" rel="stylesheet" type="text/css" />
	<link href="{{ URL::asset('frontEnd/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('frontEnd/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('frontEnd/css/idangerous.swiper.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('frontEnd/css/devices.min.css') }}" rel="stylesheet" type="text/css" />

    @if( trans('backLang.direction')=="rtl")
    <link href="{{ URL::asset('frontEnd/css/style.rtl.css') }}" rel="stylesheet" type="text/css" />
    @else
    <link href="{{ URL::asset('frontEnd/css/style.css') }}" rel="stylesheet" type="text/css" />
    @endif
    <link href="{{ URL::asset('frontEnd/css/animate.css') }}" rel="stylesheet" type="text/css" />

    <?php $segment1= Request::segment( 1 ); ?>
    @if ($segment1=='photos')
        <link href="{{ URL::asset('frontEnd/js/lightbox/jquery.fancybox.css') }}" rel="stylesheet" type="text/css" />
    @endif
    <link href="{{ URL::asset('frontEnd/css/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('frontEnd/css/organize.css') }}" rel="stylesheet" type="text/css" />
    <!-- <link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/favicon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/favicon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/favicon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/favicon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="img/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="img/favicon/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="img/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="img/favicon/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="img/favicon/manifest.json">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#f9a718">
    <link rel="shortcut icon" href="img/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="img/favicon/mstile-144x144.png">
    <meta name="msapplication-config" content="img/favicon/browserconfig.xml"> -->

    <!-- Favicon and Touch Icons -->
    @if(Helper::GeneralSiteSettings("style_fav") !="")
        <link href="{{ URL::asset('uploads/settings/'.Helper::GeneralSiteSettings('style_fav')) }}" rel="shortcut icon" type="image/png">
    @else
        <link href="{{ URL::asset('uploads/settings/nofav.png') }}" rel="shortcut icon" type="image/png">
    @endif
    @if(Helper::GeneralSiteSettings("style_apple") !="")
        <link href="{{ URL::asset('uploads/settings/'.Helper::GeneralSiteSettings('style_apple')) }}" rel="apple-touch-icon">
        <link href="{{ URL::asset('uploads/settings/'.Helper::GeneralSiteSettings('style_apple')) }}" rel="apple-touch-icon"
              sizes="72x72">
        <link href="{{ URL::asset('uploads/settings/'.Helper::GeneralSiteSettings('style_apple')) }}" rel="apple-touch-icon"
              sizes="114x114">
        <link href="{{ URL::asset('uploads/settings/'.Helper::GeneralSiteSettings('style_apple')) }}" rel="apple-touch-icon"
              sizes="144x144">
    @else
        <link href="{{ URL::asset('uploads/settings/nofav.png') }}" rel="apple-touch-icon">
        <link href="{{ URL::asset('uploads/settings/nofav.png') }}" rel="apple-touch-icon" sizes="72x72">
        <link href="{{ URL::asset('uploads/settings/nofav.png') }}" rel="apple-touch-icon" sizes="114x114">
        <link href="{{ URL::asset('uploads/settings/nofav.png') }}" rel="apple-touch-icon" sizes="144x144">
    @endif

    {{-- Google Tags and google analytics --}}
    @if($WebmasterSettings->google_tags_status && $WebmasterSettings->google_tags_id !="")
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{!! $WebmasterSettings->google_tags_id !!}');</script>
        <!-- End Google Tag Manager -->
    @endif

    <meta name="theme-color" content="#ffffff">
    <!-- Step 1 - Include the fusioncharts core library -->
    <script type="text/javascript" src="{{ URL::asset('frontEnd/js/maps/fusioncharts.js') }}"></script>
    <!-- Step 2 - Include the map renderer file -->
    <script type="text/javascript" src="{{ URL::asset('frontEnd/js/maps/fusioncharts.maps.js') }}"></script>
    <!-- Step 3 - Include the map definition file -->
    <script type="text/javascript" src="{{ URL::asset('frontEnd/js/maps/fusioncharts.egypt.js') }}"></script>
    <!-- Step 4 - Include the fusion theme -->
    <script type="text/javascript" src="{{ URL::asset('frontEnd/js/maps/fusioncharts.theme.fint.js') }}"></script>
    <script src="{{ URL::asset('frontEnd/js/jquery-3.5.0.min.js')}}"></script>
    <title>{{$PageTitle}} {{($PageTitle !="")? "|":""}} {{ Helper::GeneralSiteSettings("site_title_" . trans('backLang.boxCode')) }}</title>
