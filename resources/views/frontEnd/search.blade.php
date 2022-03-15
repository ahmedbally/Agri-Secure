@extends('frontEnd.layout')
@section('content')
    <?php
    $name = "title_" . trans('backLang.boxCode');
    ?>
    <!-- BLOCK "TYPE 11" -->
    <div class="new-block type-inner">
        <div class="container">
            <div class="col-sm-6 col-xs-12 pdt25">البحث</div>
            <div class="col-sm-6 col-xs-12 text-left path-links">
                <a href="{{ route("Home") }}">الرئيسية</a>
                <a href="{{ route("Search") }}">البحث</a>
            </div>
        </div>

    </div>



    <!-- BLOCK "TYPE 3" -->
    <div class="new-block has-pattern2">
        <div class="container type-3-text">
            <script async src="https://cse.google.com/cse.js?cx=001862386756040434406:zjhslspetsg"></script>
            <div class="gcse-searchresults-only"></div>
        </div>
    </div>
@endsection
