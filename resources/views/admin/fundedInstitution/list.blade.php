@extends('layouts.dashboard.app')

@section('pageTitle','إدارة الجهات المرشحة')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}">
    <style>
        .dataTables_filter {
            display: none;
        }
    </style>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation3','إدارة الجهات المرشحة')
@section('navigation1_link','/admin/home')
@section('navigation3_link','/admin/fundedInstitutions')
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
                        ادارة الجهات المرشحة
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <div class="row">

                    <!-- Start col -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <div style="width: 95%;">
                                <label class="col-form-label col-lg-12">الجهات المرشحة</label>
                                <select class="form-control " id="name">
                                    <option value=" " selected>الجهة المرشحة
                                    </option>
                                    @foreach(\App\FundedInstitution::all() as $fundedInstitution)
                                        <option value="{{ $fundedInstitution->name }}">{{ $fundedInstitution->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <div style="width: 95%;">
                                <label class="col-form-label col-lg-12">النوع</label>
                                <select class="form-control " id="type">
                                    <option value=" " selected>نوع الجهة المرشحة</option>
                                    <option value="غير جامعي">غير جامعي</option>
                                    <option value="جامعي"> جامعي</option>
                                </select>
                                <label for="type"> نوع الجهة المرشحة</label>
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
                        <th class="big-col">#</th>
                        <th class="big-col">اسم الجهة</th>
                        <th class="big-col">بالتركي</th>
                        <th class="big-col">الكود</th>
                        <th class="big-col">الشعار</th>
                        <th class="big-col">النوع</th>
                        <th class="big-col">الحالة</th>
                        <th width="15%">العمليات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $i = 1 @endphp
                    @foreach($fundedInstitutions->sortByDesc('created_at') as $fundedInstitution)
                        <tr>
                            <td width="10%"> {{ $i }} </td>
                            <td> {{ $fundedInstitution->name }} </td>
                            <td> {{ $fundedInstitution->name_tr }} </td>
                            <td> {{ !is_null($fundedInstitution->code) ? $fundedInstitution->code : '-' }} </td>
                            <td>
                                @if(((!is_null($fundedInstitution->logo)) && (!is_null($fundedInstitution->logo)) && (($fundedInstitution->logo != ''))))
                                    <img width="50px" height="50px"
                                         src="{{ asset($fundedInstitution->logo) }}">
                                @else
                                    {{ '-' }}
                                @endif
                            </td>
                            <td> {{ $fundedInstitution->type == 0 ?'غير جامعي':'جامعي' }} </td>
                            <td> {{ $fundedInstitution->status == 1 ?'مقبول' : 'لم يتم القبول' }} </td>
                            <td>
                                <div class="dropdown dropdown-inline">
                                    <button type="button"
                                            class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="la la-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item Confirm"
                                           href="{{ url('admin/fundedInstitutions/delete/'.$fundedInstitution->id) }}"><i
                                                    class="fa fa-trash"></i>حذف</a>
                                        <a class="dropdown-item"
                                           href="{{ url('admin/fundedInstitutions/'.$fundedInstitution->id .'/edit') }}"><i
                                                    class="fa fa-edit"></i>تعديل</a>
                                        @if($fundedInstitution->status == 0)
                                            <a class="dropdown-item"
                                               href="{{ url('admin/fundedInstitutions/approve/'.$fundedInstitution->id ) }}"><i
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

            var table = $('#table').DataTable({
                responsive: true,
                "processing": true,
                dom: 'Bfrtp',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                },

                initComplete: function () {
                    $('select').formSelect();
                }

            });

            $('#type').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(4).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            $('#name').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.columns(1).search(val ? '^' + val + '$' : '', true, false).draw();
            });
        });
    </script>
@endsection
