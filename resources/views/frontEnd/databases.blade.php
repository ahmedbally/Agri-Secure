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
                <h1 class="col-md-12">اجمالي التكتلات حسب المجموعة الصنفية</h1>

                <div class="col-md-3">
                    <strong><span class="control-label">نوع التجارة</span></strong>
                    <select class="selectpicker show-menu-arrow" name="select1">
                        @foreach($select1 as $select)
                            <option value="{{$select->mmcod}}">{{$select->name}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <strong><span class="control-label">العام</span></strong>
                    <select class="selectpicker show-menu-arrow">
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <strong><span class="control-label">المجموعة الصنفية</span></strong>
                    <select class="selectpicker show-menu-arrow">
                        <option value="1">الحبوب</option>
                        <option value="2">خضر ونباتات وجذور ودرنات</option>
                        <option value="3">فواكه وأثمار قشرية وقشور</option>
                        <option value="4">الألياف</option>
                        <option value="5">الحيوانات الحية</option>
                        <option value="6">اللحوم ومستحضرات اللحوم</option>                      
                    </select>
                </div>
                
                <div class="col-md-3">
                    <input type="submit" name="Button1" value="بحث" id="Button1" class="btn btn-success">
                </div>

            </div>
        </div>

    
        <div class="table-responsive mgt40">
            <table  class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                      <th>التكتل</th>
                      <th>المحصول</th>
                      <th>الدولة</th>
                      <th>الكمية بالكيلو</th>
                      <th>العدد بالوحدة </th>
                      <th>القيمة بالجنيه</th>
                      <th>القيمة بالدولار</th>
                    </tr>
                </thead>
                <tbody class="txtcolor">
                    <tr>
                      <th>2010</th>
                      <td>20000 طن</td>
                      <td>5000 طن</td>
                      <td>23300 طن</td>
                      <td>350000 طن</td>
                      <td>350000 طن</td>
                      <th>2010</th>
                    </tr>
                    <tr>
                      <th>2011</th>
                      <td>20000 طن</td>
                      <td>5000 طن</td>
                      <td>23300 طن</td>
                      <td>350000 طن</td>
                      <td>350000 طن</td>
                      <th>2010</th>
                    </tr>
                    <tr>
                      <th>2012</th>
                      <td>20000 طن</td>
                      <td>5000 طن</td>
                      <td>23300 طن</td>
                      <td>350000 طن</td>
                      <td>350000 طن</td>
                      <th>2010</th>
                    </tr>
                    <tr class="bg-cloro1">
                      <th></th>
                      <td>اجمالي</td>
                      <td>5000</td>
                      <td>23300</td>
                      <td>ـ</td>
                      <td>350000 طن</td>
                      <th></th>
                    </tr>
                    <tr class="bg-cloro2">
                        <th></th>
                        <td>اجمالي</td>
                        <td>5000</td>
                        <td>23300</td>
                        <td>ـ</td>
                        <td>350000 طن</td>
                        <th></th>
                      </tr>
                    <tr>
                      <th>2015</th>
                      <td>20000 طن</td>
                      <td>5000 طن</td>
                      <td>23300 طن</td>
                      <td>350000 طن</td>
                      <td>350000 طن</td>
                      <th>2010</th>
                    </tr>
                    <tr>
                      <th>2016</th>
                      <td>20000 طن</td>
                      <td>5000 طن</td>
                      <td>23300 طن</td>
                      <td>350000 طن</td>
                      <td>350000 طن</td>
                      <th>2010</th>
                    </tr>
                    <tr>
                      <th>2017</th>
                      <td>20000 طن</td>
                      <td>5000 طن</td>
                      <td>23300 طن</td>
                      <td>350000 طن</td>
                      <td>350000 طن</td>
                      <th>2010</th>
                    </tr>
                    <tr class="bg-cloro1">
                        <th></th>
                        <td>اجمالي</td>
                        <td>5000</td>
                        <td>23300</td>
                        <td>ـ</td>
                        <td>350000 طن</td>
                        <th></th>
                      </tr>
                      <tr class="bg-cloro2">
                          <th></th>
                          <td>اجمالي</td>
                          <td>5000</td>
                          <td>23300</td>
                          <td>ـ</td>
                          <td>350000 طن</td>
                          <th></th>
                        </tr>
                      <tr>
                    <tr>
                      <th>2020</th>
                      <td>20000 طن</td>
                      <td>5000 طن</td>
                      <td>23300 طن</td>
                      <td>350000 طن</td>
                      <td>350000 طن</td>
                      <th>2010</th>
                    </tr>
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
        });
    </script>
@endsection
