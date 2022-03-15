@extends('frontEnd.layout')
@section('content')


<div class="new-block type-inner">
    <div class="container">
        <div class="col-sm-6 col-xs-12 pdt25">استرجاع كلمة المرور </div>

        <!-- <div class="col-sm-6 col-xs-12 text-left path-links">
            <a href="{{ route("Home") }}">{{trans('frontLang.home')}}</a>
            <a class="active">تسجيل دخول</a>
        </div> -->
    </div>
</div>

    <!-- ############ LAYOUT START-->
    <div class="center-block w-xxl w-auto-xs p-y-md">
        <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
            

            <form class="form-horizontal form-login" name="reset" method="POST" action="{{ url('/password/email') }}">

                <div class="m-b text-center">
                    {{ trans('backLang.forgotPassword') }}
                    <br><br>
                    <p class="text-xs m-t">{{ trans('backLang.enterYourEmail') }}</p>
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <hr>

                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">            
                    <label class="control-label col-sm-3">{{ trans('backLang.yourEmail') }}</label>
                    <div class="col-sm-9">
                        <input type="email"  name="email" value="{{ old('email') }}" class="form-control" required>
                    </div> 
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
                <button type="submit" class="btn btn-default btn-block btn-green">{{ trans('backLang.sendPasswordResetLink') }}</button>
            </form>
            <p id="alerts-container"></p>
            <div class="p-v-lg text-center"> 
                <a href="{{ url('/login') }}" class="btn btn-default btn-gray">{{ trans('backLang.signIn') }}</a>
            </div>
        </div>
        
    </div>

    <!-- ############ LAYOUT END-->

@endsection
