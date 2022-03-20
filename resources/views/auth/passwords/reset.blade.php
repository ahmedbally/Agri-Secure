@extends('frontEnd.layout')
@section('content')


<div class="new-block type-inner">
    <div class="container">
        <div class="col-sm-6 col-xs-12 pdt25"> إستعادة كلمة المرور</div>

        <!-- <div class="col-sm-6 col-xs-12 text-left path-links">
            <a href="{{ route("Home") }}">{{trans('frontLang.home')}}</a>
            <a class="active">تسجيل دخول</a>
        </div> -->
    </div>
</div>

    <!-- ############ LAYOUT START-->
    <div class="center-block w-xxl w-auto-xs p-y-md">
        <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
            <div class="m-b">
                {{ trans('backLang.resetPassword') }}
            </div>
            <form class="form-horizontal form-login" name="reset" method="POST" action="{{ url('/password/reset') }}">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label col-sm-2">{{ trans('backLang.yourEmail') }}</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control" required>
                    </div>
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif

                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="control-label col-sm-2">{{ trans('backLang.newPassword') }}</label>
                    <div class="col-sm-10">
                       <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif


                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label class="control-label col-sm-2">{{ trans('backLang.confirmPassword') }}</label>
                    <div class="col-sm-10">
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif

                <button type="submit" class="btn btn-default btn-block btn-green">{{ trans('backLang.resetPassword') }}</button>
            </form>
        </div>
    </div>

    <!-- ############ LAYOUT END-->

@endsection
