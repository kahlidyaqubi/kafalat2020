@extends('layouts.dashboard.app')

@section('pageTitle','تعديل مبلغ صرف')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة مبالغ الصرف')
@section('navigation3','تعديل مبلغ صرف')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expense_amounts')
@section('navigation3_link','/admin/expense_amounts/edit'.$expense_amount->id)
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل مبلغ صرف
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body" method="post" action="/admin/expense_amounts/{{$expense_amount->id}}">
            @csrf
            @method('put')
            <!-- Start Row -->

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 type3">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">الجهة المرشحة<span style="color:red;">*</span></label>
                            <div style="width: 95%;">
                                <select disabled readonly=""   class="form-control kt-select2 select2-multi"
                                >
                                    <option
                                            selected>{{$expense_amount->funded_institution->name}}</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 type3">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">السنة<span style="color:red;">*</span></label>
                            <div style="width: 95%;">
                                <select readonly disabled class="form-control kt-select2 select2-multi"
                                >
                                    <option selected> {{$expense_amount->year}}</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12 type3">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">الشهر<span style="color:red;">*</span></label>
                            <div style="width: 95%;">
                                <select readonly disabled class="form-control kt-select2 select2-multi"
                                >
                                    <option selected> {{$expense_amount->month->name_ar}}</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Start col -->
                    <!-- End col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">المبلغ<span style="color:red;">*</span></label>
                            <input class="form-control " type="number" step="0.00001"
                                   name="amount" id="amount" required 
                                   value="{{$expense_amount->amount??0}}" style="width: 86%">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 type3">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">العملة<span style="color:red;">*</span></label>
                            <div style="width: 95%;">
                                <select  required class="form-control kt-select2 select2-multi"
                                        name="currency_id">
                                    <option value="" selected> العملة</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}"
                                                @if($currency->id == $expense_amount->currency_id) selected @endif>{{$currency->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">الاقتطاع بال %<span style="color:red;">*</span></label>
                            <input class="form-control " type="number" step="0.00001"
                                   name="discount" id="discount" required 
                                   value="{{$expense_amount->discount??0}}" style="width: 86%">
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