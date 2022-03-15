@extends('backEnd.layout')
@section('content')
<style>
    .clearfix {
        clear: both;
    }

    .create-btn {
        display: block;
        width: 16%;
        float: right;
    }

    .old_options,
    .options,
    .button-add {
        list-style-type: none;
    }

    .add-input {
        width: 80%;
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>
<div class="padding">
<div class="box">
    <div class="box-header dker">
        <h3>{!! trans('backLang.polls') !!}</h3>
        <small>
            <a href="{{ route('adminHome') }}">{{ trans('backLang.home') }}</a> /
            <a href="{{route('poll.index')}}">{!! trans('backLang.polls') !!}</a> /
            <a class="active">تعديل استفتاء</a>
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
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
        <form method="POST" action=" {{ route('poll.update', $poll->id) }}">
            {{ csrf_field() }}
            @method('patch')
            <div class="form-group row">
                <label>السؤال: </label>
                <textarea id="question" name="question" cols="30" rows="2" class="form-control" placeholder="Ex: Who is the best player in the world?">{{ old('question', $poll->question) }}</textarea>
            </div>
            <div class="form-group row">
                <label>الإختيارات</label>
                <ul class="options">
                    @foreach($poll->options as $option)
                    <li>
                        <input class="form-control add-input" value="{{ $option->name }}" disabled />
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group row">
                <label>عدد الإختيارات التى يمكن اختيارها</label>
                <select name="count_check" class="form-control">
                    @foreach(range(1, $poll->optionsNumber()) as $i)
                    <option {{ $i==$poll->maxCheck? 'selected':'' }}>{{ $i }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group row clearfix">
                <label>اختياري</label>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="starts_at">يبدأ فى :</label>
                        <input type="text" id="starts_at" name="starts_at" class="form-control date" value="{{ old('starts_at', \Carbon\Carbon::parse($poll->starts_at)->format('Y-m-d\TH:i')) }}"  ui-jp="datetimepicker" ui-options="{
                                format: 'YYYY-MM-DD HH:mm',
                                icons: {
                                  time: 'fa fa-clock-o',
                                  date: 'fa fa-calendar',
                                  up: 'fa fa-chevron-up',
                                  down: 'fa fa-chevron-down',
                                  previous: 'fa fa-chevron-left',
                                  next: 'fa fa-chevron-right',
                                  today: 'fa fa-screenshot',
                                  clear: 'fa fa-trash',
                                  close: 'fa fa-remove'
                                }
                              }"/>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="starts_at">ينتهي فى :</label>
                        <input type="text" id="ends_at" name="ends_at" class="form-control date" value="{{ old('ends_at', \Carbon\Carbon::parse($poll->ends_at)->format('Y-m-d\TH:i')) }}" ui-jp="datetimepicker" ui-options="{
                                format: 'YYYY-MM-DD HH:mm',
                                icons: {
                                  time: 'fa fa-clock-o',
                                  date: 'fa fa-calendar',
                                  up: 'fa fa-chevron-up',
                                  down: 'fa fa-chevron-down',
                                  previous: 'fa fa-chevron-left',
                                  next: 'fa fa-chevron-right',
                                  today: 'fa fa-screenshot',
                                  clear: 'fa fa-trash',
                                  close: 'fa fa-remove'
                                }
                              }"/>
                    </div>
                </div>
            </div>

            <div class="radio">
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="canVisitorsVote" value="1" {{ old('canVisitorsVote', $poll->canVisitorsVote)  == 1 ? 'checked' : ''  }}> السماح للزوار
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="close" {{ old('close', $poll->isLocked()) ? 'checked':'' }}> اغلاق
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="canVoterSeeResult" {{ old('canVoterSeeResult', $poll->showResultsEnabled()) ? 'checked':'' }}> السماح للزوار برؤية النتيجه
                    </label>
                </div>
            </div>

            <!-- Create Form Submit -->
            <div class="form-group row">
                <input name="update" type="submit" value="{{ trans('backLang.update') }}" class="btn btn-primary create-btn" />
            </div>
        </form>
    </div>
</div>
@endsection