    @extends('frontEnd.layout')



    @section('content')

        <!-- start Home Slider -->

        @include('frontEnd.includes.slider')

        <!-- end Home Slider -->





    <!--<div class="new-block pd20 nobrdr">

        <div class="container type-3-text">

            <div class="row page-tagline">

                <div class="col-md-10 col-md-offset-1 wow flipInX" data-wow-delay="0.3s">

                    <h2 class="title nwtitle">الخريطة المحصولية</h2>



                </div>

            </div>



        </div>

    </div>-->

    <div class="new-block has-pattern pt30">

        <div class="container type-3-text">



            <div class="row">



                <div class="col-md-6">

                <div><h2 style="font-family: 'black';color: #222;padding-bottom: 32px;font-size: 24px">{{trans('backLang.news')}}</h2></div>

                             <?php

            $title_var = "title_" . trans('backLang.boxCode');

            $title_var2 = "title_" . trans('backLang.boxCodeOther');

            $details_var = "details_" . trans('backLang.boxCode');

            $details_var2 = "details_" . trans('backLang.boxCodeOther');

            $slug_var = "seo_url_slug_" . trans('backLang.boxCode');

            $slug_var2 = "seo_url_slug_" . trans('backLang.boxCodeOther');

            $section_url = "";

            ?>

            @foreach($LatestNews as $HomeTopic)

                <?php

                if ($HomeTopic->$title_var != "") {

                    $title = $HomeTopic->$title_var;

                } else {

                    $title = $HomeTopic->$title_var2;

                }

                if ($HomeTopic->$details_var != "") {

                    $details = $details_var;

                } else {

                    $details = $details_var2;

                }



                if ($HomeTopic->$slug_var != "" && Helper::GeneralWebmasterSettings("links_status")) {
                    $topic_link_url = url($HomeTopic->$slug_var);
                } else {
                    $topic_link_url = route('FrontendTopic', ["section" => $HomeTopic->webmasterSection->name, "id" => $HomeTopic->id]);
                }



                ?>

            <div class="paddings-container mgb30">

                <div class="row">

                    <div class="col-md-4">

                        <a href="{{$topic_link_url}}">

                            <img src="{{ URL::asset('frontEnd/img/slice.png')}}" alt="{{ $title }}" class="thumbnail-image img-responsive nwsimg" style="background-image:url({{ URL::to('uploads/topics/'.$HomeTopic->photo_file) }});">

                        </a>

                    </div>

                    <div class="col-md-8">

                        <div class="name mgb10 titnewc"><a href="{{$topic_link_url}}">{{ $title }}</a></div>

                        <div class="position nwdat">{{$HomeTopic->updated_at->toDateString()}}</div>

                        <div class="description descnew">{!!str_limit(strip_tags($HomeTopic->$details),$limit = 250, $end = '...') !!}</div>

                    </div>

                </div>

            </div>

            @endforeach

                </div>



                <div class="col-md-6">

                    @if($bossSpeach)

                    {!! $bossSpeach->details_ar !!}

                    @endif



                    <div class="row">

                        <div class="mr30">

                            <div class="col-md-6">

                                <div class="compare-column-entry wow fadeInLeft animated animated" style="visibility: visible; animation-name: fadeInLeft;">

                                    <div class="wrapper padd001">

                                        <div class="price nwtitle">زوار الموقع</div>

                                        <div class="vistimg">

                                            <img src="http://agri.sprograming.com/frontEnd/img/businessman.svg" width="80" alt="">

                                        </div>

                                        <h1 class="vistcount">{{\App\Topic::sum('visits')+ \App\Visit::sum('visits')}}</h1>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="compare-column-entry wow fadeInLeft animated animated" style="visibility: visible; animation-name: fadeInLeft;">

                                    <div class="wrapper padd001">

                                        <div class="price nwtitle">عدد المسجلين</div>

                                        <div class="vistimg">

                                            <img src="http://agri.sprograming.com/frontEnd/img/boss.svg" width="80" alt="">

                                        </div>

                                        <h1 class="vistcount">{{\App\User::where('permissions_id',3)->count()}}</h1>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-12">
                                <p class="padd002">منذ تاريخ الاطلاق : <span class="orange"> 15 يونيو 2020</span></p>
                            </div>



                            <div class="col-md-12">
                                <a href="http://agri.sprograming.com/contact" class="bannerimg">
                                    <img src="http://agri.sprograming.com/frontEnd/img/bg_banner001.jpg" alt="">
                                </a>
                            </div>



                            <div class="col-md-12">
                                <a href="http://agri.sprograming.com/polls" class="bannerimg">
                                    <img src="http://agri.sprograming.com/frontEnd/img/bg_banner002.jpg" alt="">
                                </a>
                            </div>


                            <div class="col-md-12">
                                <a href="#" data-toggle="modal" data-target="#gehatModal" class="bannerimg">
                                    <img src="http://agri.sprograming.com/frontEnd/img/bg_banner003.jpg" alt="">
                                </a>
                            </div>


                            <div class="col-md-12">

                                @if(count($sites)>0)

                                    <div class="compare-column-entry wow fadeInLeft animated" style="visibility: visible; animation-name: fadeInLeft;margin-top: 15px;">

                                        <div class="wrapper sites padd1">

                                            <div class="price nwtitle">{{trans('frontLang.sites')}}</div>

                                            <div class="imposite">

                                                <?php

                                                $title_var = "title_" . trans('backLang.boxCode');

                                                $title_var2 = "title_" . trans('backLang.boxCodeOther');

                                                ?>

                                                @foreach($sites as $Item)

                                                    <?php $title =($Item->$title_var != "")? $Item->$title_var : $Item->$title_var2; ?>

                                                    <a href="{{(isset($Item->fields[0]))?$Item->fields[0]->field_value : ''}}" target="_blanck">{{$title}}</a>

                                                @endforeach

                                            </div>

                                        </div>

                                    </div>

                                @endif

                            </div>

                        </div>



                    </div><!---->

                </div>

            </div>

        </div>

    </div>





    <!--

    <div class="new-block graydark">

        <div class="container type-3-text">

            <div class="row page-tagline">

                <div class="col-md-12 wow flipInX" data-wow-delay="0.3s">

                    <h2 class="title nwtitle wht">إعلانات</h2>

                    <div>

                         <img class="img-responsive" src="{{ URL::asset('frontEnd/img/ads/ads1.jpg')}}" />

                    </div>

                </div>

            </div>

        </div>

    </div>

    -->







    <!--

    <div class="new-block greendark">

        <div class="container type-3-text">

            <div class="row page-tagline">

                <div class="col-md-12 wow flipInX" data-wow-delay="0.3s">

                    <h2 class="title nwtitle wht">إعلانات</h2>

                    <div class="col-md-6">

                         <img class="img-responsive" src="{{ URL::asset('frontEnd/img/ads/ads2.jpg')}}" />

                    </div>

                    <div class="col-md-6">

                         <img class="img-responsive" src="{{ URL::asset('frontEnd/img/ads/ads3.jpg')}}" />

                    </div>

                </div>

            </div>

        </div>

    </div>

    -->

    <?php $libraryTopicsAll=[]; ?>

    @if(count($LatestLibrary)>0)

    <div class="new-block type-14 pt0">

        <div class="container">

            <div class="row page-tagline">

                <div class="col-md-6 col-md-offset-3 wow flipInX animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: flipInX;">

                    <h2 class="title nwtitle">اصدارات القطاع</h2>

                </div>

            </div>

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

                            $libraryTopics = App\Topic::where([['webmaster_id', '=', 12], ['status', 1], ['expire_date', '>=', date("Y-m-d")], ['expire_date', '<>', null]])->orWhere([['webmaster_id', '=', 12], ['status', 1], ['expire_date', null]])->whereIn('id', $category_topics)->limit(3)->get();

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

                        <div class="col-md-12">

                            <div class="tabmore">

                                <h2>للإطلاع علي كافة الأصدارات برجاء الضغط هنا</h2>

                                <a href="{{route('FrontendTopicsByCat', ['section' => $Library->webmasterSection->name, 'cat' => $Library->id])}}">المزيد</a>

                            </div>

                        </div>

                    </div>





                    <?php $active=false; ?>

                    @endforeach

                </div>

            </div>



        </div>

    </div>



    @foreach($libraryTopicsAll as $item)

        <div class="modal fade" id="pdfPreview{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog" role="document" style="width: 90%">

                <div class="modal-content">

                    <div class="modal-header bgmdlgry">

                        <h5 class="modal-title" id="exampleModalLabel">{{trans('frontLang.preview')}}</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body newmod">

                        <embed src="https://drive.google.com/viewerng/viewer?embedded=true&url=@if(env('APP_DEBUG'))http://www.africau.edu/images/default/sample.pdf @else{{URL::to('uploads/topics/'.$item->attach_file)}}@endif" width="100%" height="100%" style="min-height: 450px">

                    </div>

                </div>

            </div>

        </div>

    @endforeach

    @endif



    <!-- <div class="new-block type-14">

        <div class="container">

            <div class="row page-tagline">

                <div class="col-md-6 col-md-offset-3 wow flipInX animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: flipInX;">

                    <h2 class="title nwtitle">المكتبة الإلكترونية</h2>

                </div>

            </div>

            <div class="row tabs-switch-container">

                <div class="col-md-3">

                    <div class="tabs-limit-container">

                        <div class="tabs-switch wow fadeInLeft animated active" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">

                            <img src="{{ URL::asset('frontEnd/img/001.svg')}}" width="35" alt=""><span>موارد زراعية</span>

                        </div>

                        <div class="tabs-switch wow fadeInLeft animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">

                            <img src="{{ URL::asset('frontEnd/img/002.svg')}}" width="35" alt=""><span>أمن غذائي</span>

                        </div>

                        <div class="tabs-switch wow fadeInLeft animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">

                            <img src="{{ URL::asset('frontEnd/img/003.svg')}}" width="35" alt=""><span>احصائيات زراعية</span>

                        </div>

                        <div class="tabs-switch wow fadeInLeft animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">

                            <img src="{{ URL::asset('frontEnd/img/004.svg')}}" width="35" alt=""><span>تقارير احصائية</span>

                        </div>



                        <div class="clear"></div>

                    </div>

                </div>

                <div class="col-md-9 wow fadeInUp animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">

                    <div class="row tabs-entry" style="display: block;">

                        <div class="col-sm-4">

                            <div class="cell-view">

                                <a href="#">

                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::asset('frontEnd/img/report001.jpg')}});">

                                    <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>

                                </a>

                            </div>

                        </div>

                        <div class="col-sm-4">

                            <div class="cell-view">

                                <a href="#">

                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::asset('frontEnd/img/report002.jpg')}});">

                                    <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>

                                </a>

                            </div>

                        </div>

                        <div class="col-sm-4">

                            <div class="cell-view">

                                <a href="#">

                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::asset('frontEnd/img/report001.jpg')}});">

                                    <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>

                                </a>

                            </div>

                        </div>

                    </div>



                    <div class="row tabs-entry" style="display: none;">

                        <div class="col-sm-4">

                            <div class="cell-view">

                                <a href="#">

                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::asset('frontEnd/img/report003.jpg')}});">

                                    <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>

                                </a>

                            </div>

                        </div>



                        <div class="col-sm-4">

                            <div class="cell-view">

                                <a href="#">

                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::asset('frontEnd/img/report001.jpg')}});">

                                    <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>

                                </a>

                            </div>

                        </div>



                        <div class="col-sm-4">

                            <div class="cell-view">

                                <a href="#">

                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::asset('frontEnd/img/report004.jpg')}});">

                                    <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>

                                </a>

                            </div>

                        </div>



                    </div>



                    <div class="row tabs-entry" style="display: none;">

                        <div class="col-sm-4">

                            <div class="cell-view">

                                <a href="#">

                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::asset('frontEnd/img/report001.jpg')}});">

                                    <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>

                                </a>

                            </div>

                        </div>



                        <div class="col-sm-4">

                            <div class="cell-view">

                                <a href="#">

                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::asset('frontEnd/img/report002.jpg')}});">

                                    <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>

                                </a>

                            </div>

                        </div>



                        <div class="col-sm-4">

                            <div class="cell-view">

                                <a href="#">

                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::asset('frontEnd/img/report004.jpg')}});">

                                    <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>

                                </a>

                            </div>

                        </div>

                    </div>



                    <div class="row tabs-entry" style="display: none;">

                        <div class="col-sm-4">

                            <div class="cell-view">

                                <a href="#">

                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::asset('frontEnd/img/report001.jpg')}});">

                                    <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>

                                </a>

                            </div>

                        </div>



                        <div class="col-sm-4">

                            <div class="cell-view">

                                <a href="#">

                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::asset('frontEnd/img/report004.jpg')}});">

                                    <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>

                                </a>

                            </div>

                        </div>



                        <div class="col-sm-4">

                            <div class="cell-view">

                                <a href="#">

                                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="rptimg" style="background-image:url({{ URL::asset('frontEnd/img/report003.jpg')}});">

                                    <div class="tabs-title2">نشرة الاحصائيات الزراعية - المحاصيل الشتوية 2016-2017</div>

                                </a>

                            </div>

                        </div>



                    </div>



                </div>

            </div>



        </div>

    </div>

     -->



    <!-- LatestProjects -->

        @if(count($LatestProjects)>0)

        <div class="new-block type-18 scroll-to-block" data-id="how-it-work">

            <div class="container">

                <div class="row page-tagline">

                    <div class="col-md-6 col-md-offset-3 wow flipInX animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: flipInX;">

                        <h2 class="title nwtitle">{{trans('frontLang.LatestProjects')}}</h2>

                        <div class="description">{{trans('frontLang.LatestProjectsSlug')}}</div>

                    </div>

                </div>

                <div class="row tabs-switch-container">

                    <div class="col-md-12 wow fadeInUp animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">

                        <div class="row tabs-entry">

                            <div class="new-block type-8">

                                <div class="container">

                                    <div class="row">

                                        <div class="content-entry col-sm-12">

                                            <div class="accordeon">

                                                <?php

                                                    $title_var = "title_" . trans('backLang.boxCode');

                                                    $title_var2 = "title_" . trans('backLang.boxCodeOther');

                                                    $details_var = "details_" . trans('backLang.boxCode');

                                                    $details_var2 = "details_" . trans('backLang.boxCodeOther');

                                                ?>



                                                @foreach($LatestProjects as $Item)

                                                    <?php

                                                        if ($Item->$title_var != "") {

                                                            $title = $Item->$title_var;

                                                            $details = $Item->$details_var;

                                                        } else {

                                                            $title = $Item->$title_var2;

                                                            $details = $Item->$details_var2;

                                                        }

                                                    ?>

                                                    <div class="entry">

                                                        <div class="title pdr50 fontlg"><span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span>{{$title}}</div>

                                                        <div class="text" style="display: none;">{{$details}}</div>

                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                    </div>

                </div>

            </div>

        </div>

        @endif

    <!-- Clients -->











    <!-- POPUP "VIDEO" -->

    @endsection

