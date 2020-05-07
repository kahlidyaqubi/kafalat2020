@extends('layouts.dashboard.app')

@section('pageTitle','تعديل كافل')
@section('headerCSS')
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة الكفلاء')
@section('navigation3','تعديل كافل')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/sponsors')
@section('navigation3_link','/admin/sponsors/'.$sponsor->id.'/edit')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل كافل {{$sponsor->name}}
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body" method="post" action="/admin/sponsors/{{$sponsor->id}}">
            @csrf
            @method('put')
            <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12 ">
                        <div class="form-group ">
                            <label class="col-form-label col-lg-12">الدولة</label>
                            <div style="width: 99%;">
                                <select class="form-control kt-select2 select2-multi"
                                        name="country_id" id="country_id">
                                    <option value=" " selected> الدول</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}" country_id="{{$country->id}}"
                                                @if($country->id == $sponsor->country_id) selected @endif>{{$country->name." ".$country->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group ">
                            <label class="col-form-label col-lg-12">رقم الكافل</label>
                            <input class="form-control numbers"
                                   maxlength="15" minlength="8"
                                   name="mobile" id="mobile"
                                   value="{{$sponsor->mobile}}" style="width: 99%">
                        </div>
                    </div>
                    <hr class="col-lg-10 col-md-10 col-sm-10" style="border: 2px #ddd solid">
                    <!-- Start col -->
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group ">
                            <label class="col-form-label col-lg-12">اسم الكافل</label>
                            <input class="form-control " type="text"
                                    disabled readonly
                                   value="{{$sponsor->name}}" style="width: 99%">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group ">
                            <label class="col-form-label col-lg-12">كود الكافل</label>
                            <input class="form-control " type="text"
                                   disabled readonly
                                   value="{{$sponsor->code}}" style="width: 99%">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label col-lg-12">حالة الكافل</label>
                            <input class="form-control " type="text"
                                    disabled readonly
                                   value="{{$sponsor->sponsor_status ?$sponsor->sponsor_status->name : ""}}"
                                   style="width: 99%">
                        </div>
                    </div>
                </div>
                <!-- End Row -->

                <!-- Satrt Button Confirm -->
                <div class="col-12">
                   <div class="form-group row">
                        <button type="submit"
                                  class="btn btn-success btn-elevate btn-block ">تعديل
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
            </form>
        </div>
        <!--end::Portlet-->
    </div>


@endsection

@section('footerJS')
     <script>
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
@endsection