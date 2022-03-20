<!-- HEADER -->
	<div class="top-bar">
        <div class="row">
            <div class="col-sm-5 text-right hidden-xs">
                @if(Helper::GeneralSiteSettings("contact_t3") !="")
                    <i class="fa fa-phone"></i> &nbsp;<a
                            href="tel:{{ Helper::GeneralSiteSettings("contact_t3") }}">
                            <span dir="ltr">{{ Helper::GeneralSiteSettings("contact_t3") }}</span></a>
                @endif
                @if(Helper::GeneralSiteSettings("contact_t6") !="")
                    <span class="top-email">
                    &nbsp; | &nbsp;
                <i class="fa fa-envelope-o"></i> &nbsp;<a
                                href="mailto:{{ Helper::GeneralSiteSettings('contact_t6') }}">{{ Helper::GeneralSiteSettings("contact_t6") }}</a>
                </span>
                @endif
                <!-- <span><i class="fa fa-phone"></i> 0123456789</span> &nbsp;&nbsp;|&nbsp;&nbsp;
                <span><i class="fa fa-envelope-o"></i> info@agri.gov.eg</span> 	 -->
            </div>
            <div class="col-sm-7 text-left col-xs-12">

                <div class="top-social">
                    @if($WebsiteSettings->social_link1)
                        <a href="{{$WebsiteSettings->social_link1}}" data-placement="top" title="Facebook"
                            target="_blank"><img src="{{ URL::asset('frontEnd/img/fb.png')}}"/></a>
                    @endif
                    @if($WebsiteSettings->social_link2)
                        <a href="{{$WebsiteSettings->social_link2}}" data-placement="top" title="Twitter"
                            target="_blank"><img src="{{ URL::asset('frontEnd/img/tw.png')}}"/></a>
                    @endif
                    @if($WebsiteSettings->social_link3)
                        <a href="{{$WebsiteSettings->social_link3}}" data-placement="top" title="Google+"
                            target="_blank"><img src="{{ URL::asset('frontEnd/img/gplus.png')}}"/></a>
                    @endif
                    @if($WebsiteSettings->social_link4)
                        <a href="{{$WebsiteSettings->social_link4}}" data-placement="top" title="linkedin"
                            target="_blank"><img src="{{ URL::asset('frontEnd/img/lnkd.png')}}"/></a>
                    @endif
                    @if($WebsiteSettings->social_link5)
                        <a href="{{$WebsiteSettings->social_link5}}" data-placement="top" title="Youtube"
                            target="_blank"><img src="{{ URL::asset('frontEnd/img/yt.png')}}"/></a>
                    @endif
                    @if($WebsiteSettings->social_link6)
                        <a href="{{$WebsiteSettings->social_link6}}" data-placement="top" title="Instagram"
                            target="_blank"><img src="{{ URL::asset('frontEnd/img/insta.png')}}"/></a>
                    @endif
                    @if($WebsiteSettings->social_link7)
                        <a href="{{$WebsiteSettings->social_link7}}" data-placement="top" title="Pinterest"
                            target="_blank"><img src="{{ URL::asset('frontEnd/img/pint.png')}}"/></a>
                    @endif
                    @if($WebsiteSettings->social_link8)
                        <a href="{{$WebsiteSettings->social_link8}}" data-placement="top" title="Tumblr"
                            target="_blank"><img src="{{ URL::asset('frontEnd/img/tumblr.png')}}"/></a>
                    @endif
                    @if($WebsiteSettings->social_link9)
                        <a href="{{$WebsiteSettings->social_link9}}" data-placement="top" title="Flickr"
                            target="_blank"><img src="{{ URL::asset('frontEnd/img/flk.png')}}"/></a>
                    @endif
                    @if($WebsiteSettings->social_link10)
                        <a href="https://api.whatsapp.com/send?phone={{$WebsiteSettings->social_link10}}"
                            data-placement="top"
                            title="Whatsapp" target="_blank"><img src="{{ URL::asset('frontEnd/img/wts.png')}}"/></a>
                    @endif
                </div>

                @guest
                <div class="login">
                    <form class="form-inline" name="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <input class="form-control" placeholder="{{ trans('backLang.connectEmail') }}" id="email"  type="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <input class="form-control" type="password" name="password" required id="pwd" placeholder="{{ trans('backLang.connectPassword') }}">
                        </div>
                        <button type="submit" class="btn btn-default">دخول</button>
                    </form>
                    <a class="newuser" href="{{url('/register')}}">مستخدم جديد <i class="fa fa-lock"></i></a>
                    <a class="search" data-toggle="modal" data-target="#searchModal" href="#"><i class="fa fa-search"></i></a>
                    <a class="newuser-responsive" href="{{url('/login')}}"> <i class="fa fa-user"></i></a>
                    <a class="search-responsive" data-toggle="modal" data-target="#searchModal" href="#"> <i class="fa fa-search"></i></a>
                </div>
                @else
                <div class="login">
                    <a class="search" data-toggle="modal" data-target="#searchModal" href="#"><i class="fa fa-search"></i></a>
                    <a class="search-responsive" data-toggle="modal" data-target="#searchModal" href="#"> <i class="fa fa-search"></i></a>

                    <span>{{auth()->user()->name}}  <button class="btn btn-default" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> تسجيل خروج</button></span>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    </form>
                </div>
                @endguest

                <strong class="tagreby">بث تجريبي - تحت الإنشاء</strong>

            </div>
        </div>
    </div>
    <header class="stick">
        <a href="{{ route('Home') }}" id="logo">
             @if(Helper::GeneralSiteSettings("style_logo_" . trans('backLang.boxCode')) !="")
                <img class="act" alt="{{ Helper::GeneralSiteSettings('site_title_' . trans('backLang.boxCode')) }}"
                src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings('style_logo_' . trans('backLang.boxCode'))) }}">
            @else
                <img alt="" src="{{ URL::to('uploads/settings/nologo.png') }}">
            @endif

			<span>{{ Helper::GeneralSiteSettings("site_title_" . trans('backLang.boxCode')) }}</span>
			<p>وزراة الزراعة واستصلاح الاراضي</p>
		</a>
        <div class="mob-icon">
            <span></span>
        </div>

        @include('frontEnd.includes.menu')
    </header>

    <!-- LOADER -->
    <div id="loader-wrapper">
        <img src="{{ URL::asset('frontEnd/img/sitelogowhite-ar.png')}}" alt=""/>
        <span></span>
    </div>
