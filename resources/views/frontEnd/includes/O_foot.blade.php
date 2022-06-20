<?php $segment1= Request::segment( 1 ); ?>
<script src="{{ URL::asset('frontEnd/js/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('frontEnd/js/idangerous.swiper.min.js')}}"></script>
@if ($segment1=='photos')
    <script src="{{ URL::asset('frontEnd/js/lightbox/jquery.fancybox.pack.js')}}"></script>
@endif
<script src="{{ URL::asset('frontEnd/js/global.js')}}"></script>

<script src="{{ URL::asset('frontEnd/js/wow.min.js')}}"></script>


<script>
    var wow = new WOW(
        {
            boxClass:     'wow',      // animated element css class (default is wow)
            animateClass: 'animated', // animation css class (default is animated)
            offset:       100,          // distance to the element when triggering the animation (default is 0)
            mobile:       true,       // trigger animations on mobile devices (default is true)
            live:         true,       // act on asynchronously loaded content (default is true)
            callback:     function(box) {
              // the callback is fired every time an animation is started
              // the argument that is passed in is the DOM node being animated
            }
        }
    );
    @if ($segment1=='')
        $(window).on('load', function(){
            wow.init();
        });
    @endif
    @if ($segment1=='photos')
        $(window).on('load', function(){
            wow.init();
            $(".fancybox").fancybox();
        });
    @endif
</script>
@if ($segment1=='')
    <!-- portfolio with filtering -->
    <script src="{{ URL::asset('frontEnd/js/isotope.pkgd.min.js')}}"></script>
    <script>
        $(function(){
            $(window).on('load', function(){
                var $container_filter = $('.filter-container').isotope({
                    itemSelector: '.filter-item',
                    masonry: {
                        columnWidth: '.filtergrid-sizer'
                    }
                });
                $container_filter.isotope({ filter: '.filter-1' });
                $('.filter-button').on( 'click', function() {
                  var filterValue = $(this).attr('data-filter');
                  $container_filter.isotope({ filter: filterValue });
                  $(this).parent().find('.active').removeClass('active');
                  $(this).addClass('active');
                });
            });
        });
    </script>

    <script>
        $(function(){
            FusionCharts.ready(function () {
                window.populationMap = new FusionCharts({
                    type: 'maps/egypt',
                    renderAt: 'agriculture',
                    width: '100%',
                    height: '100%',
                    dataFormat: 'json',
                    dataSource: {
                        "chart": {
                            "caption": "",
                            "showBorder": "1",
                            "borderColor": "#000000",
                            "borderThickness": "1",
                            "theme": "fint",
                            "formatNumberScale": "0",
                            "showLabels": "1",
                            "textDirection":"1",
                            "entityFillhoverColor":"#ff7d33",
                            "includeNameInLabels": "1",
                            "fontColor": "white",
                            "useSNameInLabels": "0",
                            "nullEntityColor": "#c6c6c6",
                            "stroke": "#ff9800",
                            "showMarkerLabels": "1",
                        },
                    },
                    "events": {
                        "entityClick": function (evt, data) {
                            window.location.href='/city/'+(data.shortLabel);

                        },
                    }
                });
                populationMap.render()
                $.ajax({
                    "url":"/map/2010/",
                    "success": function(data){
                        // create an object with the key of the array
                        populationMap.setJSONData({
                            chart:{
                                "caption": "",
                                "showBorder": "1",
                                "borderColor": "#000000",
                                "borderThickness": "1",
                                "theme": "fint",
                                "formatNumberScale": "0",
                                "showLabels": "1",
                                "textDirection":"1",
                                "entityFillhoverColor":"#ff7d33",
                                "includeNameInLabels": "1",
                                "fontColor": "white",
                                "useSNameInLabels": "0",
                                "nullEntityColor": "#c6c6c6",
                                "stroke": "#ff9800",
                                "showMarkerLabels": "1",
                            },
                            "colorrange": {
                                "color": data.color
                            },
                            "data": data.data
                        });
                        populationMap.render();
                    },
                    "error": function(data){
                        alert('error');
                    }
                })
            });
            $('#agr').on('change',function () {
                $.ajax({
                    "url":"/map/2010/"+$(this).val(),
                    "success": function(data){
                        // create an object with the key of the array
                        populationMap.setJSONData({
                            chart:{
                                "caption": "",
                                "showBorder": "1",
                                "borderColor": "#000000",
                                "borderThickness": "1",
                                "theme": "fint",
                                "formatNumberScale": "0",
                                "showLabels": "1",
                                "textDirection":"1",
                                "entityFillhoverColor":"#ff7d33",
                                "includeNameInLabels": "1",
                                "fontColor": "white",
                                "useSNameInLabels": "0",
                                "nullEntityColor": "#c6c6c6",
                                "stroke": "#ff9800",
                                "showMarkerLabels": "1",
                            },
                            "colorrange": {
                                "color": data.color
                            },
                            "data": data.data
                        });
                        populationMap.render();
                    },
                    "error": function(data){
                        alert('error');
                    }
                })

            });
            $(window).on('load', function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var $container_filter = $('.filter-container').isotope({
                    itemSelector: '.filter-item',
                    masonry: {
                        columnWidth: '.filtergrid-sizer'
                    }
                });
                $container_filter.isotope({ filter: '.filter-1' });
                $('.filter-button').on( 'click', function() {
                    var filterValue = $(this).attr('data-filter');
                    $container_filter.isotope({ filter: filterValue });
                    $(this).parent().find('.active').removeClass('active');
                    $(this).addClass('active');
                });
            });
        });
    </script>
@endif
<script src="{{ URL::asset('frontEnd/js/subscription.js')}}"></script>
