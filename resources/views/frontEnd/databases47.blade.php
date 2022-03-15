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
                    @if(!$type)
                        <h1 class="col-md-12">الميزان الغذائي</h1>

                        <div class="col-md-2">
                            <strong><span class="control-label">اسم المجموعة:  </span></strong>
                            <select class="selectpicker show-menu-arrow" name="type_group" onchange="getItems(this,'item_name')">
                                <option value="">اسم المجموعة: </option>
                                @foreach($select1 as $select)
                                    <option value="{{$select->group}}" @if($select->group == $type_group) selected @endif>{{$select->group}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <strong><span class="control-label">المنتج </span></strong>
                            <select class="selectpicker show-menu-arrow" name="item_name">
                                <option value="">المجموعة كاملة</option>
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

                        <div class="col-md-4">
                            <input type="submit" name="Button1" value="نصيب الفرد" id="Button1" class="btn btn-success" style="margin-right:14px " onclick="sendQuery('individual');">
                            <input type="submit" name="Button1" value="الميزان الغذائي" id="Button1" class="btn btn-success" onclick="sendQuery('balance');">
                        </div>
                    @elseif($type=='balance')
                        <h1 class="col-md-10">الانتاج والمتاح للاستهلاك من {{!empty($item3)?$item3:$type_group}} من سنة {{$item}} حتى سنة {{$item2}}</h1>
                        <div class="col-md-2">
                            <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" style="margin-right:14px;    margin-top: 0; " onclick="window.location='{{route("databasesSearch",$CurrentCategory->id)}}'">
                            @if(!request()->exists('draw'))
                            <input type="submit" name="Button1" value="رسم" id="Button1" class="btn btn-success" style="    margin-top: 0;"  onclick="window.location='{{url(request()->fullUrlWithQuery(["draw"=>1]))}}'">
                            @endif
                        </div>
                    @elseif($type=='individual')
                        <h1 class="col-md-10">متوسط نصيب الفرد من {{!empty($item3)?$item3:$type_group}} من سنة {{$item}} حتى سنة {{$item2}}</h1>
                        <div class="col-md-2">
                            <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" onclick="window.location='{{route("databasesSearch",$CurrentCategory->id)}}'">
                        </div>
                    @endif
                </div>
            </div>

            <style type="text/css">
                td > div{
                    height: 20px;
                    margin-top: -12px;
                }
            </style>
            @if($type !='balance')
                <div class="table-responsive mgt40" style="height : 450px;">
                    <table  class="table table-bordered">
                        <thead class="thead-dark">
                        <tr style="white-space: nowrap;vertical-align: middle;">
                            <!-- <th>المجموعة</th>
                            <th>المنتجات</th> -->
                            <th rowspan="2">السنة</th>
                            <th rowspan="2">تقدير السكان فى<br> منتصف العام <br>(ألف نسمة)</th>
                            <th colspan="3">نصيب الفرد (كجم/سنة) من</th>
                            <th rowspan="2">الغذاء الصافي <br> (ألف طن)</th>
                            <th colspan="5">متوسط نصيب الفرد</th>
                        </tr>
                        <tr>
                            <th>الانتاج</th>
                            <th>المتاح للاستهلاك</th>
                            <th>كغذاء للانسان</th>
                            <th>فى السنة<br>(كيلوجرام)</th>
                            <th>في اليوم<br>(جرام)</th>
                            <th>كالوري/اليوم</th>
                            <th>بروتين<br>(جم/اليوم)</th>
                            <th>دهن<br>(جم/اليوم)</th>
                        </tr>
                        </thead>
                        <tbody class="txtcolor">
                        <!-- bg-cloro1 -->
                        @foreach($ListArr as $row)
                            <tr class="bg-cloro2" style="white-space: nowrap;vertical-align: middle;">
                            <!-- <th style="width: 17%">{{$row->CAT_NAME}}</th>
                          <th style="width: 17%">{{$row->ITEM_NAME}}</th> -->
                                <td><div>{{$row->year}}</div></td>
                                <td><div>{{$row->population}}</div></td>
                                <td><div>{{round($row->individual_production*1000,3)}}</div></td>
                                <td><div>{{round($row->individual_available_consumption*1000,3)}}</div></td>
                                <td><div>{{round($row->individual_human_food*100,3)}}</div></td>
                                <td><div>{{$row->pure_food}}</div></td>
                                <td><div>{{$row->human_year}}</div></td>
                                <td><div>{{$row->human_day}}</div></td>
                                <td><div>{{$row->human_cal}}</div></td>
                                <td><div>{{$row->human_protein}}</div></td>
                                <td><div>{{$row->human_fat}}</div></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                @if(!request()->exists('draw'))
                    <div class="table-responsive mgt40" style="height : 450px;">
                    <table  class="table table-bordered">
                        <thead class="thead-dark">
                        <tr style="white-space: nowrap;vertical-align: middle;">
                            <!-- <th>المجموعة</th>
                            <th>المنتجات</th> -->
                            <th rowspan="3">السنة</th>
                            <th colspan="6">المعروض (ألف طن)</th>
                            <th colspan="5">الاستخدامات (ألف طن)</th>
                        </tr>
                        <tr>
                            <th rowspan="2">الانتاج</th>
                            <th rowspan="2">الواردات</th>
                            <th colspan="2">المخزون</th>
                            <th rowspan="2">الصادرات</th>
                            <th rowspan="2">المتاح <br> للاستهلاك</th>
                            <th rowspan="2">غذاء الحيوان</th>
                            <th rowspan="2">التقاوي</th>
                            <th rowspan="2">الصناعة</th>
                            <th rowspan="2">الفاقد</th>
                            <th rowspan="2">المتبقي <br>كغذاء للانسان</th>
                        </tr>
                        <tr>
                            <th>اول المدة</th>
                            <th>اخر المدة</th>
                        </tr>
                        </thead>
                        <tbody class="txtcolor">
                        <!-- bg-cloro1 -->
                        @foreach($ListArr as $row)
                            <tr class="bg-cloro2" style="white-space: nowrap;vertical-align: middle;">
                            <!-- <th style="width: 17%">{{$row->CAT_NAME}}</th>
                          <th style="width: 17%">{{$row->ITEM_NAME}}</th> -->
                                <td><div>{{$row->year}}</div></td>
                                <td><div>{{$row->production}}</div></td>
                                <td><div>{{$row->imports}}</div></td>
                                <td><div>{{$row->stock_first}}</div></td>
                                <td><div>{{$row->stock_end}}</div></td>
                                <td><div>{{$row->exports}}</div></td>
                                <td><div>{{$row->available_consumption}}</div></td>
                                <td><div>{{$row->animal_food}}</div></td>
                                <td><div>{{$row->seed}}</div></td>
                                <td><div>{{$row->industry}}</div></td>
                                <td><div>{{$row->wastage}}</div></td>
                                <td><div>{{$row->human_food}}</div></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="mgt40">
                            <div id="chartContainer">FusionCharts XT will load here!</div>
                            <script type="text/javascript">
                                let area= {
                                    "chart": {
                                        "caption": "",
                                        "subCaption": "",
                                        "xAxisName": "السنة",
                                        "yAxisName": "الف طن",
                                        "decimals": "2",
                                        "baseFontSize": "17",
                                        "formatNumberScale": "0",
                                        "hasRTLText": "1",
                                        "setAdaptiveYMin": "1",
                                        "legendItemFontSize":"17",
                                        "theme": "fint"
                                    },
                                    categories: [
                                        {
                                            category: [
                                                    @foreach($ListArr as $row)
                                                {
                                                    "label": "{{$row->year}}"
                                                },
                                                @endforeach
                                            ]
                                        }
                                    ],
                                    dataset: [
                                        {
                                            seriesname: "الانتاج",
                                            data: [
                                                    @foreach($ListArr as $row)
                                                {
                                                    "value": "{{$row->production}}"
                                                },
                                                @endforeach

                                            ]
                                        },
                                        {
                                            seriesname: "المتاح للاستهلاك",
                                            data: [
                                                    @foreach($ListArr as $row)
                                                {
                                                    "value": "{{$row->available_consumption}}"
                                                },
                                                @endforeach
                                            ],
                                        }
                                    ]
                                };
                                FusionCharts.ready(function() {
                                    window.plantsChart = new FusionCharts({
                                        type: 'msline',
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
        function sendQuery(type) {
            var url ='{{route("databasesSearch",$CurrentCategory->id)}}'
            var type_group = $('select[name=type_group]').val();
            var item = $('select[name=item]').val();
            var item2 = $('select[name=item2]').val();
            var item_name = $('select[name=item_name]').val();
            var fullURL= url+"?type="+type+"&type_group="+type_group+"&item="+item+"&item2="+item2+"&item_name="+item_name;
            console.log('fullURL');
            console.log(fullURL);
            window.location = fullURL;
        }

        function getItems(selectEL,nextSelect){
            var cat_id = {{$CurrentCategory->id}};
            var _token = '{{csrf_token()}}';
            var xhr = $.ajax({
                type: "POST",
                url: "<?=route("getNextSelect"); ?>",
                data: {type_group :  $(selectEL).val() , cat_id : cat_id ,_token : _token},
                success: function (res) {
                    $('select[name='+nextSelect+'] option').each(function() {
                        $(this).remove();
                    });

                    if (res.code == 1) {
                        $('select[name='+nextSelect+']').append($('<option></option>').val('').text('المجموعة كاملة'));
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
