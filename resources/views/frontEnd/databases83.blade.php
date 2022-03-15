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
                    @if(!request()->exists('type_group'))
                        <h1 class="col-md-12">أسعار المحاصيل اليومية</h1>
                        <div class="col-md-2">
                            <strong><span class="control-label">المجموعة</span></strong>
                            <select class="selectpicker show-menu-arrow" name="type_group" onchange="get_crops('crop_name')">
                                <option value="">اختر</option>
                                @foreach($select1 as $select)
                                    <option value="{{$select->group}}" @if($select->group == $type_group) selected @endif>{{$select->group}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <strong><span class="control-label">الصنف</span></strong>
                            <select class="selectpicker show-menu-arrow" name="crop_name">
                                <option value="">اختر</option>
                            </select>
                        </div>


                        <div class="col-md-4">
                            <strong><span class="control-label">التاريخ</span></strong>
                            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 12px 10px; height:44px; border: 1px solid #aaa;border-radius: 4px;">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                <span></span> <b class="caret"></b>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <input type="submit" name="Button1" value="بحث" id="Button1" class="btn btn-success" onclick="sendQuery();">
                        </div>
                    @else
                        <h1 class="col-md-10" style="margin-bottom: 20px !important;">
                           تطور أسعار {{$item3}} من يوم {{$item->formatLocalized('%A %d %B %Y')}} ليوم {{$item2->formatLocalized('%A %d %B %Y')}}
                        </h1>
                        <div class="col-md-2">
                            @if(!request()->exists('draw'))
                                <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{route("databasesSearch",$CurrentCategory->id)}}'">
                                <input type="submit" name="Button1" value="رسم" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{url(request()->fullUrlWithQuery(["draw"=>1]))}}'">
                            @else
                                <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{route("databasesSearch",$CurrentCategory->id)}}'">
                            @endif
                        </div>
                        <h2 class="col-md-12" style="text-align: center;font-size: 18px">{{$ListArr->groupBy('unit')->keys()->first()}}</h2>

                    @endif
                </div>

            </div>
            @if(!request()->exists('draw'))
                <div class="table-responsive mgt40">
                    <table  class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th colspan="3">سعر الجملة (سوق العبور)</th>
                            <th colspan="3">سعر التجزئة (عينة ممثله للجمهورية)</th>
                            <th rowspan="2">التاريخ</th>
                        </tr>
                        <tr>
                            <th>أدنى سعر</th>
                            <th>أعلى سعر</th>
                            <th>المتوسط</th>
                            <th>أدنى سعر</th>
                            <th>أعلى سعر</th>
                            <th>المتوسط</th>
                        </tr>
                        </thead>
                        <tbody class="txtcolor">
                        <!-- bg-cloro1 -->

                        @foreach($ListArr as $row)
                            <tr class="bg-cloro2">
                                <td>{{round($row->wholesale_lower,2)}}</td>
                                <td>{{round($row->wholesale_higher,2)}}</td>
                                <td>{{round($row->wholesale_average,2)}}</td>
                                <td>{{round($row->retail_lower,2)}}</td>
                                <td>{{round($row->retail_higher,2)}}</td>
                                <td>{{round($row->retail_average,2)}}</td>
                                <td>{{$row->date->format('n/j/Y')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mgt40">
                    <div id="chartContainer">FusionCharts XT will load here!</div>
                    <script type="text/javascript">
                        let price= {
                            "chart": {
                                "labelDisplay": "rotate",
                                "caption": "",
                                "subCaption": "",
                                "xAxisName": "التاريخ",
                                "yAxisName": "السعر",
                                "decimals": "2",
                                "baseFontSize": "17",
                                "formatNumberScale": "0",
                                "hasRTLText": "1",
                                "setAdaptiveYMin": "1",
                                "theme": "fint"
                            },
                            categories: [
                                {
                                    category: [
                                            @foreach($ListArr as $row)
                                        {
                                            "label": "{{$row->date->format('n/j/Y')}}"
                                        },
                                        @endforeach
                                    ]
                                }
                            ],
                            dataset: [
                                {
                                    seriesname: "(سعر الجملة (سوق العبور",
                                    data: [
                                            @foreach($ListArr as $row)
                                        {
                                            "value": "{{$row->wholesale_average}}"
                                        },
                                        @endforeach

                                    ]
                                },
                                {
                                    seriesname: "(سعر التجزئة (عينة ممثله للجمهورية",
                                    data: [
                                            @foreach($ListArr as $row)
                                        {
                                            "value": "{{$row->retail_average}}"
                                        },
                                        @endforeach
                                    ],
                                }
                            ]
                        };
                        FusionCharts.ready(function() {
                            new FusionCharts({
                                type: 'msline',
                                renderAt: 'chartContainer',
                                width: '100%',
                                height: '400',
                                dataFormat: 'json',
                                dataSource:price
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
    <link href="{{ URL::asset('frontEnd/css/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{ URL::asset('frontEnd/js/select2.js')}}"></script>
    <script src="{{ URL::asset('frontEnd/js/moment.min.js')}}"></script>
    <script src="{{ URL::asset('frontEnd/js/daterangepicker.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            moment.locale('ar');
            startDate=''
            endDate=''
            function cb(start, end) {
                startDate=start.unix()
                endDate=end.unix()
                $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
            }
            $('#reportrange').daterangepicker({
                @if($select3->count())
                startDate : '{!! $select3->min()->date->format('d-m-Y') !!}',
                endDate : '{!! $select3->max()->date->format('d-m-Y') !!}',
                minDate : '{!! $select3->min()->date->format('d-m-Y') !!}',
                maxDate : '{!! $select3->max()->date->format('d-m-Y') !!}',
                @endif
                format: 'DD-MM-YYYY',
                separator: ' إلى ',
                opens :'left',
                locale: {
                    applyLabel: 'تنفيذ',
                    fromLabel: 'من',
                    toLabel: 'إلى',
                    cancelLabel :'اللغاء',
                    customRangeLabel: 'فترة مخصصة',
                    firstDay: 1
                }
            },cb);
            @if($select3->count())
            cb(moment('{!! $select3->min()->date->format('m-d-Y') !!}'),moment('{!! $select3->max()->date->format('m-d-Y') !!}'))
            @endif
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
            var item = startDate;
            var item2 = endDate;
            var crop_name = $('select[name=crop_name]').val();
            var fullURL= url+"?type_group="+type_group+"&item="+item+"&item2="+item2+"&crop_name="+crop_name+((draw)?'&draw=1':'');
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
