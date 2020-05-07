@extends('layouts.dashboard.app')

@section('pageTitle','تعديل مهمة')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة المهام')
@section('navigation3','تعديل مهمة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/tasks')
@section('navigation3_link','/admin/tasks/'.$task->id.'/edit')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل مهمة {{$task->title}}
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body" method="post" action="/admin/tasks/{{$task->id}}">
                
            @csrf
            @method('put')
            <!-- Start Row -->
                <div class="row">
                    <!-- Start col user-->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">اختيار موظف</label>
                            <div style="width: 95%;">
                                <select id='selUser2' name="user_id" style='width: 200px;'>
                                    <option value='  '>- اختر مستخدم -</option>
                                    <option value="{{$task->user_id}}" selected>{{$task->user->full_name}}</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                     <!-- Start col date-start-->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">تاريخ البدء</label>
                            <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text"
                                   name="from_date"
                                   value="{{$task->from_date}}" style="width: 86%">
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col date-end -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">تاريخ الانتهاء</label>
                            <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text"
                                   name="to_date"
                                   value="{{$task->to_date}}" style="width: 86%">
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">نوع المهمة</label>
                            <div style="width: 95%;">
                                <select class="form-control kt-select2 select2-multi"
                                        id="type" onchange="change_type()">
                                    <option selected>نوع المهمة</option>
                                    <option value="1" @if($task->task_families->first()) selected @endif> بحث حالة
                                    </option>
                                    <option value="2" @if($task->expense_date)selected @endif> رفع صرفية</option>
                                    <option value="3" @if($task->project_id)selected @endif> مساعدات</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->


                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12" id="type1"
                         @if(!($task->families->first()))style="display: none" @endif>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">مكفول</label>
                            <div style="width: 95%;" id="families_yes">

                                <select id='selUser3' name="families_yes[]" style='width: 200px;'
                                        multiple>
                                    <option value='  '>- اختر مكفول -</option>
                                    @foreach($task->families as $family)
                                        <option value="{{$family->id}}" selected>{{$family->person->full_name}}
                                            / {{$family->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12 type3" @if(!($task->project))style="display: none"@endif>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">جمعية</label>
                            <div style="width: 95%;">
                                <select class="form-control kt-select2 select2-multi"
                                        name="institution_id">
                                    <option value=" " selected> جمعية</option>
                                    @foreach($institutions as $institution)
                                        <option value="{{$institution->id}}"
                                                @if($institution->id == $task->institution_id))
                                                selected @endif>{{$institution->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12 type3" @if(!($task->project))style="display: none"@endif>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">مشروع</label>
                            <div style="width: 95%;">
                                <select class="form-control kt-select2 select2-multi"
                                        name="project_id">
                                    <option value=" " selected> مشروع</option>
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}"
                                                @if($project->id == $task->project_id) selected @endif>{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12 type3" @if(!($task->project))style="display: none"@endif>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">مستفيد</label>
                            <div style="width: 95%;">

                                <select id='selUser4' name="family_id" style='width: 200px;'>
                                    <option value='  '>- اختر -</option>
                                    @if($task->family_id)
                                        <option value="{{$task->family_id}}"
                                                selected> {{$task->family->person->full_name}}
                                            / {{$task->family->code}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12" id="type2"
                         @if(!($task->expense_date))style="display: none" @endif>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">تاريخ الصرفية</label>
                            <input class="form-control datepicker" type="text"
                                   name="expense_date"
                                   value="{{$task->expense_date}}" style="width: 95%" readonly="readonly">
                        </div>
                    </div>
                    <!-- End col -->
                    
                    <!-- Start col title -->
                    <div class="col-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">عنوان المهمة</label>
                                <input class="form-control " type="text"
                                   name="title"
                                   value="{{$task->title}}" style="width: 97%">
                        </div>
                    </div>
                    <!-- End col -->
                    
                    <!-- Start col notes-->
                    <div class="col-lg-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">ملاحظات</label>
                            <div style="width: 97%;">
								<textarea name="nots" class="form-control" placeholder="ملاحظات"
                                                                  style="height: 100px;">{{$task->nots}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->

                </div>
                <!-- End Row -->

                <!-- Satrt Button Confirm -->
                <div class="col-12">
                    <button type="submit"
                            class="btn btn-success btn-elevate btn-block ">تعديل
                        <span id="wating" class="" style="display: none">                            &nbsp;&nbsp;
                            <span class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </span>
                            <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                        </span>
                    </button>
                </div>
                <!-- End Button Confirm -->
            </form>
        </div>
        <!--end::Portlet-->
    </div>


@endsection
@section('select2')
    <script>
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
    <script>
        $("#selUser2").select2({
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
        $("[name='expense_date']").datepicker({
            format: 'yyyy-mm',
            minViewMode: 1,
                autoclose: true,
                    clearBtn: true


        });
    </script>
    <script>
        //type
        function change_type(e) {
            console.log($("#type").val());
            if ($("#type").val() == '1') {
                $('#type1').show();
                $('.type3').hide();
                $('#type2').hide();
                $("[name='family_id']").val("");
                $("[name='institution_id']").val("");
                $("[name='project_id']").val("");
                $("[name='expense_date']").val("");
            } else if ($("#type").val() == '2') {
                $('#type2').show();
                $('.type3').hide();
                $('#type1').hide();
                $("[name='family_id']").val("");
                $("[name='institution_id']").val("");
                $("[name='project_id']").val("");
                $("[name='families_yes[]']").val("");
            } else if ($("#type").val() == '3') {
                $('.type3').show();
                $('#type1').hide();
                $('#type2').hide();
                $("[name='families_yes[]']").val("");
                $("[name='expense_date']").val("");
            }
        }
    </script>

@endsection