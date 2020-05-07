@extends('layouts.dashboard.app')

@section('pageTitle','تعديل نوع وثائق')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة أنواع الوثائق')
@section('navigation3','تعديل نوع وثائق')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/idTypes')
@section('navigation3_link','/admin/idTypes/'.$idType->id.'/edit')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل نوع وثائق
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form method="post"
                      action="{{ url('admin/idTypes',$idType->id) }}">

                @csrf
                {{ method_field('PATCH') }}

                <!-- Start col -->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">اسم نوع الوثائق بالعربي</label>
                            <div style="width: 95%;">
                                <input type="text" class="form-control arabic" id="name" name="name"
                                       value="{{ $idType->name }}" placeholder="الاسم بالعربي">
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">نوع الحقل</label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi"
                                            name="type">
                                        <option value=" " selected> النوع</option>
                                        <option value="0" {{ $idType->type == 0? 'selected':'' }}>عدد</option>
                                        <option value="1" {{ $idType->type == 1? 'selected':'' }}>نص</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">عدد الخانات</label>
                                <div style="width: 95%;">
                                    <input type="number" class="form-control" id="number" name="number"
                                           value="{{ $idType->number }}"
                                           placeholder="عدد الخانات">
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
