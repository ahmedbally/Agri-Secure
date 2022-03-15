@extends('frontEnd.layout')

@section('content')
@include('frontEnd.includes.breadcrumb')

<!-- BLOCK "TYPE 3" -->
<div class="new-block has-pattern2 ptbg pdb100">
    <div class="container type-3-text">
        <div class="row">

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

                if ($Topic->$title_var != "") {
                    $title = $title_var;
                } else {
                    $title = $title_var2;
                }
                if ($Topic->$details_var != "") {
                    $details = $details_var;
                } else {
                    $details = $details_var2;
                }
            ?>
            @if(count($Childs) == 0)
                <div class="col-md-4 mb20">
                    <img src="{{ URL::asset('frontEnd/img/slice.png')}}" class="thumbnail-image img-responsive nwsimg2" style="background-image:url({{ URL::asset('frontEnd/img/organiz/org001-a.jpg')}});">
                    <h4 class="orghead">{{$Topic->$title}}</h4>

                </div>

                <div class="col-md-8">
                    <div class="typography-article">
                        <h4 class="color-blue">{{$Topic->$title}}</h4>
                        <p class="text-justify">
                            ويندرج تحتها {{count($Childs)}} إدارات :
                        </p>
                        <div class="row">
                            @foreach($Childs as $Child)
                                <?php
                                if ($Child->$title_var != "") {
                                    $title = $title_var;
                                } else {
                                    $title = $title_var2;
                                }
                                if ($Child->$details_var != "") {
                                    $details = $details_var;
                                } else {
                                    $details = $details_var2;
                                }
                                $orgLink = route('organizePageByLang', ["id" => $Child->id]);
                                $secondChilds = $Child->fatherSections;
                                ?>
                                <div class="col-md-3 mgb20">
                                    <a href="#"  data-toggle="modal" data-target="#exampleModal{{$Child->id}}">
                                        <div class="orgbt1">{{$Child->$title}}</div>
                                    </a>
                                </div>
                                <div class="modal fade" id="exampleModal{{$Child->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bgmdlgry">
                                                    <h5 class="modal-title" id="exampleModalLabel">عن الإدارة</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body newmod">
                                                    <?php $tasks=($Child->$details)? explode('<hr>',$Child->$details)[0] : ''; ?>
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
                        </div>
                        <hr>
                        {!!$Topic->$details!!}
                    </div>
                </div>
            @endif
        </div>
        @if(count($Childs) > 0)
        <div class="row">
            <div class="col-md-12">
                <h4 class="title orgtitle">شكل توضيحي يوضح هيكل الإدارة :</h4>
                <h5 class="title orgtitle">اضغط على الإدارات لمعرفة الاختصاصات</h5>
                <!-- <img src="img/organiz/org2.jpg" class="img-responsive"> -->
                <div class="row text-center">
                    <div class="col-md-12 organiz1">
                        {{$Topic->$title}}
                    </div>
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
                        @foreach($Childs as $Child)
                            <?php
                            if ($Child->$title_var != "") {
                                $title = $Child->$title_var;
                            } else {
                                $title = $Child->$title_var2;
                            }
                            if ($Child->$details_var != "") {
                                $details = $details_var;
                            } else {
                                $details = $details_var2;
                            }
                            $orgLink = route('organizePageByLang', ["id" => $Child->id]);
                            $secondSections = $Child->fatherSections;
                            //echo count($Childs); die();
                            $chCount=count($Childs);
                            ?>
                            <li class="treeli @if(count($secondSections)>0 || $chCount<4) col-md-4 @elseif($chCount==4) col-md-3 @else col-md-2 @endif">
                                @if(count($secondSections)>0)
                                    <a href="{{$orgLink}}">
                                        <div class="organiz2-{{$class1[$i]}}">
                                            {{$title}}
                                        </div>
                                    </a>
                                @else
                                    <a href="#" data-toggle="modal" data-target="#exampleModal{{$Child->id}}">
                                        <div class="organiz2-{{$class1[$i]}}">
                                            {{$title}}
                                        </div>
                                    </a>

                                    <div class="modal fade" id="exampleModal{{$Child->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bgmdlgry">
                                                    <h5 class="modal-title" id="exampleModalLabel">عن الإدارة</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body newmod">
                                                    <?php $tasks=($Child->$details)? explode('<hr>',$Child->$details)[0] : ''; ?>
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
                                        $orgLink = route('organizePageByLang', ["id" => $secondSec->id]);
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
                                                        <?php $tasks=($secondSec->$details)?explode('<hr>',$secondSec->$details)[0]:''; ?>
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

@include('frontEnd.includes.visits')
@endsection
