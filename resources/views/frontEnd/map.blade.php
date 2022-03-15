@extends('frontEnd.layout')
@section('content')
<div class="new-block type-inner">
    <div class="container">
        <div class="col-sm-6 col-xs-12 pdt25">الخريطة المحصولية</div>
        <div class="col-sm-6 col-xs-12 text-left path-links">
            <a href="{{ route("Home") }}">الرئيسية</a>
            <a class="active">الخريطة المحصولية</a>
        </div>
    </div>

</div>
<div class="new-block has-pattern2">
    <div class="container">
        <div class="row">
            <div class="col-md-4 type-3-text">
                <select id="season" style="color:#333 ;border: 1px solid #b0b0b0; width: 260px; padding:5px;">
                    <option value="" disabled selected>الموسم</option>
                    <?php
                    $name = "title_" . trans('backLang.boxCode');
                    ?>
                    @foreach(\App\CityCrop::query()->select('season')->groupBy('season')->orderBy('season','ASC')->get() as $year)
                        @if($year->season == 'بدون')
                        <option value="{{$year->season}}">بدون عروة</option>
                        @else
                        <option value="{{$year->season}}">الموسم {{$year->season}}</option>
                        @endif
                    @endforeach

                </select>
                <select id="year" style="color:#333 ;border: 1px solid #b0b0b0; width: 260px; padding:5px;">
                    <option value="" disabled selected>السنة</option>
                    <?php
                    $name = "title_" . trans('backLang.boxCode');
                    ?>
                    @foreach(\App\CityCrop::query()->select('year')->groupBy('year')->orderBy('year','DESC')->get() as $year)
                        <option value="{{$year->year}}">{{$year->year}}</option>
                    @endforeach

                </select>
                <select id="agr" style="color:#333 ;border: 1px solid #b0b0b0; width: 260px; padding:5px;">
                    <option value="" disabled selected>المحاصيل</option>
                    <?php
                    $name = "title_" . trans('backLang.boxCode');
                    ?>
                    @foreach(\App\Crop::all() as $crop)
                    <option value="{{$crop->id}}">{{$crop->$name}}</option>
                    @endforeach

                </select>
                <img id="crop_image" style="position: relative;
            z-index: 9;
            float: right;
            /* clear: both; */
            margin-bottom: 15px;
            color: rgb(51, 51, 51);
            border: 1px solid rgb(176, 176, 176);
            width: 39px;
            height: 39px;
            /* padding: 5px; */
            /* display: block;" src="https://cdn3.iconfinder.com/data/icons/food-drinks-and-agriculture-1/64/C_Crops_Sprout-512.png">
                <select id="value" style="color:#333 ;border: 1px solid #b0b0b0; width: 260px; padding:5px;">
                    <option value="" disabled selected>اختر</option>
                    <option value="quantity">الانتاج (طن)</option>
                    <option value="area">المساحة المزروعة (فدان)</option>
                    <option value="productivity">الانتاجية</option>

                </select>
                <button onclick="printJS('agriculture','html');" style="position: relative;
            z-index: 9;
            float: right;
            clear: right;
            display: block;
            margin-bottom: 15px;
            color: rgb(51, 51, 51);
            border: 1px solid rgb(176, 176, 176);
            width: 260px;
            padding: 5px;
            display: block;">طباعة الخريطة</button>
                <button onclick="zoomIn();" style="position: relative;
                z-index: 9;
                float: right;
                clear: right;
                display: block;
                margin-bottom: 15px;
                color: rgb(51, 51, 51);
                border: 1px solid rgb(176, 176, 176);
                width: 130px;
                padding: 5px;
                display: block;">+</button>
                <button onclick="zoomOut();" style="position: relative;
                z-index: 9;
                float: right;
                display: block;
                margin-bottom: 15px;
                color: rgb(51, 51, 51);
                border: 1px solid rgb(176, 176, 176);
                width: 130px;
                padding: 5px;
                display: block;">-</button>
                <h2 style="position: relative;
            z-index: 9;
            float: right;
            /* clear: both; */
            margin-bottom: 15px;
            color: rgb(51, 51, 51);
            font-size: 20px">اضغط علي المحافظة للتفاصيل</h2>
            </div>

            <div class="col-md-8 type-3-text">
                <h2 class="title maptitle"></h2>
                <div id="agriculture" style="width:100%;height:500px">
                </div>
                <div style="color:black;text-align: left;margin-left: 148px;">e-mail: <a href="mailto:hosam.eldin.mahdy@gmail.com">hosam.eldin.mahdy@gmail.com</a></div>
            </div>
        </div>
    </div>
</div>
    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection
