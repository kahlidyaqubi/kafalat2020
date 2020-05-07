@extends('layouts.dashboard.app')

@section('pageTitle','إضافة مساعدة طارئة')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة المساعدات الطارئة')
@section('navigation3','إضافة مساعدة طارئة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/urgent_coupons')
@section('navigation3_link','/admin/urgent_coupons/create?institution_id='.$institution_id.'&family_id='.$family_id)
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إضافة مساعدة
                        طارئة {{$family_id? \App\Family::find($family_id)->person->full_name :  \App\Institution::find($institution_id)->name}}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form method="post" action="/admin/urgent_coupons">
                    @csrf

                    <input type="hidden" name="family_id" value="{{$family_id}}">
                    <input type="hidden" name="institution_id" value="{{$institution_id}}">
                    <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                         <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">رأي الإدارة<span
                                            style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select required class="form-control kt-select2 select2-multi"
                                            name="admin_status_id">
                                        <option value="" selected> رأي الإدارة</option>
                                        @foreach($admin_statuses as $admin_status)
                                            <option value="{{$admin_status->id}}"
                                                    @if($admin_status->id == old('admin_status_id')) selected @endif>{{$admin_status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">سبب المساعدة<span
                                            style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select required class="form-control kt-select2 select2-multi"
                                            name="coupon_reason_id">
                                        <option value="" selected> سبب المساعدة</option>
                                        @foreach($coupon_reasons as $coupon_reason)
                                            <option value="{{$coupon_reason->id}}"
                                                    @if($coupon_reason->id == old('coupon_reason_id')) selected @endif>{{$coupon_reason->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">تاريخ
                                    الفعالية<span style="color:red;">*</span></label>
                                <input  required class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text"
                                       name="his_date" value="{{old('his_date')}}" style="width: 86%">
                            </div>
                        </div>
                        <!-- End col -->

                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">حالة التسليم<span
                                            style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio" name="delivery_status"
                                                   @if(!(old('delivery_status'))||(old('delivery_status') == 0))checked
                                                   @endif
                                                   value="0"> لا
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio" name="delivery_status"
                                                   @if(old('delivery_status') == 1)checked @endif
                                                   value="1"> نعم
                                            <span></span>
                                        </label>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">نوع المساعدة<span
                                            style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi"
                                            id="coupon_type" name="coupon_type" onchange="change_type()">
                                        <option selected>نوع المساعدة</option>
                                        <option value="1" @if(old('type') == 1)selected @endif> نقدية</option>
                                        <option value="2" @if(old('type') == 2)selected @endif> عينية</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Start col -->
                        <div class="row type1" @if(old('coupon_type') && old('coupon_type') == 1) @else style="display: none" @endif>
                            <div class="col-lg-4 ">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">قيمة المساعدة<span
                                                style="color:red;">*</span></label>
                                    <div style="width: 85%;">
                                        <input type="number" step="0.00001" class="form-control" name="amount"
                                               value="{{old('amount')}}"
                                               placeholder="قيمة المساعدة">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 ">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">نوع العملة<span style="color:red;">*</span></label>
                                    <div style="width: 95%;">
                                        <select   class="form-control kt-select2 select2-multi"
                                                name="amount_currency_id">
                                            <option value="" selected> نوع العملة</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}"
                                                        @if($currency->id==old("amount_currency_id")) selected @endif>{{$currency->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <hr style="width: 100%;">
                        <!-- Start Row -->
                        <div class="row type2" @if(old('coupon_type') && old('coupon_type') == 2) @else  style="display: none" @endif>
                            <!-- Start col -->
                            <div class="col-lg-2">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">اختر التصنيف<span
                                                style="color:red;">*</span></label>
                                    <div style="width: 95%;">
                                        <select class="form-control"
                                                id="item_categories[1]" name="item_categories[1]"
                                                onchange="get_item_types(this)">
                                            <option value=" " selected>تصنيف الوحدة</option>
                                            @foreach($item_categories as $item_category)
                                                <option value="{{ $item_category->id }}">{{ $item_category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class=" col-lg-2">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">الوحدة<span
                                                style="color:red;">*</span></label>
                                    <div style="width: 90%;">
                                        <select class="form-control" id="item_types_ids" name="item_types_ids[1]">
                                            <option value=" " selected>جميع الوحدات</option>
                                            <option value="-1" class="other">أخرى</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <div class="col-lg-2" id="otherItemTypeDiv">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">وحدات أخرى<span style="color:red;">*</span></label>
                                    <div style="width: 95%;">
                                        <input type="text"   class="form-control" name="item_types_ids_other[1]"
                                               placeholder="وحدات أخرى">
                                    </div>
                                </div>
                            </div>
                            <!-- Start col -->
                            <div class=" col-lg-2 col-md-2">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">سعر الوحدة<span style="color:red;">*</span></label>
                                    <div style="width: 86%;">
                                        <input type="number"   class="form-control one_amount" name="item_types_values[1]"
                                               placeholder="سعر الوحدة" onkeyup="sum_amount()">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-2 col-md-2">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12 ">المقدار<span
                                                style="color:red;">*</span></label>
                                    <div style="width: 86%;">
                                        <input type="text" class="form-control the_amount" name="item_types_numbers[1]"
                                               placeholder="المقدار" onkeyup="sum_amount()">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->

                            <!-- Start col -->
                            <div class="col-md-2">
                                <label class="col-form-label col-lg-12"
                                       style="opacity: 0;">اضافة</label>
                                <input type="button" class="btn btn-success btn-elevate "
                                       value="اضافة" onclick="addRow()">
                            </div>
                            <!-- End col -->
                        </div>
                        <!-- End Row -->
                        <div id="content" class="type2">

                        </div>
                        <div class="row type2" @if(old('coupon_type') && old('coupon_type') == 2) @else style="display: none" @endif>
                            <div class="col-lg-4 ">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">القيمة الاجمالية</label>
                                    <div style="width: 85%;">
                                        <input type="number" readonly step="0.00001" class="form-control the_type2"
                                               id="the_type2" name="amount"
                                               value="{{old('amount')}}"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 ">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">نوع العملة<span style="color:red;">*</span></label>
                                    <div style="width: 95%;">
                                        <select   class="form-control kt-select2 select2-multi the_type2"
                                                name="amount_currency_id">
                                            <option value="" selected> نوع العملة</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}"
                                                        @if($currency->id==old("amount_currency_id")) selected @endif>{{$currency->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Start Row -->
                        <div class="row">
                            <!-- Start col -->
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">نوع التمويل<span style="color:red;">*</span></label>
                                    <div style="width: 95%;">
                                        <div class="kt-radio-inline">
                                            <label class="kt-radio">
                                                <input type="radio"   name="funder_type" id="noCheck"
                                                       onclick="javascript:yesnoCheck();"
                                                       @if(!(old('funder_type')))checked
                                                       @endif
                                                       value="0"> غير ممولة
                                                <span></span>
                                            </label>
                                            <label class="kt-radio">
                                                <input type="radio" name="funder_type" id="yesCheck"
                                                       onclick="javascript:yesnoCheck();"
                                                       @if(old('funder_type') == 1)checked @endif
                                                       value="1"> ممولة
                                                <span></span>
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-12" id="input"
                                 @if(old('funder_type') == 1) @else style="display: none;" @endif>
                                <div class="form-group col">
                                    <label class="row">الدولة</label>
                                    <div style="width: 95%;">
                                        <select class="form-control kt-select2 select2-multi"
                                                name="country_id" id="country_id">
                                            <option value=" " selected> الدول</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}"
                                                        @if($country->id == old('country_id')) selected @endif>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <label class="row">اختيار الكافل</label>
                                    <div style="width: 95%;">
                                        <select id='selUser2' name="sponsor_id" style='width: 200px;'>
                                            <option value='  '>- اختر كافل -</option>
                                            @if(old('sponsor_id'))
                                                <?php $sponsor = \App\Sponsor::find(old('sponsor_id'))?>
                                                @if($sponsor)
                                                    <option value="{{$sponsor->id}}"
                                                            selected>{{$sponsor->name}}</option>
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <label class="row">قيمة التمويل</label>
                                    <div style="width: 85%;">
                                        <input type="number" step="0.00001" class="form-control" name="funder_value"
                                               value="{{old('funder_value')}}"
                                               placeholder="قيمة التمويل">
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <label class="row">نوع العملة</label>
                                    <div style="width: 95%;">
                                        <select class="form-control kt-select2 select2-multi"
                                                name="currency_id">
                                            <option value=" " selected> نوع العملة</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}"
                                                        @if($currency->id==old("currency_id")) selected @endif>{{$currency->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                        </div>
                        <!-- End Row -->
                        <hr style="width: 100%;">
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
                    </div>
                </form>
            </div>
            <!--end::Portlet-->
        </div>
    </div>

@endsection
@section('select2')

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
        var i = 2;

        function addRow() {
            i++;
            document.querySelector('#content').insertAdjacentHTML(
                'beforeend',
                ' <div class="row" id="row' + i + '">\n' +
                '                            <!-- Start col -->\n' +
                '                            <div class="col-lg-2">\n' +
                '                                <div class="form-group row">\n' +
                '                                    <label class="col-form-label col-lg-12">اختر التصنيف</label>\n' +
                '                                    <div style="width: 95%;">\n' +
                '                                        <select class="form-control"\n' +
                '                                                id="item_categories[' + i + ']" name="item_categories[' + i + ']"\n' +
                '                                                onchange="get_item_types(this)">\n' +
                '                                            <option value=" " selected>تصنيف الوحدة</option>\n' +
                '                                            @foreach($item_categories as $item_category)\n' +
                '                                                <option value="{{ $item_category->id }}">{{ $item_category->name }}</option>\n' +
                '                                            @endforeach\n' +
                '                                        </select>\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                            <!-- End col -->\n' +
                '                            <!-- Start col -->\n' +
                '                            <div class=" col-lg-2">\n' +
                '                                <div class="form-group row">\n' +
                '                                    <label class="col-form-label col-lg-12">الوحدة</label>\n' +
                '                                    <div style="width: 90%;">\n' +
                '                                        <select class="form-control" id="item_types_ids[' + i + ']" name="item_types_ids[' + i + ']">\n' +
                '                                            <option value=" " selected>جميع الوحدات</option>\n' +
                '                                            <option value="-1" class="other">أخرى</option>\n' +
                '\n' +
                '                                        </select>\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                            <!-- End col -->\n' +
                '                            <div class="col-lg-2" id="otherItemTypeDiv_' + i + '">\n' +
                '                                <div class="form-group row">\n' +
                '                                    <label class="col-form-label col-lg-12">وحدات أخرى</label>\n' +
                '                                    <div style="width: 95%;">\n' +
                '                                        <input type="text" class="form-control" name="item_types_ids_other[]"\n' +
                '                                               placeholder="وحدات أخرى">\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                            <!-- Start col -->\n' +
                '                            <div class=" col-lg-2 col-md-2">\n' +
                '                                <div class="form-group row">\n' +
                '                                    <label class="col-form-label col-lg-12">سعر الوحدة</label>\n' +
                '                                    <div style="width: 86%;">\n' +
                '                                        <input type="number" class="form-control one_amount"\n' +
                '                                               placeholder="سعر الوحدة" name="item_types_values[' + i + ']" onkeyup="sum_amount()">\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                            <!-- End col -->\n' +
                '                            <!-- Start col -->\n' +
                '                            <div class="col-lg-2 col-md-2">\n' +
                '                                <div class="form-group row">\n' +
                '                                    <label class="col-form-label col-lg-12 ">المقدار</label>\n' +
                '                                    <div style="width: 86%;">\n' +
                '                                        <input type="text" class="form-control the_amount"\n' +
                '                                               placeholder="المقدار" name="item_types_numbers[' + i + ']" onkeyup="sum_amount()">\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '    <div class=" col-lg-3 col-md-3">\n' +
                '        <label class="col-form-label col-lg-12" style="opacity: 0;">حذف</label>\n' +
                '        <input type="button" class="btn btn-danger btn-elevate " value="-" onclick="removeRow(this)"/>\n' +
                '    </div>\n' +
                '\n' +
                '</div>'
            );

            showSelect(i);

            function showSelect(i) {
                // show hide file type
                $('#otherItemTypeDiv_' + i).hide();
                $("#item_types_ids[" + i + "]").change(function () {
                    var id = $(this).children(":selected").attr("value");
                    if ((id == -1)) {
                        $('#otherItemTypeDiv_' + i).show();
                    } else {
                        $('#otherItemTypeDiv_' + i).hide();

                    }
                });
            }
        };

        function removeRow(input) {
            document.getElementById('content').removeChild(input.parentNode.parentNode);
            sum_amount();
        };
    </script>
    <script>
        function yesnoCheck() {
            if (document.getElementById('yesCheck').checked) {
                document.getElementById('input').style.display = 'flex';
            } else document.getElementById('input').style.display = 'none';

        }
    </script>
    <script>
        function get_item_types(mythis) {
            var item_category_id = mythis.value;
            var enable_elem = mythis.name;
            var the_id = enable_elem.split("[")[1].split("]")[0];
            $.get("/admin/item_categories/item_types_ajaxs/" + item_category_id, function (data, status) {
                $("[name='item_types_ids[" + the_id + "]']")
                    .find('option')
                    .not('.other')
                    .remove()
                    .end();
                data.forEach(function (item_type) {
                    var iselected = checktruefalse(item_type.id);
                    $("[name='item_types_ids[" + the_id + "]']")
                        .append($("<option class='item_types'></option>")
                            .attr("value", item_type.id)
                            .text(item_type.name));
                    $('.item_types[value="' + item_type.id + '"]')
                        .attr('selected', iselected);

                });
            });

        }

        function checktruefalse(id) {

            if (id == '{{old('item_type_id')}}') {
                return true
            } else
                return false
        }
    </script>
    <script>
        //type
        function change_type(e) {
            console.log($("#coupon_type").val());
            if ($("#coupon_type").val() == '1') {
                $('.type1').show();
                $('.type2').hide();
                $('.the_type2').prop("disabled", true);
            } else if ($("#coupon_type").val() == '2') {
                $('.type2').show();
                $('.type1').hide();
                $('.the_type2').prop("disabled", false);
            }
        }
    </script>
    <script>
        $('#otherItemTypeDiv').hide();
        $("#item_types_ids").change(function () {
            var id = $(this).children(":selected").attr("value");
            if ((id == -1)) {
                $('#otherItemTypeDiv').show();
            } else {
                $('#otherItemTypeDiv').hide();

            }
        });
    </script>
    <script>
        function sum_amount() {
            var amount = 0;
            for (i = 0; i < document.querySelectorAll('.one_amount').length; i++) {//
                amount += (document.querySelectorAll('.one_amount')[i].value * document.querySelectorAll('.the_amount')[i].value);
            }
            document.querySelector('#the_type2').value = amount;
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