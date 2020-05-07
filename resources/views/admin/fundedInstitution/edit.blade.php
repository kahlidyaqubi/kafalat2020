@extends('layouts.dashboard.app')

@section('pageTitle','تعديل جهة مرشحة')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الجهات المرشحة')
@section('navigation3','تعديل جهة مرشحة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/fundedInstitutions')
@section('navigation3_link','/admin/fundedInstitutions/'.$fundedInstitution->id.'/edit')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل جهة مرشحة
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form method="post"
                      action="{{ url('admin/fundedInstitutions',$fundedInstitution->id) }}"
                      enctype="multipart/form-data">

                @csrf
                {{ method_field('PATCH') }}
                <!-- Start Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">النوع</label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi"
                                            id="type" name="type">
                                        <option value=" " selected> النوع</option>
                                        <option value="0" {{ $fundedInstitution->type == '0' ? 'selected':'' }}>غير
                                            جامعية
                                        </option>
                                        <option value="1" {{ $fundedInstitution->type == '1' ? 'selected':'' }}>جامعية
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">اسم الجهة مرشحة بالعربي</label>
                                <div style="width: 95%;">
                                    <input type="text" class="form-control arabic" id="name" name="name"
                                           value="{{ $fundedInstitution->name }}" placeholder="الاسم بالعربي">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">اسم الجهة مرشحة بالتركي</label>
                                <div style="width: 95%;">
                                    <input type="text" class="form-control turkey" id="name_tr" name="name_tr"
                                           value="{{ $fundedInstitution->name_tr }}" placeholder="الاسم بالتركي">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الكود</label>
                                <div style="width: 95%;">
                                    <input type="text" class="form-control" id="code" name="code"
                                           value="{{ $fundedInstitution->code }}"
                                           placeholder="الكود">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الملف</label>
                                <input class="form-control " accept="image/png, image/jpeg, image/jpg" type="file"
                                       name="logo" style="width: 95%">
                            </div>
                        </div>
                        <!-- End col -->
                        @if(((!is_null($fundedInstitution->logo)) && (!is_null($fundedInstitution->logo)) && (($fundedInstitution->logo != ''))))
                            <div class="row img-thumbnail ">
                                <div class="col col-md-6 col-sm-12">
                                    <img width="200px" height="200px"
                                         src="{{ asset($fundedInstitution->logo) }}">
                                </div>
                            </div>
                        @endif
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
