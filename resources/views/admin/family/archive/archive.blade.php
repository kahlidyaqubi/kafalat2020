@extends('layouts.dashboard.app')

@section('pageTitle','أرشيف الاستمارة')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الاستمارات والزيارات')
@section('navigation3','أرشيف الاستمارة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/families')
@section('navigation3_link','/admin/families/archive'.$family->id)
@section('content')
    @php
        $person = !is_null($family) ? $family->person : null;
    @endphp
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-sign icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        أرشيف المكفول : <span style="color: red;">
                        {{ !is_null($person->full_name) ? $person->full_name : $person->first_name .' '. $person->second_name . ' ' . $person->third_name . ' '. $person->family_name }}
                        </span>
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Table  -->
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>تاريخ العملية</th>
                        <th>مدخل الحالة</th>
                        <th>الاسم العربي</th>
                        <th>الاسم التركي</th>
                        <th>الكود</th>
                        <th>رقم الهوية</th>
                        <th>رقم الزيارة</th>
                        <th>نوع العملية</th>
                        <th>عمليات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($archives->where('parent_id','<>',null) as $archive)
                        <tr class="text-center">

                            <td>{{  date('Y-m-d', strtotime($archive->created_at))   }}</td>
                            <td>{{ (isset($archive->user_data_entry)) ? $archive->user_data_entry->user_name  : ' -' }}</td>
                            <td>{{  $archive->person?$archive->person->full_name:"-"   }}</td>
                            <td>{{  $archive->person?$archive->person->full_name_tr:"-"   }}</td>
                            <td>{{  $archive->code   }}</td>
                            <td>{{  $archive->person?$archive->person->id_number:"-"   }}</td>
                            <td>
                                {{ $archive->visit_count }}
                            </td>
                            <td>    {{  (isset($archive->visit_reason) && (!is_null($archive->visit_reason))) ? $archive->visit_reason->name: 'غير مدخل'  }}
                            </td>
                            <td>
                                <a href="{{ url('admin/families/'.$archive->id.'/showArchive') }}"
                                   class="btn btn-success btn-elevate ">عرض الزيارة</a>
                          <a href="{{ url('admin/families/delete_visit/'.$archive->id) }}"
                                   class="btn btn-danger btn-elevate Confirm ">حذف الزيارة</
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
@endsection


