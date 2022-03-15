@php
    $seg1 = \Request::segment(1);
    $seg2 = \Request::segment(2);
    //print_r($_GET); die();
@endphp
<div class="new-block type-inner">
    <div class="container">
        <div class="col-sm-6 col-xs-12 pdt25">@if($seg1=='contact')
                {!! trans('frontLang.contactUs') !!}
            @elseif(@$WebmasterSection!="none"){!! trans('backLang.'.$WebmasterSection->name) !!} @endif</div>

        <div class="col-sm-6 col-xs-12 text-left path-links">
            <a href="{{ route("Home") }}">{{trans('frontLang.home')}}</a>
            @if(@$WebmasterSection!="none")
                @if($seg1=='contact')
                    <a href="{{(strlen($seg1)>2)? route('Home').'/'.$seg1:''}}" class="active">{!! trans('frontLang.contactUs') !!}</a>
                @else
                <a href="{{(strlen($seg1)>2)? route('Home').'/'.$seg1:''}}" class="active">{!! trans('backLang.'.$WebmasterSection->name) !!}</a>
                @endif
            @elseif(@$search_word!="")
                <a href="{{route('Home').'/'.$seg1.'/'.$seg2}}" class="active">{{ @$search_word }}</a>
            @else
                <a class="active">{{ $User->name }}</a>
            @endif
            @if($CurrentCategory!="none")
                @if(!empty($CurrentCategory))
                    <?php
                    $category_title_var = "title_" . trans('backLang.boxCode');
                    ?>
                     <a  href="{{route('Home').'/'.$seg1.'/'.$seg2}}" class="active">{{ $CurrentCategory->$category_title_var }}</a>
                @endif
            @endif
            @if(isset($_GET['countries']))
                @php
                    $title_a=($_GET['countries']=='exp')? 'صادرات' : 'واردات';
                @endphp
                <a class="active">{{$title_a}}</a>
            @endif  
        </div>
    </div>
</div>