@extends('layouts.dashboard.app')

@section('pageTitle','إدارة الترجمة')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}">
    <style>
        .dataTables_filter{
            display: none;
        }
    </style>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الترجمة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/nameTranslations')

@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        ادارة الترجمة
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6  col-md-6 col-sm-12">
                        <div class="form-group row">
                            <div style="width: 95%;">
                                <label class="col-form-label col-lg-12">الاسم بالعربي</label>
                                <div>
                                    <input type="text" class="form-control arabic" id="arabic"
                                           placeholder="الاسم بالعربي">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6  col-md-6 col-sm-12">
                        <div class="form-group row">
                            <div style="width: 95%;">
                                <label class="col-form-label col-lg-12">الاسم بالتركي</label>
                                <div>
                                    <input type="text" class="form-control turkey" id="turkey"
                                           placeholder="الاسم بالتركي">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End Row -->
                <!-- Start Table  -->
                <table class="table table-bordered table-hover" id="table">
                    <thead>
                    <tr class="text-center">
                        <th>الاسم بالعربي</th>
                        <th>الاسم بالتركي</th>
                        <th>إعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($nameTranslations as $translation)
                        <tr class="text-center">
                            <td> {{ $translation->arabic }} </td>
                            <td> {{ $translation->turkey }} </td>
                            <td>
                                <div class="dropdown dropdown-inline">
                                    <button type="button" class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="la la-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item Confirm"  href="{{ url('admin/nameTranslations/delete/'.$translation->id) }}" ><i class="fa fa-trash" ></i>حذف</a>
                                        <a class="dropdown-item" href="{{ url('admin/nameTranslations/'.$translation->id .'/edit') }}"><i class="fa fa-edit"></i>تعديل</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                <!-- End Table  -->

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
    <script src="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        jQuery(document).ready(function () {
            table = $('#table').DataTable({
                responsive: true,
                "processing": true,
                "searching": true,
                "order": [[0, "asc"]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                },
            });


            $('#arabic').on('keyup', function () {
                table.columns(0).search(this.value).draw();
            });

            $('#turkey').on('keyup', function () {
                table.columns(1).search(this.value).draw();
            });


        });
    </script>
@endsection
