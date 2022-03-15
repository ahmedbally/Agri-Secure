@extends('frontEnd.layout')

@section('content')
    <div class="new-block type-inner">
        <div class="container">
            <div class="col-sm-6 col-xs-12 pdt25">شارك رأيك</div>
            <div class="col-sm-6 col-xs-12 text-left path-links">
                <a href="{{ route('Home') }}">{{trans('frontLang.home')}}</a>             
                <a class="active"> شارك رأيك</a>
            </div>
        </div>
    </div>

    <div class="block scroll-to-block">
        <div class="container">
            <div class="col-md-12">
            @if($polls->count() > 0)
                {{ PollWriter::draw($polls) }}
            @endif  
            </div>
        </div>
    </div>
         
    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection