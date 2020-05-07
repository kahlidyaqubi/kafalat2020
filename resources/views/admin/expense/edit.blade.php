@extends('layouts.dashboard.app')

@section('pageTitle','تعديل صرفية')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الصرفيات')
@section('navigation3',' تعديل صرفية')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expenses')
@section('navigation3_link','/admin/expenses/'.$expense->is.'/edit')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <br>
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل صرفية {{$expense->old_name}}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div id="required-error"></div>
                <form method="post" data-parsley-validate action="{{ url('admin/expenses/'.$expense->id) }}"
                      enctype="multipart/form-data">
                @csrf
                @method('put')
                <!-- Start Row -->
            <br>
                    <div class="row">
                      
                      
                      <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">اسم الملف</label>
                                <input class="form-control "  type="text" 
                                       id="old_name" name="old_name" value=" {{$expense->old_name}}"
                                       style="width: 99%" required>
                            </div>
                        </div>
                        </div>
                        <!-- End col -->
                        <br>
                        <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">تاريخ الاستلام</label>
                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text" 
                                       id="recive_date" name="recive_date" value="{{$expense->recive_date?date('Y-m-d', strtotime($expense->recive_date)):""}}"
                                       style="width: 99%" required>
                            </div>
                        </div>
                        <!-- End col -->

                    </div>
                    <!-- End Row -->

                <!-- Satrt Button Confirm -->
                <div class="col-12">
                    <div class="form-group row">
                        <button type="submit"
                              class="btn btn-success btn-elevate btn-block ">التالي
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
            $("[name='recive_date']").datepicker({
                format: 'yyyy-mm-dd',
                orientation: "top auto",
                autoclose: true,
                clearBtn: true,
                    todayBtn: "linked",


            });
        </script>
    
    // <script>
                 
    //     $(document).ready(function () {
    //         $('form').submit(function () {
    //             $(this).find(':submit').attr('disabled', 'disabled');
    //             $('#wating').show();
    //         });
    //     });
    // </script>
@endsection