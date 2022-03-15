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
                <h1 class="col-md-12">إجماليات الثروة الداجنة</h1>

                <div class="col-md-3">
                    <strong><span class="control-label">ألنوع :  </span></strong>
                    <select class="selectpicker show-menu-arrow" name="type_group">
                        <option value="">اختر</option>
                        @foreach($select1 as $select)
                            <option value="{{$select->type}}" @if($select->type == $type_group) selected @endif>{{$select->type}}</option>
                        @endforeach
                    </select>
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
                      <th colspan="3"></th>
                      <th colspan="3">عدد العنابر</th>
                      <th colspan="2">الطاقة الكلية  <i class="count"></i></th>
                      <th colspan="2">الطاقة الفعلية  <i class="count"></i></th>
                    </tr>
                    <tr>
                      <th>السنة</th>
                      <th>النوع</th>
                      <th>المزارع</th>
                      <th>عامله</th>
                      <th>غ . عامله</th>
                      <th>جملة</th>
                      <th class="f_capacity_item">الف طائر</th>
                      <th class="f_capacity_prod">مليون بيضة</th>
                      <th class="a_capacity_item">الف طائر</th>
                      <th class="a_capacity_prod">مليون بيضة</th>
                    </tr>
                </thead>
                <tbody class="txtcolor" id="rep4_1">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="new-block has-pattern2">
    <div class="container type-3-text">
        <div class="row">
            <div class="infooo" width="100%">
                <h1 class="col-md-12">الإنتاج الحيواني – مصانع اعلاف الدواجن</h1>

                <div class="col-md-3">
                    <strong><span class="control-label">العام  من :</span></strong>
                    <select class="selectpicker show-menu-arrow" name="item2">
                        <option value="">اختر</option>
                        @foreach($select2 as $select)
                            <option value="{{$select->year}}" @if($select->year == $item) selected @endif >{{$select->year}}</option>
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
                      <th>عدد المصانع العاملة</th>
                      <th>الطاقة الكلية (طن)</th>
                      <th>الطاقة الفعلية (طن)</th>
                    </tr>
                </thead>
                <tbody class="txtcolor" id="rep4_2">
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
            var type = $('select[name=type]').val();
            var type_group = $('select[name=type_group]').val();
            var item = $('select[name=item'+repIndex+']').val();
            var item2 = $('select[name=item2'+repIndex+']').val();
            var fullURL= url+"?item="+item+"&item2="+item2;
            fullURL= (repIndex==1)? fullURL+"type_group="+type_group : fullURL;

            console.log('fullURL');
            console.log(fullURL);
            if (!repIndex) {
                window.location = fullURL;
            }else{
                var params= {ajax:1,item:item,item2:item2,repIndex:repIndex};
                if (repIndex==1){
                    params.type_group=type_group;
                    if (type_group =="الأرانب") {
                        $('.f_capacity_item').html('عدد الأمهات');
                        $('.f_capacity_prod').html('عدد  الانتاج');
                        $('.a_capacity_item').html('عدد الأمهات');
                        $('.a_capacity_prod').html('عدد  الانتاج');

                        $('.count').html('( ألف ارنب )');
                    }else{
                        $('.f_capacity_item').html('ألف طائر');
                        $('.f_capacity_prod').html('مليون بيضة');
                        $('.a_capacity_item').html('ألف طائر');
                        $('.a_capacity_prod').html('مليون بيضة');
                        $('.count').html('');
                    }
                } 
                $.get(url, params, function(response) { // requesting url which in form
                    $('#rep4_'+repIndex).html(response); // getting response and pushing to element with id #response
                });
            }
        }
    </script>
@endsection
