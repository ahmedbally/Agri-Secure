@extends('backEnd.layout')

@section('content')
<style>
    .errors-list {
        list-style-type: none;
    }

    .clearfix {
        clear: both;
    }

    .create-btn {
        display: block;
        width: 16%;
        float: right;
    }

    .old_options,
    #options,
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
                <a href="{{route('poll.index')}}">{!! trans('backLang.polls') !!}</a>
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
            @if(Session::has('danger'))
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
            @endif
            <form method="POST" action=" {{ route('poll.store') }}">
                {{ csrf_field() }}
                <!-- Question Input -->
                <div class="form-group row">
                    <label for="question">السؤال :</label>
                    <textarea id="question" name="question" cols="30" rows="2" class="form-control" placeholder="Ex: Who is the best player in the world?">{{ old('question') }}</textarea>
                </div>
                <div class="form-group row">
                    <label>الاختيارات</label>
                    <ul id="options">
                        <li>
                            <input id="option_1" type="text" name="options[0]" class="form-control add-input" value="{{ old('options.0') }}" placeholder="Ex: Cristiano Ronaldo" />
                        </li>
                        <li>
                            <input id="option_2" type="text" name="options[1]" class="form-control add-input" value="{{ old('options.1') }}" placeholder="Ex: Lionel Messi" />
                        </li>
                    </ul>

                    <ul>
                        <li class="button-add">
                            <div class="form-group">
                                <a class="btn btn-primary" id="add">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="form-group row clearfix">
                    <label>اختياري : </label>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="starts_at">يبدأ فى :</label>
                            <input type="text" id="starts_at" name="starts_at" class="form-control date" value="{{ old('starts_at') }}" ui-jp="datetimepicker" ui-options="{
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
                            <label for="starts_at">ينتهي فى:</label>
                            <input type="text" id="ends_at" name="ends_at" class="form-control date" value="{{ old('ends_at') }}"  ui-jp="datetimepicker" ui-options="{
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
                <div class="form-group row">
                    <label>
                        <input type="checkbox" name="canVisitorsVote" value="1" {{ old('canVisitorsVote')  == 1 ? 'checked' : ''  }}> السماح للزوار ؟
                    </label>
                </div>
                <!-- Create Form Submit -->
                <div class="form-group row">
                    <input name="create" type="submit" value="{{ trans('backLang.add') }}" class="btn btn-primary create-btn" />
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    // re render requested options
    @if(old('options'))
    @foreach(array_slice(old('options'), 2) as $option)
    var e = document.createElement('li');
    e.innerHTML = "<input type='text' name='options[]' value='{{ $option }}' class='form-control add-input' placeholder='Insert your option' /> <a class='btn btn-danger' href='#' onclick='remove(this)'><i class='fa fa-minus-circle' aria-hidden='true'></i></a>";
    document.getElementById("options").appendChild(e);
    @endforeach
    @endif

    function remove(current) {
        current.parentNode.remove()
    }
    document.getElementById("add").onclick = function() {
        var e = document.createElement('li');
        e.innerHTML = "<input type='text' name='options[]' class='form-control add-input' placeholder='Insert your option' /> <a class='btn btn-danger' href='#' onclick='remove(this)'><i class='fa fa-minus-circle' aria-hidden='true'></i></a>";
        document.getElementById("options").appendChild(e);
    }
</script>
@endsection