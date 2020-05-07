@extends('layouts.dashboard.app')

@section('pageTitle','إدارة الإشعارات')
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
@section('navigation2','إدارة الإشعارات')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/notifications')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        عرض إشعارت المستخدم {{$user->full_name}}
                    </h3>
                </div>
            </div>
            @if($items->count()>0)
                <div class="kt-section">
                    <div class="kt-section__content">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th> الاشعار</th>
                                <th width="15%">التاريخ</th>
                                <th width="35%">الإجراءات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <?php
                                $action = $item->data['action']; ?>
                                <tr>
                                    <td> {{$action['title']}}</td>
                                    <td> {{date('Y-m-d',strtotime($action['created_at']))}}</td>
                                    <td>

                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                الاجراءات
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item notfiylink" href="{{$action['link']}}"
                                                   onclick="pop(this)"
                                                   the_id='{{$item->id}}'
                                                   href="/admin/notifications/delete/{{$item->id}}">عرض</a>
                                                <a class="dropdown-item Confirm"
                                                   href="/admin/notifications/delete/{{$item->id}}">حذف</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{$items->links()}}
            @else
                <br><br>
                <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضةا</div>
            @endif
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

        function pop(e) {
            event.preventDefault();
            var the_id = e.getAttribute('the_id');
            var the_href = e.href;
            $.get('/admin/getnotfiy/' + the_id, function (data, status) {
            });
            location.href = the_href;
        };

    </script>
@endsection
