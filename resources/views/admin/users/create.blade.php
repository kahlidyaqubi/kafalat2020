@extends('layouts.dashboard.app')

@section('pageTitle','إضافة مستخدم')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة المستخدمين')
@section('navigation3','إضافة مستخدم')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/users')
@section('navigation3_link','/admin/users/create')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        اضافة مستخدم
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form method="post"
                      action="{{ url('admin/users') }}">
                @csrf
                <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">إسم الموظف
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" id="first_name" name="first_name" type="text"
                                           value="{{ old("first_name")}}" placeholder="إسم الموظف">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">إسم الأب
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" id="second_name" name="second_name" type="text"
                                           value="{{ old("second_name")}}" placeholder="إسم الأب">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">إسم الجد
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" id="third_name" name="third_name" type="text"
                                           value="{{ old("third_name")}}" placeholder="إسم الجد">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">إسم العائلة
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" id="family_name" name="family_name" type="text"
                                           value="{{ old("family_name")}}" placeholder="إسم العائلة">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">إسم المستخدم
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" id="user_name" name="user_name" type="text"
                                           value="{{ old("user_name")}}" placeholder="اسم المستخدم">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">البريد الإلكتروني
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" name="email" type="text" value="{{ old("email")}}"
                                           placeholder="البريد الإلكتروني">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">كلمة السر
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" name="password" type="password"
                                           value="{{ old("password")}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تأكيد كلمة السر
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" name="password_confirmation" type="password"
                                           value="{{ old("password")}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الهوية
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control numbers" maxlength="9" minlength="9" class="numbers"

                                           name="id_number"
                                           value="{{ old("id_number")}}" placeholder="رقم الهوية">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ الميلاد
                                    <span style="color:red;">*</span></label>
                                <input  required class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text" name="date_of_birth"
                                       value="{{old("date_of_birth")}}"
                                       style="width: 95%" placeholder="تاريخ الميلاد">
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ بدء العمل
                                    <span style="color:red;">*</span></label>
                                <input  required class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text" name="work_start_date"
                                       value="{{old("work_start_date")}}"
                                       style="width: 95%" placeholder="تاريخ بدء العمل">
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الحالة الاجتماعية
                                    <span style="color:red;">*</span></label>
                                <div style="width: 100%;">
                                    <select  required class="form-control kt-select2 select2-multi" name="social_status_id">
                                        <option value="" selected>الحالة الاجتماعية</option>
                                        @foreach($social_statuses->sortBy('name') as $social_status)
                                            <option value="{{$social_status->id}}"
                                                    @if($social_status->id==old("social_status_id")) selected @endif>{{$social_status->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الجوال - 1
                                    <span style="color:red;">*</span>
                                </label>
                                <div class="input-group" style="width: 95%;">
                                    <input  required class="form-control numbers" value="{{ old("mobile_one") }}"
                                           name="mobile_one"
                                           maxlength="10" minlength="9"
                                           aria-describedby="basic-addon1"
                                           placeholder="رقم الجوال">
                                    <div class="input-group-prepend"><span class="input-group-text">
																	<span class="fa fa-phone"></span>
																	970+</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الجوال - 2</label>
                                <div class="input-group" style="width: 95%;">
                                    <input class="form-control numbers" value="{{ old("mobile_two") }}"
                                           name="mobile_two"
                                           aria-describedby="basic-addon1"
                                           maxlength="10" minlength="9"
                                           placeholder=" رقم الجوال 2">
                                    <div class="input-group-prepend"><span class="input-group-text">
																	<span class="fa fa-phone"></span>
																	970+</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">هاتف أرضي</label>
                                <div class="input-group" style="width: 95%;">
                                    <input class="form-control numbers"
                                           value="{{ old("mobile") }}" name="mobile"
                                           maxlength="9" minlength="7"
                                           placeholder="هاتف أرضي" aria-describedby="basic-addon1">
                                    <div class="input-group-prepend"><span class="input-group-text">
																	<span class="fa fa-phone"></span>
																	970+</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">التخصص الجامعي
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi"
                                            name="university_specialty_id" id="university_specialty_id"
                                            onchange="university_specialty_other()">
                                        <option value="" selected>التخصص الجامعي</option>
                                        @foreach($university_specialties->sortBy('name') as $university_specialty)
                                            <option value="{{$university_specialty->id}}"
                                                    @if($university_specialty->id==old("university_specialty_id")) selected @endif>{{$university_specialty->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 university_specialty_other" style="display: none">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تخصص جامعي آخر
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input class="form-control" id="university_specialty_id_other"
                                           name="university_specialty_id_other" type="text"
                                           value="{{ old("university_specialty_id_other")}}"
                                           placeholder="التخصص الجامعي">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">القسم
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi" name="department_id"
                                            id="department_id" onchange="department_other()">
                                        <option value="" selected>القسم</option>
                                        @foreach($departments->sortBy('name') as $department)
                                            <option value="{{$department->id}}"
                                                    @if($department->id==old("department_id")) selected @endif>{{$department->name}} {{ !is_null($department->name_tr) ? ' ( ' .$department->name_tr .' )' : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 department_other" style="display: none">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">قسم آخر
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input class="form-control" id="department_id_other"
                                           name="department_id_other" type="text"
                                           value="{{ old("department_id_other")}}"
                                           placeholder="اسم القسم">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">المحافظة
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select required  class="form-control kt-select2 select2-multi" id="governorate_id"
                                            name="governorate_id" onchange="get_cities()">
                                        <option value="" selected> المحافظة</option>
                                        @foreach($governorates->sortBy('name') as $governorate)
                                            <option value="{{$governorate->id}}"
                                                    @if($governorate->id==old("governorate_id")) selected @endif>{{$governorate->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">المدينة
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi" id="city_id"
                                            name="city_id" onchange="get_neighborhoods()">
                                        <option value="" selected> المدينة</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الحي
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi" id="neighborhood_id"
                                            name="neighborhood_id" id="neighborhood_id" onchange="neighborhood_other()">
                                        <option value="" selected>الحي</option>
                                        <option value="1" class="other">أخرى</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 neighborhood_other" style="display: none">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">حي آخر
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input class="form-control" id="neighborhood_id_other"
                                           name="neighborhood_id_other" type="text"
                                           value="{{ old("neighborhood_id_other")}}"
                                           placeholder="الحي">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">عنوان السكن
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" name="address" type="text"
                                           value="{{old("address")}}" placeholder="عنوان السكن">
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-12">
                        <!--<div class="form-group row">-->
                        <!--    <div style="width: 95%;">-->
                        <!--        <input type="submit" class="btn btn-success btn-elevate " value="إضافة">-->
                        <!--    </div>-->
                        <!--</div>-->
                        
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
                    <!-- End col -->
                </form>
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
    <script>
        function university_specialty_other() {
            if ($('#university_specialty_id').val() == 1) {
                $('.university_specialty_other').show();
            } else {
                $('.university_specialty_other').hide();
                $('#university_specialty_id_other').val("");
            }
        }

        function neighborhood_other() {
            if ($('#neighborhood_id').val() == 1) {
                $('.neighborhood_other').show();
            } else {
                $('.neighborhood_other').hide();
                $('#neighborhood_id_other').val("");
            }
        }

        function department_other() {
            if ($('#department_id').val() == 1) {
                $('.department_other').show();
            } else {
                $('.department_other').hide();
                $('#department_id_other').val("");
            }
        }

        $(document).ready(function () {
            if ($('#university_specialty_id').val() == 1) {
                $('.university_specialty_other').show();
            } else {
                $('.university_specialty_other').hide();
                $('#university_specialty_id_other').val("");
            }
            if ($('#neighborhood_id').val() == 1) {
                $('.neighborhood_other').show();
            } else {
                $('.neighborhood_other').hide();
                $('#neighborhood_id_other').val("");
            }
            if ($('#department_id').val() == 1) {
                $('.department_other').show();
            } else {
                $('.department_other').hide();
                $('#department_id_other').val("");
            }
        });
    </script>
    <script>
        $(document).ready(function () {

            var governorate_id = $("[name='governorate_id']").val();

            $.get("/admin/governorates/cities/" + governorate_id, function (data, status) {
                $("[name='city_id']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="cities" value=" " >جميع المدن</option>');
                $("[name='neighborhood_id']")
                    .find('option')
                    .not('.other')
                    .remove()
                    .end()
                    .append('<option class="neighborhoods" value=" ">جميع الأحياء</option>');
                data.forEach(function (city) {
                    var iselected = checktruefalse(city.id);
                    $("[name='city_id']")
                        .append($("<option class='cities'></option>")
                            .attr("value", city.id)
                            .text(city.name));

                    $('.cities[value="' + city.id + '"]')
                        .attr('selected', iselected);
                    get_neighborhoods();
                });


            });


        });

        function get_cities() {
            var governorate_id = $("[name='governorate_id']").val();
            $.get("/admin/governorates/cities/" + governorate_id, function (data, status) {
                $("[name='city_id']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="cities" value=" ">جميع المدن</option>');
                $("[name='neighborhood_id']")
                    .find('option')
                    .not('.other')
                    .remove()
                    .end()
                    .append('<option class="neighborhoods" value=" ">جميع الأحياء</option>');
                data.forEach(function (city) {
                    var iselected = checktruefalse(city.id);
                    $("[name='city_id']")
                        .append($("<option class='cities'></option>")
                            .attr("value", city.id)
                            .text(city.name));
                    $('.cities[value="' + city.id + '"]')
                        .attr('selected', iselected);

                });
            });

        }

        function checktruefalse(id) {

            if (id == '{{old('city_id')}}') {
                return true
            } else
                return false
        }
    </script>
    <script>
        $(document).ready(function () {

            var city_id = $("[name='city_id']").val();

            $.get("/admin/cities/neighborhoods/" + city_id, function (data, status) {
                if(typeof data=='object'){
                $("[name='neighborhood_id']")
                    .find('option')
                    .not('.other')
                    .remove()
                    .end()
                    .append('<option class="neighborhoods" value=" ">جميع الأحياء</option>');

                data.forEach(function (neighborhood) {
                    var iselected = checktruefalse2(neighborhood.id);
                    $("[name='neighborhood_id']")
                        .append($("<option class='neighborhoods'></option>")
                            .attr("value", neighborhood.id)
                            .text(neighborhood.name));

                    $('.neighborhoods[value="' + neighborhood.id + '"]')
                        .attr('selected', iselected);

                });
                }
            });
        });

        function get_neighborhoods() {
            var city_id = $("[name='city_id']").val();

            $.get("/admin/cities/neighborhoods/" + city_id, function (data, status) {
                if(typeof data=='object'){
                $("[name='neighborhood_id']")
                    .find('option')
                    .not('.other')
                    .remove()
                    .end()
                    .append('<option class="neighborhoods" value=" ">جميع الأحياء</option>');

                data.forEach(function (neighborhood) {
                    var iselected = checktruefalse2(neighborhood.id);
                    $("[name='neighborhood_id']")
                        .append($("<option class='neighborhoods'></option>")
                            .attr("value", neighborhood.id)
                            .text(neighborhood.name));
                    $('.neighborhoods[value="' + neighborhood.id + '"]')
                        .attr('selected', iselected);

                });
}
            });

        }

        function checktruefalse2(id) {
            if (id == '{{old('neighborhood_id')}}') {
                return true
            } else
                return false
        }


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