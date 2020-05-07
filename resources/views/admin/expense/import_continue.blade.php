@extends('layouts.dashboard.app')

@section('pageTitle','اكمال معلومات الصرفية')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الصرفيات')
@section('navigation3','اكمال معلومات الصرفية')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expenses')
@section('navigation3_link','#')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        اكمال استيراد صرفية
                    {{$old_name}}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div id="required-error"></div>
                <form method="post" id="import_file" data-parsley-validate
                      action="{{ url('admin/expenses/ImportExcel_2') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <input name="excel_file" type="hidden" value="{{$excel_file_name}}">
                    <input name="old_name" type="hidden" value="{{$old_name}}">
                    <input name="has_months" type="hidden" value="{{$has_months}}">
                    <input name="family_project_id" type="hidden" value="{{$family_project_id}}">
                    <input name="recive_date" type="hidden" value="{{$recive_date}}">
                    <input name="the_amount_in_index" type="hidden" value="{{$the_amount_in_index}}">


                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group row">
                                <label class="kt-checkbox">
                                    <input type="checkbox" id="in_valid" name="in_valid" type="checkbox"
                                           value="1">تميكن الإبطال
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">السنة</label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi"
                                            name="year" disabled>
                                        @for($i=2006;$i<=2025;$i++)
                                            <option value="{{$i}}" @if($i==$year) disabled
                                                    selected @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        @if($months)
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">الاشهر</label>
                                    <div style="width: 95%;">
                                        <select class="form-control kt-select2 select2-multi"
                                                id="months" multiple name="months[]" readonly>
                                            @foreach($months as $month)
                                                <option value="{{$month->id}}" selected disabled>{{$month->name_tr}}
                                                    -{{$month->name_ar}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">الاشهر</label>
                                    <div style="width: 95%;">
                                        <select class="form-control kt-select2 select2-multi"
                                                id="months" name="months[]" readonly>
                                            @foreach($all_months as $month)
                                                <option value="{{$month->id}}"
                                                        @if($month->id==old("month")) selected @endif>{{$month->name_tr}}
                                                    -{{$month->name_ar}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                    <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">اسم الجهة
                                    المستفيدة</label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi"
                                            multiple name="funded_institutions[]" readonly>
                                        <option value=" ">الجهات المستفدية</option>
                                        @foreach($funded_institutions as $funded_institution)
                                            <option value="{{$funded_institution->id}}" selected
                                                    disabled>{{$funded_institution->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- End col -->
                        <hr style="width: 100%;">
                        <h2>أسعار ومبالغ الجهات</h2>
                        <hr style="width: 100%;">
                        @if($expense_prices && $expense_amounts)
                            @for($i=0 ; $i<count($expense_prices) ; $i++)
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <h4>{{$expense_prices[$i]->funded_institution->name}}
                                            -{{$expense_prices[$i]->funded_institution->code}}</h4>
                                        <input name="funded_institution_id_prices[{{$expense_prices[$i]->id}}]"
                                               value="{{$expense_prices[$i]->funded_institution->id}}"
                                               type="hidden">
                                        <input name="funded_institution_id_amounts[{{$expense_amounts[$i]->id}}]"
                                               value="{{$expense_amounts[$i]->funded_institution->id}}"
                                               type="hidden">
                                    </div>
                                    @if($expense_amounts[$i]->funded_institution->id != $expense_prices[$i]->funded_institution->id)
                                        {{dd('خطأ فادح يرجى مراجعة المبرمج')}}
                                    @endif
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <h4>{{$expense_prices[$i]->month->name_en}}-{{$expense_prices[$i]->year}}</h4>
                                        <input readonly
                                               value="{{$expense_amounts[$i]->month->id}}"
                                               name="month_amounts[{{$expense_amounts[$i]->id}}]" type="hidden">
                                        <input readonly
                                               value="{{$expense_prices[$i]->month->id}}"
                                               name="month_prices[{{$expense_prices[$i]->id}}]" type="hidden">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        @if($currency)
                                            <h4>{{$currency->name}}</h4>
                                            <input readonly oka class="numbers" value="{{$currency->id}}"
                                                   name="currency_id[{{$expense_amounts[$i]->id}}]"
                                                   type="hidden">
                                        @elseif($expense_amounts[$i]->currency)
                                            <h4>{{$expense_amounts[$i]->currency->name}}</h4>
                                            <input readonly boka class="numbers"
                                                   value="{{$expense_amounts[$i]->currency->id}}"
                                                   name="currency_id[{{$expense_amounts[$i]->id}}]"
                                                   type="hidden">
                                        @else
                                            <label class="col-form-label col-lg-12"> نوع العملة</label>
                                            <select class="form-control "
                                                    name="currency_id[{{$expense_amounts[$i]->id}}]"
                                                    hisprice="{{$expense_prices[$i]->id}}">
                                                <option value=" "> نوع العملة
                                                </option>
                                                @foreach($all_currencies->where('id','!=',3) as $currency_now)
                                                    <option value="{{$currency_now->id}}"
                                                            @if($currency_now->id==old("currency_id")) selected @endif>{{$currency_now->name}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <!-- Start col -->
                                    <textarea style="display: none" name="change_type[{{$expense_prices[$i]->id}}]"
                                              type="hidden">0</textarea>
                                    <div class="col-lg-4 col-md-4 col-sm-12">

                                        <div class="">
                                            <label class="kt-radio">
                                                <input name="change_type[{{$expense_prices[$i]->id}}]"
                                                       type="radio"
                                                       special="one_{{$expense_prices[$i]->id}}" value="1"
                                                       @if((($expense_amounts[$i]->currency)&&$expense_amounts[$i]->currency->name_en  == 'usd'&&!($currency)) || (($currency)&&$currency->name_en == 'usd'))
                                                       disabled @endif
                                                       @if(old("change_type")[$expense_prices[$i]->id] == 1) checked @endif>
                                                من يورو الى شيكل
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-12">سعر الصرف</label>
                                            <div style="width: 95%;">
                                                <input class="form-control "
                                                       type="number"
                                                       id="euroToDollarPrice"
                                                       name="euro_nis[{{$expense_prices[$i]->id}}]"
                                                       special="one_{{$expense_prices[$i]->id}}"
                                                       data-parsley-errors-container="#required-error"
                                                       step="0.00001"
                                                       @if((($expense_amounts[$i]->currency)&&$expense_amounts[$i]->currency->name_en == 'usd') || (($currency)&&$currency->name_en == 'usd'))
                                                       disabled 
                                                       @endif
                                                       value="{{old("euro_nis")[$expense_prices[$i]->id] ?? $expense_prices[$i]->euro_nis}}"
                                                       placeholder="يورو لشيكل">
                                            </div>
                                        </div>

                                    </div>
                                    <!-- End col -->
                                    <!-- Start col -->
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="">
                                            <label class="kt-radio">
                                                <input name="change_type[{{$expense_prices[$i]->id}}]"
                                                       type="radio"
                                                       special="three_{{$expense_prices[$i]->id}}" value="3"
                                                       @if((($expense_amounts[$i]->currency)&&$expense_amounts[$i]->currency->name_en == 'euro' && !($currency)) || (($currency)&&$currency->name_en == 'euro'))
                                                       disabled @endif
                                                       @if(old("change_type")[$expense_prices[$i]->id]== 3)checked= @endif>
                                                من دولار الى شيكل
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-12">سعر الصرف</label>
                                            <div style="width: 95%;">
                                                <input class="form-control  "
                                                       type="number"
                                                       id="dollarToNisPrice" name="usd_nis[{{$expense_prices[$i]->id}}]"
                                                       data-parsley-error-message="حقل سعر صرف من الدولار الى الشيكل إِجباري"
                                                       special="three_{{$expense_prices[$i]->id}}"
                                                       data-parsley-errors-container="#required-error"
                                                       step="0.00001"
                                                       @if((($expense_amounts[$i]->currency)&&$expense_amounts[$i]->currency->name_en == 'euro') || (($currency)&&$currency->name_en == 'euro'))
                                                       disabled @endif
                                                       value="{{old("usd_nis")[$expense_prices[$i]->id] ?? $expense_prices[$i]->usd_nis}}"
                                                       placeholder="دولار لشيكل">
                                            </div>
                                        </div>

                                    </div>
                                    <!-- End col -->
                                    <!-- Start col -->
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="">
                                            <label class="kt-radio">
                                                <input name="change_type[{{$expense_prices[$i]->id}}]"
                                                       type="radio"
                                                       special="two_{{$expense_prices[$i]->id}}" value="2"
                                                       @if((($expense_amounts[$i]->currency)&&$expense_amounts[$i]->currency->name_en == 'usd'&&!($currency)) || (($currency)&&$currency->name_en == 'usd'))
                                                       disabled @endif
                                                       @if(old("change_type")[$expense_prices[$i]->id] == 2)checked= @endif>
                                                تحويل عملتين
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 col-md-6">
                                                <label class="col-form-label col-lg-12">سعر
                                                    الصرف</label>
                                                <div style="width: 95%;">
                                                    <input class="form-control  "
                                                           type="number"
                                                           id="euroToNisPrice"
                                                           name="euro_usd[{{$expense_prices[$i]->id}}]"
                                                           special="two_{{$expense_prices[$i]->id}}"
                                                           data-parsley-errors-container="#required-error"
                                                           step="0.00001"
                                                           @if((($expense_amounts[$i]->currency)&&$expense_amounts[$i]->currency->name_en == 'usd') || (($currency)&&$currency->name_en == 'usd'))
                                                           disabled @endif
                                                           value="{{old("euro_usd")[$expense_prices[$i]->id] ?? $expense_prices[$i]->euro_usd}}"
                                                           placeholder="يورو لدولار">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <label class="col-form-label col-lg-12"> .</label>
                                                <div style="width: 95%;">
                                                    <input class="form-control  "
                                                           type="number"
                                                           id="euroToNisPrice"
                                                           name="usd_nis_ind[{{$expense_prices[$i]->id}}]"
                                                           special="two_{{$expense_prices[$i]->id}}"
                                                           data-parsley-errors-container="#required-error"
                                                           step="0.00001"
                                                           @if((($expense_amounts[$i]->currency)&&$expense_amounts[$i]->currency->name_en == 'usd') || (($currency)&&$currency->name_en == 'usd'))
                                                           disabled @endif
                                                           value="{{old("usd_nis_ind")[$expense_prices[$i]->id] ?? $expense_prices[$i]->usd_nis}}"
                                                           placeholder="دولار لشيكل">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    @if($the_amount_in_index)
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">المبلغ</label>
                                                <div style="width: 87%;">
                                                    <input type="text" class="form-control" readonly disabled
                                                           value="متوفر داخل الملف">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">نسبة
                                                    % الاقتطاع</label>
                                                <div style="width: 87%;">
                                                    <input type="number"
                                                           step="0.00001" class="form-control"
                                                           value="{{old("discount")[$expense_amounts[$i]->id] ??  $expense_amounts[$i]->discount}}"
                                                           name="discount[{{$expense_amounts[$i]->id}}]">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="amount_befor[{{$expense_amounts[$i]->id}}]"
                                               value="0">
                                    @else
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">المبلغ</label>
                                                <div style="width: 87%;">
                                                    <input class="form-control"
                                                           value="{{old("amount_befor")[$expense_amounts[$i]->id] ?? $expense_amounts[$i]->amount}}"
                                                           name="amount_befor[{{$expense_amounts[$i]->id}}]"
                                                           type="number"
                                                           min="1"
                                                           step="0.00001">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">نسبة
                                                    % الاقتطاع</label>
                                                <div style="width: 87%;">
                                                    <input class="form-control"
                                                           value="{{old("discount")[$expense_amounts[$i]->id] ??  $expense_amounts[$i]->discount}}"
                                                           name="discount[{{$expense_amounts[$i]->id}}]" type="number"
                                                           step="0.00001">
                                                </div>
                                            </div>
                                        </div>
                                @endif
                                <!-- End col -->
                                    <hr style="width: 100%;border:2px solid #ddd">
                                </div>
                            @endfor
                        @endif
                    </div>
                    <!-- End Row -->
                    
                <!-- Satrt Button Confirm -->
                <div class="col-12">
                    <div class="form-group row">
                        <button type="submit"
                              class="btn btn-success btn-elevate btn-block ">حفظ
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
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
    <script>
        $('select[name^="currency_id"]').on("change", function () {

            var hisprice = $(this).attr('hisprice');
            var hisvalue = $(this).val();

            console.log(hisprice);
            console.log(hisvalue);

            if (hisvalue == 1) {
                $(":input[type='number'][special=one_" + hisprice + "]").attr('disabled', false);
                $(":radio[special=one_" + hisprice + "]").attr('disabled', false);
                $(":radio[special=two_" + hisprice + "]").attr('disabled', false);

                $(":input[type='number'][special=two_" + hisprice + "]").val(0).attr('disabled', true);
                $(":input[type='number'][special=three_" + hisprice + "]").val(0).attr('disabled', true);
                
                $(":radio[special=three_" + hisprice + "]").attr('disabled', true);
            } else if (hisvalue == 2) {
                $(":input[type='number'][special=three_" + hisprice + "]").attr('disabled', false);
                $(":radio[special=three_" + hisprice + "]").attr('disabled', false);

                $(":input[type='number'][special=one_" + hisprice + "]").val(0).attr('disabled', true);
                $(":input[type='number'][special=two_" + hisprice + "]").val(0).attr('disabled', true);
                $(":radio[special=two_" + hisprice + "]").attr('disabled', true);
                $(":radio[special=one_" + hisprice + "]").attr('disabled', true);
            }

        });
    </script>
    <script>
        $(document).ready(function () {
            for (var j = 0; j < document.querySelectorAll('select[name^="currency_id"]').length; j++) {
                var hisprice = document.querySelectorAll('select[name^="currency_id"]')[j].getAttribute('hisprice');
                var hisvalue = document.querySelectorAll('select[name^="currency_id"]')[j].value;

                if (hisvalue == 1) {
                    $(":input[type='number'][special=one_" + hisprice + "]").attr('disabled', false);
                    $(":input[type='number'][special=one_" + hisprice + "]").attr('disabled', false);

                    $(":input[type='number'][special=two_" + hisprice + "]").attr('value', 0).attr('disabled', true);
                    $(":input[type='number'][special=three_" + hisprice + "]").attr('value', 0).attr('disabled', true);
                    $(":radio[special=two_" + hisprice + "]").attr('disabled', true);
                    $(":radio[special=three_" + hisprice + "]").attr('disabled', true);
                } else if (hisvalue == 2) {
                    $(":input[type='number'][special=three_" + hisprice + "]").attr('disabled', false);
                    $(":radio[special=three_" + hisprice + "]").attr('disabled', false);

                    $(":input[type='number'][special=one_" + hisprice + "]").attr('value', 0).attr('disabled', true);
                    $(":input[type='number'][special=two_" + hisprice + "]").attr('value', 0).attr('disabled', true);
                    $(":radio[special=two_" + hisprice + "]").attr('disabled', true);
                    $(":radio[special=one_" + hisprice + "]").attr('disabled', true);
                }
            }
        });

    </script>
    
    <script>
        $('input[name^="change_type"]').on("change", function () {

            console.log('test');
            var enable_elem = $(this).attr('special');
            var arr = enable_elem.split("_");
            var disbale_elem_contain = arr[1];

            $(":input[type='number'][special$=" + disbale_elem_contain + "]").attr('disabled', true);
            $(":input[type='number'][special$=" + disbale_elem_contain + "]").val(0);
            $(":input[type='number'][special=" + enable_elem + "]").attr('disabled', false);
        });
        $(document).ready(function () {

            for (var j = 0; j < document.querySelectorAll('input[name^="change_type"]').length; j++) {
                if (document.querySelectorAll('input[name^="change_type"]')[j].getAttribute('disabled') == "") {
                } else {

                    var enable_elem = document.querySelectorAll('input[name^="change_type"]')[j].getAttribute('special');
                    var arr = enable_elem.split("_");
                    var disbale_elem_contain = arr[1];


                    var first_arry = $(":input[type='number'][special$=" + disbale_elem_contain + "]");
                    if ($(":input[type='number'][special=" + enable_elem + "]")[0].getAttribute('value') == 0) {
                    } else {
                        for (var i = 0; i < first_arry.length; i++) {


                            if (first_arry[i].getAttribute('special') == enable_elem) {
                            } else {
                                first_arry[i].setAttribute('disabled', true);
                                first_arry[i].setAttribute('value', 0);
                            }

                        }
                        for (var z = 0; z < $(":input[type='number'][special=" + enable_elem + "]").length; z++) {
                            $(":input[type='number'][special=" + enable_elem + "]")[z].removeAttribute('disabled');
                            document.querySelectorAll('input[name^="change_type"]')[j].setAttribute('checked', 'checked')
                        }
                    }
                }
            }
        });
    </script>
    
        <script>
                 
        $(document).ready(function () {
            $('form').submit(function () {
                $("[disabled]").attr('disabled', false)
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
@endsection