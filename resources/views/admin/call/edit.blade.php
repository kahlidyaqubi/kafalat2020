@extends('layouts.dashboard.app')

@section('pageTitle','تعديل اتصال')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة الاتصالات')
@section('navigation3','تعديل اتصال')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/calls')
@section('navigation3_link','/admin/calls/'.$call->id.'/edit')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل اتصال
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body" method="post" action="/admin/calls/{{$call->id}}">
            @csrf
            @method('put')
            <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">اختيار الكافل<span
                                        style="color:red;">*</span></label>
                            <div style="width: 95%;">

                                <select id='selUser2' name="sponsor_id" style='width: 200px;'>
                                    <option value='0'>- اختر كافل -</option>
                                    <option value="{{$call->sponsor_id}}" selected>{{$call->sponsor->name}}-{{$call->sponsor->code}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <!-- Start col -->
                    <div class="col-lg-2 col-md-6 col-sm-12 ">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">مقدمة رقم الكافل <span
                                        style="color:red;">*</span></label>
                            <div style="width: 95%;">
                                <select class="form-control "
                                        name="code" id="code">
                                    <option value=" " selected> الدول</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->code}}" country_id="{{$country->id}}"
                                                @if($country->code == $call->sponsor->country->code) selected @endif>{{$country->name." ".$country->code}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">رقم اتصال الكافل<span
                                        style="color:red;">*</span></label>
                            <input class="form-control numbers"
                                   maxlength="15" minlength="8"
                                   name="sponsor_mobile" id="sponsor_mobile"
                                   value="{{$call->sponsor->mobile}}" style="width: 95%" placeholder="-رقم اتصال الكافل-">
                        </div>
                    </div>

                    <!-- Start col -->

                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12 type3">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">مكفول<span style="color:red;">*</span></label>
                            <div style="width: 95%;">

                                <select id='selUser' name="family_id"  required style='width: 200px;'>
                                    <option value=''>- اختر مكفولاً -</option>
                                    <option value="{{$call->family_id}}"
                                            selected> {{$call->family->person->full_name}}
                                        / {{$call->family->code}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">رقم اتصال المكفول<span
                                        style="color:red;">*</span></label>
                            <div class="input-group" style="width: 96%;">
                                <input maxlength="10" minlength="8"
                                       name="family_mobile"
                                       id="family_mobile"
                                       value="{{$call->family->mobile_one ? $call->family->mobile_one:$call->family->mobile_two}}"
                                       class="form-control numbers"
                                       aria-describedby="basic-addon1" placeholder="-رقم اتصال المكفول-" >
                                <div class="input-group-prepend"><span class="input-group-text">
																	<span class="fa fa-phone"></span>
																	970+</span></div>
                            </div>

                        </div>
                    </div>
                    <!-- Start col -->
                  <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">تاريخ الاتصال
                                <span style="color:red;">*</span></label>
                            <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text"
                                   name="his_date"
                                   value="{{$call->his_date}}"  required style="width: 86%" placeholder="-تاريخ الاتصال-">
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <input type="hidden" name="status"
                           value="0">
                   <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">نجاح الاتصال<span style="color:red;">*</span></label>
                            <input type="checkbox" name="status" {{$call->status?"checked":" "}} value="1" style="width: 39px; height: 39px; margin: 0px 35px;">
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">سبب الاتصال<span style="color:red;">*</span></label>
                            <input class="form-control "  required type="text"
                                   name="reason"
                                   value="{{$call->reason}}" style="width: 96%" placeholder="-سبب الاتصال-">
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">ملاحظات<span style="color:red;">*</span></label>
                            <div style="width: 98%;">
														<textarea  required name="note" class="form-control" placeholder="ملاحظات"
                                                                  style="height: 100px;">{{$call->note}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->

                </div>
                <!-- End Row -->

                <!-- Satrt Button Confirm -->
                <div class="col-12">
                    <button type="submit"
                            class="btn btn-success btn-elevate btn-block ">حفظ
                        <span id="wating" class="" style="display: none">                            &nbsp;&nbsp;
                            <span class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </span>
                            <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                        </span>
                    </button>
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
        $("#selUser").select2({
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

        $("#selUser").on('select2:select', function (e) {
            $.get("/admin/families/families_ajax_id?q=" + $("#selUser").val(), function (data, status) {
                // family= data.
                var the_family_mobile = data.mobile_one ? data.mobile_one : data.mobile_two;
                //console.log(data + "/" + $("#selUser").val());
                $('#family_mobile').val(the_family_mobile);
            });
        });

    </script>

    <script>
        $("#selUser2").select2({
            ajax: {
                url: "/admin/sponsors/sponsors_ajax",
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
        $("#selUser2").on('select2:select', function (e) {
            $.get("/admin/sponsors/sponsors_ajax_id?q=" + $("#selUser2").val(), function (data, status) {
                // family= data.
                $('#sponsor_mobile').val(data.mobile);
                $('#code').val(data.country.code);
            });
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

@endsection