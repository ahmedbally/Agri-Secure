<?php $segment1= Request::segment( 1 ); ?>
<script src="{{ URL::asset('frontEnd/js/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('frontEnd/js/idangerous.swiper.min.js')}}"></script>
@if ($segment1=='photos')
    <script src="{{ URL::asset('frontEnd/js/lightbox/jquery.fancybox.pack.js')}}"></script>
@endif
<script src="{{ URL::asset('frontEnd/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{ URL::asset('frontEnd/js/global.js')}}"></script>
<script src="{{ URL::asset('https://printjs-4de6.kxcdn.com/print.min.js')}}"></script>
<script src="{{ URL::asset('frontEnd/js/wow.min.js')}}"></script>

<script>
    $(document).on("click", "#open-popup", function(e){
        e.preventDefault();
        $(this).magnificPopup({
          type: 'iframe',
          mainClass: 'mfp-fade',
          midClick:true,
          closeOnBgClick: true,
          fixedContentPos: false,
          callbacks: {
            open: function() {
              $('body').addClass('noscroll');
            },
            close: function() {
              $('body').removeClass('noscroll');
            }
          }
         }).magnificPopup('open');
    });
      
    
</script>
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
        $(window).load(function(){
            wow.init();
        });
    @endif
    @if ($segment1=='photos')
        $(window).load(function(){
            wow.init();
            $(".fancybox").fancybox();
        });
    @endif
</script>
@if($segment1=='' || $segment1=='home' || $segment1=='map')
    <script>
		var scale=1;
		var margin=0
		function zoomIn(){
			if(scale < 1.6){
			scale+=.05
            margin+=200
			var svg = $("#chartobject-1 svg > g:nth-child(7)");
			svg.attr("transform","matrix(0.0599,0,0,0.0599,136,11) translate("+-margin+",0) scale(" + scale + ")");
			var svg = $("#chartobject-1 svg > g:nth-child(9)");
			svg.attr("transform","matrix(1,0,0,1,136,11) translate("+-margin*.06+",0) scale(" + scale + ")");
			}
		}
		function zoomOut(){
			if(scale > 1){
			scale-=.05
            margin-=200
            var svg = $("#chartobject-1 svg > g:nth-child(7)");
			svg.attr("transform","matrix(0.0599,0,0,0.0599,136,11) translate("+-margin+",0) scale(" + scale + ")");
            var svg = $("#chartobject-1 svg > g:nth-child(9)");
			svg.attr("transform","matrix(1,0,0,1,136,11) translate("+-margin*.06+",0) scale(" + scale + ")");
			}
		}
        function getMap(year,crop,value,season){
		    if(crop!==0 && season !=='' && value !=='')
            $.ajax({
                "url":"/map/"+year+"/"+crop+"/"+value+"?season="+season,
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
                            "legendItemFontSize": "14",

                        },
                        "colorrange": {
                            "color": data.color
                        },
                        "data": data.data
                    });
                    populationMap.render();
                    let type=$("#value [value="+value+"]").text()
                    let agr=$("#agr [value="+crop+"]").text()
                    let yea=$("#year [value="+year+"]").text()
                    let seas=$("#season [value="+season+"]").text()
                    $('h2.maptitle').text(type+' لمحصول '+agr+' لعام '+yea+' '+seas)
                },
                "error": function(data){
                    alert('error');
                }
            })
        }
        $(function(){
            let season_crops={!!  json_encode(App\CityCrop::with('Crop')->get()->groupBy('season')->map(function ($item){
                return $item->groupBy('year')->SortByDesc('year')->map(function($item){
                    return  array_values($item->unique('crop_id')->map(function($item){
                          return [$item->crop->id,$item->crop->title_ar,'/uploads/crops/'.$item->crop->image,[
                              'quantity'=>'الانتاج ('.$item->crop->quantity.')',
                              'area'=>'المساحة المزروعة ('.$item->crop->area.')',
                              'productivity'=>'الانتاجية ('.$item->crop->quantity.'/'.$item->crop->area.')',
]];
                    })->toArray());
                });

        }))!!};
            let year={{\App\CityCrop::query()->select('year')->groupBy('year')->orderBy('year','DESC')->first()->year??0}};
            let crop=0;
            let value='';
            let season='';
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
                            "legendItemFontSize": "11",

                        },
                    },
                    "events": {
                        "entityClick": function (evt, data) {
                            if(crop&&year&&season)
                            window.location.href='/city/'+(data.shortLabel)+'?crop='+crop+'&year='+year+'&season='+season;

                        },
                    }
                });
                populationMap.render()
                //getMap(year,crop,value);
            });
            $('#agr').on('change',function () {
                crop=$(this).val();
                Object.values(season_crops[season]).forEach(function (el,key) {
                    el.forEach(function (ee) {
                        if(ee[0]==crop) {
                            $("#crop_image").attr('src', ee[2]);
                            $('#value').html('')
                            $("#value").append("<option value=\"\" disabled selected>اختر</option>\n");
                            Object.keys(ee[3]).forEach(function (key) {
                                $("#value").append("<option value=\""+key+"\">"+ee[3][key]+"</option>\n");
                            })
                        }
                    })

                })
                getMap(year,crop,value,season);
            });
            $('#year').on('change',function () {
                year=$(this).val();
                $("#agr").html('')
                $("#agr").append("<option value=\"\" disabled selected>المحاصيل</option>\n");
                console.log(season_crops[$(this).val()])
                season_crops[season][year].map(function(item){
                    $("#agr").append("<option value=\""+item[0]+"\">"+item[1]+"</option>");
                })
                getMap(year,crop,value,season);
            });
            $('#value').on('change',function () {
                value=$(this).val();
                getMap(year,crop,value,season);
            });
            $('#season').on('change',function () {
                crop=0
                season=$(this).val();
                $("#year").html('')
                $("#year").append("<option value=\"\" disabled selected>السنة</option>")
                Object.keys(season_crops[season]).reverse().map(function (item) {
                    $("#year").append("<option value=\""+item+"\">"+item+"</option>");
                })
                $("#agr").html('')
                $("#agr").append("<option value=\"\" disabled selected>المحاصيل</option>\n");
                console.log(season_crops[$(this).val()])
                season_crops[season][year].map(function(item){
                    $("#agr").append("<option value=\""+item[0]+"\">"+item[1]+"</option>");
                })
                getMap(year,crop,value,season);
            });
            $(window).load(function(){
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
@if ($segment1=='' || $segment1=='home' || $segment1=='map')
    <!-- portfolio with filtering -->
    <script src="{{ URL::asset('frontEnd/js/isotope.pkgd.min.js')}}"></script>
    <script>
        $(function(){
            $(window).load(function(){
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
