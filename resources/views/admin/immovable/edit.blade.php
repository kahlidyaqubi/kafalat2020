@extends('layouts.dashboard.app')

@section('pageTitle','تعديل عقار')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة العقارات')
@section('navigation3','تعديل عقار')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/immovables')
@section('navigation3_link','/admin/immovables/'.$immovable->id.'/edit')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل عقار
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form method="post"
                      action="{{ url('admin/immovables',$immovable->id) }}">

                @csrf
                {{ method_field('PATCH') }}
                <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">اسم العقار بالعربي</label>
                                <div style="width: 95%;">
                                    <input type="text" class="form-control arabic" id="name" name="name"
                                           value="{{ $immovable->name }}" placeholder="الاسم بالعربي">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">اسم العقار بالتركي</label>
                                <div style="width: 95%;">
                                    <input type="text" class="form-control turkey" id="name_tr" name="name_tr"
                                           value="{{ $immovable->name_tr }}"
                                           placeholder="الاسم بالتركي">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                    </div>
                    <!-- End Row -->

                    <!-- Satrt Button Confirm -->
                    <div class="col-md-2">
                        <input type="submit" class="btn btn-success btn-elevate btn-block "
                               value="حفظ">
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
