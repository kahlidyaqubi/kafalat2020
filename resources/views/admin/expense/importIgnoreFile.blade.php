@extends('layouts.dashboard.app')

@section('pageTitle','استيراد ملف الإبطال')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الصرفيات')
@section('navigation3','استيراد ملف الإبطال')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expenses')
@section('navigation3_link','/admin/expenses/importIgnoreFile')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        استيراد ملف الإبطال
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="col text-left">
                    <a class='button btn btn-success' href='{{ asset('word_templates/invalid.xlsx') }}'>
                        <i class="fa fa-cloud-download-alt"></i>
                        تصدير نماذج الإبطال المسموحة</a>
                </div>
                <div class="row">
                    <div class="col">
                        <hr>
                    </div>
                </div>
                <form method="post" data-parsley-validate action="{{ url('admin/expenses/importIgnoreFile') }}"
                      enctype="multipart/form-data">
                @csrf
                <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group ">
                                <label class="col-form-label col-lg-12">الملف</label>
                                <input class="form-control " type="file"
                                       name="excel_file"
                                       accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                       style="width: 99%">
                            </div>
                        </div>
                        <!-- End col -->
                    </div>
                    <!-- End Row -->

                <div class="col-12">
                    <div class="form-group row">
                        <button type="submit"
                              class="btn btn-success btn-elevate btn-block "> 
                              <i class="fa fa-cloud-upload-alt"></i>
                            استيراد ملف الإبطال
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

     <script>
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>

@endsection
