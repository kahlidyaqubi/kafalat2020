@extends('layouts.dashboard.app')

@section('pageTitle','استيراد ملف مساعدات اكسترا ياردم')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة المساعدات الطارئة')
@section('navigation3','استيراد ملف مساعدات اكسترا ياردم')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/urgent_coupons')
@section('navigation3_link','/admin/urgent_coupons/import_urgent_coupon_extra')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        استيراد ملف مساعدات اكسترا ياردم
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="col m6 s12 text-left">
                    <a class='btn' href='{{ asset('word_templates/extra.xlsx') }}'>تصدير
                        نموذج ملف
                        مساعدات اكسترا ياردم</a>
                </div>
                <form method="post" data-parsley-validate action="{{ url('admin/urgent_coupons/import_urgent_coupon_extra') }}"
                      enctype="multipart/form-data">
                @csrf
                <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الملف</label>
                                <input class="form-control "  type="file"
                                       name="excel_file" accept=".csv,.xlsx"
                                       style="width: 95%">
                            </div>
                        </div>
                        <!-- End col -->
                    </div>
                    <!-- End Row -->

                    <!-- Satrt Button Confirm -->
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success btn-elevate"><i
                                    class="fa fa-cloud-download-alt"></i> استيراد ملف مساعدات اكسترا ياردم
                        </button>
                        <!-- <button type="button" class="btn btn-success btn-elevate "> <i class="fa fa-cloud-upload-alt"></i> تصدير نموذج الإبطال</button> -->
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
@endsection
