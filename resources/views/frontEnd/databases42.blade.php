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
            <div class="row">
                <div class="infooo" width="100%">
                    @if(!request()->exists('type'))
                        <h1 class="col-md-12">الانتاج النباتي</h1>
                        <div class="col-md-2">
                            <strong><span class="control-label">اسم المجموعة:  </span></strong>
                            <select class="selectpicker show-menu-arrow" name="type_group" onchange="get_seasons('type')">
                                <option value="">اختر</option>
                                @foreach($groups as $key=>$value)
                                    <option value="{{$key}}" @if($key== $type_group) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <strong><span class="control-label">العروة :</span></strong>
                            <select class="selectpicker show-menu-arrow" name="type" onchange="get_crops('crop_name')">
                                <option value="">اختر</option>
                                @foreach($select2 as $select)
                                    <option value="{{$select->season}}"  @if($select->season === $type && !empty($type)) selected @endif >{{$seasons[$select->season]}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <strong><span class="control-label">المحصول </span></strong>
                            <select class="selectpicker show-menu-arrow" name="crop_name">
                                <option value="">اختر</option>
                                @foreach($select3 as $select)
                                    <option value="{{$select->crop}}"  @if(trim($select->crop) == trim($item3)) selected @endif >{{$select->crop}}</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="col-md-2">
                            <strong><span class="control-label">العام  من :</span></strong>
                            <select class="selectpicker show-menu-arrow" name="item">
                                <option value="">اختر</option>
                                @foreach($select4 as $select)
                                    <option value="{{$select->year}}"  @if($select->year == $item) selected @endif >{{$select->year}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <strong><span class="control-label">إلي </span></strong>
                            <select class="selectpicker show-menu-arrow" name="item2">
                                <option value="">اختر</option>
                                @foreach($select4 as $select)
                                    <option value="{{$select->year}}"  @if($select->year == $item2) selected @endif >{{$select->year}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="submit" name="Button1" value="بحث" id="Button1" class="btn btn-success" onclick="sendQuery();">
                        </div>
                    @else
                        <h1 class="col-md-10" style="margin-bottom: 20px !important;">
                            @if($details)
                             {{request()->exists('draw')?'مساحة':''}} محصول {{$item3}} سنة {{request()->input('year')}}
                            @else
                             تطور {{request()->exists('draw')?'مساحة':''}} محصول {{$item3}} من سنة {{$item}} لسنة {{$item2}}
                            @endif
                        </h1>
                        <div class="col-md-2">
                            @if(!request()->exists('draw'))
                                @if(!$details)
                                    <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{route("databasesSearch",$CurrentCategory->id)}}'">
                                @else
                                    <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{url(request()->fullUrlWithQuery(["year"=>'']))}}'">
                                @endif

                                <input type="submit" name="Button1" value="رسم" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{url(request()->fullUrlWithQuery(["draw"=>1]))}}'">
                            @else
                                @if(!$details)
                                    <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{route("databasesSearch",$CurrentCategory->id)}}'">
                                @else
                                    <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{url(request()->fullUrlWithQuery(["year"=>'']))}}'">
                                @endif
                            @endif
                        </div>
                        <h2 class="col-md-10" style="text-align: center;font-size: 18px">({{$seasons[$type]}})</h2>

                    @endif
                </div>

            </div>
            @if(!request()->exists('draw'))
                <div class="table-responsive mgt40">
                    <table  class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            @if(!$details)
                                <th rowspan="2">سنة</th>
                            @else
                                <th rowspan="2">المحافظة</th>
                            @endif
                            <th colspan="3">أراضى قديمة</th>
                            <th colspan="3">أراضى جديدة</th>
                            <th colspan="3">إجمالى الأراضى القديمة والجديدة</th>
                            @if(!$details)
                                <th rowspan="2">المحافظات</th>
                            @endif
                        </tr>
                        <tr>
                            <!-- <th>المجموعة</th> -->
                            <!-- <th>العروة</th> -->
                            <!-- <th>المحصول</th> -->
                            <th>المساحة
                                (فدان)</th>
                            <th>الإنتاجية
                                (طن/فدان)</th>
                            <th>الإنتاج
                                (طن)</th>
                            <th>المساحة
                                (فدان)</th>
                            <th>الإنتاجية
                                (طن/فدان)</th>
                            <th>الإنتاج
                                (طن)</th>
                            <th>المساحة
                                (فدان)</th>
                            <th>الإنتاجية
                                (طن/فدان)</th>
                            <th>الإنتاج
                                (طن)</th>
                        </tr>
                        </thead>
                        <tbody class="txtcolor">
                        <!-- bg-cloro1 -->
                        @php
                         $total_old_area=0;
                         $total_old_quantity=0;
                         $total_new_area=0;
                         $total_new_quantity=0;
                        @endphp
                        @foreach($ListArr as $row)
                            @php
                                $total_old_area +=$row->old_area;
                                $total_old_quantity +=$row->old_quantity;
                                $total_new_area +=$row->new_area;
                                $total_new_quantity +=$row->new_quantity;
                            @endphp
                            <tr class="bg-cloro2">
                                @if(!$details)
                                    <td>{{$row->year}}</td>
                                @else
                                    <td>{{$row->gov}}</td>
                                @endif
                                <td>{{round($row->old_area,2)}}</td>
                                <td>{{round($row->old_productivity,2)}}</td>
                                <td>{{round($row->old_quantity,2)}}</td>
                                <td>{{round($row->new_area,2)}}</td>
                                <td>{{round($row->new_productivity,2)}}</td>
                                <td>{{round($row->new_quantity,2)}}</td>
                                <td>{{round($row->total_area,2)}}</td>
                                <td>{{round($row->total_productivity,2)}}</td>
                                <td>{{round($row->total_quantity,2)}}</td>
                                @if(!$details)
                                    <th style="width: 10%"><a class="btn btn-info" href="{{url(request()->fullUrlWithQuery(["year"=>$row->year]))}}">تفاصيل</a></th>
                                @endif
                            </tr>
                        @endforeach
                        @if($details)
                            <tr>
                                <td>الإجمالي</td>
                                <td>{{round($total_old_area,2)}}</td>
                                <td>{{round($total_old_quantity/$total_old_area,2)}}</td>
                                <td>{{round($total_old_quantity,2)}}</td>
                                <td>{{round($total_new_area,2)}}</td>
                                <td>{{$total_new_area > 0 ? round($total_new_quantity/$total_new_area,2) : '-'}}</td>
                                <td>{{round($total_new_quantity,2)}}</td>
                                <td>{{round($total_old_area+$total_new_area,2)}}</td>
                                <td>{{round(($total_old_area+$total_new_area)/($total_old_quantity+$total_new_quantity),2)}}</td>
                                <td>{{round($total_old_quantity+$total_new_quantity,2)}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mgt40">
                    <div id="chartContainer">FusionCharts XT will load here!</div>
                    <div class="row"  style="text-align: center;">
                        <div class="col-md-4">
                            <button class="btn btn-success enum-options active" onclick="$('.enum-options').removeClass('active');$(this).addClass('active');plantsChart.setJSONData(area);plantsChart.render();@if($details)
                                $('.infooo h1').text('مساحة محصول {{$item3}} سنة {{request()->input('year')}}');
                            @else
                                $('.infooo h1').text('تطور مساحة محصول {{$item3}} من سنة {{$item}} لسنة {{$item2}}');
                            @endif">المساحة</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success enum-options" onclick="$('.enum-options').removeClass('active');$(this).addClass('active');plantsChart.setJSONData(productivity);plantsChart.render();@if($details)
                                $('.infooo h1').text('انتاجية محصول {{$item3}} سنة {{request()->input('year')}}');
                            @else
                                $('.infooo h1').text('تطور انتاجية محصول {{$item3}} من سنة {{$item}} لسنة {{$item2}}');
                            @endif">الانتاجية</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success enum-options" onclick="$('.enum-options').removeClass('active');$(this).addClass('active');plantsChart.setJSONData(quantity);plantsChart.render();@if($details)
                                $('.infooo h1').text('انتاج محصول {{$item3}} سنة {{request()->input('year')}}');
                            @else
                                $('.infooo h1').text('تطور انتاج محصول {{$item3}} من سنة {{$item}} لسنة {{$item2}}');
                            @endif">الانتاج</button>
                        </div>
                    </div>
                    <script type="text/javascript">
                        let area={
                            "chart": {
                                @if($details)
                                "labelDisplay":"rotate",
                                @endif
                                "caption": "",
                                "subCaption": "",
                                @if(!$details)
                                "xAxisName": "السنة",
                                @else
                                "xAxisName": "المحافظة",
                                @endif
                                "yAxisName": "(المساحة (فدان",
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
                                    @if(!$details)
                                    "label": "{{$row->year}}",
                                    @else
                                    "label": "{{$row->gov}}",
                                    @endif
                                    "value": "{{$row->total_area}}"
                                },
                                @endforeach

                            ],
                        };
                        let productivity={
                            "chart": {
                                @if($details)
                                "labelDisplay":"rotate",
                                @endif
                                "caption": "",
                                "subCaption": "",
                                @if(!$details)
                                "xAxisName": "السنة",
                                @else
                                "xAxisName": "المحافظة",
                                @endif
                                "yAxisName": "(الإنتاجية (طن/فدان",
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
                                    @if(!$details)
                                    "label": "{{$row->year}}",
                                    @else
                                    "label": "{{$row->gov}}",
                                    @endif
                                    "value": "{{$row->total_productivity}}",

                                },
                                @endforeach

                            ],
                        };
                        let quantity= {
                            "chart": {
                                @if($details)
                                "labelDisplay":"rotate",
                                @endif
                                "caption": "",
                                "subCaption": "",
                                @if(!$details)
                                "xAxisName": "السنة",
                                @else
                                "xAxisName": "المحافظة",
                                @endif
                                "yAxisName": "(الانتاج (طن",
                                "decimals": "2",
                                "baseFontSize":"17",
                                "formatNumberScale":"0",
                                "hasRTLText":"1",
                                "setAdaptiveYMin":"1",
                                "theme": "fint",
                                "palettecolors": "#99cc00"
                            },
                            "data": [
                                    @foreach($ListArr as $row)
                                {
                                    @if(!$details)
                                    "label": "{{$row->year}}",
                                    @else
                                    "label": "{{$row->gov}}",
                                    @endif
                                    "value": "{{$row->total_quantity}}"
                                },
                                @endforeach
                            ],
                        };
                        FusionCharts.ready(function() {
                            window.plantsChart = new FusionCharts({
                                @if(!$details)
                                type: 'area2d',
                                @else
                                type: 'column2d',
                                @endif
                                renderAt: 'chartContainer',
                                width: '100%',
                                height: '400',
                                dataFormat: 'json',
                                dataSource:area
                            }).render();
                        });
                    </script>
                </div>
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
        function sendQuery(draw) {
            var url ='{{route("databasesSearch",$CurrentCategory->id)}}'
            var type = $('select[name=type]').val();
            var type_group = $('select[name=type_group]').val();
            var item = $('select[name=item]').val();
            var item2 = $('select[name=item2]').val();
            var crop_name = $('select[name=crop_name]').val();
            var fullURL= url+"?type="+type+"&type_group="+type_group+"&item="+item+"&item2="+item2+"&crop_name="+crop_name+((draw)?'&draw=1':'');
            console.log('fullURL');
            console.log(fullURL);
            window.location = fullURL;
        }
        let seasons={!! json_encode($seasons) !!}
        function get_seasons(nextSelect){
            var cat_id = {{$CurrentCategory->id}};
            var _token = '{{csrf_token()}}';
            var xhr = $.ajax({
                type: "POST",
                url: "<?=route("getNextSelect"); ?>",
                data: {type:$('select[name="type_group"]').val(), cat_id : cat_id ,_token : _token},
                success: function (res) {
                    $('select[name='+nextSelect+'] option').each(function() {
                        $(this).remove();
                    });

                    if (res.code == 1) {
                        $('select[name='+nextSelect+']').append($('<option></option>').val(0).text('اختر'));

                        res.options.forEach(function (option) {
                            $('select[name='+nextSelect+']').append($('<option></option>').val(option.season).text(seasons[option.season]));
                        });
                        $('select[name='+nextSelect+']').select2({
                            dir: "rtl"
                        });

                    }
                }
            });
        }
        function get_crops(nextSelect){
            var cat_id = {{$CurrentCategory->id}};
            var _token = '{{csrf_token()}}';
            var xhr = $.ajax({
                type: "POST",
                url: "<?=route("getNextSelect"); ?>",
                data: {type:$('select[name="type_group"]').val(),
                    type_group :  $('select[name="type"]').val() , cat_id : cat_id ,_token : _token},
                success: function (res) {
                    $('select[name='+nextSelect+'] option').each(function() {
                        $(this).remove();
                    });

                    if (res.code == 1) {
                        $('select[name='+nextSelect+']').append($('<option></option>').val(0).text('اختر'));

                        res.options.forEach(function (option) {
                            $('select[name='+nextSelect+']').append($('<option></option>').val(option.crop).text(option.crop));
                        });
                        $('select[name='+nextSelect+']').select2({
                            dir: "rtl"
                        });

                    }
                }
            });
        }
    </script>


@endsection
