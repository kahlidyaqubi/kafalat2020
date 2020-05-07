@extends('layouts.dashboard.app')

@section('pageTitle','عرض اتصال')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة الاتصالات')
@section('navigation3','عرض اتصال')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/calls')
@section('navigation3_link','/admin/calls/'.$call->id)
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        عرض اتصال
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body">
                <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">اختيار الكافل</label>
                            <div style="width: 95%;">
                                <select readonly disabled class="form-control kt-select2 select2-multi" id="sponsor_id"
                                        name="sponsor_id">
                                    <option value=" " selected>الكافل</option>
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
                                <select readonly disabled class="form-control kt-select2 select2-multi"
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
                            <input  disabled class="form-control numbers" 
                                   maxlength="9" minlength="11"
                                   name="sponsor_mobile" id="sponsor_mobile"
                                   value="{{$call->sponsor->mobile}}" style="width: 95%">
                        </div>
                    </div>

                    <!-- Start col -->

                    <!-- End col -->
                    <!-- Start col -->
                     <div class="col-lg-6 col-md-6 col-sm-12 type3">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">مكفول<span style="color:red;">*</span></label>
                            <div style="width: 95%;">
                                <select readonly disabled  required class="form-control kt-select2 select2-multi"
                                        name="family_id" required  id="family_id">
                                    <option value="" selected> مكفول</option>
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
                                <input disabled 
                                       maxlength="9" minlength="11"
                                       name="family_mobile"
                                       id="family_mobile"
                                       value="{{$call->family->mobile_one ? $call->family->mobile_one:$call->family->mobile_two}}"
                                       class="form-control numbers"
                                       aria-describedby="basic-addon1">
                                <div class="input-group-prepend"><span class="input-group-text">
																	<span class="fa fa-phone"></span>
																	970+</span></div>
                            </div>

                        </div>
                    </div>
                    <!-- Start col -->
                     <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">تاريخ الاتصال</label>
                            <input disabled class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text"
                                   name="his_date"
                                   value="{{$call->his_date}}" style="width: 86%">
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <input type="hidden" name="status"
                           value="0">
                   <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">نجاح الاتصال<span style="color:red;">*</span></label>
                            <input readonly disabled type="checkbox"   name="status"
                                   {{$call->status?"checked":" "}} value="1" style="width: 39px; height: 39px; margin: 0px 35px;">
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">سبب الاتصال<span style="color:red;">*</span></label>
                            <input disabled class="form-control "  required type="text"
                                   name="reason"
                                   value="{{$call->reason}}" style="width: 96%">
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                     <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">ملاحظات<span style="color:red;">*</span></label>
                            <div style="width: 98%;">
								<textarea disabled name="note" required  class="form-control" placeholder="ملاحظات">{{$call->note}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->

                </div>
                <!-- End Row -->
            </form>
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