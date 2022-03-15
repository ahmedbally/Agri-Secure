@extends('backEnd.layout')
@section('headerInclude')
    <link href="{{ URL::to("backEnd/libs/js/iconpicker/fontawesome-iconpicker.min.css") }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
@endsection
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe3c9;</i> {{ trans('backLang.Crops') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ trans('backLang.home') }}</a> /
                    <a href="">{{ trans('backLang.Crops') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{route("Crops")}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{Form::open(['route'=>['CropsUpdate',$Crop->id],'method'=>'POST', 'files' => true])}}

                @if(Helper::GeneralWebmasterSettings("ar_box_status"))
                    <div class="form-group row">
                        <label for="title_ar"
                               class="col-sm-2 form-control-label">{!!  trans('backLang.cropName') !!}
                            @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                        </label>
                        <div class="col-sm-10">
                            {!! Form::text('title_ar',$Crop->title_ar, array('placeholder' => '','class' => 'form-control','id'=>'title_ar','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                        </div>
                    </div>
                @endif
                @if(Helper::GeneralWebmasterSettings("en_box_status"))
                    <div class="form-group row">
                        <label for="title_en"
                               class="col-sm-2 form-control-label">{!!  trans('backLang.cropName') !!}

                            @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.englishBox') !!}@endif
                        </label>
                        <div class="col-sm-10">
                            {!! Form::text('title_en',$Crop->title_en, array('placeholder' => '','class' => 'form-control','id'=>'title_en','required'=>'', 'dir'=>trans('backLang.ltr'))) !!}
                        </div>
                    </div>
                @endif
                <div class="form-group row">
                    <label for="title_ar"
                           class="col-sm-2 form-control-label">{!!  trans('backLang.cropColor') !!}
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('color',$Crop->color, array('placeholder' => '','class' => 'form-control','id'=>'color','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title_ar"
                           class="col-sm-2 form-control-label">الانتاج
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::select('quantity',[''=>'اختر وحدة','طن'=>'طن','اردب'=>'اردب'], $Crop->quantity,array('class' => 'form-control','id'=>'quantity','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title_ar"
                           class="col-sm-2 form-control-label">المساحة
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::select('area',[''=>'اختر وحدة','فدان'=>'فدان','هيكتار'=>'هيكتار'],$Crop->area,array('class' => 'form-control','id'=>'area','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="file_ar"
                           class="col-sm-2 form-control-label">صوره
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::file("image", array('class' => 'form-control','id'=>'image','accept'=>"image/*")) !!}
                    </div>
                </div>
                <div class="form-group row m-t-md">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! trans('backLang.update') !!}</button>
                        <a href="{{route("Banners")}}"
                           class="btn btn-default m-t"><i class="material-icons">
                                &#xe5cd;</i> {!! trans('backLang.cancel') !!}</a>
                    </div>
                </div>

                {{Form::close()}}
            </div>
        </div>
    </div>



@endsection

@section('footerInclude')

    <script src="{{ URL::to("backEnd/libs/js/iconpicker/fontawesome-iconpicker.js") }}"></script>
    <script>
        $(function () {
            $('.icp-auto').iconpicker({placement: '{{ (trans('backLang.direction')=="rtl")?"topLeft":"topRight" }}'});
        });
    </script>
@endsection
