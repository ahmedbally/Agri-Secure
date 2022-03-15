<!-- BLOCK "TYPE 11" -->

@if(count($SliderBanners)>0)

    <div class="new-block type-11 scroll-to-block" data-id="home">

        <!-- start slider -->

        <!-- Slider -->

        @foreach($SliderBanners->slice(0,1) as $SliderBanner)

            <?php

            try {

                $SliderBanner_type = $SliderBanner->webmasterBanner->type;

            } catch (Exception $e) {

                $SliderBanner_type = 0;

            }

            ?>

        @endforeach

        <?php

        $title_var = "title_" . trans('backLang.boxCode');

        $details_var = "details_" . trans('backLang.boxCode');

        $file_var = "file_" . trans('backLang.boxCode');

        ?>

        @if($SliderBanner_type==0)

            {{-- Text/Code Banners--}}

            <div class="text-center">

                @foreach($SliderBanners as $SliderBanner)

                    @if($SliderBanner->$details_var !="")

                        <div>{!! $SliderBanner->$details_var !!}</div>

                    @endif

                @endforeach

            </div>

        @elseif($SliderBanner_type==1)

            {{-- Photo Slider Banners--}}



            <div class="swiper-container horizontal-pagination gallery-top" dir="rtl" data-autoplay="5000" data-loop="1" data-speed="500" data-center="0" data-slides-per-view="1">

                <div class="swiper-wrapper">

                    @foreach($SliderBanners as $SliderBanner)

                        <div class="swiper-slide">

                            <img src="{{ URL::to('uploads/banners/'.$SliderBanner->$file_var) }}"

                                 alt="{{ $SliderBanner->$title_var }}" class="center-image"/>

                            <div class="center-tagline">

                                <div class="container">

                                    <div class="row">

                                        <div class="col-md-6 banner-text">

                                            <div class="banner-article">

                                                <h1 class="title text-center hidden-xs" style="font-family:'regular';font-variant:300;"></h1>

                                                <span class="visible-xs"><br/><br/><br/><br/></span>

                                                @if($SliderBanner->$details_var !="")

                                                    <h1 class="title text-center">{!! $SliderBanner->$title_var !!}</h1>

                                                @endif

                                                @if($SliderBanner->$details_var !="")

                                                    <h1 class="title text-center smltxt">{!! nl2br($SliderBanner->$details_var) !!}</h1>

                                                @endif



                                                @if($SliderBanner->link_url !="")

                                                    <div class="text-center head-buttons">
                                                        {!! $SliderBanner->link_url !!}
                                                        <!-- <a class="round-button" href="#"><span> {{ trans('frontLang.downBrochure') }} <img src="{{ URL::asset('frontEnd/img/dnicon.png')}}"/></span></a> -->

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                <div class="pagination"></div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

            </div>

            <div class="gallery-thumbs">
                <div class="swiper-wrapper">
                    @foreach($SliderBanners as $SliderBanner)
                    <div title="{{ $SliderBanner->$title_var }}" class="swiper-slide" style="background-image:url({{ URL::to('uploads/banners/'.$SliderBanner->$file_var) }})"></div>
                    @endforeach
                </div>
            </div>


    @endif

    <!-- end slider -->

    </div>

@endif

