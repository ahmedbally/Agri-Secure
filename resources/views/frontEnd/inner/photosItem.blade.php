@extends('frontEnd.layout')

@section('content')
    @include('frontEnd.includes.breadcrumb')       
    <?php
    $title_var = "title_" . trans('backLang.boxCode');
    $title_var2 = "title_" . trans('backLang.boxCodeOther');
    if ($Topic->$title_var != "") {
        $title = $Topic->$title_var;
    } else {
        $title = $Topic->$title_var2;
    }
    $i=0;
    ?>
    <!-- BLOCK "TYPE 3" -->
    <div class="new-block has-pattern2">
        <div class="container type-3-text">
            <div class="widget-entry">
                <h3 class="widget-title color-blue">{{$title}}:</h3>
                <div class="swiper-container horizontal-pagination screens-custom-slider-box" data-autoplay="0" data-loop="0" data-speed="500" data-center="0" data-slides-per-view="1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            @foreach($Topic->photos as $photo)
                            <?=(($i%3)==0 && $i>1)? '</div><div class="swiper-slide">' : '';?>  

                            <div class="col-md-4">
                                <a href="{{ URL::to('uploads/topics/'.$photo->file) }}" class="popular-thumbnail fancybox">
                                    <img src="{{ URL::to('uploads/topics/'.$photo->file) }}" alt="{{ $photo->title  }}">
                                </a>
                            </div>
                            <?php $i++;?>
                            @endforeach
                        </div>
                    </div>

                    <div class="pagination"></div>
                    <div class="swiper-arrow left default-arrow"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></div>
                    <div class="swiper-arrow right default-arrow"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></div>
                </div>
            </div>
        </div>
    </div>

    @include('frontEnd.includes.visits')


@endsection