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
                        <h1 class="col-md-12">التركيب المحصولي</h1>
                        <div class="col-md-2">
                            <strong><span class="control-label">الأراضي:  </span></strong>
                            <select class="selectpicker show-menu-arrow" name="type">
                                <option value="">اختر</option>
                                @foreach($lands as $key=>$value)
                                    <option value="{{$key}}" @if($key == $type) selected @endif>{{$value}}</option>
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
                        </div>

                        <div class="col-md-2">
                        </div>
                        <div class="col-md-2">
                            <input type="submit" name="Button1" value="بحث" id="Button1" class="btn btn-success" onclick="sendQuery();">
                        </div>
                    @else
                        <h1 class="col-md-10" style="margin-bottom: 20px !important;">
                            @if($details)
                                التركيب المحصولي  {{$type=='old'?'بالأراضى القديمة':($type=='new'?'بالأراضى الجديدة':'لجملة الأراضى القديمة والجديدة')}} سنة {{request()->input('year')}}
                            @else
                                التركيب المحصولي  {{$type=='old'?'بالأراضى القديمة':($type=='new'?'بالأراضى الجديدة':'لجملة الأراضى القديمة والجديدة')}} من سنة {{$item}} لسنة {{$item2}}
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
                            <th colspan="3">المساحة المنزرعة (فدان)</th>
                            <th colspan="3">المساحة المحصولية (فدان)</th>
                            @if(!$details)
                                <th rowspan="2">المحافظات</th>
                            @endif
                        </tr>
                        <tr>
                            <!-- <th>المجموعة</th> -->
                            <!-- <th>العروة</th> -->
                            <!-- <th>المحصول</th> -->
                            <th>إجمالى الشتوى</th>
                            <th>إجمالى المعمرات</th>
                            <th>جملة</th>
                            <th>إجمالى الصيفى</th>
                            <th>إجمالى النيلى</th>
                            <th>جملة</th>

                        </tr>
                        </thead>
                        <tbody class="txtcolor">
                        <!-- bg-cloro1 -->
                        @php
                            $total_winter=0;
                            $total_perennial=0;
                            $total_summer=0;
                            $total_indigo=0;
                        @endphp
                        @foreach($ListArr as $row)
                            @php
                                $total_winter +=$row->{'winter_'.$type};
                                $total_perennial +=$row->{'perennial_'.$type};
                                $total_summer +=$row->{'summer_'.$type};
                                $total_indigo +=$row->{'indigo_'.$type};
                            @endphp
                            <tr class="bg-cloro2">
                                @if(!$details)
                                    <td>{{$row->year}}</td>
                                @else
                                    <td>{{$row->gov}}</td>
                                @endif
                                <td>{{round($row->{'winter_'.$type},2)}}</td>
                                <td>{{round($row->{'perennial_'.$type},2)}}</td>
                                <td>{{round($row->{'winter_'.$type}+$row->{'perennial_'.$type},2)}}</td>
                                <td>{{round($row->{'summer_'.$type},2)}}</td>
                                <td>{{round($row->{'indigo_'.$type},2)}}</td>
                                <td>{{round($row->{'winter_'.$type}+$row->{'perennial_'.$type}+$row->{'summer_'.$type}+$row->{'indigo_'.$type},2)}}</td>
                                @if(!$details)
                                    <th style="width: 10%"><a class="btn btn-info" href="{{url(request()->fullUrlWithQuery(["year"=>$row->year]))}}">تفاصيل</a></th>
                                @endif
                            </tr>
                        @endforeach
                        @if($details)
                            <tr>
                                <td>الإجمالي</td>
                                <td>{{round($total_winter,2)}}</td>
                                <td>{{round($total_perennial,2)}}</td>
                                <td>{{round($total_winter+$total_perennial,2)}}</td>
                                <td>{{round($total_summer,2)}}</td>
                                <td>{{round($total_indigo,2)}}</td>
                                <td>{{round($total_winter+$total_perennial+$total_summer+$total_indigo,2)}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mgt40">
                    <div id="chartContainer">FusionCharts XT will load here!</div>

                    <script type="text/javascript">
                        const dataSource = {
                            chart: {
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
                                "showvalues": "0",
                                "drawcrossline": "1",
                                "divlinealpha": "20",
                                "decimals": "2",
                                "baseFontSize":"17",
                                "formatNumberScale":"0",
                                "hasRTLText":"1",
                                "setAdaptiveYMin":"1",
                                "theme": "fint"
                            },
                            categories: [
                                {
                                    category: [
                                        @foreach($ListArr as $row)
                                        {
                                            @if(!$details)
                                            label: "{{$row->year}}"
                                            @else
                                            label: "{{$row->gov}}"
                                            @endif
                                        },
                                        @endforeach
                                    ]
                                }
                            ],
                            dataset: [
                                {
                                    dataset: [
                                        {
                                            seriesname: "إجمالى الشتوى",
                                            data: [
                                                @foreach($ListArr as $row)
                                                {
                                                    value: "{{$row->{'winter_'.$type} }}}"
                                                },
                                                @endforeach
                                            ]
                                        },
                                        {
                                            seriesname: "إجمالى المعمرات",
                                            data: [
                                                @foreach($ListArr as $row)
                                                {
                                                    value: "{{$row->{'perennial_'.$type} }}}"
                                                },
                                                @endforeach
                                            ]
                                        }
                                    ]
                                },
                                {
                                    dataset: [
                                        {
                                            seriesname: "إجمالى الصيفى",
                                            data: [
                                                @foreach($ListArr as $row)
                                                {
                                                    value: "{{$row->{'summer_'.$type} }}}"
                                                },
                                                @endforeach
                                            ]
                                        },
                                        {
                                            seriesname: "إجمالى النيلى",
                                            data: [
                                                @foreach($ListArr as $row)
                                                {
                                                    value: "{{$row->{'indigo_'.$type} }}}"
                                                },
                                                @endforeach
                                            ]
                                        }
                                    ]
                                }
                            ],
                        };

                        FusionCharts.ready(function() {
                            var myChart = new FusionCharts({
                                type: "msstackedcolumn2d",
                                renderAt: "chartContainer",
                                width: "100%",
                                height: "400",
                                dataFormat: "json",

                                dataSource
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
            var fullURL= url+"?type="+type+"&item="+item+"&item2="+item2+((draw)?'&draw=1':'');
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
