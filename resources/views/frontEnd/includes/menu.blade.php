<?php $segment1= Request::segment( 1 );
    // Get list of footer menu links by group Id
    // $HeaderMenuLinks = Helper::MenuList(Helper::GeneralWebmasterSettings("header_menu_id"));
    $LatestLibrary = App\Section::where([['status', 1], ['webmaster_id', 12],['father_id',0]])->orderby('row_no', 'asc')->get();
    $analyticsSections = App\Section::where([['status', 1], ['webmaster_id', 16],['father_id',0]])->orderby('row_no', 'asc')->get();
    $LatestAgriCounter = App\Section::where([['status', 1], ['webmaster_id', 15]])->orwhere([['status', 1], ['webmaster_id', 15]])->orderby('row_no', 'asc')->limit(5)->get();

    $title_var = "title_" . trans('backLang.boxCode');
    $title_var2 = "title_" . trans('backLang.boxCodeOther');
    $details_var = "details_" . trans('backLang.boxCode');
    $details_var2 = "details_" . trans('backLang.boxCodeOther');
    $slug_var = "seo_url_slug_" . trans('backLang.boxCode');
    $slug_var2 = "seo_url_slug_" . trans('backLang.boxCodeOther');
?>
<nav>
    <ul>
        <li><a class="pdhrz3 @if($segment1=='') act @endif" href="{{url('/')}}">{{trans('frontLang.home')}}</a>
		<li><a class="pdhrz3 @if($segment1=='organize') act @endif" href="{{url('/organize')}}">الهيكل التنظيمي</a>
        </li>
        <li class="submeny">
            <a  class="submeny  pdhrz3 @if(in_array($segment1, ['news','photos','videos','events','media'])) act @endif"  href="{{url('/media')}}">{{trans('frontLang.mediaCenter')}}</a>
            <ul>
                <li><a href="{{url('news')}}">{{trans('backLang.news')}} </a></li>
                <li><a href="{{url('photos')}}">{{trans('backLang.photos')}} </a></li>
                <li><a href="{{url('videos')}}">{{trans('backLang.videos')}} </a></li>
                <li><a href="{{url('events')}}">{{trans('backLang.events')}} </a></li>
            </ul>
        </li>
        <li>
            <a class="pdhrz3" href="{{url('map')}}">الخريطة المحصولية</a>
        </li>
<!--         <li class="submeny">
            <a class="submeny  pdhrz3">التعدادات الزراعية</a>
            <ul>
                <li><a href="#">التعدادات السابقة</a></li>
                <li><a href="#">دراسات مقارنة</a></li>
            </ul>
        </li> -->
        <li class="submeny">
            <a class="submeny pdhrz3 @if($segment1=='agri-counter') act @endif" href="{{url('/agri-counter')}}" >{{ trans('backLang.agri-counter') }}</a>
            <ul>
                @foreach($LatestAgriCounter as $item)
                    <?php
                        // print_r($item); die();
                        if ($item->$title_var != "") {
                            $title = $item->$title_var;
                        } else {
                            $title = $item->$title_var2;
                        }
                        if ($item->webmasterSection->$slug_var != "" && Helper::GeneralWebmasterSettings("links_status")) {
                            $section_url = url($item->webmasterSection->$slug_var);
                        } else {
                            /*if (trans('backLang.code') != env('DEFAULT_LANGUAGE')) {
                                $section_url = url(trans('backLang.code') . "/" . $item->webmasterSection->name);
                            } else {
                                $section_url = url($item->webmasterSection->name);
                            }*/

                            $section_url = route('FrontendTopicsByCat', ["section" => $item->webmasterSection->name, "cat" => $item->id]);
                        }


                    ?>

                    <li><a href="{{$section_url}}">{{$title}}</a></li>
                @endforeach

            </ul>
        </li>
        <li class="submeny">
            <a class="submeny pdhrz3 @if($segment1=='library') act @endif" href="{{url('/library')}}">اصدارات القطاع</a>
            <ul>
                @foreach($LatestLibrary as $item)
                    <?php
                        // print_r($item); die();
                        if ($item->$title_var != "") {
                            $title = $item->$title_var;
                        } else {
                            $title = $item->$title_var2;
                        }
                        if ($item->webmasterSection->$slug_var != "" && Helper::GeneralWebmasterSettings("links_status")) {
                            $section_url = url($item->webmasterSection->$slug_var);
                        } else {
                            /*if (trans('backLang.code') != env('DEFAULT_LANGUAGE')) {
                                $section_url = url(trans('backLang.code') . "/" . $item->webmasterSection->name);
                            } else {
                                $section_url = url($item->webmasterSection->name);
                            }*/
                            $section_url = route('FrontendTopicsByCat', ["section" => $item->webmasterSection->name, "cat" => $item->id]);
                        }


                    ?>

                    <li><a href="{{($item->id!=48)? $section_url : 'http://agri.vertex-infsys.com/crop_prices_show.aspx'}}" {{($item->id==48)? 'target="_blank"' : ''}}>{{$title}}</a></li>
                @endforeach

            </ul>
        </li>
        <li class="submeny">
            <a class="submeny pdhrz3 @if($segment1=='analytics') act @endif" href="{{route('FrontendTopics','databases')}}">قواعد البيانات</a>
            <ul>
                @foreach($analyticsSections as $item)
                    <?php
                        if ($item->$title_var != "") {
                            $title = $item->$title_var;
                        } else {
                            $title = $item->$title_var2;
                        }
                        if ($item->webmasterSection->$slug_var != "" && Helper::GeneralWebmasterSettings("links_status")) {
                            $section_url = url($item->webmasterSection->$slug_var);
                        } else {
                            $section_url = route('FrontendTopicsByCat', ["section" => $item->webmasterSection->name, "cat" => $item->id]);
                        }
                    ?>

                    <li><a href="{{$section_url}}">{{$title}}</a></li>
                @endforeach
            </ul>
        </li><!--
        <li>
            <a class="pdhrz3" href="#">إحصاءات ذات صلة</a>
        </li> -->
        <li class="submeny">
            <a class="submeny  pdhrz3">رأيك يهمنا</a>
            <ul>
                <li><a href="{{url('/contact')}}">{{trans('frontLang.contactUs')}}</a></li>
                <li><a href="{{url('polls')}}">شارك رأيك</a></li>
            </ul>
        </li>
    </ul>
</nav>
