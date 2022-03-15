@extends('frontEnd.layout')
@section('content')
    <?php
    $name = "title_" . trans('backLang.boxCode');
    ?>
    <!-- BLOCK "TYPE 11" -->
    <div class="new-block type-inner">
        <div class="container">
            <div class="col-sm-6 col-xs-12 pdt25">الخريطة المحصولية</div>
            <div class="col-sm-6 col-xs-12 text-left path-links">
                <a href="{{ route("Home") }}">الرئيسية</a>
                <a href="{{ route("Map") }}">الخريطة المحصولية</a>
                <a class="active">المراكز</a>
            </div>
        </div>

    </div>



    <!-- BLOCK "TYPE 3" -->
    <div class="new-block has-pattern2">
        <div class="container type-3-text">

            <div class="row">
                <div class="col-md-12">
                    <div class="flag">

                        <h2> محصول {{$crop->$name}} لمراكز محافظة {{ $city->$name }} لسنة {{$year}}</h2>
                    </div>
                </div>
            </div>
            @php
                $total_area=0;
                $total_quantity=0;
            @endphp
            <div class="table-responsive mgt40">
                <table  class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th>المركز</th>
                        <th>مساحة</th>
                        <th>انتاج</th>
                        <th>إنتاجية</th>

                    </tr>
                    </thead>
                    <tbody class="txtcolor">
                    @foreach($city_crops as $crop_city)
                        @php
                            $total_area+=$crop_city->area??0;
                            $total_quantity+=$crop_city->quantity??0;
                        @endphp
                    <tr>
                      <td>
                          {{$crop_city->Center->$name}}
                      </td>
                        <td>
                          {{$crop_city->area}}
                        </td>
                    <td>
                          {{$crop_city->quantity}}
                    </td>
                        <td>
                          {{$crop_city->productivity}}
                      </td>
                    </tr>
                   @endforeach
                    <tr>
                        <td>
                            إجمالي
                        </td>
                        <td>
                            {{number_format($total_area,2)}}
                        </td>
                        <td>
                            {{number_format($total_quantity,2)}}
                        </td>
                        <td>
                            {{number_format($total_quantity/$total_area,2)}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection
