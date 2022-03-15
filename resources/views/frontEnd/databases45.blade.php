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
                <h1 class="col-md-12">اجماليات الانتاج السمكى والحشرى والتصنيع الغذائي</h1>

                <div class="col-md-3">
                    <br><br><h2>الإنتاج السمكى :</h2>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">العام  من :</span></strong>
                    <select class="selectpicker show-menu-arrow" name="item1">
                        <option value="">اختر</option>
                        @foreach($select2 as $select)
                            <option value="{{$select->year}}"  @if($select->year == $item) selected @endif >{{$select->year}}</option>
                        @endforeach                     
                    </select>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">إلي </span></strong>
                    <select class="selectpicker show-menu-arrow" name="item21">
                        <option value="">اختر</option>
                        @foreach($select3 as $select)
                            <option value="{{$select->year}}"  @if($select->year == $item2) selected @endif >{{$select->year}}</option>
                        @endforeach                     
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="submit" name="Button1" value="بحث" id="Button1" class="btn btn-success" onclick="sendQuery(1);">
                </div>
            </div>
        </div>

        <div class="table-responsive mgt40">
            <table  class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                      <th>السنة</th>
                      <th>المصادر الطبيعية</th>
                      <th>الاستزراع السمكى</th>
                      <th>الجملة ( طن )</th>
                    </tr>
                </thead>
                <tbody class="txtcolor" id="rep5_1">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="new-block has-pattern2">
    <div class="container type-3-text">
        <div class="row">
            <div class="infooo" width="100%">
                <div class="col-md-3">
                    <br><br><h2>الإنتاج الحشرى  :</h2>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">العام  من :</span></strong>
                    <select class="selectpicker show-menu-arrow" name="item2">
                        <option value="">اختر</option>
                        @foreach($select2 as $select)
                            <option value="{{$select->year}}"  @if($select->year == $item) selected @endif >{{$select->year}}</option>
                        @endforeach                     
                    </select>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">إلي </span></strong>
                    <select class="selectpicker show-menu-arrow" name="item22">
                        <option value="">اختر</option>
                        @foreach($select3 as $select)
                            <option value="{{$select->year}}"  @if($select->year == $item2) selected @endif >{{$select->year}}</option>
                        @endforeach                     
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="submit" name="Button1" value="بحث" id="Button1" class="btn btn-success" onclick="sendQuery(2);">
                </div>
            </div>
        </div>

        <div class="table-responsive mgt40">
            <table  class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                      <th>السنة</th>
                      <th>اعداد المناحل</th>
                      <th>اعداد الخلايا</th>
                      <th>انتاج العسل ( طن )</th>
                      <th>انتاج الشمع ( طن )</th>
                      <th> انتاج الحرير ( طن )</th>
                    </tr>
                </thead>
                <tbody class="txtcolor" id="rep5_2">
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="new-block has-pattern2">
    <div class="container type-3-text">
        <div class="row">
            <div class="infooo" width="100%">
                <div class="col-md-3">
                    <br><br><h2> مصانع السكر  :</h2>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">العام  من :</span></strong>
                    <select class="selectpicker show-menu-arrow" name="item3">
                        <option value="">اختر</option>
                        @foreach($select2 as $select)
                            <option value="{{$select->year}}"  @if($select->year == $item) selected @endif >{{$select->year}}</option>
                        @endforeach                     
                    </select>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">إلي </span></strong>
                    <select class="selectpicker show-menu-arrow" name="item23">
                        <option value="">اختر</option>
                        @foreach($select3 as $select)
                            <option value="{{$select->year}}"  @if($select->year == $item2) selected @endif >{{$select->year}}</option>
                        @endforeach                     
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="submit" name="Button1" value="بحث" id="Button1" class="btn btn-success" onclick="sendQuery(3);">
                </div>
            </div>
        </div>

        <div class="table-responsive mgt40">
            <table  class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                      <th>السنة</th>
                      <th>الصنف</th>
                      <th>عدد المصانع</th>
                      <th>الطاقة الكلية ( طن )</th>
                      <th>الكميات الموردة ( طن )</th>
                      <th>%  كفاءة التشغيل</th>
                      <th>إنتاج السكر ( طن )</th>
                      <th>%  معامل الاستخراج</th>
                    </tr>
                </thead>
                <tbody class="txtcolor" id="rep5_3">
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="new-block has-pattern2">
    <div class="container type-3-text">
        <div class="row">
            <div class="infooo" width="100%">
                <div class="col-md-3">
                    <br><br><h2> العسل الاسود :</h2>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">العام  من :</span></strong>
                    <select class="selectpicker show-menu-arrow" name="item4">
                        <option value="">اختر</option>
                        @foreach($select2 as $select)
                            <option value="{{$select->year}}"  @if($select->year == $item) selected @endif >{{$select->year}}</option>
                        @endforeach                     
                    </select>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">إلي </span></strong>
                    <select class="selectpicker show-menu-arrow" name="item24">
                        <option value="">اختر</option>
                        @foreach($select3 as $select)
                            <option value="{{$select->year}}"  @if($select->year == $item2) selected @endif >{{$select->year}}</option>
                        @endforeach                     
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="submit" name="Button1" value="بحث" id="Button1" class="btn btn-success" onclick="sendQuery(4);">
                </div>
            </div>
        </div>

        <div class="table-responsive mgt40">
            <table  class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                      <th>السنة</th>
                      <th>الصنف</th>
                      <th>عدد العصارات</th>
                      <th>القصب المعصور ( طن )</th>
                      <th>إنتاج العسل ( طن )</th>
                      <th>%  معامل الاستخراج</th>
                    </tr>
                </thead>
                <tbody class="txtcolor" id="rep5_4">
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="new-block has-pattern2">
    <div class="container type-3-text">
        <div class="row">
            <div class="infooo" width="100%">
                <div class="col-md-3">
                    <br><br><h2>التصنيع الغذائى :</h2>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">العام  من :</span></strong>
                    <select class="selectpicker show-menu-arrow" name="item5">
                        <option value="">اختر</option>
                        @foreach($select2 as $select)
                            <option value="{{$select->year}}"  @if($select->year == $item) selected @endif >{{$select->year}}</option>
                        @endforeach                     
                    </select>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">إلي </span></strong>
                    <select class="selectpicker show-menu-arrow" name="item25">
                        <option value="">اختر</option>
                        @foreach($select3 as $select)
                            <option value="{{$select->year}}"  @if($select->year == $item2) selected @endif >{{$select->year}}</option>
                        @endforeach                     
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="submit" name="Button1" value="بحث" id="Button1" class="btn btn-success" onclick="sendQuery(5);">
                </div>
            </div>
        </div>

        <div class="table-responsive mgt40">
            <table  class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                      <th>السنة</th>
                      <th>الصنف</th>
                      <th>عدد المصانع</th>
                      <th>الطاقة الكلية ( طن )</th>
                      <th>الانتاج الفعلى ( طن )</th>
                    </tr>
                </thead>
                <tbody class="txtcolor" id="rep5_5">
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
        function sendQuery(repIndex='') {
            var url ='{{route("databasesSearch",$CurrentCategory->id)}}'
            var item = $('select[name=item'+repIndex+']').val();
            var item2 = $('select[name=item2'+repIndex+']').val();
            var fullURL= url+"?item="+item+"&item2="+item2;

            if (!repIndex) {
                window.location = fullURL;
            }else{
                var params= {ajax:1,item:item,item2:item2,repIndex:repIndex};
                $.get(url, params, function(response) { // requesting url which in form
                    $('#rep5_'+repIndex).html(response); // getting response and pushing to element with id #response
                });
            }
        }
    </script>
@endsection
