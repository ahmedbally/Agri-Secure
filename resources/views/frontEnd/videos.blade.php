@extends('frontEnd.layout')

@section('content')
    @include('frontEnd.includes.breadcrumb')       
    <div class="new-block has-pattern2">
        <div class="container type-3-text">
            <div class="row">
                @if($Topics->total() > 0)
                    <?php
                        $title_var = "title_" . trans('backLang.boxCode');
                        $title_var2 = "title_" . trans('backLang.boxCodeOther');
                        $slug_var = "seo_url_slug_" . trans('backLang.boxCode');
                        $slug_var2 = "seo_url_slug_" . trans('backLang.boxCodeOther');
                    ?>
                    @foreach($Topics as $Topic)
                        <?php
                        if ($Topic->$title_var != "") {
                            $title = $Topic->$title_var;
                        } else {
                            $title = $Topic->$title_var2;
                        }
                        ?>

                        <div class="col-md-6">
                            <div class="bggry">                         
                                <div class="eve">
                                    @if($Topic->video_type==0 && $Topic->video_file!="")                                            
                                        <video width="100%" height="310" controls>
                                            <source src="{{ URL::to('uploads/topics/'.$Topic->video_file) }}" type="video/mp4">
                                        </video>
                                    @elseif($Topic->video_type==3)
                                    {!!$Topic->video_file!!}
                                    @else
                                        <iframe width="100%" height="310" src="{{$Topic->video_file}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    @endif
                                                                 
                                </div>
                                <h3 class="evehead" style="color: #fff">{{$title}}</h3>
                            </div>
                        </div>
                    @endforeach
                @endif  
            </div>
        </div>
    </div> 
    @include('frontEnd.includes.visits',['customVisits'=>true])
@endsection