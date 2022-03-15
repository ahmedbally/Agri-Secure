@extends('frontEnd.layout')

@section('content')
    @include('frontEnd.includes.breadcrumb')
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
        		@foreach($Sections as $item)
                    <?php
                        if ($item->$title_var != "") {
                            $title = $item->$title_var;
                        } else {
                            $title = $item->$title_var2;
                        }
                        if ($item->webmasterSection->$slug_var != "" && Helper::GeneralWebmasterSettings("links_status")) {
                            if (trans('backLang.code') != env('DEFAULT_LANGUAGE')) {
                                $section_url = url(trans('backLang.code') . "/" . $item->webmasterSection->$slug_var);
                            } else {
                                $section_url = url($item->webmasterSection->$slug_var);
                            }
                        } else {
                            /*if (trans('backLang.code') != env('DEFAULT_LANGUAGE')) {
                                $section_url = url(trans('backLang.code') . "/" . $item->webmasterSection->name);
                            } else {
                                $section_url = url($item->webmasterSection->name);
                            }*/
                            if (trans('backLang.code') != env('DEFAULT_LANGUAGE')) {
                                $section_url = route('FrontendTopicsByCatWithLang', ["lang" => trans('backLang.code'), "section" => $item->webmasterSection->name, "cat" => $item->id]);
                            } else {
                                $section_url = route('FrontendTopicsByCat', ["section" => $item->webmasterSection->name, "cat" => $item->id]);
                            }
                        }
                    ?>
        			<div class="col-md-3"  style="margin-bottom:20px;">
        				<a href="{{$section_url}}">
                            <li class="inner1">
                                <img src="{{ URL::to('uploads/sections/'.$item->photo)}}" alt="" width="60">
                                {{$title}}
                            </li>
                        </a>
                    </div>
                    <?php $start++;

                    if ($start%4==0) {
                        echo '</div><div class="row">';
                     } ?>
                @endforeach
            </div>
        </div>
    </div>
         
    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection