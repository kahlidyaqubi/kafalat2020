@extends('layouts.dashboard.app')

@section('pageTitle','إضافة مهمة')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة المهام')
@section('navigation3','إضافة مهمة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/tasks')
@section('navigation3_link','/admin/tasks/create')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        اضافة مهمة
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body" method="post" action="/admin/tasks">

            @csrf
            <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">الموظف
                                <span style="color:red;">*</span></label>
                            <div style="width: 95%;">

                                <select required  id='selUser2' name="user_id" style='width: 200px;'>
                                    <option value=''>- اختر مستخدم -</option>
                                    @if(old('user_id'))
                                        <?php $user = \App\User::find(old('user_id'))?>
                                        @if($user)
                                            <option value="{{$user->id}}"
                                                    selected>{{$user->full_name}}</option>
                                        @endif
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->

                    <!-- Start col -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">تاريخ البدء
                                <span style="color:red;">*</span></label>
                            <input  required class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text"
                                   name="from_date"
                                   value="{{old('from_date')}}" style="width: 86%">
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">تاريخ الانتهاء
                                <span style="color:red;">*</span></label>
                            <input  required class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text"
                                   name="to_date"
                                   value="{{old('to_date')}}" style="width: 86%">
                        </div>
                    </div>
                    <!-- End col -->
                                        <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label  class="col-form-label col-lg-12">نوع المهمة</label>
                            <div style="width: 95%;">
                                <select required class="form-control kt-select2 select2-multi"
                                        id="type" onchange="change_type()">
                                    <option  value="" selected>نوع المهمة</option>
                                    <option value="1" @if(old('type') == 1)selected @endif> بحث حالة</option>
                                    <option value="2" @if(old('type') == 2)selected @endif> رفع صرفية</option>
                                    <option value="3" @if(old('type') == 3)selected @endif> مساعدات</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12" id="type1" style="display: none">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">مكفول
                                <span style="color:red;">*</span></label>
                            <div style="width: 95%;" id="families_yes">

                                <select   id='selUser3' name="families_yes[]" style='width: 200px;'
                                        multiple>
                                    <option value='  '>- اختر مكفول -</option>
                                    @if(old('families_yes'))
                                        @foreach(old('families_yes') as $family_id)
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
                    <div class="col-lg-6 col-md-6 col-sm-12 type3" style="display: none">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">جمعية</label>
                            <div style="width: 95%;">
                                <select class="form-control kt-select2 select2-multi"
                                        name="institution_id">
                                    <option value=" " selected> جمعية</option>
                                    @foreach($institutions as $institution)
                                        <option value="{{$institution->id}}"
                                                @if($institution->id == old('institution_id')) selected @endif>{{$institution->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12 type3" style="display: none">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">مشروع
                                <span style="color:red;">*</span></label>
                            <div style="width: 95%;">
                                <select  class="form-control kt-select2 select2-multi"
                                        name="project_id">
                                    <option value=" " selected> مشروع</option>
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}"
                                                @if($project->id == old('project_id')) selected @endif>{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12 type3" style="display: none">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">مستفيد</label>
                            <div style="width: 95%;">
                                <select id='selUser4' name="family_id" style='width: 200px;'>
                                    <option value='  '>- اختر -</option>
                                    @if(old('family_id'))
                                        <?php $family = \App\Family::find(old('family_id'))?>
                                        @if($family)
                                            <option value="{{$family_id}}"
                                                    selected>{{$family->code}}{{$family->person?$family->person->full_name."-".$family->person->id_number:""}}</option>
                                        @endif
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12" id="type2" style="display: none">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">تاريخ الصرفية
                                <span style="color:red;">*</span></label>
                            <input class="form-control datepicker" type="text"
                                   name="expense_date"
                                   value="{{old('expense_date')}}" style="width: 95%" readonly="readonly" >
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">عنوان المهمة
                                <span style="color:red;">*</span></label>
                            <input class="form-control " type="text"
                                   name="title" required 
                                   value="{{old('title')}}" style="width: 97%" placeholder="اكتب عنوان المهمة">
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">ملاحظات
                                <span style="color:red;">*</span></label>
                            <div style="width: 97%;">
								<textarea  required name="nots" class="form-control" placeholder="ملاحظات المهمة"
                         style="height: 100px;">{{old('nots')}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->

                </div>
                <!-- End Row -->

                <!-- Satrt Button Confirm -->
                <div class="col-12">
                    <button type="submit"
                            class="btn btn-success btn-elevate btn-block ">إضافة
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