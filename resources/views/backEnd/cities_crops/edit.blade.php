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
                        <a class="nav-link" href="{{route("CitiesCrops")}}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{Form::open(['route'=>['CitiesCropsUpdate',$Crop->id],'method'=>'POST', 'files' => true])}}
                <div class="form-group row">
                    <label for="title_ar"
                           class="col-sm-2 form-control-label">الموسم
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::select('season',['اختر الموسم','بدون'=>'بدون','الشتوي'=>'الشتوي','الصيفي'=>'الصيفي','النيلي'=>'النيلي'], $Crop->season,array('class' => 'form-control','id'=>'season','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title_ar"
                           class="col-sm-2 form-control-label">المحصول
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::select('crop',$Crops, $Crop->Crop->id,array('class' => 'form-control','id'=>'crop','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title_ar"
                           class="col-sm-2 form-control-label">المدينة
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::select('city',$Cities, $Crop->City->id,array('class' => 'form-control','id'=>'city','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title_ar"
                           class="col-sm-2 form-control-label">المركز
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::select('center',$Centers,$Crop->Center->id,array('class' => 'form-control','id'=>'center','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title_ar"
                           class="col-sm-2 form-control-label">الانتاج
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('quantity',$Crop->quantity, array('placeholder' => '','class' => 'form-control','id'=>'quantity','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title_ar"
                           class="col-sm-2 form-control-label">المساحة
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('area',$Crop->area, array('placeholder' => '','class' => 'form-control','id'=>'area','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title_ar"
                           class="col-sm-2 form-control-label">الانتاجية
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('productivity',$Crop->productivity, array('placeholder' => '','class' => 'form-control','id'=>'productivity','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title_ar"
                           class="col-sm-2 form-control-label">السنة
                        @if(Helper::GeneralWebmasterSettings("ar_box_status") && Helper::GeneralWebmasterSettings("en_box_status")){!!  trans('backLang.arabicBox') !!}@endif
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('year',$Crop->year, array('placeholder' => '','class' => 'form-control','id'=>'year','required'=>'', 'dir'=>trans('backLang.rtl'))) !!}
                    </div>
                </div>

                <div class="form-group row m-t-md">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! trans('backLang.update') !!}</button>
                        <a href="{{route("CitiesCrops")}}"
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
        let centers={!! json_encode(\App\Center::all()->groupBy('city_id')->map(function($item){
                    return $item->map(function($item){
                                          return [$item->id,$item->title_ar];
                                    })->toArray();
                    })); !!}
        $("#city").on('change',function () {
            $("#center").html('');
            $("#center").append('<option value="" selected="selected">اختر المركز</option>');
            let cent=centers[$(this).val()];
            (cent?cent:[]).map(function (item) {
                $("#center").append('<option value="'+item[0]+'">'+item[1]+'</option>')
            });
        })
    </script>
@endsection
