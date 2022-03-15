@extends('backEnd.layout')
@section('content')
    <style>
        .errors-list{
            list-style-type: none;
        }
    </style>
<div class="padding">
    <div class="box">
        <div class="box-header dker">
            <h3>{!! trans('backLang.polls') !!}</h3>
            <small>
                <a href="{{ route('adminHome') }}">{{ trans('backLang.home') }}</a> /
                <a href="{{route('poll.index')}}">{!! trans('backLang.polls') !!}</a> /
                <a class="active">حزف اختيارات</a>
            </small>
        </div>
        <div class="box-tool">
            <ul class="nav">
                <li class="nav-item inline">
                    <a class="nav-link" href="{{route('poll.index') }}">
                        <i class="material-icons md-18">×</i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="box-body">
            @if($errors->any())
                <ul class="alert alert-danger errors-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form method="POST" action=" {{ route('poll.options.remove', $poll->id) }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <!-- Question Input -->
                <div class="form-group">
                    <label>{{ $poll->question }}</label>
                    <div class="radio">
                        @foreach($poll->options as $option)
                            <label>
                                <input type="checkbox" name="options[]" value={{ $option->id }}> {{ $option->name }}
                            </label>
                            <br/>
                        @endforeach
                    </div>
                </div>
                <!-- Create Form Submit -->
                <div class="form-group">
                    <input name="Delete" type="submit" value="Delete" class="btn btn-danger form-control" >
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
