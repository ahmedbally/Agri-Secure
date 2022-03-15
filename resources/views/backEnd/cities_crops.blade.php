@extends('backEnd.layout')

@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ trans('backLang.Crops') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ trans('backLang.home') }}</a> /
                    <a href="">{{ trans('backLang.CitiesCrops') }}</a>
                </small>
            </div>
            @if(@Auth::user()->permissionsGroup->add_status)
                <div class="row p-a">
                    <div class="col-sm-3">
                        <a class="btn btn-fw primary marginBottom5"
                           href="{{route('CitiesCropsCreate')}}">
                            <i class="material-icons">&#xe02e;</i>
                            &nbsp; {!! trans('backLang.CitiesCrops') !!}</a>
                    </div>
                    {{Form::open(['route'=>['CitiesCrops'],'method'=>'GET', 'files' => false ])}}

                    <div class="col-sm-3">
                        {!! Form::select('f[crop_id]',$Crops, request()->input('f.crop_id'),array('class' => 'form-control','id'=>'crop','required'=>'','onChange'=>'this.form.submit()', 'dir'=>trans('backLang.rtl'))) !!}

                    </div>
                    <div class="col-sm-3">
                        {!! Form::select('f[city_id]',$Cities, request()->input('f.city_id'),array('class' => 'form-control','id'=>'city','required'=>'','onChange'=>'this.form.submit()', 'dir'=>trans('backLang.rtl'))) !!}

                    </div>
                    <div class="col-sm-3">
                        {!! Form::select('f[year]',$years, request()->input('f.year'),array('class' => 'form-control','id'=>'year','required'=>'','onChange'=>'this.form.submit()', 'dir'=>trans('backLang.rtl'))) !!}

                    </div>
                    {{Form::close()}}

                </div>
            @endif
            @if($CitiesCrops->total() == 0)
                <div class="row p-a">
                    <div class="col-sm-12">
                        <div class=" p-a text-center ">
                            {{ trans('backLang.noData') }}
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            @endif

            @if($CitiesCrops->total() > 0)
                {{Form::open(['route'=>'CitiesCropsUpdateAll','method'=>'post'])}}
                <div class="table-responsive">
                    <table class="table table-striped  b-t">
                        <thead>
                        <tr>
                            <th class="width20">
                                <label class="ui-check m-a-0">
                                    <input id="checkAll" type="checkbox"><i></i>
                                </label>
                            </th>
                            <th>{{ trans('backLang.city') }}</th>
                            <th>المركز</th>
                            <th>المحصول</th>
                            <th>الموسم</th>
                            <th>الكمية</th>
                            <th>المساحة</th>
                            <th>الانتاجية</th>
                            <th>السنة</th>
                            <th class="text-center width200">{{ trans('backLang.options') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $title_var = "title_" . trans('backLang.boxCode');
                        $title_var2 = "title_" . trans('backLang.boxCodeOther');
                        ?>
                        @foreach($CitiesCrops as $CityCrop)
                            <?php
                            if ($CityCrop->Crop->$title_var != "") {
                                $Crop = $CityCrop->Crop->$title_var;
                            } else {
                                $Crop = $CityCrop->Crop->$title_var2;
                            }
                            if ($CityCrop->City->$title_var != "") {
                                $City = $CityCrop->City->$title_var;
                            } else {
                                $City = $CityCrop->City->$title_var2;
                            }
                            if ($CityCrop->Center->$title_var != "") {
                                $Center = $CityCrop->Center->$title_var;
                            } else {
                                $Center = $CityCrop->Center->$title_var2;
                            }
                            ?>
                            <tr>
                                <td><label class="ui-check m-a-0">
                                        <input type="checkbox" name="ids[]" value="{{ $CityCrop->id }}"><i
                                                class="dark-white"></i>
                                        {!! Form::hidden('row_ids[]',$CityCrop->id, array('class' => 'form-control row_no')) !!}
                                    </label>
                                </td>
                                <td>{!! $City   !!}</td>
                                <td>{!! $Center !!}</td>
                                <td>{!! $Crop   !!}</td>
                                <td>{!! $CityCrop->season !!}</td>
                                <td>{!! $CityCrop->quantity !!}</td>
                                <td>{!! $CityCrop->area !!}</td>
                                <td>{!! $CityCrop->productivity !!}</td>
                                <td>{!! $CityCrop->year   !!}</td>
                                <td class="text-center">
                                    @if(@Auth::user()->permissionsGroup->edit_status)
                                        <a class="btn btn-sm success"
                                           href="{{ route("CitiesCropsEdit",["id"=>$CityCrop->id]) }}">
                                            <small><i class="material-icons">&#xe3c9;</i> {{ trans('backLang.edit') }}
                                            </small>
                                        </a>
                                    @endif
                                        @if(@Auth::user()->permissionsGroup->delete_status)
                                        <button class="btn btn-sm warning" data-toggle="modal"
                                                data-target="#m-{{ $CityCrop->id }}" ui-toggle-class="bounce"
                                                ui-target="#animate">
                                            <small><i class="material-icons">&#xe872;</i> {{ trans('backLang.delete') }}
                                            </small>
                                        </button>
                                    @endif

                                </td>
                            </tr>
                            <!-- .modal -->
                            <div id="m-{{ $CityCrop->id }}" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ trans('backLang.confirmation') }}</h5>
                                        </div>
                                        <div class="modal-body text-center p-lg">
                                            <p>
                                                {{ trans('backLang.confirmationDeleteMsg') }}
                                                <br>
                                                <strong>[ {{ $Crop }}-{{ $City }}-{{ $Center }}]</strong>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark-white p-x-md"
                                                    data-dismiss="modal">{{ trans('backLang.no') }}</button>
                                            <a href="{{ route("CitiesCropsDestroy",["id"=>$CityCrop->id]) }}"
                                               class="btn danger p-x-md">{{ trans('backLang.yes') }}</a>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div>
                            </div>
                            <!-- / .modal -->
                        @endforeach

                        </tbody>
                    </table>

                </div>
                <footer class="dker p-a">
                    <div class="row">
                        <div class="col-sm-3 hidden-xs">
                            <!-- .modal -->
                            <div id="m-all" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ trans('backLang.confirmation') }}</h5>
                                        </div>
                                        <div class="modal-body text-center p-lg">
                                            <p>
                                                {{ trans('backLang.confirmationDeleteMsg') }}
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark-white p-x-md"
                                                    data-dismiss="modal">{{ trans('backLang.no') }}</button>
                                            <button type="submit"
                                                    class="btn danger p-x-md">{{ trans('backLang.yes') }}</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div>
                            </div>
                            <!-- / .modal -->
                            @if(@Auth::user()->permissionsGroup->edit_status)
                                <select name="action" id="action" class="input-sm form-control w-sm inline v-middle"
                                        required>
                                    <option value="">{{ trans('backLang.bulkAction') }}</option>
                                    @if(@Auth::user()->permissionsGroup->delete_status)
                                        <option value="delete">{{ trans('backLang.deleteSelected') }}</option>
                                    @endif
                                </select>
                                <button type="submit" id="submit_all"
                                        class="btn btn-sm white">{{ trans('backLang.apply') }}</button>
                                <button id="submit_show_msg" class="btn btn-sm white displayNone" data-toggle="modal"
                                        data-target="#m-all" ui-toggle-class="bounce"
                                        ui-target="#animate">{{ trans('backLang.apply') }}
                                </button>
                            @endif
                        </div>

                        <div class="col-sm-3 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">{{ trans('backLang.showing') }} {{ $CitiesCrops->firstItem() }}
                                -{{ $CitiesCrops->lastItem() }} {{ trans('backLang.of') }}
                                <strong>{{ $CitiesCrops->total()  }}</strong> {{ trans('backLang.records') }}</small>
                        </div>
                        <div class="col-sm-6 text-right text-center-xs">
                            {!! $CitiesCrops->links() !!}
                        </div>
                    </div>
                </footer>
                {{Form::close()}}

                <script type="text/javascript">
                    $("#checkAll").click(function () {
                        $('input:checkbox').not(this).prop('checked', this.checked);
                    });
                    $("#action").change(function () {
                        if (this.value == "delete") {
                            $("#submit_all").css("display", "none");
                            $("#submit_show_msg").css("display", "inline-block");
                        } else {
                            $("#submit_all").css("display", "inline-block");
                            $("#submit_show_msg").css("display", "none");
                        }
                    });
                </script>
            @endif
        </div>
    </div>
@endsection
@section('footerInclude')
    <script type="text/javascript">
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $("#action").change(function () {
            if (this.value == "delete") {
                $("#submit_all").css("display", "none");
                $("#submit_show_msg").css("display", "inline-block");
            } else {
                $("#submit_all").css("display", "inline-block");
                $("#submit_show_msg").css("display", "none");
            }
        });
    </script>
@endsection
