@extends('frontEnd.layout')

@section('content')
    @include('frontEnd.includes.breadcrumb')       
    <div class="new-block has-pattern2">
        <div class="container type-3-text">
            <div class="col-md-12">
            @if($Topics->total() > 0)
                <?php
                    $title_var = "title_" . trans('backLang.boxCode');
                    $title_var2 = "title_" . trans('backLang.boxCodeOther');
                    $details_var = "details_" . trans('backLang.boxCode');
                    $details_var2 = "details_" . trans('backLang.boxCodeOther');
                    $slug_var = "seo_url_slug_" . trans('backLang.boxCode');
                    $slug_var2 = "seo_url_slug_" . trans('backLang.boxCodeOther');
                ?>
                @foreach($Topics as $Topic)
                    <?php
                    if ($Topic->$title_var != "") {
                        $title = $Topic->$title_var;
                    } else {
                        $title = $Topic->$title_var2;
                    }
                    if ($Topic->$details_var != "") {
                        $details = $details_var;
                    } else {
                        $details = $details_var2;
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

                    // set row div
                        if ($Topic->$slug_var != "" && Helper::GeneralWebmasterSettings("links_status")) {
                            if (trans('backLang.code') != env('DEFAULT_LANGUAGE')) {
                                $topic_link_url = url(trans('backLang.code') . "/" . $Topic->$slug_var);
                            } else {
                                $topic_link_url = url($Topic->$slug_var);
                            }
                        } else {
                            if (trans('backLang.code') != env('DEFAULT_LANGUAGE')) {
                                $topic_link_url = route('FrontendTopicByLang', ["lang" => trans('backLang.code'), "section" => $Topic->webmasterSection->name, "id" => $Topic->id]);
                            } else {
                                $topic_link_url = route('FrontendTopic', ["section" => $Topic->webmasterSection->name, "id" => $Topic->id]);
                            }
                        }
                    ?>

                    <div class="blog-post style-3">
                        <div class="row">
                            <div class="col-sm-4 col-md-2">
                                <a href="{{$topic_link_url}}" class="thumbnail-entry"><img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="thumbnail-image img-responsive nwsimg" style="background-image:url({{ URL::to('uploads/topics/'.$Topic->photo_file) }});"></a>
                                <div class="clear"></div>
                            </div>
                            <div class="col-sm-8 col-md-10">
                                <div class="data">
                                    <a class="title color-blue" href="{{$topic_link_url}}">{{$title}}</a>
                                    <div class="description text-justify">
                                        {{str_limit(strip_tags($Topic->$details),$limit = 400, $end = '...') }}
                                        <a href="{{$topic_link_url}}" class="more-btn"><b>{{trans('frontLang.readMore')}}</b></a>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif  
            </div>
        </div>
    </div>
         
    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection