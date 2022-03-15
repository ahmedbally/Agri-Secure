@extends('frontEnd.layout')
@section('headInclude')
    <link href="{{ URL::asset('frontEnd/css/table-info.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('frontEnd/css/select2.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
    @include('frontEnd.includes.breadcrumb')
<?php
    $title_var = "title_" . trans('backLang.boxCode');
    $title_var2 = "title_" . trans('backLang.boxCodeOther');
    $details_var = "details_" . trans('backLang.boxCode');
    $details_var2 = "details_" . trans('backLang.boxCodeOther');
    $slug_var = "seo_url_slug_" . trans('backLang.boxCode');
    $slug_var2 = "seo_url_slug_" . trans('backLang.boxCodeOther');
    $start=0
?>
    <!-- BLOCK "TYPE 3" -->
<div class="new-block has-pattern2">
    <div class="container type-3-text">

        @if(empty($type) || !in_array($type, ['imp','exp']))
        <div class="row">
            <div class="infooo" width="100%">
                @if(!request()->exists('type_group'))
                <h1 class="col-md-12">تقرير التجارة الخارجية</h1>

                <div class="col-md-3">
                    <strong><span class="control-label">الصنف  :  </span></strong>
                    <select class="selectpicker show-menu-arrow" name="type_group">
                        <option value="">اختر</option>
                        @foreach($select1 as $select)
                            <option value="{{$select->item}}" @if(trim($select->item) == $type_group) selected @endif>{{$select->item}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">العام  من :</span></strong>
                    <select class="selectpicker show-menu-arrow" name="item">
                        <option value="">اختر</option>
                        @foreach($select2 as $select)
                            <option value="{{$select->year}}"  @if($select->year == $item) selected @endif >{{$select->year}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">إلي </span></strong>
                    <select class="selectpicker show-menu-arrow" name="item2">
                        <option value="">اختر</option>
                        @foreach($select3 as $select)
                            <option value="{{$select->year}}"  @if($select->year == $item2) selected @endif >{{$select->year}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="submit" name="Button1" value="بحث" id="Button1" class="btn btn-success" onclick="sendQuery(1);">
                </div>
                @else
                    <h1 class="col-md-10" style="margin-bottom: 20px !important;">
                        صادرات وواردات {{$type_group}} من سنة {{$item}} حتى سنة {{$item2}}
                    </h1>
                    <div class="col-md-2">
                        @if(!request()->exists('draw'))
                            <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{route("databasesSearch",$CurrentCategory->id)}}'">

                            <input type="submit" name="Button1" value="رسم" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{url(request()->fullUrlWithQuery(["draw"=>1]))}}'">
                        @else
                            <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{route("databasesSearch",$CurrentCategory->id)}}'">
                        @endif
                    </div>
                @endif
            </div>
        </div>
            @if(!request()->exists('draw'))
                <div class="table-responsive mgt40">
            <table  class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th rowspan="2">السنة</th>
                        <th colspan="2">الصادرات</th>
                        <th rowspan="2">الدول</th>
                        <th colspan="2">الواردات </th>
                        <th rowspan="2">الدول</th>
                    </tr>
                    <tr>
                      <th>الكمية طن</th>
                      <th>القيمة الف ج </th>
                      <th>الكمية طن</th>
                      <th>القيمة الف ج </th>
                    </tr>
                </thead>
                <tbody class="txtcolor" id="rep6">
                    @if($ListArr)
                        @include("frontEnd.__databases43", ['ListArr'=>$ListArr,'cat'=>$CurrentCategory->id,'item'=>$item,'item2'=>$item2])
                    @endif
                </tbody>
            </table>
        </div>
            @else
                <div class="mgt40">
                    <div id="chartContainerExp" class="col-md-6">FusionCharts XT will load here!</div>
                    <div id="chartContainerImp" class="col-md-6">FusionCharts XT will load here!</div>
                    <div class="row"  style="text-align: center;">
                        <div class="col-md-6">
                            <div class="col-md-4">
                                <button class="btn btn-success enum-options-exp active" onclick="$('.enum-options-exp').removeClass('active');$(this).addClass('active');chartContainerExp.setJSONData(quantityExp);chartContainerExp.render()">الكمية</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success enum-options-exp" onclick="$('.enum-options-exp').removeClass('active');$(this).addClass('active');chartContainerExp.setJSONData(priceExp);chartContainerExp.render()">القيمة</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-4">
                                <button class="btn btn-success enum-options-imp active" onclick="$('.enum-options-imp').removeClass('active');$(this).addClass('active');chartContainerImp.setJSONData(quantityImp);chartContainerImp.render()">الكمية</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success enum-options-imp" onclick="$('.enum-options-imp').removeClass('active');$(this).addClass('active');chartContainerImp.setJSONData(priceImp);chartContainerImp.render()">القيمة</button>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        let quantityExp={
                            "chart": {
                                "caption": "الصادرات",
                                "subCaption": "",
                                "xAxisName": "السنة",
                                "yAxisName": "(الكمية (طن",
                                "decimals": "2",
                                "baseFontSize":"17",
                                "formatNumberScale":"0",
                                "hasRTLText":"1",
                                "setAdaptiveYMin":"1",
                                "theme": "fint"
                            },
                            "data": [
                                    @foreach($ListArr as $row)
                                {
                                    "label": "{{$row->year}}",
                                    "value": "{{$row->exp_quantity}}"
                                },
                                @endforeach

                            ],
                        };
                        let priceExp={
                            "chart": {
                                "caption": "الصادرات",
                                "subCaption": "",
                                "xAxisName": "السنة",
                                "yAxisName": "(القيمة (الف ج",
                                "decimals": "2",
                                "baseFontSize":"17",
                                "formatNumberScale":"0",
                                "hasRTLText":"1",
                                "setAdaptiveYMin":"1",
                                "theme": "fint",
                                "palettecolors": "#fb5607"
                            },
                            "data": [
                                    @foreach($ListArr as $row)
                                {
                                    "label": "{{$row->year}}",
                                    "value": "{{$row->exp_value}}"
                                },
                                @endforeach

                            ],
                        };
                        let quantityImp= {
                            "chart": {
                                "caption": "الواردات",
                                "subCaption": "",
                                "xAxisName": "السنة",
                                "yAxisName": "(الكمية (طن",
                                "decimals": "2",
                                "baseFontSize":"17",
                                "formatNumberScale":"0",
                                "hasRTLText":"1",
                                "setAdaptiveYMin":"1",
                                "theme": "fint"
                            },
                            "data": [
                                    @foreach($ListArr as $row)
                                {
                                    "label": "{{$row->year}}",
                                    "value": "{{$row->imp_quantity}}"
                                },
                                @endforeach
                            ],
                        };
                        let priceImp= {
                            "chart": {
                                "caption": "الواردات",
                                "subCaption": "",
                                "xAxisName": "السنة",
                                "yAxisName": "(القيمة (الف ج",
                                "decimals": "2",
                                "baseFontSize":"17",
                                "formatNumberScale":"0",
                                "hasRTLText":"1",
                                "setAdaptiveYMin":"1",
                                "theme": "fint",
                                "palettecolors": "#fb5607"
                            },
                            "data": [
                                    @foreach($ListArr as $row)
                                {
                                    "label": "{{$row->year}}",
                                    "value": "{{$row->imp_value}}"
                                },
                                @endforeach

                            ],
                        };
                        FusionCharts.ready(function() {
                            window.chartContainerImp = new FusionCharts({
                                type: 'area2d',
                                renderAt: 'chartContainerImp',
                                width: '100%',
                                height: '400',
                                dataFormat: 'json',
                                dataSource:quantityImp
                            }).render();
                            window.chartContainerExp = new FusionCharts({
                                type: 'area2d',
                                renderAt: 'chartContainerExp',
                                width: '100%',
                                height: '400',
                                dataFormat: 'json',
                                dataSource:quantityExp
                            }).render();
                        });

                    </script>
                </div>
            @endif
        @else
            @php
                $price = $type.'_price';
                $quantity = $type.'_quantity';
            @endphp
        <div class="row">
            <div class="infooo" width="100%">
                <h1 class="col-md-10">{{($type=='imp')? 'واردات ' : 'صادرات ' }} {{$item}} {{$extraData['year']}}</h1>
                <div class="col-md-2">
                    @if(!request()->exists('draw'))
                        <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{url(request()->fullUrlWithQuery(["countries"=>'']))}}'">

                        <input type="submit" name="Button1" value="رسم" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{url(request()->fullUrlWithQuery(["draw"=>1]))}}'">
                    @else
                        <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{url(request()->fullUrlWithQuery(["countries"=>'']))}}'">
                    @endif
                </div>
            </div>
        </div>
            @if(!request()->exists('draw'))
                <div class="table-responsive mgt40">
        <table  class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                  <th>الدولة</th>
                  <th>القيمة بالألف جنيه</th>
                  <th>الكمية بالطن</th>
                </tr>
            </thead>
            <tbody class="txtcolor" id="rep6">

                @if($ListArr)
                    @foreach($ListArr as $row)
                        @if(!empty($row->$quantity))
                        <tr class="bg-cloro2">
                          <th style="width: 10%">{{$row->country}}</th>
                          <th style="width: 10%">{{$row->$price}}</th>
                          <th style="width: 10%">{{$row->$quantity}}</th>
                        </tr>
                        @endif
                    @endforeach
                    <tr class="bg-cloro1">
                      <th style="width: 10%">إجمالي</th>
                        <th style="width: 10%">
                            @php
                                $sum = 0;
                                foreach($ListArr as $row){

                                if(isset($row->$price))
                                    $sum += $row->$price;
                                }
                                echo $sum;
                            @endphp
                        </th>
                        <th style="width: 10%">
                            @php
                                $sum = 0;
                                foreach($ListArr as $row){

                                if(isset($row->$quantity))
                                    $sum += $row->$quantity;
                                }
                                echo $sum;
                            @endphp
                        </th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
            @else
                <div class="mgt40">
                    <div id="chartContainer">FusionCharts XT will load here!</div>
                    <div class="row"  style="text-align: center;">
                        <div class="col-md-6">
                            <button class="btn btn-success enum-options active" onclick="$('.enum-options').removeClass('active');$(this).addClass('active');plantsChart.setJSONData(quantity);plantsChart.render()">الكمية</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-success enum-options" onclick="$('.enum-options').removeClass('active');$(this).addClass('active');plantsChart.setJSONData(price);plantsChart.render()">القيمة</button>
                        </div>
                    </div>
                    <script type="text/javascript">
                        let quantity={
                            "chart": {
                                "labelDisplay":"rotate",
                                "caption": "",
                                "subCaption": "",
                                "xAxisName": "الدولة",
                                "yAxisName": "(الكمية (طن",
                                "decimals": "2",
                                "baseFontSize":"17",
                                "formatNumberScale":"0",
                                "hasRTLText":"1",
                                "setAdaptiveYMin":"1",
                                "theme": "fint"
                            },
                            "data": [
                                    @foreach($ListArr as $row)
                                {
                                    "label": "{{$row->country}}",
                                    "value": "{{$row->$quantity}}"
                                },
                                @endforeach

                            ],
                        };
                        let price={
                            "chart": {
                                "labelDisplay":"rotate",
                                "caption": "",
                                "subCaption": "",
                                "xAxisName": "الدولة",
                                "yAxisName": "(القيمة (الف ج",
                                "decimals": "2",
                                "baseFontSize":"17",
                                "formatNumberScale":"0",
                                "hasRTLText":"1",
                                "setAdaptiveYMin":"1",
                                "theme": "fint"
                            },
                            "data": [
                                    @foreach($ListArr as $row)
                                {
                                    "label": "{{$row->country}}",
                                    "value": "{{$row->$price}}"
                                },
                                @endforeach

                            ],
                        };
                        FusionCharts.ready(function() {
                            window.plantsChart = new FusionCharts({
                                type: 'column2d',
                                renderAt: 'chartContainer',
                                width: '100%',
                                height: '400',
                                dataFormat: 'json',
                                dataSource:quantity
                            }).render();
                        });
                    </script>
                </div>
            @endif
        @endif
    </div>
</div>

    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection

@section('footerInclude')
<script src="{{ URL::asset('frontEnd/js/select2.js')}}"></script>
<script type="text/javascript">
        $(document).ready(function() {
            $('.selectpicker').select2({
                dir: "rtl"
            });

            $('.selectpicker').on('change',function (e) {
                // sendQuery();
            });
        });
        function sendQuery(repIndex='') {
            var url ='{{route("databasesSearch",$CurrentCategory->id)}}'
            var type_group = $('select[name=type_group]').val();
            var item = $('select[name=item]').val();
            var item2 = $('select[name=item2]').val();
            var fullURL= url+"?item="+item+"&item2="+item2+"&type_group="+type_group;

            console.log('fullURL');
            console.log(fullURL);
            if (repIndex) {
                window.location = fullURL;
            }else{
                var params= {ajax:1,item:item,item2:item2,type_group:type_group};
                $.get(url, params, function(response) { // requesting url which in form
                    $('h1.col-md-12').text('صادرات وواردات '+type_group+' من سنة '+item+' حتى سنة '+item2+'')
                    $('#rep6').html(response); // getting response and pushing to element with id #response
                });
            }
        }
    </script>
@endsection
