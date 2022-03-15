@extends('frontEnd.layout')

@section('content')
    @include('frontEnd.includes.breadcrumb')
    <div class="new-block has-pattern2">
        <div class="container type-3-text">
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
                            $topic_link_url = url($Topic->$slug_var);
                        } else {
                            $topic_link_url = route('FrontendTopic', ["section" => $Topic->webmasterSection->name, "id" => $Topic->id]);
                        }
                    ?>
                    <div class="blog-post style-3">
                        <div class="row">
                            <div class="col-sm-4 col-md-2">
                                <a href="{{$topic_link_url}}" class="thumbnail-entry"><img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="thumbnail-image img-responsive nwsimg" style="background-image:url({{ URL::to('uploads/topics/'.$Topic->photo_file)}});"></a>
                                <div class="clear"></div>
                            </div>
                            <div class="col-sm-8 col-md-10">
                                <div class="data">
                                    <a class="title color-blue" href="{{$topic_link_url}}">{{$title}}</a>

                                    @if(count($Topic->webmasterSection->customFields) >0)
                                        <?php
                                        $cf_title_var = "title_" . trans('backLang.boxCode');
                                        $cf_title_var2 = "title_" . trans('backLang.boxCodeOther');
                                        ?>
                                        @foreach($Topic->webmasterSection->customFields as $customField)
                                            <?php
                                            if ($customField->$cf_title_var != "") {
                                                $cf_title = $customField->$cf_title_var;
                                            } else {
                                                $cf_title = $customField->$cf_title_var2;
                                            }

                                            $cf_saved_val = "";
                                            $cf_saved_val_array = array();
                                            if (count($Topic->fields) > 0) {
                                                foreach ($Topic->fields as $t_field) {
                                                    if ($t_field->field_id == $customField->id) {
                                                        if ($customField->type == 7) {
                                                            // if multi check
                                                            $cf_saved_val_array = explode(", ", $t_field->field_value);
                                                        } else {
                                                            $cf_saved_val = $t_field->field_value;
                                                        }
                                                    }
                                                }
                                            }
                                            ?>

                                            @if(($cf_saved_val!="" || count($cf_saved_val_array) > 0) && ($customField->lang_code == "all" || $customField->lang_code == trans('backLang.boxCode')))
                                                @if($customField->type ==4)
                                                    <p class="evetime"><span>{!!  $cf_title !!} :</span>{!! date('Y-m-d', strtotime($cf_saved_val)) !!}</p>
                                                    <!-- <p class="evetime"><span>{!!  $cf_title !!} :</span>الأربعاء 20 يناير - 11 صباحاً</p> -->
                                                @else
                                                    <p class="eveinfo"><span>{!!  $cf_title !!} :</span>{!! $cf_saved_val !!}</p>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
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

    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection
