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
                   <div class="block scroll-to-block pdb100">
                <div class="container">
                  
                    <div class="row">
                        <div class="col-md-12">
                        @foreach($polls as $Topic)
                            <a href="{{URL('polls/'.$Topic->id)}}">
                                <div class="vtbox">                         
                                    <img src="{{ URL::asset('frontEnd/img/ballot.svg')}}">
                                    <p>{{$Topic->question}}</p>                            
                                </div>
                            </a>
                        @endforeach
                        </div>   
                    </div> 
                    
                </div>
            </div>
            @endif  
            </div>
        </div>
    </div>
         
    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection