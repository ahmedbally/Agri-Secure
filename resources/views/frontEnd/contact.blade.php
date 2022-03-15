@extends('frontEnd.layout')
@section('content')
    @include('frontEnd.includes.breadcrumb')       

    <?php
    $title_var = "title_" . trans('backLang.boxCode');
    $title_var2 = "title_" . trans('backLang.boxCodeOther');
    $details_var = "details_" . trans('backLang.boxCode');
    $details_var2 = "details_" . trans('backLang.boxCodeOther');
    if ($Topic->$title_var != "") {
        $title = $Topic->$title_var;
    } else {
        $title = $Topic->$title_var2;
    }
    if ($Topic->$details_var != "") {
        $details = $details_var;
    } else {
        $details = $details_var2;
    }
    $section = "";
    try {
        if ($Topic->section->$title_var != "") {
            $section = $Topic->section->$title_var;
        } else {
            $section = $Topic->section->$title_var2;
        }
    } catch (Exception $e) {
        $section = "";
    }
    ?>
    <div class="block type-7 scroll-to-block pdtb50" id="contact_div">
        <div class="container">
            <div class="row" id="sendmessage" style="display: none;">
                <div class="col-lg-12">
                    <div class="alert alert-success m-b-0">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        {{ trans('frontLang.messageRecieved') }}
                    </div>
                </div>
            </div>

            <div class="row" id="errormessage" style="display: none;">
                <div class="col-lg-12">
                    <div class="alert alert-danger m-b-0">
                        <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button> -->
                        <span id="errormessageTxt"></span>
                    </div>
                </div>
            </div>
            @if(Session::has('doneMessage'))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success m-b-0">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ Session::get('doneMessage') }}
                        </div>
                    </div>
                </div>
            @endif

            @if(Session::has('errorMessage'))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-danger m-b-0">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ Session::get('errorMessage') }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-4">
                    <div class="infobox">
                        @if(Helper::GeneralSiteSettings("contact_t1_" . trans('backLang.boxCode')) !="")                            
                        <div class="contact-thumbs">
                            <img class="pd0" src="{{ URL::asset('frontEnd/img/address.svg')}}" alt="" width="24">
                            <article class="normall">
                                <p class="pd0">
                                  {{ trans('frontLang.address') }}:
                                  <br>
                                  <a>{{ Helper::GeneralSiteSettings("contact_t1_" . trans('backLang.boxCode')) }}</a> 
                                </p>
                            </article>
                        </div>
                        @endif 
                        @if(Helper::GeneralSiteSettings("contact_t3") !="")
                            <div class="contact-thumbs">
                                <img class="pd0" src="{{ URL::asset('frontEnd/img/phone.svg')}}" alt="" width="24">
                                <article class="normall">
                                    <p class="pd0">
                                      {{ trans('frontLang.callPhone') }}:
                                      <br>
                                      <a href="tel:{{ Helper::GeneralSiteSettings('contact_t3') }}">{{ Helper::GeneralSiteSettings("contact_t3") }}</a> 
                                    </p>
                                </article>
                            </div>
                        @endif
                        @if(Helper::GeneralSiteSettings("contact_t4") !="")
                            <div class="contact-thumbs">
                                <img class="pd0" src="{{ URL::asset('frontEnd/img/fax.svg')}}" alt="" width="24">
                                <article class="normall">
                                    <p class="pd0">
                                      {{ trans('frontLang.callFax') }}:
                                      <br>
                                      <a>{{ Helper::GeneralSiteSettings("contact_t4") }}</a> 
                                    </p>
                                </article>
                            </div> 
                        @endif
                        
                         @if(Helper::GeneralSiteSettings("contact_t6") !="")
                            <div class="contact-thumbs">
                                <img class="pd0" src="{{ URL::asset('frontEnd/img/email.svg')}}" alt="" width="24">
                                <article class="normall">
                                    <p class="pd0">
                                      {{ trans('frontLang.email') }}: 
                                      <br>
                                      <a href="mailto:{{ Helper::GeneralSiteSettings('contact_t6') }}">{{ Helper::GeneralSiteSettings("contact_t6") }}</a>
                                    </p>
                                </article>
                            </div>
                        @endif

                        @if(Helper::GeneralSiteSettings("contact_t7_" . trans('backLang.boxCode')) !="")
                            <div class="contact-thumbs">
                                <img class="pd0" src="{{ URL::asset('frontEnd/img/001.svg')}}" alt="" width="24">
                                <article class="normall">
                                    <p class="pd0">
                                      {{ trans('frontLang.callTimes') }}: 
                                      <br>
                                      <a>{{ Helper::GeneralSiteSettings("contact_t7_" . trans('backLang.boxCode')) }}</a>
                                    </p>
                                </article>
                            </div>
                        @endif
                            
                    </div>
                </div>
                <div class="col-md-8">
                    {{Form::open(['route'=>['contactPageSubmit'],'method'=>'POST','class'=>'contactForm'])}}
                        <div class="form-group col-md-12">
                            {!! Form::text('contact_name',"", array('placeholder' => trans('frontLang.yourName'),'class' => 'newinp','id'=>'name', 'data-msg'=> trans('frontLang.enterYourName'),'data-rule'=>'minlen:4')) !!}
                            <div class="validation">{{$errors->first('contact_name')}}</div>
                        </div>
                        <div class="form-group col-md-12">
                             {!! Form::email('contact_email',"", array('placeholder' => trans('frontLang.yourEmail'),'class' => 'newinp','id'=>'email', 'data-msg'=> trans('frontLang.enterYourEmail'),'data-rule'=>'email')) !!}
                            <div class="validation">{{$errors->first('contact_email')}}</div>
                        </div>
                        <div class="form-group col-md-12">
                             {!! Form::text('contact_phone',"", array('placeholder' => trans('frontLang.phone'),'class' => 'newinp','id'=>'phone', 'data-msg'=> trans('frontLang.enterYourPhone'),'data-rule'=>'minlen:4')) !!}
                            <div class="validation">{{$errors->first('contact_phone')}}</div>
                        </div>
                        <div class="form-group col-md-12">
                             {!! Form::text('contact_subject',"", array('placeholder' => trans('frontLang.subject'),'class' => 'newinp','id'=>'subject', 'data-msg'=> trans('frontLang.enterYourSubject'),'data-rule'=>'minlen:4')) !!}
                            <div class="validation">{{$errors->first('contact_subject')}}</div>
                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::textarea('contact_message','', array('placeholder' => trans('frontLang.message'),'class' => 'newarea','id'=>'message','rows'=>'8', 'data-msg'=> trans('frontLang.enterYourMessage'),'data-rule'=>'required')) !!}
                            <div class="validation">{{$errors->first('contact_message')}}</div>
                        </div>
                        @if(env('NOCAPTCHA_STATUS', false))
                            <div class="form-group col-md-12">
                                {!! NoCaptcha::renderJs(trans('backLang.code')) !!}
                                {!! NoCaptcha::display() !!}
                                <div class="validation">{{$errors->first('g-recaptcha-response')}}</div>
                            </div>
                        @endif
                        <div class="form-group col-md-12">
                            <div class="pothrz">
                                <div class="button">{{ trans('frontLang.sendMessage') }}
                                    <input type="submit" value="{{ trans('frontLang.sendMessage') }}">
                                </div>
                            </div>                                  
                        </div>                                  
                    {{Form::close()}}
                </div>                        
            </div>
            
        </div>
    </div>
    
    
    @if(count($Topic->maps) >2222222222)
    <div class="mgt20" id="google-map">
    </div>
    @endif
    @if(count($Topic->maps) >0)
    <div class="mgt20">
        <iframe scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.eg/maps?sll={{$Topic->maps[0]->longitude}},{{$Topic->maps[0]->latitude}}&amp;sspn={{$Topic->maps[0]->longitude}},{{$Topic->maps[0]->latitude}}&amp;cid=0&amp;q={{$Topic->maps[0]->longitude}},{{$Topic->maps[0]->latitude}}&amp;ie=UTF8&amp;t=m&amp;ll={{$Topic->maps[0]->longitude}},{{$Topic->maps[0]->latitude}}&amp;spn=0.006295,0.006295&amp;output=embed" width="100%" height="400" frameborder="0"></iframe>
    </div>
    @endif

