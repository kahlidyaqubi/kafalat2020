@extends('layouts.dashboard.app')

@section('pageTitle','إضافة جمعية')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('new_theme/assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الجمعيات')
@section('navigation3','إضافة جمعية')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/institutions')
@section('navigation3_link','/admin/institutions/create')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        اضافة جمعية
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form method="post"
                      action="{{ url('admin/institutions') }}">
                    @csrf
                    <input type="hidden" name="come_by" value="{{$come_by??""}}">
                    <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">إسم الجمعية
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input  required class="form-control arabic" id="name" name="name" type="text"
                                           value="{{ old("name")}}" placeholder="إسم الجمعية">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الشخص المسؤول
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" id="responsible_person" name="responsible_person"
                                           type="text"
                                           value="{{ old("responsible_person")}}" placeholder="الشخص المسؤول">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الجوال - 1
                                    <span style="color:red;">*</span></label>
                                <div class="input-group" style="width: 95%;">
                                    <input  required class="form-control numbers" value="{{ old("mobile_one") }}"
                                           name="mobile_one"
                                           maxlength="10" minlength="9" aria-describedby="basic-addon1"
                                           placeholder="رقم الجوال">
                                    <div class="input-group-prepend"><span class="input-group-text">
																	<span class="fa fa-phone"></span>
																	970+</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الجوال - 2</label>
                                <div class="input-group" style="width: 95%;">
                                    <input class="form-control numbers" value="{{ old("mobile_two") }}"
                                           name="mobile_two"
                                           maxlength="10" minlength="9" aria-describedby="basic-addon1"
                                           placeholder=" رقم الجوال 2">
                                    <div class="input-group-prepend"><span class="input-group-text">
																	<span class="fa fa-phone"></span>
																	970+</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الهاتف</label>
                                <div class="input-group" style="width: 95%;">
                                    <input class="form-control numbers"
                                           value="{{ old("mobile") }}" name="mobile"
                                           maxlength="9" minlength="7"
                                           placeholder="الهاتف" aria-describedby="basic-addon1">
                                    <div class="input-group-prepend"><span class="input-group-text">
																	<span class="fa fa-phone"></span>
																	970+</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                         <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">المحافظة
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi" id="governorate_id"
                                            name="governorate_id" onchange="get_cities()">
                                        <option value=" " selected> المحافظة</option>
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
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">المدينة
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi" id="city_id"
                                            name="city_id" onchange="get_neighborhoods()">
                                        <option value=" " selected> المدينة</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الحي
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi" id="neighborhood_id"
                                            name="neighborhood_id" id="neighborhood_id" onchange="neighborhood_other()">
                                        <option value="" selected>الحي</option>
                                        <option value="1" class="other" >أخرى</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 neighborhood_other" style="display: none">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">حي آخر
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input  class="form-control" id="neighborhood_id_other"
                                           name="neighborhood_id_other" type="text"
                                           value="{{ old("neighborhood_id_other")}}"
                                           placeholder="الحي">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">عنوان السكن
                                    <span style="color:red;">*</span></label>
                                <div style="width: 98%;">
                                    <input class="form-control" name="address" type="text"
                                           value="{{old("address")}}" placeholder="عنوان السكن">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">جهة الترخيص
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi" name="licensor_id"
                                            id="licensor_id" onchange="licensor_other()">
                                        <option value=" " selected>جهة الترخيص</option>
                                        @foreach($licensors->sortBy('name') as $licensor)
                                            <option value="{{$licensor->id}}"
                                                    @if($licensor->id==old("licensor_id")) selected @endif>{{$licensor->name}} {{ !is_null($licensor->name_tr) ? ' ( ' .$licensor->name_tr .' )' : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                       <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12 licensor_other" style="display: none">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">جهة ترخيص آخر
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input class="form-control" id="licensor_id_other"
                                           name="licensor_id_other" type="text"
                                           value="{{ old("licensor_id_other")}}"
                                           placeholder="اسم جهة الترخيص">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الترخيص

                                </label>
                                <div style="width: 95%;">
                                    <input minlength="3" class="form-control" id="licensor_number" name="licensor_number" type="number"
                                           value="{{ old("licensor_number")}}" placeholder="رقم الترخيص">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->

                        
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">مجال عمل الجمعية
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi"
                                            name="institution_type_id" id="institution_type_id"
                                            onchange="institution_type_other()">
                                        <option value="" selected>مجال عمل الجمعية</option>
                                        @foreach($institution_types->sortBy('name') as $institution_type)
                                            <option value="{{$institution_type->id}}"
                                                    @if($institution_type->id==old("institution_type_id")) selected @endif>{{$institution_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 institution_type_other" style="display: none">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">مجال عمل جمعية آخر
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input class="form-control" id="institution_type_id_other"
                                           name="institution_type_id_other" type="text"
                                           value="{{ old("institution_type_id_other")}}"
                                           placeholder="مجال عمل الجمعية">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                       
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">فئات الاستهداف
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi" name="target_types_ids[]"
                                            id="target_types_ids" multiple>
                                        <option value=" " disabled>فئة الاستهداف</option>
                                        @foreach($target_types as $target_type)
                                            <option value="{{$target_type->id}}"
                                                    @if(collect(old('target_types_ids'))->contains($target_type->id))selected @endif>{{$target_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12" >
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">فئات أخرى

                                </label>
                                <div style="width: 95%;">
                                    <input class="form-control" type="text" style="width: 100%"
                                           value="{{old("other_targets")}}" name="other_targets" data-role="tagsinput">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                       


                    </div>
                    <!-- End col -->
                <!-- Satrt Button Confirm -->
                    <div class="col-12">
                        <button type="submit"
                                  class="btn btn-success btn-elevate btn-block ">إضافة
                                <span id="wating" class="" style="display: none">&nbsp;&nbsp;
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
    <script src="{{asset('new_theme/assets/js/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('.bootstrap-tagsinput input').on('keypress', function (e) {
                if (e.keyCode == 13) {
                    e.keyCode = 188;
                    e.preventDefault();
                }
                ;
            });
        });
    </script>
    <script>

        function institution_type_other() {
            if ($('#institution_type_id').val() == 1) {
                $('.institution_type_other').show();
            } else {
                $('.institution_type_other').hide();
                $('#institution_type_id_other').val("");
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

        function licensor_other() {
            if ($('#licensor_id').val() == 1) {
                $('.licensor_other').show();
            } else {
                $('.licensor_other').hide();
                $('#licensor_id_other').val("");
            }
        }

        $(document).ready(function () {
            $(".bootstrap-tagsinput input").css({"width": "400px", "height": "28px"});
            if ($('#institution_type_id').val() == 1) {
                $('.institution_type_other').show();
            } else {
                $('.institution_type_other').hide();
                $('#institution_type_id_other').val("");
            }
            if ($('#neighborhood_id').val() == 1) {
                $('.neighborhood_other').show();
            } else {
                $('.neighborhood_other').hide();
                $('#neighborhood_id_other').val("");
            }
            if ($('#licensor_id').val() == 1) {
                $('.licensor_other').show();
            } else {
                $('.licensor_other').hide();
                $('#licensor_id_other').val("");
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
                    .end();
                    
                    $("[name='neighborhood_id']").append('<option class="neighborhoods" value=" " selected>جميع الأحياء</option>');
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
                    .end();
                    $("[name='neighborhood_id']").append('<option class="neighborhoods" value=" " selected>جميع الأحياء</option>');
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
                    ;
                    $("[name='neighborhood_id']").append('<option class="neighborhoods" value=" " selected>جميع الأحياء</option>');

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
                    .end();
                    $("[name='neighborhood_id']").append('<option class="neighborhoods" value=" " selected>جميع الأحياء</option>');

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