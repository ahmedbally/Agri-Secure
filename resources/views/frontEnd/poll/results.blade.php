@if(Session::has('errors'))
    <div class="alert alert-danger">
            {{ session('errors') }}
    </div>
@endif
@if(Session::has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<h3 class="vothead">استفتاء : {{ $question }}</h3>

@foreach($options as $option)
    <div class='result-option-id'>
        <h4 class="vothead">{{ $option->name }}</h4> <span class='pull-left' style="color: #4e9525">{{ $option->percent }}%</span>
        <div class='progress'>
            <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='{{ $option->percent }}' aria-valuemin='0' aria-valuemax='100' style='width: {{ $option->percent }}%'>
                <span class='sr-only'>{{ $option->percent }}% Complete</span>
            </div>
        </div>
    </div>
@endforeach
