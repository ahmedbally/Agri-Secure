@extends('frontEnd.layout')

@section('content')
    @include('frontEnd.includes.breadcrumb')
    <div class="block type-7 scroll-to-block pdtb50">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
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
                            if (($i == 1 && count($Categories) > 0) || ($i == 2 && count($Categories) == 0)) {
                                $i = 0;
                                echo "</div><div class='row'>";
                            }
                            if ($Topic->$slug_var != "" && Helper::GeneralWebmasterSettings("links_status")) {
                                $topic_link_url = url($Topic->$slug_var);
                            } else {
                                $topic_link_url = route('FrontendTopic', ["section" => $Topic->webmasterSection->name, "id" => $Topic->id]);
                            }
                        ?>
                        <a href="{{$Topic->fields[0]->field_value}}" target="_blanck">
                            <div class="vtbox">
                                <img src="{{ URL::asset('frontEnd/img/world.svg')}}">
                                <p>{{ $title }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection
