@extends('frontEnd.layout')

@section('content')
    @include('frontEnd.includes.breadcrumb')

<!--     <div class="new-block has-pattern2">
                <div class="container type-3-text">


                    <div class="row">
                        <div class="col-md-3">
                            <a href="#">
                                <img src="img/slice.png" class="rptimg" style="background-image:url(img/report001.jpg);">
                                <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>
                            </a>
                            <div class="twbtn">
                                <a class="viewbtn">عرض</a>
                                <a class="dowbtn">تحميل</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <a href="#">
                                <img src="img/slice.png" class="rptimg" style="background-image:url(img/report002.jpg);">
                                <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>
                            </a>
                            <div class="twbtn">
                                <a class="viewbtn">عرض</a>
                                <a class="dowbtn">تحميل</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <a href="#">
                                <img src="img/slice.png" class="rptimg" style="background-image:url(img/report001.jpg);">
                                <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>
                            </a>
                            <div class="twbtn">
                                <a class="viewbtn">عرض</a>
                                <a class="dowbtn">تحميل</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <a href="#">
                                <img src="img/slice.png" class="rptimg" style="background-image:url(img/report002.jpg);">
                                <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>
                            </a>
                            <div class="twbtn">
                                <a class="viewbtn">عرض</a>
                                <a class="dowbtn">تحميل</a>
                            </div>
                        </div>
                    </div>

                    <hr class="splithr">

                </div>
            </div> -->
    <?php
    $title_var = "title_" . trans('backLang.boxCode');
    $title_var2 = "title_" . trans('backLang.boxCodeOther');
    $details_var = "details_" . trans('backLang.boxCode');
    $details_var2 = "details_" . trans('backLang.boxCodeOther');
    $slug_var = "seo_url_slug_" . trans('backLang.boxCode');
    $slug_var2 = "seo_url_slug_" . trans('backLang.boxCodeOther');
    $i = 0;
    ?>
    <div class="new-block has-pattern2 type-14 ta3dodat">
        @if($CurrentCategory->father_id==0 && $section=='library')
            @php
                $LatestLibrary = App\Section::where([['status', 1], ['webmaster_id', 12],['father_id',$CurrentCategory->id]])->orderby('row_no', 'asc')->limit(5)->get();
            @endphp
            <div class="row tabs-switch-container">
                <div class="col-md-3">
                    <div class="tabs-limit-container">
                        <?php
                        $active=3;
                        ?>
                        @foreach($LatestLibrary as $item)
                            <?php
                            // print_r($item); die();
                            if ($item->$title_var != "") {
                                $title = $item->$title_var;
                            } else {
                                $title = $item->$title_var2;
                            }
                            ?>

                            <div class="tabs-switch wow fadeInLeft animated @if($active==3) active @endif" data-wow-delay="0.{{$active}}s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">
                                <img src="{{ URL::to('uploads/sections/'.$item->photo)}}" width="35" alt=""><span>{{$title}}</span>
                            </div>
                            <?php $active++; ?>
                        @endforeach

                        <div class="clear"></div>
                    </div>
                </div>
                <div class="col-md-9 wow fadeInUp animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                    <?php $active=true; ?>
                    @foreach($LatestLibrary as $Library)
                        <?php
                        $category_topics = array();
                        $TopicCategories = App\TopicCategory::where('section_id', $Library->id)->get();
                        foreach ($TopicCategories as $category) {
                            $category_topics[] = $category->topic_id;
                        }
                        ?>
                        <div class="row tabs-entry" style="display: @if($active) block @else none @endif;">
                            <?php
                            $libraryTopics = App\Topic::where([['webmaster_id', '=', 12], ['status', 1], ['expire_date', '>=', date("Y-m-d")], ['expire_date', '<>', null]])->orWhere([['webmaster_id', '=', 12], ['status', 1], ['expire_date', null]])->whereIn('id', $category_topics)->orderby('row_no', 'asc')->get();
                            ?>
                            @foreach($libraryTopics as $item)
                                <?php
                                $libraryTopicsAll[]=$item;
                                if ($item->$title_var != "") {
                                    $title = $item->$title_var;
                                } else {
                                    $title = $item->$title_var2;
                                }
                                ?>
                                <div class="col-sm-4">
                                    <div class="cell-view">
                                        @if($item->photo_file !="")
                                            <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::to('uploads/topics/'.$item->photo_file) }})"  alt="{{ $title }}">
                                        @endif
                                        <div class="tabs-title2">{{ $title }}</div>

                                        @if($item->attach_file)
                                            @guest
                                                <div class="col-md-12">
                                                    <div class="twbtn">
                                                        <a href="{{ URL('/login') }}" class="viewbtn">سجل دخول للعرض</a>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-12">
                                                    <div class="twbtn">
                                                        <a href="https://drive.google.com/viewerng/viewer?embedded=true&url=@if(env('APP_DEBUG'))http://www.africau.edu/images/default/sample.pdf @else{{URL::to('uploads/topics/'.$item->attach_file)}}@endif" class="viewbtn" data-toggle="modal" data-target="#pdfPreview{{$item->id}}">{{trans('frontLang.view')}}</a>
                                                        <a href="{{ URL::to('uploads/topics/'.$item->attach_file) }}" class="dowbtn" download>{{trans('frontLang.download')}}</a>
                                                    </div>
                                                </div>
                                            @endguest
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>


                        <?php $active=false; ?>
                    @endforeach
                </div>
            </div>
        @else
        <div class="container type-3-text">
            <div class="row">
            @if($Topics->total() > 0)
                @foreach($Topics as $Topic)
                    <?php
                    // print_r($Topic->attach_file); die();
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
                    <?=($i > 1 && ($i % 4 == 0))? "</div><div class='row'>":'';?>

                    <div class="col-md-3">
                        <a href="#">
                            <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::to('uploads/topics/'.$Topic->photo_file) }});">
                            <div class="tabs-title2">{{$title}}</div>
                        </a>
                        @if($Topic->attach_file)

                        @guest
                            <div class="twbtn">
                                <a href="{{ URL('/login') }}" class="viewbtn">سجل دخول للعرض</a>
                            </div>
                        @else
                        <div class="twbtn">
                            <a href="https://drive.google.com/viewerng/viewer?embedded=true&url=@if(env('APP_DEBUG'))http://www.africau.edu/images/default/sample.pdf @else{{URL::to('uploads/topics/'.$Topic->attach_file)}}@endif" class="viewbtn" data-toggle="modal" data-target="#pdfPreview{{$Topic->id}}">{{trans('frontLang.view')}}</a>
                            <a href="{{ URL::to('uploads/topics/'.$Topic->attach_file) }}" class="dowbtn" download>{{trans('frontLang.download')}}</a>
                        </div>
                        @endguest
                        @endif
                    </div>

                    <div class="modal fade" id="pdfPreview{{$Topic->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document" style="width: 90%">
                            <div class="modal-content">
                                <div class="modal-header bgmdlgry">
                                    <h5 class="modal-title" id="exampleModalLabel">{{trans('frontLang.preview')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body newmod">
                                    <embed src="https://drive.google.com/viewerng/viewer?embedded=true&url=@if(env('APP_DEBUG'))http://www.africau.edu/images/default/sample.pdf @else{{URL::to('uploads/topics/'.$Topic->attach_file)}}@endif" width="100%" height="100%" style="min-height: 450px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++?>

                @endforeach
            @endif
            </div>
        </div>
        @endif
    </div>

    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection
