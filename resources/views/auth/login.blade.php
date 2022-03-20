@extends('frontEnd.layout')
@section('content')


<div class="new-block type-inner">
    <div class="container">
        <div class="col-sm-6 col-xs-12 pdt25">تسجيل الدخول</div>

        <!-- <div class="col-sm-6 col-xs-12 text-left path-links">
            <a href="{{ route("Home") }}">{{trans('frontLang.home')}}</a>
            <a class="active">تسجيل دخول</a>
        </div> -->
    </div>
</div>

    <!-- ############ LAYOUT START-->
    <div class="center-block w-xxl w-auto-xs p-y-md">
        <div class="p-a-md box-color r box-shadow-z1 text-color">
            <form class="form-horizontal form-login" name="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                @if($errors ->any())
                    <div class="alert alert-danger m-b-0">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="form-group float-label {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label col-sm-2">{{ trans('backLang.connectEmail') }}</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    </div>
                </div>
                <div class="form-group float-label {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="control-label col-sm-2">{{ trans('backLang.connectPassword') }}</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label class="md-check">
                                <input type="checkbox" name="remember"><i
                                    class="primary"></i> {{ trans('backLang.keepMeSignedIn') }}
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-default btn-block btn-green">{{ trans('backLang.signIn') }}</button>
            </form>
            <hr/>
            @if(env("FACEBOOK_STATUS") && env("FACEBOOK_ID") && env("FACEBOOK_SECRET"))
                <a href="{{ route('social.oauth', 'facebook') }}" class="btn btn-primary btn-block text-left">
                    <i class="fa fa-facebook pull-right"></i> {{ trans('backLang.loginWithFacebook') }}
                </a>
            @endif
            @if(env("TWITTER_STATUS") && env("TWITTER_ID") && env("TWITTER_SECRET"))
                <a href="{{ route('social.oauth', 'twitter') }}" class="btn btn-info btn-block text-left">
                    <i class="fa  fa-twitter pull-right"></i> {{ trans('backLang.loginWithTwitter') }}
                </a>
            @endif
            @if(env("GOOGLE_STATUS") && env("GOOGLE_ID") && env("GOOGLE_SECRET"))
                <a href="{{ route('social.oauth', 'google') }}" class="btn danger btn-block text-left">
                    <i class="fa fa-google pull-right"></i> {{ trans('backLang.loginWithGoogle') }}
                </a>
            @endif
            @if(env("LINKEDIN_STATUS") && env("LINKEDIN_ID") && env("LINKEDIN_SECRET"))
                <a href="{{ route('social.oauth', 'linkedin') }}" class="btn btn-primary btn-block text-left">
                    <i class="fa fa-linkedin pull-right"></i> {{ trans('backLang.loginWithLinkedIn') }}
                </a>
            @endif
            @if(env("GITHUB_STATUS") && env("GITHUB_ID") && env("GITHUB_SECRET"))
                <a href="{{ route('social.oauth', 'github') }}" class="btn btn-default dark btn-block text-left">
                    <i class="fa fa-github pull-right"></i> {{ trans('backLang.loginWithGitHub') }}
                </a>
            @endif
            @if(env("BITBUCKET_STATUS") && env("BITBUCKET_ID") && env("BITBUCKET_SECRET"))
                <a href="{{ route('social.oauth', 'bitbucket') }}" class="btn primary btn-block text-left">
                    <i class="fa fa-bitbucket pull-right"></i> {{ trans('backLang.loginWithBitbucket') }}
                </a>
            @endif

            @if(Helper::GeneralWebmasterSettings("register_status"))
            <div class="p-v-lg text-center">
                <a href="{{ url('/register') }}" class="btn btn-default btn-gray">
                    <i class="fa fa-user-plus"></i> {{ trans('backLang.createNewAccount') }}
                </a>
            </div>
            @endif
            <div class="p-v-lg text-center">
                    <a href="{{ url('/password/reset') }}" class="btn btn-default btn-green">{{ trans('backLang.forgotPassword') }}</a>
            </div>

        </div>



    </div>

    <!-- ############ LAYOUT END-->


@endsection
