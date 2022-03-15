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
                    <h1 class="col-md-12" style="margin-bottom: 20px !important;">
                        أسعار العقود الحالية بالبورصات العالمية
                    </h1>
                    <h2 class="col-md-12" style="text-align: center;font-size: 18px">تاريخ اليوم {{\Carbon\Carbon::now()->formatLocalized('%A %d %B %Y')}}</h2>
                </div>

            </div>
            <div class="table-responsive mgt40">
                    <table  class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th rowspan="2">المحصول</th>
                            <th rowspan="2">الوحدة</th>
                            <th colspan="3">الاغلاق</th>
                            <th colspan="3">أدنى سعر</th>
                            <th colspan="3">أعلى سعر</th>
                        </tr>
                        <tr>
                            <!-- <th>المجموعة</th> -->
                            <!-- <th>العروة</th> -->
                            <!-- <th>المحصول</th> -->
                            <th>الوحدة بالبورصة</th>
                            <th>دولار/طن</th>
                            <th>جنيه/طن</th>
                            <th>الوحدة بالبورصة</th>
                            <th>دولار/طن</th>
                            <th>جنيه/طن</th>
                            <th>الوحدة بالبورصة</th>
                            <th>دولار/طن</th>
                            <th>جنيه/طن</th>
                        </tr>
                        </thead>
                        <tbody class="txtcolor">
                        <!-- bg-cloro1 -->
                        @foreach($ListArr as $row)
                            <tr class="bg-cloro2">
                                <td>{{$row->crop}}</td>
                                <td>{{$row->unit}}</td>
                                <td>{{round($row->close_cent,2)}}</td>
                                <td>{{round($row->close_dollar,2)}}</td>
                                <td>{{round($row->close_pound,2)}}</td>
                                <td>{{round($row->lower_cent,2)}}</td>
                                <td>{{round($row->lower_dollar,2)}}</td>
                                <td>{{round($row->lower_pound,2)}}</td>
                                <td>{{round($row->higher_cent,2)}}</td>
                                <td>{{round($row->higher_dollar,2)}}</td>
                                <td>{{round($row->higher_pound,2)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
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
    </script>


@endsection
