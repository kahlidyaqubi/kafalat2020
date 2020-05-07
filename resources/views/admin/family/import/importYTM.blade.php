
@extends('layouts.dashboard.app')

@section('pageTitle','استيراد ملف الأيتام')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الأيتام')
@section('navigation3','استيراد ملف الأيتام')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/families')
@section('navigation3_link','/admin/families/import/ytm')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">

                        استيراد ملف الأيتام
                    </h3>
                </div>
            </div>
            
            <div class="kt-portlet__body">

                <div class="col text-left">
                    <a class='button btn btn-success'href='{{ url('admin/families/ytm/template/download') }}'>                                                <i class="fa fa-cloud-download-alt"></i>

                        تصدير
                    
                        نموذج ملف
                        الأيتام</a>
                </div>
                <form method="post" data-parsley-validate action="{{ url('admin/families/import/ytmFile') }}"
                      enctype="multipart/form-data">
                @csrf
                <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">الملف</label>
                                <input class="form-control " name="file" type="file"
                                       accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                       style="width: 99%">
                            </div>
                        </div>
                        <!-- End col -->
                    </div>
                    <!-- End Row -->

                    <!-- Satrt Button Confirm -->
                    <div class="col-12">
                    <div class="form-group row">
                        <button type="submit"
                              class="btn btn-success btn-elevate btn-block "> 
                              <i class="fa fa-cloud-upload-alt"></i>
                            استيراد ملف الأيتام
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
                <form method="post" data-parsley-validate action="{{ url('admin/families/import/ytmOld') }}"
                      enctype="multipart/form-data">
                @csrf
                
                <!--mah work-->
                <!-- Start Row -->
                <!--    <div class="row">-->
                        <!-- Start col -->
                <!--        <div class="col-lg-12 col-md-12 col-sm-12">-->
                <!--            <div class="form-group row">-->
                <!--                <label class="col-form-label col-lg-12">الملف</label>-->
                <!--                <input class="form-control " name="file" type="file"-->
                <!--                       accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"-->
                <!--                       style="width: 95%">-->
                <!--            </div>-->
                <!--        </div>-->
                        <!-- End col -->
                <!--    </div>-->
                    <!-- End Row -->

                    <!-- Satrt Button Confirm -->
                <!--    <div class="col-md-12 text-center">-->
                <!--        <button type="submit" class="btn btn-success btn-elevate"><i-->
                <!--                    class="fa fa-cloud-download-alt"></i> استيراد أرشيف الأيتام-->
                <!--        </button>-->
                        <!-- <button type="button" class="btn btn-success btn-elevate "> <i class="fa fa-cloud-upload-alt"></i> تصدير نموذج الإبطال</button> -->
                <!--    </div>-->
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