@endsection
@section('footerInclude')
    @if(count($Topic->maps) >2222222222)
        @foreach($Topic->maps->slice(0,1) as $map)
            <?php
            $MapCenter = $map->longitude . "," . $map->latitude;
            ?>
        @endforeach
        <?php
        $map_title_var = "title_" . trans('backLang.boxCode');
        $map_details_var = "details_" . trans('backLang.boxCode');
        ?>
        <script type="text/javascript"
                src="//maps.google.com/maps/api/js?key={{env('gmapkey')}}"></script>

        <script type="text/javascript">
            // var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
            var iconURLPrefix = "{{ URL::to('backEnd/assets/images/')."/" }}";
            var icons = [
                iconURLPrefix + 'marker_0.png',
                iconURLPrefix + 'marker_1.png',
                iconURLPrefix + 'marker_2.png',
                iconURLPrefix + 'marker_3.png',
                iconURLPrefix + 'marker_4.png',
                iconURLPrefix + 'marker_5.png',
                iconURLPrefix + 'marker_6.png'
            ]

            var locations = [
                    @foreach($Topic->maps as $map)
                ['<?php echo "<strong>" . $map->$map_title_var . "</strong>" . "<br>" . $map->$map_details_var; ?>', <?php echo $map->longitude; ?>, <?php echo $map->latitude; ?>, <?php echo $map->id; ?>, <?php echo $map->icon; ?>],
                @endforeach
            ];

            var map = new google.maps.Map(document.getElementById('google-map'), {
                zoom: 12,
                draggable: false,
                scrollwheel: false,
                center: new google.maps.LatLng(<?php echo $MapCenter; ?>),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    icon: icons[locations[i][4]],
                    map: map
                });

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
        </script>
    @endif
    <script type="text/javascript">

        jQuery(document).ready(function ($) {
            "use strict";

            //Contact
            $('form.contactForm').submit(function (e) {
                e.preventDefault()
                var f = $(this).find('.form-group'),
                    ferror = false,
                    emailExp = /^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i;
                console.log('afewefwefew');
                f.children('input').each(function () { // run all inputs

                    var i = $(this); // current input
                    var rule = i.attr('data-rule');

                    if (rule !== undefined) {
                        var ierror = false; // error flag for current input
                        var pos = rule.indexOf(':', 0);
                        if (pos >= 0) {
                            var exp = rule.substr(pos + 1, rule.length);
                            rule = rule.substr(0, pos);
                        } else {
                            rule = rule.substr(pos + 1, rule.length);
                        }

                        switch (rule) {
                            case 'required':
                                if (i.val() === '') {
                                    ferror = ierror = true;
                                }
                                break;

                            case 'minlen':
                                if (i.val().length < parseInt(exp)) {
                                    ferror = ierror = true;
                                }
                                break;

                            case 'email':
                                if (!emailExp.test(i.val())) {
                                    ferror = ierror = true;
                                }
                                break;

                            case 'checked':
                                if (!i.attr('checked')) {
                                    ferror = ierror = true;
                                }
                                break;

                            case 'regexp':
                                exp = new RegExp(exp);
                                if (!exp.test(i.val())) {
                                    ferror = ierror = true;
                                }
                                break;
                        }
                        i.next('.validation').html('<i class=\"fa fa-info\"></i> &nbsp;' + ( ierror ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '' )).show();
                        !ierror ? i.next('.validation').hide() : i.next('.validation').show();
                    }
                });
                f.children('textarea').each(function () { // run all inputs

                    var i = $(this); // current input
                    var rule = i.attr('data-rule');

                    if (rule !== undefined) {
                        var ierror = false; // error flag for current input
                        var pos = rule.indexOf(':', 0);
                        if (pos >= 0) {
                            var exp = rule.substr(pos + 1, rule.length);
                            rule = rule.substr(0, pos);
                        } else {
                            rule = rule.substr(pos + 1, rule.length);
                        }

                        switch (rule) {
                            case 'required':
                                if (i.val() === '') {
                                    ferror = ierror = true;
                                }
                                break;

                            case 'minlen':
                                if (i.val().length < parseInt(exp)) {
                                    ferror = ierror = true;
                                }
                                break;
                        }
                        i.next('.validation').html('<i class=\"fa fa-info\"></i> &nbsp;' + ( ierror ? (i.attr('data-msg') != undefined ? i.attr('data-msg') : 'wrong Input') : '' )).show();
                        !ierror ? i.next('.validation').hide() : i.next('.validation').show();
                    }
                });
                if (ferror) return false;
                else var str = $(this).serialize();
                var xhr = $.ajax({
                    type: "POST",
                    url: "<?php echo route("contactPageSubmit"); ?>",
                    data: str,
                    success: function (msg) {
                        if (msg == 'OK') {
                            $("#sendmessage").addClass("show");
                            $("#errormessage").removeClass("show");
                            $("#name").val('');
                            $("#email").val('');
                            $("#phone").val('');
                            $("#subject").val('');
                            $("#message").val('');
                        }else {
                            $("#sendmessage").removeClass("show");
                            $("#errormessage").addClass("show");
                            $('#errormessageTxt').html(msg);
                        }
                        $(window).scrollTop($('#contact_div').offset().top);
                    }
                });
                //console.log(xhr);
                return false;
            });

        });
    </script>

@endsection