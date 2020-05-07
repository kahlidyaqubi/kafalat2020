@extends('layouts.dashboard.app')

@section('pageTitle','اكمال معلومات الصرفية')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الصرفيات')
@section('navigation3','اكمال معلومات الصرفية')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expenses')
@section('navigation3_link','#')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        اكمال معلومات الصرفية
                    {{$old_name}}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div id="required-error"></div>
                <form method="get" id="import_file" data-parsley-validate
                      action="{{ url('admin/expenses/continue') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <input name="excel_file" type="hidden" value="{{$excel_file_name}}">
                    <input name="old_name" type="hidden" value="{{$old_name}}">
                    <input name="recive_date" type="hidden" value="{{$recive_date}}">
                    <input name="year" type="hidden" value="{{$year}}">
                    <input name="family_project_id" type="hidden" value="{{$family_project_id}}">
                    <input name="mounth_count" type="hidden" value="{{$mounth_count}}">

                    <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->

                        <div class="col-12">
                            <div class="form-group row">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">الأشهر<span style="color:red;">*</span></label>
                                    <select class="form-control kt-select2 select2-multi"
                                             required id="the_months" name="the_months[]" multiple>
                                        <option value=" " disabled>الأشهر</option>
                                        @foreach($all_months as $month)
                                            <option value="{{$month->id}}"
                                                    @if($month->id==old("month")) selected @endif>{{$month->name_tr}}
                                                -{{$month->name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Start col -->

                        <!-- End col -->

                        <!-- End col -->
                    </div>
                    <!-- End Row -->


                <!-- Satrt Button Confirm -->
                <div class="col-12">
                    <div class="form-group row">
                        <button type="submit"
                              class="btn btn-success btn-elevate btn-block ">التالي
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
                 
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
@endsection