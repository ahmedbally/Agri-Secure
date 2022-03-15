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
                        <h4 class="color-blue">{{$title}}</h4>
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

                        {!! $details !!}                                
                    </div>                          
                </div>

            </div>
        </div>
    </div>

    @include('frontEnd.includes.visits')


@endsection