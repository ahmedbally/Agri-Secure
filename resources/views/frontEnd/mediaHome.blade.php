@extends('frontEnd.layout')

@section('content')
<div class="new-block type-inner">
    <div class="container">
        <div class="col-sm-6 col-xs-12 pdt25">المركز الإعلامي</div>

        <div class="col-sm-6 col-xs-12 text-left path-links">
            <a href="{{ route("Home") }}">{{trans('frontLang.home')}}</a>
            <a class="active">المركز الإعلامي</a>
        </div>
    </div>
</div>

<?php
    $title_var = "title_" . trans('backLang.boxCode');
    $title_var2 = "title_" . trans('backLang.boxCodeOther');
    $details_var = "details_" . trans('backLang.boxCode');
    $details_var2 = "details_" . trans('backLang.boxCodeOther');
    $slug_var = "seo_url_slug_" . trans('backLang.boxCode');
    $slug_var2 = "seo_url_slug_" . trans('backLang.boxCodeOther');
    $start=0
?>
    <div class="new-block has-pattern2">
        <div class="container type-3-text">
            <div class="row">
    			<div class="col-md-3"  style="margin-bottom:20px;">
    				<a href="{{url('news')}}">
                        <li class="inner1">
                            <img src="{{ URL::to('uploads/sections/news.svg')}}" alt="" width="60">
                            {{trans('backLang.news')}}
                        </li>
                    </a>
                </div>
                <div class="col-md-3"  style="margin-bottom:20px;">
    				<a href="{{url('photos')}}">
                        <li class="inner1">
                            <img src="{{ URL::to('uploads/sections/photos.svg')}}" alt="" width="60">
                            {{trans('backLang.photos')}}
                        </li>
                    </a>
                </div>
                <div class="col-md-3"  style="margin-bottom:20px;">
    				<a href="{{url('videos')}}">
                        <li class="inner1">
                            <img src="{{ URL::to('uploads/sections/videos.svg')}}" alt="" width="60">
                            {{trans('backLang.videos')}}
                        </li>
                    </a>
                </div>
                <div class="col-md-3"  style="margin-bottom:20px;">
    				<a href="{{url('events')}}">
                        <li class="inner1">
                            <img src="{{ URL::to('uploads/sections/events.svg')}}" alt="" width="60">
                            {{trans('backLang.events')}}
                        </li>
                    </a>
                </div>
            </div>
        </div>
    </div>
         
    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection