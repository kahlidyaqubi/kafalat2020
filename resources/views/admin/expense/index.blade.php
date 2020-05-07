@extends('layouts.dashboard.app')

@section('pageTitle','إدارة الصرفيات')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الصرفيات')
@section('navigation3','')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expenses')
@section('navigation3_link','')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <div class="col s12" id="the_error"></div>
        @if(Session::get('error_string'))
            <div class="alert alert-danger" role="alert" style="text-align: right;padding-top: 0;">
                {!! Session::get('error_string') !!}
            </div>
            <div class="container-fluid col s12" style="min-height: 0;">
                <div class="row">
                    <form method="post" action="{{ url('admin/expenses/exportIgnoreFile') }}">
                        @csrf
                        <input name="file_name" type="hidden" value="ملف الإبطال">
                        <input name="faild_collection" type="hidden" value="{{$faild_collection}}">
                        <div class="col s12">
                            <button type="submit" class="btn teal waves-effect waves-light">تحميل الصفوف التي فشل
                                إضافتها
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        @if(Session::get('note_string'))
            <div class="alert alert-warning" role="alert" style="text-align: right;padding-top: 0;">
                {!! Session::get('note_string') !!}
            </div>
    @endif
    <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إدارة الصرفيات
                    </h3>
                </div>
            </div>

            <div class="kt-portlet__body">
                <!-- Start Row -->
                <form>
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">بحث من خلال اسم الكشف</label>
                                <div style="width: 100%;">
                                    <input class="form-control" placeholder=" اكتب الاسم  " id="q" name="q"
                                           value="{{$q}}"
                                           type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 100%;">
                                    <label class="col-form-label col-lg-12">المشروع</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="family_project_id" name="family_project_id">
                                        <option value=" " selected> اختر مشروعا</option>

                                        @foreach($family_projects as $family_project)
                                            <option value="{{$family_project->id}}"
                                                    @if($family_project->id==$family_project_id) selected @endif>{{$family_project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ استلام من</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="from_recive_date"
                                           value="{{$from_recive_date}}"
                                           type="text"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ استلام إلى</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="to_recive_date" type="text"
                                           value="{{$to_recive_date}}"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">من الرقم</label>
                                <div style="width: 100%;">
                                    <input class="form-control" type="number" name="from_id" value="{{$from_id}}"
                                           placeholder="اختر id" max="{{$max_id}}"
                                           min="{{$min_id}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">إلى الرقم</label>
                                <div style="width: 100%;">
                                    <input class="form-control" type="number" name="to_id" value="{{$to_id}}"
                                           placeholder="اختر id" max="{{$max_id}}"
                                           min="{{$min_id}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Satrt Button Confirm -->
                        <div class="col-12">
                            <div class="form-group row">
                                <button type="submit"
                                      class="btn btn-success btn-elevate btn-block ">بحث
                                    <span id="wating" class="" style="display: none">&nbsp;&nbsp;
                                        <span class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                        </span>
                                        <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                                </span>
                                </button>
                            </div>
                        </div>
                        <!-- End Button Confirm -->
                        
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group ">
                                <a href="/admin/expenseDetails"
                                   class="btn btn-outline-success col" name="theaction"
                                   value="search">عرض الكشوفات
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <button type="submit" form="show-select"
                                    class="btn btn-outline-success  col">
                                عرض كشوفات المحدد
                        </button>
                    </div>
                </div>
                        <!-- End col -->
                    </div>
                </form>
                 <!--Start Row -->
                <div class="row">
                    <form action="/admin/expenseDetails" id="show-select">
                        <input type="hidden" name="the_ids" id="myIds1">
                    </form>
                </div>
                
            </div>
        </div>
        <!--end::Portlet-->
        
                
            </div>
        </div>
        <!--end::Portlet-->


        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-sign icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        عرض الصرفيات
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body ">
                <!-- Start Table  -->
                <div class="table-responsive">

                    <table class="table table-bordered table-hover ">
                        <thead>
                        <tr class="text-center">

                            <th style="width: 5%">
                                #
                            </th>
                            <th style="width: 5%;">
                                <label class="kt-checkbox">
                                    <input type="checkbox" id="check_all" name="check_all" type="checkbox"
                                           value="1">الكل
                                    <span></span>
                                </label>
                            </th>
                            <th>الصرفية
                            </th>
                            <th style="width: 20%;">تاريخ الاستلام
                            </th>
                            <th style="width: 20%;">المشروع
                            </th>
                            <th style="width: 10%;">العمليات
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expense as $item)
                            <tr class="text-center">

                                <td>{{ $item->id }}</td>
                                <td>
                                    <div class="">
															<span
                                                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
																<label>
																	<input type="checkbox" id="{{$item->id}}"
                                                                           name="ids[{{$item->id}}]" type="checkbox"
                                                                           value="1">
																	<span></span>
																</label>
															</span>
                                    </div>
                                </td>
                                <td>{{$item->old_name}}
                                <td>{{$item->recive_date?date('d-m-Y', strtotime($item->recive_date)):""}}</td>
                                <td>{{$item->family_project->name}}</td>
                                <td>
                                    <div class="dropdown dropdown-inline">
                                        <button type="button"
                                                class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle"
                                                data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="la la-cog"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                               href="/admin/expenseDetails?the_ids={{$item->id}}">
                                                <i class="fa fa-sign"></i>عرض الكشوفات</a>
                                            @if(auth()->user()->hasPermissionTo(47))
                                                <a class="dropdown-item"
                                                   href="/admin/expenses/delivery/{{$item->id}}"><i
                                                            class="fa fa-signal"></i>تسليم</a>
                                            @endif
                                            <a class="dropdown-item" href="#"
                                               id="sms_{{$item->id}}"
                                               value="{{$item->id}}"
                                               onclick="sms(this.id)"><i
                                                        class="fa fa-signal"></i>SMS</a>
                                                         <a class="dropdown-item "
                                               href="/admin/expenses/{{$item->id}}/edit"><i
                                                        class="fa fa-signal"></i>تعديل</a>
                                            <a class="dropdown-item Confirm"
                                               href="/admin/expenses/delete/{{$item->id}}"><i
                                                        class="fa fa-trash"></i>حذف</a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table  -->
                <!--begin: Pagination-->
            {{$expense->links()}}

            <!--end: Pagination-->
            </div>
        </div>
        <!--end::Portlet-->
    </div>
    <div class="modal fade" id="sms_model" tabindex="-1" role="dialog" aria-labelledby="sms_modelLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sms_modelLabel">إبلاغ مستلمين</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="sms_form">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">محتوى الرسالة:</label>
                            <textarea class="form-control" id="massage"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary cbActive">إرسال</button>
                </div>
            </div>
        </div>
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
    <script>
        function sms(id) {
            var old_status = !($('#' + id).is(':checked'));
            $("#sms_model").modal("show");
            $("#sms_model .cbActive").attr("id", id);
            $("#sms_model .close").attr("old_status", old_status);
            $("#sms_model .cbActive").val($('#' + id).attr("value"));
            $("#sms_model .close").val($('#' + id).attr("value"));
            return false;

        };
        $('#sms_model').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('New message to ' + recipient)
            modal.find('.modal-body input').val(recipient)
        })
    </script>
    <script>
        $(function () {
            $(".close").click(function () {
                var id = $(this).val();
                var isTrueSet = (this.old_status == 'true');
                $('#sms_' + id).prop("checked", isTrueSet);


            });
            $(".cbActive").click(function () {

                var id = $(this).val();

                var mythis = $('#sms_' + id);
                console.log("oka" + id);
                $.ajax({
                    url: "/admin/expenses/sendSMS",
                    data: {
                        _token: '{{ csrf_token() }}',
                        massage: $('#massage').val(),
                        the_type: 'json',
                        the_ids: id,
                    },
                    success: function (resp) {
                        document.getElementById("the_error").innerHTML = '<div class="alert alert-success alert-dismissible">\n' + resp.message +
                            '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                            '            <span aria-hidden="true">&times;</span>\n' +
                            '        </button>\n' +
                            '    </div>';
                        mythis.disabled = true;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        document.getElementById("the_error").innerHTML = '<div class="alert alert-danger alert-dismissible">\n' + jqXHR.responseJSON.message +
                            '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                            '            <span aria-hidden="true">&times;</span>\n' +
                            '        </button>\n' +
                            '    </div>';
                        mythis.prop("checked", false);
                    },
                });
                $("#sms_model").modal("hide");


            });

        });
    </script>
    <script>

        var ids_array = [];
        var ids = "";
        $("#check_all").change(function () {

            for (var z = 0; z < $('input[name^="ids"]').length; z++) {
                if ($("#check_all")[0].checked) {
                    $('input[name^="ids"]')[z].setAttribute('checked', 'checked');
                } else {
                    $('input[name^="ids"]')[z].removeAttribute('checked')
                }
                ids_array = [];
                $("input:checkbox[name^='ids']:checked").each(function () {
                    ids_array.push($(this).attr("id"));
                });
            }

            ids = ids_array.join();
            document.getElementById("myIds1").value = ids;
        });
        $('input[name^="ids"]').change(function () {
            ids_array = [];
            $("input:checkbox[name^='ids']:checked").each(function () {
                ids_array.push($(this).attr("id"));
            });
            ids = ids_array.join();
            document.getElementById("myIds1").value = ids;
        });
    </script>
         <script>
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
    
@endsection