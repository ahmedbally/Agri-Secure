@extends('backEnd.layout')

@section('content')
<style>
    .errors-list{
        list-style-type: none;
    }
    .create-btn{
        display: block;
        width: 16%;
        float: right;
    }
    .old_options, .options, #options, .button-add {
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
            <a class="active">إضافة  اختيارات</a>
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
            <div class="alert alert-danger">
                <span>Please fill empty inputs</span>
            </div>
        @endif
        <form method="POST" action=" {{ route('poll.options.add', $poll->id) }}">
            {{ csrf_field() }}
            <!-- Question Input -->
            <div class="form-group row">
                <label for="question">{{ $poll->question }}</label>
            </div>
            <div class="form-group row">
                <label>Options</label>
                <ul class="options">
                    @foreach($poll->options as $option)
                        <li>
                            <input class="form-control add-input" value="{{ $option->name }}" disabled />
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group row">
                <ul id="options">
                    <li>
                        <input type="text" name="options[0]" class="form-control add-input" placeholder="Insert your option" />
                        <a class="btn btn-danger" href="#" onclick='remove(this)'>
                            <i class="fa fa-minus-circle" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <ul>
                <li class="button-add">
                    <div class="form-group">
                        <a class="btn btn-success" id="add">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>
            </ul>
            <!-- Create Form Submit -->
            <div class="form-group row">
                <input name="Add" type="submit" value="Add" class="btn btn-primary create-btn" >
            </div>
        </form>
    </div>
</div>
</div><script type="text/javascript">
    function remove(current){
        current.parentNode.remove()
    }
    document.getElementById("add").onclick = function() {
        var e = document.createElement('li');
        e.innerHTML = "<input type='text' name='options[]' class='form-control add-input' placeholder='Insert your option' /> <a class='btn btn-danger' href='#' onclick='remove(this)'><i class='fa fa-minus-circle' aria-hidden='true'></i></a>";
        document.getElementById("options").appendChild(e);
    }
</script>
@endsection
