@extends('layouts.dashboard.app')

@section('pageTitle','إدارة المهام')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة المهام')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/tasks')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إدارة المهام
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <form>
                    
                    <div class="row">
                        <!-- Start col user -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 100%;" id="user_ids">
                                    <label class="col-form-label col-lg-12">المستخدم
                                    </label>

                                    <select id='selUser2' name="user_ids[]" style='width: 200px;'
                                            multiple>
                                        <option value='  '>- اختر مستخدم -</option>
                                        @if($user_ids)
                                            @foreach($user_ids as $user_id)
                                                <?php $user = \App\User::find($user_id)?>
                                                @if($user)
                                                    <option value="{{$user_id}}"
                                                            selected>{{$user->full_name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col user -->
                        <!-- Start col admin -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 100%;" id="admin_ids">
                                    <label class="col-form-label col-lg-12">الأدمن
                                    </label>

                                    <select id='selUser' name="admin_ids[]" style='width: 200px;'
                                            multiple>
                                        <option value='  '>- اختر آدمن -</option>
                                        @if($admin_ids)
                                            @foreach($admin_ids as $user_id)
                                                <?php $user = \App\User::find($user_id)?>
                                                @if($user)
                                                    <option value="{{$user_id}}"
                                                            selected>{{$user->full_name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col admin-->

                        <!-- Start col title -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">
                                    عنوان المهمة</label>
                                <div style="width: 99%;">
                                    <input class="form-control" placeholder=" اكتب العنوان  " id="title" name="title"
                                           value="{{$title}}"
                                           type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col title -->

                        <!-- Start col done-->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">الإنجاز</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="done" name="done">
                                        <option value=" " selected> الإنجاز</option>
                                        <option value="1" @if($done == 1)selected @endif> تمت</option>
                                        <option value="0" @if($done === '0')selected @endif> لم تتم</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col done -->
                        <!-- Start col ok-->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">القبول</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="full_done" name="full_done">
                                        <option value=" " selected> القبول</option>
                                        <option value="1" @if($full_done == 1)selected @endif> مقبولة</option>
                                        <option value="0" @if($full_done === '0')selected @endif> غير مقبولة</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col ok -->
                        <!-- Start col type -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">نوع المهمة</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="type" name="type" onchange="change_type()">
                                        <option value=" " selected> نوع المهمة</option>
                                        <option value="1" @if(request()['type'] == 1)selected @endif> بحث حالة</option>
                                        <option value="2" @if(request()['type'] == 2)selected @endif> رفع صرفية</option>
                                        <option value="3" @if(request()['type'] == 3)selected @endif> مساعدات</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col type -->

                        

                    
                        <div style="display: none" class="col-lg-3 col-md-6 col-sm-12 type3">
                            <div class="form-group">
                                <div style="width: 95%;" id="family_ids">
                                    <label class="col-form-label col-lg-12">المستفيد
                                    </label>

                                    <select id='selUser4' name="family_ids[]" style='width: 200px;'
                                            multiple>
                                        <option value='  '>- اختر -</option>
                                        @if($family_ids)
                                            @foreach($family_ids as $family_id)
                                                <?php $family = \App\Family::find($family_id)?>
                                                @if($family)
                                                    <option value="{{$family_id}}"
                                                            selected>{{$family->code}}{{$family->person?$family->person->full_name."-".$family->person->id_number:""}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div style="display: none" class="col-lg-3 col-md-6 col-sm-12 type3">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">جمعيات</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="institution_ids" name="institution_ids[]" multiple>
                                        <option value=" " disabled> الجمعية</option>
                                        @foreach($institutions as $institution)
                                            <option value="{{$institution->id}}"
                                                    @if(in_array($institution->id, $institution_ids)) selected @endif>{{$institution->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div style="display: none" class="col-lg-3 col-md-6 col-sm-12 type3">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">مشاريع</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="project_ids" name="project_ids[]" multiple>
                                        <option value=" " disabled> مشروع</option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}"
                                                    @if(in_array($project->id, $project_ids)) selected @endif>{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->


                        <div class="col-lg-3 col-md-6 col-sm-12" id="type1" style="display: none">
                            <div class="form-group">
                                <div style="width: 95%;" id="families_yes">
                                    <label class="col-form-label col-lg-12">المكفول
                                    </label>
                                    <select id='selUser3' name="families_yes[]" style='width: 200px;'
                                            multiple>
                                        <option value='  '>- اختر مكفول -</option>
                                        @if($families_yes)
                                            @foreach($families_yes as $family_id)
                                                <?php $family = \App\Family::find($family_id)?>
                                                @if($family)
                                                    <option value="{{$family_id}}"
                                                            selected>{{$family->code}}{{$family->person?$family->person->full_name."-".$family->person->id_number:""}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                       <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">من الرقم</label>
                                <div style="width: 95%;">
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
                                <div style="width: 95%;">
                                    <input class="form-control" type="number" name="to_id" value="{{$to_id}}"
                                           placeholder="اختر id" max="{{$max_id}}"
                                           min="{{$min_id}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                         <!-- Start col date -->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ البدء من</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="from_from_date" type="text"
                                           value="{{$from_from_date}}"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col date -->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ البدء إلى</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="to_from_date" type="text"
                                           value="{{$to_from_date}}"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col date-->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ الانتهاء من</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="from_to_date"
                                           value="{{$from_to_date}}"
                                           type="text"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col date-->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ الانتهاء إلى</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="$to_to_date"
                                           value="{{$to_to_date}}"
                                           type="text"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">تحديد الأعمدة المعروضة </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="coulmn" name="coulmn[]" multiple="multiple">
                                        <option value="id"
                                                @if(collect($coulmn)->contains('id'))selected @endif>#
                                        </option>
                                        <option value="admin"
                                                @if(collect($coulmn)->contains('admin'))selected @endif>
                                            الأدمن
                                        </option>
                                        <option value="user"
                                                @if(collect($coulmn)->contains('user'))selected @endif>
                                            المستخدم
                                        </option>
                                        <option value="type"
                                                @if(collect($coulmn)->contains('type'))selected @endif>
                                            نوع المهمة
                                        </option>
                                        <option value="done"
                                                @if(collect($coulmn)->contains('done'))selected @endif>
                                            الإنجاز
                                        </option>
                                        <option value="full_done"
                                                @if(collect($coulmn)->contains('full_done'))selected @endif>
                                            القبول
                                        </option>
                                        <option value="from_date"
                                                @if(collect($coulmn)->contains('from_date'))selected @endif>
                                            تاريخ البدء
                                        </option>
                                        <option value="to_date"
                                                @if(collect($coulmn)->contains('to_date'))selected @endif>
                                            تاريخ الانتهاء
                                        </option>
                                        <option value="operations"
                                                @if(collect($coulmn)->contains('operations'))selected @endif>
                                            العمليات
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-12">
                            <div class="form-group row">
                                 <button type="submit"
                                        name="theaction" value="search" class="btn btn-success btn-elevate btn-block ">بحث
                                    <span id="wating" class="" style="display: none">                            &nbsp;&nbsp;
                                        <span class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </span>
                                        <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <!-- End col -->

                    </div>
                </form>
            </div>
        </div>
        <!--end::Portlet-->
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
                        عرض المهام
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body ">
                <!-- Start Table  -->
                <div class="table-responsive">

                    <table class="table table-bordered table-hover ">
                        <thead>
                        <tr class="text-center">

                            @if(collect($coulmn)->contains('id'))
                                <th style="width: 5%">
                                    #
                                </th>@endif
                            @if(collect($coulmn)->contains('admin'))
                                <th style="width: 20%;">الأدمن
                                </th>@endif
                            @if(collect($coulmn)->contains('user'))
                                <th style="width: 20%;">المستخدم
                                </th>@endif
                            @if(collect($coulmn)->contains('type'))
                                <th style="width: 15%">نوع المهمة
                                </th>@endif
                            @if(collect($coulmn)->contains('done'))
                                <th style="width: 5%;">الإنجاز
                                </th>@endif
                            @if(collect($coulmn)->contains('full_done'))
                                <th style="width: 5%;">القبول
                                </th>@endif
                            @if(collect($coulmn)->contains('from_date'))
                                <th style="width: 15%;">تاريخ البدء
                                </th>@endif
                            @if(collect($coulmn)->contains('to_date'))
                                <th style="width: 15%;">تاريخ الانتهاء
                                </th>@endif
                            @if(collect($coulmn)->contains('operations'))
                                <th style="width: 5%;">العمليات
                                </th>@endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr class="text-center">


                                @if(collect($coulmn)->contains('id'))
                                    <td>{{ $item->id }}</td>@endif
                                @if(collect($coulmn)->contains('admin'))
                                    <td>{{$item->admin->full_name}}</td>@endif
                                @if(collect($coulmn)->contains('user'))
                                    <td>{{$item->user->full_name}}</td>@endif
                                @if(collect($coulmn)->contains('type'))
                                    <td>

                                        @if($item->task_families->first())
                                            بحث حالة
                                        @elseif($item->expense_date)
                                            رفع صرفية
                                        @elseif($item->project_id)
                                            مساعدات
                                        @endif

                                    </td>@endif
                                @if(collect($coulmn)->contains('done'))
                                    <td>
                                        <div class="">
                            <span
                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                <label>

                                    <input type="checkbox" id="done_{{$item->id}}"
                                           @if(auth()->user()->id == $item->user_id)
                                           {{$item->done?"checked":""}} value="{{$item->id}}"
                                           @else
                                           {{$item->done?"checked":" "}} disabled
                                           title="لا تملك صلاحية اتمام عملية"
                                           @endif
                                           value="{{$item->id}}"
                                           onclick="done(this.id)">
                                    <span></span>
                                </label>
                            </span>
                                        </div>
                                    </td>@endif
                                @if(collect($coulmn)->contains('full_done'))
                                    <td>
                                        <div class="">
                            <span
                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                <label>
                                    <input class="cbActive2" type="checkbox"
                                           @if(auth()->user()->hasPermissionTo(231) && $item->done && auth()->user()->id == $item->admin_id)
                                           {{$item->full_done?"checked":" "}} value="{{$item->id}}"
                                           @else
                                           {{$item->full_done?"checked":" "}} disabled
                                           title="لا تملك صلاحية قبول مهمة"
                                           value="{{$item->id}}"
                            @endif>
                                    <span></span>
                                </label>
                            </span>
                                        </div>
                                    </td>@endif
                                @if(collect($coulmn)->contains('from_date'))
                                    <td>{{$item->from_date?date('d-m-Y', strtotime($item->from_date)):""}}</td>@endif
                                @if(collect($coulmn)->contains('to_date'))
                                    <td>{{$item->to_date?date('d-m-Y', strtotime($item->to_date)):""}}</td>@endif
                                @if(collect($coulmn)->contains('operations'))
                                    <td>
                                        <!-- <button type="button" class="btn btn-danger btn-elevate">حذف</button> -->
                                        <!-- <button type="button" class="btn btn-success btn-elevate ">تعديل</button> -->
                                        <div class="dropdown dropdown-inline">
                                            <button type="button"
                                                    class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="la la-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="/admin/tasks/{{$item->id}}/edit"><i
                                                            class="fa fa-pen"></i>
                                                    تعديل
                                                </a>
                                                <a class="dropdown-item" href="/admin/tasks/{{$item->id}}">
                                                    <i class="fa fa-shopping-bag"></i>
                                                    عرض</a>
                                                <a class="dropdown-item Confirm"
                                                   href="/admin/tasks/delete/{{$item->id}}">
                                                    <i class="fa fa-trash"></i>
                                                    حذف</a>
                                            </div>
                                        </div>
                                    </td>@endif

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table  -->
                <!--begin: Pagination-->
            {{$items->links()}}

            <!--end: Pagination-->
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
@section('select2')
    <script>
        $("#selUser").select2({
            multiple: true,
            ajax: {
                url: "/admin/users/users_ajax",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    console.log(params);
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function (response) {

                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $("#selUser2").select2({
            multiple: true,
            ajax: {
                url: "/admin/users/users_ajax",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    console.log(params);
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function (response) {

                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $("#selUser3").select2({
            multiple: true,
            ajax: {
                url: "/admin/families/families_ajax",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    console.log(params);
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function (response) {

                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $("#selUser4").select2({
            multiple: true,
            ajax: {
                url: "/admin/families/families_ajax",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    console.log(params);
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function (response) {

                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    </script>
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
        //type
        function change_type(e) {
            console.log($("#type").val());
            if ($("#type").val() == '1') {
                $('#type1').show();
                $('.type3').hide();
                $("[name='family_ids[]']").val("");
                $("[name='institution_ids[]']").val("");
                $("[name='project_ids[]']").val("");

            } else if ($("#type").val() == '3') {
                $('.type3').show();
                $('#type1').hide();
                $("[name='families_yes[]']").val("");
            }
        }
    </script>

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
                        mythis.prop("checked", !(mythis.checked));
                        mythis.disabled = false;
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
    
     <script>
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
@endsection