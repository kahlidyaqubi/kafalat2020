@extends('layouts.dashboard.app')

@section('pageTitle','تعديل موسم')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة المواسم')
@section('navigation3','تعديل موسم')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/seasons')
@section('navigation3_link','/admin/seasons/'.$season->id."/edit")
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل موسم
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body" method="post" action="/admin/seasons/{{$season->id}}">
            @csrf
            @method('put')
            <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">تاريخ الموسم
                                <span style="color:red;">*</span></label>
                            <input  style="width: 95%;" autocomplete="off" required readonly="readonly" class="form-control datepicker" name="start_date" type="text"
                                   value="{{$season->start_date?date('Y-m', strtotime($season->start_date)):""}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">المشروع
                                <span style="color:red;">*</span></label>
                            <div style="width: 95%;">
                                <select  required class="form-control kt-select2 select2-multi"
                                        name="project_id" id="project_id">
                                    <option value="" selected>المشروع</option>
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}"
                                                @if($project->id==$season->project_id) selected @endif>{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- End col -->
                </div>
                <!-- End Row -->

                <!-- Satrt Button Confirm -->
                <div class="col-12">
                    <div class="form-group row">
                        <button type="submit"
                              class="btn btn-success btn-elevate btn-block ">تعديل
                            <span id="wating" class="" style="display: none">&nbsp;&nbsp;
                                <span class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                                </span>
                                <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                        </span>
                        </button>
                    </div>
                </div>
                <!-- End Button Confirm -->
            </form>
        </div>
        <!--end::Portlet-->
    </div>


@endsection

@section('footerJS')
    <script src="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('new_theme/assets/plugins/general/js/global/integration/plugins/bootstrap-datepicker.init.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('new_theme/assets/plugins/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('new_theme/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"
            type="text/javascript"></script>
    
    <script>
        $("[name='start_date']").datepicker({
            format: 'yyyy-mm',
            minViewMode: 1,
            orientation: "bottom auto",
            autoclose: true,
            clearBtn: true
        });
    </script>
     <script>
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
@endsection