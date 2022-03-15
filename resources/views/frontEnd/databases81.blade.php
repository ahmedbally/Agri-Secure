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
                        <h1 class="col-md-12">الأسعار المزرعية</h1>
                        <div class="col-md-2">
                            <strong><span class="control-label">العروة :</span></strong>
                            <select class="selectpicker show-menu-arrow" name="type" onchange="/*get_crops('crop_name')*/">
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
                        <div class="col-md-4">
                            <input type="submit" name="Button1" value="بحث" id="Button1" class="btn btn-success" onclick="sendQuery();">
                        </div>
                    @else
                        <h1 class="col-md-10" style="margin-bottom: 20px !important;">
                            تطور اسعار {{request()->exists('draw')?'مساحة':''}} محصول {{$item3}} من سنة {{$item}} لسنة {{$item2}}
                        </h1>
                        <div class="col-md-2">
                            <input type="submit" name="Button1" value="رجوع" id="Button1" class="btn btn-success" style="margin-left:20px;margin-top: 0" onclick="window.location='{{route("databasesSearch",$CurrentCategory->id)}}'">
                        </div>
                        <h2 class="col-md-10" style="text-align: center;font-size: 18px">({{$seasons[$type]}})</h2>

                    @endif
                </div>

            </div>
            <div class="table-responsive mgt40">
                    <table  class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th>سنة</th>
                            <th>الأسعار المزرعية
                                (جنيه/طن)
                            </th>
                            <!--<th>أسعار الجملة-->
                            <!--    (جنيه/طن)-->
                            <!--</th>-->
                            <th>الأسعار المتداولة
                                (جنيه/كيلو)
                            </th>

                        </tr>
                        </thead>
                        <tbody class="txtcolor">
                        <!-- bg-cloro1 -->
                        @foreach($ListArr as $row)
                            <tr class="bg-cloro2">
                                <td>{{$row->year}}</td>
                                <td>{{round($row->farm_price,2)}}</td>
                                <!--<td>{{round($row->total_price,2)}}</td>-->
                                <td>{{round($row->trading_price,2)}}</td>
                            </tr>
                        @endforeach
                        @if($details)
                            <tr>
                                <td>الإجمالي</td>
                                <td>{{round($total_old_area,2)}}</td>
                                <td>{{round($total_old_quantity/$total_old_area,2)}}</td>
                                <td>{{round($total_old_quantity,2)}}</td>
                                <td>{{round($total_new_area,2)}}</td>
                                <td>{{round($total_new_quantity/$total_new_area,2)}}</td>
                                <td>{{round($total_new_quantity,2)}}</td>
                                <td>{{round($total_old_area+$total_new_area,2)}}</td>
                                <td>{{round(($total_old_area+$total_new_area)/($total_old_quantity+$total_new_quantity),2)}}</td>
                                <td>{{round($total_old_quantity+$total_new_quantity,2)}}</td>
                            </tr>
                        @endif
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
        function sendQuery(draw) {
            var url ='{{route("databasesSearch",$CurrentCategory->id)}}'
            var type = $('select[name=type]').val();
            var type_group = $('select[name=type_group]').val();
            var item = $('select[name=item]').val();
            var item2 = $('select[name=item2]').val();
            var crop_name = $('select[name=crop_name]').val();
            var fullURL= url+"?type="+type+"&item="+item+"&item2="+item2+"&crop_name="+crop_name+((draw)?'&draw=1':'');
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
