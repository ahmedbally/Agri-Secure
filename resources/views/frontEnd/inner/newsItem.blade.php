@extends('frontEnd.layout')

@section('content')
    @include('frontEnd.includes.breadcrumb')       
    <?php
    $title_var = "title_" . trans('backLang.boxCode');
    $title_var2 = "title_" . trans('backLang.boxCodeOther');
    $details_var = "details_" . trans('backLang.boxCode');
    $details_var2 = "details_" . trans('backLang.boxCodeOther');
    if ($Topic->$title_var != "") {
        $title = $Topic->$title_var;
    } else {
        $title = $Topic->$title_var2;
    }
    if ($Topic->$details_var != "") {
        $details = $Topic->$details_var;
    } else {
        $details = $Topic->$details_var2;
    }
    $section = "";
    try {
        if ($Topic->section->$title_var != "") {
            $section = $Topic->section->$title_var;
        } else {
            $section = $Topic->section->$title_var2;
        }
    } catch (Exception $e) {
        $section = "";
    }
    ?>
    <!-- BLOCK "TYPE 3" -->
    <div class="new-block has-pattern2">
        <div class="container type-3-text">
            <div class="row">
                <div class="col-md-4 mb20">
                    <img src="{{ URL::to('uploads/topics/'.$Topic->photo_file) }}" class="thumbnail-image img-responsive nwsimg2" style="background-image:url({{ URL::to('uploads/topics/'.$Topic->photo_file) }});">
                </div>
                <div class="col-md-8">
                    <div class="typography-article">
                        <h4 class="color-blue">{{$title}} </h4>
                        <h2 style="font-size: 18px; font-weight: 700; color: rgb(176, 28, 40); margin: 24px 0px 0px; font-family: NotoNaskhArabic, "Helvetica Neue", Helvetica, sans-serif;">
                            <p style="font-size: 14px; color: rgb(77, 77, 77); font-weight: 400; text-align: justify;">{!!$details!!}</p></h2>                                
                    </div>                          
                </div>
            </div>
        </div>
    </div>

    @include('frontEnd.includes.visits')


@endsection