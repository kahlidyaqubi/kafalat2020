@extends('layouts.dashboard.app')

@section('pageTitle','إدارة أسماء المرفقات')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}">
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation3','إدارة أسماء المرفقات')
@section('navigation1_link','/admin/home')
@section('navigation3_link','/admin/fileTypes')
@section('navigation2','إعدادت عامة')
@section('navigation2_link','/admin/all_settings')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        ادارة أسماء المرفقات
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <div class="row">
                </div>
                <!-- End Row -->
                <!-- Start Table  -->
                <table class="table table-bordered table-hover" id="table">
                    <thead>
                    <tr class="text-center">
                        <th class="big-col">#</th>
                        <th class="big-col"> اسم المرفق بالعربي</th>
                        <th class="big-col">اسم المرفق بالتركي</th>
                        <th class="big-col">الحالة</th>
                        <th width="15%">العمليات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $i = 1 ;@endphp
                    @foreach($fileTypes->sortByDesc('created_at') as $fileType)
                        <tr>
                            <td width="10%"> {{ $i }} </td>
                            <td> {{ $fileType->name }} </td>
                            <td> {{ !is_null($fileType->name_tr) ? $fileType->name_tr : '-' }} </td>
                            <td> {{ $fileType->status == 1 ?'مقبول' : 'لم يتم القبول' }} </td>
                            <td>
                                <div class="dropdown dropdown-inline">
                                    <button type="button"
                                            class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="la la-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item Confirm"
                                           href="{{ url('admin/fileTypes/delete/'.$fileType->id) }}"><i
                                                    class="fa fa-trash"></i>حذف</a>
                                        <a class="dropdown-item"
                                           href="{{ url('admin/fileTypes/'.$fileType->id .'/edit') }}"><i
                                                    class="fa fa-edit"></i>تعديل</a>
                                        @if($fileType->status == 0)
                                            <a class="dropdown-item"
                                               href="{{ url('admin/fileTypes/approve/'.$fileType->id ) }}"><i
                                                        class="fa fa-edit"></i>القبول</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @php $i++ @endphp
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
            $('#table').DataTable({
                // responsive: true,
                // "processing": true,
                "searching": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                },
            });
        });
    </script>
@endsection
