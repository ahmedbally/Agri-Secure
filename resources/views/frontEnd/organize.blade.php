@extends('frontEnd.layout')

@section('content')
@include('frontEnd.includes.breadcrumb')
<div class="new-block has-pattern2 ptbg pdb100">
    <div class="container type-3-text">
        @if(count($Sections) > 0)
        <!-- BLOCK "TYPE 3" -->
        <div class="new-block has-pattern type-3 ptbg">
            <div class="container type-3-text">
                <!-- <div class="row page-tagline">
                    <div class="col-md-10 col-md-offset-1 wow flipInX" data-wow-delay="0.3s">
                        <h2 class="title nwtitle">الهيكل التنظيمي</h2>

                    </div>
                </div> -->
                <h4 class="title orgtitle">اضغط على الإدارات لمعرفة الاختصاصات</h4>

                <div class="row text-center">
                    <div class="col-md-12 organiz1">رئيس قطاع الشئون الإقتصادية</div>
                </div>

                <div class="row text-center">
                    <?php
                    $title_var = "title_" . trans('backLang.boxCode');
                    $title_var2 = "title_" . trans('backLang.boxCodeOther');
                    $details_var = "details_" . trans('backLang.boxCode');
                    $details_var2 = "details_" . trans('backLang.boxCodeOther');
                    $slug_var = "seo_url_slug_" . trans('backLang.boxCode');
                    $slug_var2 = "seo_url_slug_" . trans('backLang.boxCodeOther');
                    $section_url = "";
                    $class1 = ['a','b','c','d','d','d','d','d','d','d'];
                    $i = 0;
                    ?>

                    <div class="tree">
                        <ul class="treeul">
                        @foreach($Sections as $Section)
                            <?php
                            if ($Section->$title_var != "") {
                                $title = $Section->$title_var;
                            } else {
                                $title = $Section->$title_var2;
                            }
                            if ($Section->$details_var != "") {
                                $details = $details_var;
                            } else {
                                $details = $details_var2;
                            }
                            $orgLink = route('organizePageByLang', ["id" => $Section->id]);
                            $secondSections = $Section->fatherSections;
                            ?>
                            <li class="treeli @if(count($secondSections)>1)col-md-4 @else col-md-2 @endif">
                                @if(count($secondSections)>0)
                                    <a href="{{$orgLink}}">
                                        <div class="organiz2-{{$class1[$i]}}">
                                            {{$title}}
                                        </div>
                                    </a>
                                @else
                                <a href="#" data-toggle="modal" data-target="#exampleModal{{$Section->id}}">
                                    <div class="organiz2-{{$class1[$i]}}">
                                        {{$title}}
                                    </div>
                                </a>

                                <div class="modal fade" id="exampleModal{{$Section->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bgmdlgry">
                                                <h5 class="modal-title" id="exampleModalLabel">عن الإدارة</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body newmod">
                                                <?php $tasks=explode('<hr>',$Section->$details)[0]; ?>
                                                {!!$tasks!!}
                                            </div>
                                            <div class="modal-footer">
                                                <!-- <a class="btn btn-primary org" href="{{$orgLink}}">المزيد عن الإدارة</a> -->
                                                <button type="button" class="btn color-primary cls" data-dismiss="modal">اغلاق</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(count($secondSections)>0)
                                <ul class="treeul">
                                    @foreach($secondSections as $secondSec)
                                        <?php
                                        if ($secondSec->$title_var != "") {
                                            $title = $secondSec->$title_var;
                                        } else {
                                            $title = $secondSec->$title_var2;
                                        }
                                        if ($secondSec->$details_var != "") {
                                            $details = $details_var;
                                        } else {
                                            $details = $details_var2;
                                        }
                                        $orgLink = route('organizePageByLang', ["id" => $Section->id]);
                                        ?>
                                        <li class="treeli @if(count($secondSections)>3)col-md-3 @else col-md-4 @endif ">
                                            <a href="#" data-toggle="modal" data-target="#exampleModal{{$secondSec->id}}">
                                                <div class="organiz3-{{$class1[$i]}}">{{$title}}</div>
                                            </a>
                                        </li>

                                        <div class="modal fade" id="exampleModal{{$secondSec->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bgmdlgry">
                                                        <h5 class="modal-title" id="exampleModalLabel">عن الإدارة</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body newmod">
                                                        <?php $tasks=explode('<hr>',$secondSec->$details)[0]; ?>
                                                        {!!$tasks!!}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <!-- <a class="btn btn-primary org" href="{{$orgLink}}">المزيد عن الإدارة</a> -->
                                                        <button type="button" class="btn color-primary cls" data-dismiss="modal">اغلاق</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            <?php $i++;?>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection
