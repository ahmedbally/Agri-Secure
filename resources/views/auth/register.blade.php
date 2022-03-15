@extends('frontEnd.layout')
@section('content')
    @if(Helper::GeneralWebmasterSettings("register_status"))


    <div class="new-block type-inner">
        <div class="container">
            <div class="col-sm-6 col-xs-12 pdt25">الإشتراك</div>

            <!-- <div class="col-sm-6 col-xs-12 text-left path-links">
                <a href="{{ route("Home") }}">{{trans('frontLang.home')}}</a>
                <a class="active">تسجيل دخول</a>
            </div> -->
        </div>
    </div>

    <!-- ############ LAYOUT START-->
    <div class="center-block w-xxl w-auto-xs p-y-md">
        <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
            <form class="form-horizontal form-login" role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                @if ($errors->has('name'))
                    <div class="alert alert-warning">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                @if ($errors->has('email'))
                    <div class="alert alert-warning">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                @if ($errors->has('password'))
                    <div class="alert alert-warning">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                @if ($errors->has('mobile'))
                    <div class="alert alert-warning">
                        {{ $errors->first('mobile') }}
                    </div>
                @endif
                <div class="form-group">
                    <label class="control-label col-sm-3">{{ trans('backLang.fullName') }}</label>
                    <div class="col-sm-9">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div> 
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">{{ trans('backLang.connectEmail') }}</label>
                    <div class="col-sm-9">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">الموبايل</label>
                    <div class="col-sm-9">
                        <input id="mobile" type="number" class="form-control" name="mobile" value="{{ old('mobile') }}" required>
                    </div>
                </div>
                <div class="form-group">                
                    <label class="control-label col-sm-3">{{ trans('backLang.connectPassword') }}</label>
                    <div class="col-sm-9">
                       <input id="password" type="password" class="form-control" name="password" required> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">{{ trans('backLang.confirmPassword') }}</label>
                    <div class="col-sm-9">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>   
                    </div>
                </div>

                <button type="submit" class="btn btn-default btn-block btn-green"><i class="fa fa-user-plus"></i> {{ trans('backLang.createNewAccount') }}</button>
            </form>

            <div class="p-v-lg text-center">
                <a href="{{ url('/login') }}" class="btn btn-default btn-gray">{{ trans('backLang.signIn') }}</a>
            </div>
        </div>


    </div>

    <!-- ############ LAYOUT END-->

@else
    <script>
        window.location.href = '{{url("/login")}}';
    </script>
@endif


@endsection
