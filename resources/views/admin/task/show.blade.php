@extends('layouts.dashboard.app')

@section('pageTitle','عرض المهمة')
@section('headerCSS')
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة المهام')
@section('navigation3','عرض المهمة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/tasks')
@section('navigation3_link','/admin/tasks/'.$task->id)
@section('content')

    <div class="col-lg-8 col-md-8 ">
        <div class="row">
            <div class="col s12" id="the_error">

            </div>
        </div>
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-sign icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        عرض المهمة
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <h3 class="kt-widget14__title">{{$task->title}}</h3>
                <p class="kt-widget3__text" style="word-break: break-word;
    overflow-wrap: break-word; overflow: auto;">
                    {{$task->nots}}</p>

                <p class="kt-widget14__title" style="word-break: break-word;
    overflow-wrap: break-word; overflow: auto;">نوع المهمة :
                    @if($task->task_families->first())
                        بحث حالة
                    @elseif($task->expense_date)
                        رفع صرفية
                    @elseif($task->project_id)
                        مساعدات
                    @endif</p>
                @if($task->project_id)
                    <p class="kt-widget14__title">المشروع : {{$task->project->name}}</p>
                    <p class="kt-widget14__title">الجمعية: {{$task->institution->name}}</p>
                    @if($task->family)
                        <p class="kt-widget14__title">المستفيد : {{$task->family->person->full_name}}</p>
                    @endif
                @endif
                @if($task->task_families->first())
                    <p class="kt-widget14__title">الاستمارات :
                    @foreach($task->families as $family)
                        <li>{{$family->person->full_name}} / {{$family->code}}</li>
                        @endforeach
                        </p>
                        @endif
                        @if($task->expense_date)
                            <h4 class="kt-widget14__title">تاريخ الصرفية
                                : {{$task->expense_date?date('m-Y', strtotime($task->expense_date)):""}}</h4>
                        @endif
            </div>
        </div>
        <!--end::Portlet-->
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label ">

                    <div class="row">
                        <span class="fa fa-sign icon-padding"></span>
                        <h3 class="kt-portlet__head-title ">
                            ملاحظة المتابع للمهمة


                        </h3>
                    </div>


                </div>
                <div class="row">
                    <h5 class="col-md-12">إنجاز المهمة
                        <span
                                class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                <label>

                                    <input type="checkbox" id="done_{{$task->id}}"
                                           @if(auth()->user()->id == $task->user_id)
                                           {{$task->done?"checked":""}} value="{{$task->id}}"
                                           @else
                                           {{$task->done?"checked":" "}} disabled
                                           title="لا تملك صلاحية اتمام عملية"
                                           @endif
                                           value="{{$task->id}}"
                                           onclick="done(this.id)">
                                     <span> </span>
                                </label>
                            </span>
                    </h5>
                </div>
                <div class="row">
                    <h5 class="col-md-12">قبول المهمة
                        <span
                                class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                <label>
                                    <input class="cbActive2" type="checkbox"
                                           @if(auth()->user()->hasPermissionTo(231) && $task->done && auth()->user()->id == $task->admin_id)
                                           {{$task->full_done?"checked":" "}} value="{{$task->id}}"
                                           @else
                                           {{$task->full_done?"checked":" "}} disabled
                                           title="لا تملك صلاحية قبول مهمة"
                                           value="{{$task->id}}"
                            @endif>
                                    <span> </span>
                                </label>
                            </span></h5>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-widget3">
                    @if($task->user_note)
                        <div class="kt-widget3__item">
                            <div class="kt-widget3__header">
                                <div class="kt-widget3__user-img">
                                    @if(((!is_null($task->user->image)) && (!is_null($task->user->image)) && (($task->user->image != ''))))
                                        <img class="kt-widget3__img" src="{{ asset($task->user->image) }}"/>
                                    @else
                                        <img class="kt-widget3__img"
                                             src="{{asset('new_theme/assets/media/users/default.jpg')}}"/>
                                    @endif
                                </div>
                                <div class="kt-widget3__info">
                                    <a href="#" class="kt-widget3__username">
                                        {{$task->user->full_name}}
                                    </a><br>
                                </div>
                                <span class="kt-widget3__status kt-font-info">
														<!-- Pending -->
													</span>
                            </div>
                            <div class="kt-widget3__body">
                                <p class="kt-widget3__text">
                                    {{$task->user_note}}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!--end::Portlet-->
    </div>
    <div class="col-lg-4 col-md-4">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-sign icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        معلومات التنفيذ
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-widget17__item">
											<span class="kt-widget17__icon">
												<svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px" viewBox="0 0 24 24" version="1.1"
                                                     class="kt-svg-icon kt-svg-icon--success">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<polygon points="0 0 24 0 24 24 0 24"></polygon>
														<path
                                                                d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                                                fill="#000000" fill-rule="nonzero"></path>
														<path
                                                                d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                                                fill="#000000" opacity="0.3"></path>
													</g>
												</svg> </span>
                    <span class="kt-widget17__subtitle">
												<span class="btn btn-bold btn-sm btn-font-sm  btn-label-success">
                                                    @if($task->done)
                                                        تمت
                                                    @else
                                                        قيد العمل
                                                    @endif
                                                </span>
											</span>
                </div>
                <div style="margin-top: 20px;">
                    <h5 class="kt-widget14__title">مضيف المهمة:</h5>
                    <p class="kt-widget3__text">
                        {{$task->admin->full_name}}
                    </p>
                    <h5 class="kt-widget14__title">متابع المهمة:</h5>
                    <p class="kt-widget3__text">
                        {{$task->user->full_name}}
                    </p>
                    <h5 class="kt-widget14__title">تاريخ البدء:</h5>
                    <p class="kt-widget3__text">
                        {{$task->from_date?date('Y-m-d', strtotime($task->from_date)):""}}
                    </p>
                    <h5 class="kt-widget14__title">تاريخ الانتهاء:</h5>
                    <p class="kt-widget3__text">
                        {{$task->to_date?date('Y-m-d', strtotime($task->to_date)):""}}
                    </p>
                </div>
            </div>
        </div>
        <!--end::Portlet-->
    </div>



    <div class="modal fade" id="done_model" tabindex="-1" role="dialog" aria-labelledby="done_modelLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="done_modelLabel">إنجاز مهمة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="done_form">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">أضف ملاحظة:</label>
                            <textarea class="form-control" id="user_note"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary cbActive">تم إنجاز المهمة</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footerJS')
    <script>
        $(function () {
            $(".close").click(function () {
                var id = $(this).val();
                var isTrueSet = (this.old_status == 'true');
                $('#done_' + id).prop("checked", isTrueSet);


            });
            $(".cbActive").click(function () {

                var id = $(this).val();
                var mythis = $('#done_' + id);

                $.ajax({
                    url: "/admin/tasks/done/" + id,
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_note: $('#user_note').val()
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
                $("#done_model").modal("hide");
            });

        });
    </script>

    <script>
        $(function () {
            $(".cbActive2").change(function () {

                var id = $(this).val();
                var mythis = this;
                mythis.disabled = true;
                $.ajax({
                    url: "/admin/tasks/full_done/" + id,
                    data: {_token: '{{ csrf_token() }}'},
                    success: function (resp) {
                        document.getElementById("the_error").innerHTML = '<div class="alert alert-success alert-dismissible">\n' + resp.message +
                            '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                            '            <span aria-hidden="true">&times;</span>\n' +
                            '        </button>\n' +
                            '    </div>';
                        mythis.disabled = false;
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

            });

        });
    </script>
    <script>
        function done(id) {
            console.log('test');
            var old_status = !($('#' + id).is(':checked'));
			
                $("#done_model .cbActive").attr("id", id);
                $("#done_model .close").attr("old_status", old_status);
                $("#done_model .cbActive").attr("value", $('#' + id).val());
                $("#done_model .close").attr("value", $('#' + id).val());
            if (($('#' + id).is(':checked'))) {
                $("#done_model").modal("show");
                return false;
            } else {
                $("#done_model .cbActive").attr("value", $('#' + id).val());
                $("#done_model .cbActive").click();
            }

        };
        $('#done_model').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('New message to ' + recipient)
            modal.find('.modal-body input').val(recipient)
        })
    </script>


@endsection