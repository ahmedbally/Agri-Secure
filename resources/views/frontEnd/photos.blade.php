@extends('frontEnd.layout')

@section('content')
    @include('frontEnd.includes.breadcrumb')
    <div class="new-block has-pattern2">
        <div class="container type-3-text">
            <div class="row">
                @if($Topics->total() > 0)
                    <?php
                        $title_var = "title_" . trans('backLang.boxCode');
                        $title_var2 = "title_" . trans('backLang.boxCodeOther');
                        $details_var = "details_" . trans('backLang.boxCode');
                        $details_var2 = "details_" . trans('backLang.boxCodeOther');
                        $slug_var = "seo_url_slug_" . trans('backLang.boxCode');
                        $slug_var2 = "seo_url_slug_" . trans('backLang.boxCodeOther');
                        $i = 0;
                    ?>
                    @foreach($Topics as $Topic)
                        <?php
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
                        // print_r($Topic->photos[0]->file); die();
                        $mainPhoto=($Topic->photo_file!='')?$Topic->photo_file : $Topic->photos[0]->file;
                        // set row div

                            if ($Topic->$slug_var != "" && Helper::GeneralWebmasterSettings("links_status")) {
                                $topic_link_url = url($Topic->$slug_var);
                            } else {
                                $topic_link_url = route('FrontendTopic', ["section" => $Topic->webmasterSection->name, "id" => $Topic->id]);
                            }
                        ?>
                        <!-- BLOCK "TYPE 3" -->
                        <?=($i > 1 && ($i % 4 == 0))? "</div><div class='row'>":'';?>
                        <div class="col-md-3">
                            <a href="{{$topic_link_url}}" class="thumbnail-entry">
                                <div class="mgb20">
                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="img-responsive nwsimg" style="background-image:url({{ URL::to('uploads/topics/'.$mainPhoto) }});">
                                    <p class="title ghead" href="{{$topic_link_url}}">{{$title}}</p>
                                </div>
                            </a>
                        </div>
                        <?php $i++; ?>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection
