@if(!empty($customVisits))
@php
    $page = \Request::segment(1).\Request::segment(2);
@endphp
@endif
<div class="new-block type-16 scroll-to-block pd10" data-id="offers">
    <div class="container">     
        <div class="row">
            <div class="col-md-12">
                <div class="compare-column-entry wow fadeInLeft animated" style="visibility: visible; animation-name: fadeInLeft;">
                    <div class="" style="">
                        <img class="visimg" src="{{ URL::asset('frontEnd/img/businessman.svg')}}" alt="">
                        <div class="price nwtitle2">{{ trans('frontLang.visits') }} :</div>                                    
                        <h1 class="vistcount2">@if(!empty($customVisits)) {{\Helper::CustomVisits($page)}} @elseif(isset($Topic)){!! $Topic->visits !!} @endif</h1>                                   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>