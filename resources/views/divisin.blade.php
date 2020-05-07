@extends('layouts.dashboard.app')

@section('pageTitle','تقسم ملف الصرفية')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الصرفيات')
@section('navigation3','تقسم ملف الصرفية')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expenses')
@section('navigation3_link','/divisin')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                       تقسيم ملف الصرفية
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
@if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
        @endif
                <form method="post" data-parsley-validate action="{{ url('/divisin') }}"
                      enctype="multipart/form-data">
                @csrf
                <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الملف</label>
                                <input class="form-control " type="file" required
                                       name="excel_file"
                                       accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                       style="width: 95%">
                            </div>
                        </div>
                        <!-- End col -->
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <div style="width: 95%;">
                                <label class="col-form-label col-lg-12"><span style="color:red;">*</span>القسم المطلوب</label>
                                <select class="form-control kt-select2 select2-multi"
                                        id="part" name="part" required>
                                    <option value="" selected>القسم المطلوب</option>
                                    @for($i=1;$i<=20;$i++)
                                        <option value="{{$i}}"
                                                @if(old('part')==$i)selected @endif>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->

                    <!-- Satrt Button Confirm -->
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success btn-elevate"><i
                                    class="fa fa-cloud-download-alt"></i>تقسيم ملف الصرفية
                        </button>
                        <!-- <button type="button" class="btn btn-success btn-elevate "> <i class="fa fa-cloud-upload-alt"></i> تصدير نموذج الابطال</button> -->
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
