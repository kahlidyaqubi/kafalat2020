@extends('layouts.dashboard.app')

@section('pageTitle','إدارة المؤسسات التعليمية')
@section('headerCSS')
    <link href="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}">
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation3','إدارة المؤسسة التعليمية')
@section('navigation1_link','/admin/home')
@section('navigation3_link','/admin/educationalInstitutions')
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
                        ادارة المؤسسة التعليمية
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
                        <th class="big-col">اسم المؤسسة التعليمية بالعربي</th>
                        <th class="big-col">
                            اسم المؤسسة التعليمية
                            بالتركي
                        </th>
                        <th class="big-col">الحالة</th>
                        <th width="15%">العمليات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $i = 1 @endphp
                    @foreach($educationalInstitutions->sortByDesc('created_at') as $educationalInstitution)
                        <tr>
                            <td width="10%"> {{ $i }} </td>
                            <td> {{ $educationalInstitution->name }} </td>
                            <td> {{ !is_null($educationalInstitution->name_tr) ? $educationalInstitution->name_tr :'-' }} </td>
                            <td> {{ $educationalInstitution->status == 1 ?'مقبول' : 'لم يتم القبول' }} </td>
                            <td>
                                <div class="dropdown dropdown-inline">
                                    <button type="button"
                                            class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="la la-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item Confirm"
                                           href="{{ url('admin/educationalInstitutions/delete/'.$educationalInstitution->id) }}"><i
                                                    class="fa fa-trash"></i>حذف</a>
                                        <a class="dropdown-item"
                                           href="{{ url('admin/educationalInstitutions/'.$educationalInstitution->id .'/edit') }}"><i
                                                    class="fa fa-edit"></i>تعديل</a>
                                        @if($educationalInstitution->status == 0)
                                            <a class="dropdown-item"
                                               href="{{ url('admin/educationalInstitutions/approve/'.$educationalInstitution->id ) }}"><i
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
    <script src="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        jQuery(document).ready(function () {
            $('#table').DataTable({
                responsive: true,
                "processing": true,
                "searching": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                },
            });
        });
    </script>
@endsection
