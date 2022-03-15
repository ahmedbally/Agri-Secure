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
                <h3><i class="material-icons">&#xe02e;</i> تصنيفات قواعد البيانات</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ trans('backLang.home') }}</a> /
                    <a href="{{route("sections",16)}}">قواعد البيانات</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{route("sections",16)}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{Form::open(['route'=>['databaseImport'],'method'=>'POST', 'files' => true ])}}
                <div class="form-group row">
                    <label for="database"
                           class="col-sm-2 form-control-label">قواعد البيانات
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::select('database',$imports, '',array('class' => 'form-control','id'=>'database','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="file_ar"
                           class="col-sm-2 form-control-label">ملف EXCEL
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::file("file", array('class' => 'form-control','id'=>'file_ar','accept'=>"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) !!}
                    </div>
                </div>
                <div class="form-group row m-t-md">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> استيراد</button>
                        <a href="{{route("sections",16)}}"
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

