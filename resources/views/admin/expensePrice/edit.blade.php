@extends('layouts.dashboard.app')

@section('pageTitle','تعديل سعر صرف')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة أسعار الصرف')
@section('navigation3','تعديل سعر صرف')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expense_prices')
@section('navigation3_link','/admin/expense_prices/edit'.$expense_price->id)
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل سعر صرف
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body" method="post" action="/admin/expense_prices/{{$expense_price->id}}">
            @csrf
            @method('put')
            <!-- Start Row -->

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 type3">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">الجهة المرشحة</label>
                            <div style="width: 95%;">
                                <select disabled readonly="" class="form-control kt-select2 select2-multi"
                                >
                                    <option
                                            selected>{{$expense_price->funded_institution->name}}</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 type3">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">السنة</label>
                            <div style="width: 95%;">
                                <select readonly disabled class="form-control kt-select2 select2-multi"
                                >
                                    <option selected> {{$expense_price->year}}</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12 type3">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">الشهر</label>
                            <div style="width: 95%;">
                                <select readonly disabled class="form-control kt-select2 select2-multi"
                                >
                                    <option selected> {{$expense_price->month->name_ar}}</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Start col -->
                    <!-- End col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">من يورو لشيكل</label>
                            <input class="form-control " type="number" step="0.00001"
                                   name="euro_nis" id="euro_nis"
                                   value="{{$expense_price->euro_nis??0}}" style="width: 86%">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">من يورو لدولار</label>
                            <input class="form-control " type="number" step="0.00001"
                                   name="euro_usd" id="euro_usd"
                                   value="{{$expense_price->euro_usd??0}}" style="width: 86%">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">من دولار لشيكل</label>
                            <input class="form-control " type="number" step="0.00001"
                                   name="usd_nis" id="usd_nis"
                                   value="{{$expense_price->usd_nis??0}}" style="width: 86%">
                        </div>
                    </div>


                </div>
                <!-- End Row -->

                <!-- Satrt Button Confirm -->
                <div class="col-md-2">
                    <button type="submit"
                            class="btn btn-success btn-elevate btn-block ">حفظ
                    </button>
                </div>
                <!-- End Button Confirm -->
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