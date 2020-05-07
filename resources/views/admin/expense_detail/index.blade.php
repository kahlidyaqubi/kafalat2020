@extends('layouts.dashboard.app')

@section('pageTitle','إدارة الكشوفات')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة الكشوفات')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expenseDetails')
@section('content')
    <style>
        .btn.btn-primary.col mr-3 {
            color: #eee;
        }

        a.btn-primary:hover {
            color: #FFF;
        }

    </style>
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">

                        إدارة @if(count($expense_in) ==1&&\App\Expense::where('id',$expense_in[0])->first()) كشوفات
                        الصرفية {{\App\Expense::find($expense_in[0])->old_name}}
                        @else  الكشوفات
                        @endif
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <form>
                    <input type='hidden' name=the_ids value="{{request('the_ids')}}">
                    <div class="row">

                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">المشروع</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="family_project_id" name="family_project_id">
                                        <option value=" " selected> اختر مشروعا</option>
                                        @foreach($family_projects as $family_project)
                                            <option value="{{$family_project->id}}"
                                                    @if($family_project->id==$family_project_id) selected @endif>{{$family_project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">نوع الكشف</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="thetype" name="thetype">
                                        <option value=" " selected> نوع الكشف</option>
                                        <option value="unv" @if(request()['thetype'] == "unv")selected @endif> كشف
                                            الجامعة
                                        </option>
                                        <option value="ytm" @if(request()['thetype'] == "ytm")selected @endif> كشف
                                            الأيتام
                                        </option>
                                        <option value="normal" @if(request()['thetype'] == "normal")selected @endif>كشف
                                            البنك
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->


                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">التسليم</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="delivery" name="delivery">
                                        <option value=" " selected> التسليم</option>
                                        <option value="1" @if($delivery == 1)selected @endif> تم التسليم</option>
                                        <option value="0" @if($delivery === '0')selected @endif>لم يتم التسليم</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">الخصم</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="is_discount" name="is_discount">
                                        <option value=" " selected> الخصم</option>
                                        <option value="1" @if($is_discount == 1)selected @endif> عليها خصم</option>
                                        <option value="0" @if($is_discount === '0')selected @endif>ليس عليها خصم
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group ">
                                <label class="col-form-label col-lg-12">تاريخ الاستلام من</label>
                                <div style="width: 99%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="from_recive_date" type="text"
                                           value="{{$from_recive_date}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">تاريخ الاستلام إلى</label>
                                <div style="width: 99%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="to_recive_date" type="text"
                                           value="{{$to_recive_date}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">من الرقم</label>
                                <div style="width: 99%;">
                                    <input class="form-control" type="number" name="from_id" value="{{$from_id}}"
                                           placeholder="اختر id" max="{{$max_id}}"
                                           min="{{$min_id}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">إلى الرقم</label>
                                <div style="width: 99%;">
                                    <input class="form-control" type="number" name="to_id" value="{{$to_id}}"
                                           placeholder="اختر id" max="{{$max_id}}"
                                           min="{{$min_id}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Starte col -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;" id="families_yes">
                                    <label class="col-form-label col-lg-12">تحديد المكفولين
                                    </label>

                                    <select id='selUser5' name="families_yes[]" style='width: 200px;'
                                            multiple>
                                        <option value='0'>- اختر مكفول -</option>
                                        @if($families_yes)
                                            @foreach($families_yes as $family_id)
                                                <?php $family = \App\Family::find($family_id)?>
                                                @if($family)
                                                    <option value="{{$family_id}}"
                                                            selected>{{$family->code}}{{$family->person?$family->person->full_name."-".$family->person->id_number:""}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Starte col -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;" id="families_no">
                                    <label class="col-form-label col-lg-12">استثناء مكفولين
                                    </label>
                                    <select id='selUser6' name="families_no[]" style='width: 200px;'
                                            multiple>
                                        <option value='0'>- اختر مكفول -</option>
                                        @if($families_no)
                                            @foreach($families_no as $family_id)
                                                <?php $family = \App\Family::find($family_id)?>
                                                @if($family)
                                                    <option value="{{$family_id}}"
                                                            selected>{{$family->code}}{{$family->person?$family->person->full_name."-".$family->person->id_number:""}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12 type3">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">تحديد الجهات</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="funded_institutions_ids_yes" name="funded_institutions_ids_yes[]"
                                            multiple>
                                        <option value=" " disabled> الجهة المرشحة</option>
                                        @foreach($funded_institutions as $funded_institution)
                                            <option value="{{$funded_institution->id}}"
                                                    @if(in_array($funded_institution->id, $funded_institutions_ids_yes)) selected @endif>{{$funded_institution->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12 type3">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">استثناء جهات</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="funded_institutions_ids_no" name="funded_institutions_ids_no[]"
                                            multiple>
                                        <option value=" " disabled> الجهة المرشحة</option>
                                        @foreach($funded_institutions as $funded_institution)
                                            <option value="{{$funded_institution->id}}"
                                                    @if(in_array($funded_institution->id, $funded_institutions_ids_no)) selected @endif>{{$funded_institution->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Start col -->
                        <div class="col-12">
                            <div class="form-group">
                                <div style="width: 100%;">
                                    <label class="col-form-label col-lg-12">تحديد الأعمدة المعروضة </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="coulmn" name="coulmn[]" multiple="multiple">
                                        <option value="id"
                                                @if(collect($coulmn)->contains('id'))selected @endif>#
                                        </option>
                                        <option value="select"
                                                @if(collect($coulmn)->contains('select'))selected @endif>تحديد
                                        </option>
                                        <option value="full_name"
                                                @if(collect($coulmn)->contains('full_name'))selected @endif>
                                            اسم المكفول
                                        </option>
                                        <option value="code"
                                                @if(collect($coulmn)->contains('code'))selected @endif>
                                            كود المكفول
                                        </option>
                                        <option value="expense"
                                                @if(collect($coulmn)->contains('expense'))selected @endif>
                                            الصرفية
                                        </option>
                                        <option value="amount"
                                                @if(collect($coulmn)->contains('amount'))selected @endif>
                                            شيكل
                                        </option>
                                        <option value="amount_befor"
                                                @if(collect($coulmn)->contains('amount_befor'))selected @endif>
                                            العملة الأصلية
                                        </option>
                                        <option value="discount"
                                                @if(collect($coulmn)->contains('discount'))selected @endif>
                                            الخصم
                                        </option>
                                        <option value="months"
                                                @if(collect($coulmn)->contains('months'))selected @endif>
                                            الأشهر
                                        </option>
                                         <option value="year"
                                                @if(collect($coulmn)->contains('year'))selected @endif>
                                            السنة
                                        </option>
                                        <option value="delivery"
                                                @if(collect($coulmn)->contains('delivery'))selected @endif>
                                            التسليم
                                        </option>
                                        <option value="SMS"
                                                @if(collect($coulmn)->contains('SMS'))selected @endif>
                                            ابلاغ
                                        </option>
                                        <option value="operations"
                                                @if(collect($coulmn)->contains('operations'))selected @endif>
                                            العمليات
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <div class="col-12">
                        </div>

                <!-- Satrt Button Confirm -->
                <div class="col-12">
                    <div class="form-group row">
                        <button type="submit"
                              class="btn btn-success btn-elevate btn-block ">بحث
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

                        <div class="col-md-6">
                            <div class="form-group row">
                                <button type="submit" formtarget="_blank"
                                        class="btn btn-outline-success col mr-3" name="theaction"
                                        value="print">طباعة
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <button type="submit" 
                                        class="btn btn-outline-success col mr-3" name="theaction"
                                        value="excel" formtarget="_blank">تصدير
                                </button>
                            </div>
                        </div>
                        <!-- End col -->

                    </div>
                </form>
                <div class="row">
                    <form action="/admin/expenseDetails/delivery" class="col-md-6 p-0">
                        <input type="hidden" name="the_ids" id="myIds2">
                        <input type="hidden" name="massege">
                        <button type="submit" style="width: 97%;" formtarget="_blank"
                                class="btn btn-outline-success col" name="theaction">طباعة كرت المحدد
                        </button>
                    </form>
                    <form action="/admin/expenseDetails/sendSMS" class="col-md-6 p-0">
                        <input type="hidden" name="the_ids" id="myIds1">
                        <a style="width: 97%;" class="btn btn-outline-success col text-success " name="theaction"
                           onclick="sms_all()">ابلاغ رسائل للمحدد
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Portlet-->
        <div class="row">
            <div class="col s12" id="the_error">

            </div>
        </div>
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-sign icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        عرض الكشوفات
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body ">
                <!-- Start Table  -->
                <div class="table-responsive">

                    <table class="table table-bordered table-hover ">
                        <thead>
                        <tr class="text-center">

                            @if(collect($coulmn)->contains('id'))
                                <th style="width: 5%">
                                    #
                                </th>@endif
                            @if(collect($coulmn)->contains('select'))
                                <th>
                                    <label class="kt-checkbox">
                                        <input type="checkbox" id="check_all" name="check_all" type="checkbox"
                                               value="1">الكل
                                        <span></span>
                                    </label>
                                </th>
                            @endif
                            @if(collect($coulmn)->contains('full_name'))
                                <th style="width: 20%;">اسم المكفول
                                </th>@endif
                            @if(collect($coulmn)->contains('code'))
                                <th style="width: 20%;">كود المكفول
                                </th>@endif
                            @if(collect($coulmn)->contains('expense'))
                                <th style="width: 15%">الصرفية
                                </th>@endif
                            @if(collect($coulmn)->contains('amount'))
                                <th style="width: 5%;">المبلغ
                                </th>@endif
                                @if(collect($coulmn)->contains('amount_befor'))
                                <th style="width: 7%;">بالعملة الأصلية
                                </th>@endif
                                
                            @if(collect($coulmn)->contains('discount'))
                                <th style="width: 5%;">الخصم
                                </th>@endif
                            @if(collect($coulmn)->contains('months'))
                                <th style="width: 15%;">الأشهر
                                </th>@endif
                                @if(collect($coulmn)->contains('year'))
                                <th style="width: 15%;">السنة
                                </th>@endif
                            @if(collect($coulmn)->contains('SMS'))
                                <th style="width: 15%;">SMS
                                </th>@endif
                            @if(collect($coulmn)->contains('delivery'))
                                <th style="width: 15%;">التسليم
                                </th>@endif
                            @if(collect($coulmn)->contains('operations'))
                                <th style="width: 5%;">العمليات
                                </th>@endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expense_details as $item)
                            <tr class="text-center">
                                @if(collect($coulmn)->contains('id'))
                                    <td>{{ $item->id }}</td>@endif
                                @if(collect($coulmn)->contains('select'))
                                    <td>
                                        <div class="">
															<span
                                                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
																<label>
																	<input type="checkbox" id="{{$item->id}}"
                                                                           name="ids[{{$item->id}}]" type="checkbox"
                                                                           value="1">
																	<span></span>
																</label>
															</span>
                                        </div>
                                    </td>@endif
                                @if(collect($coulmn)->contains('full_name'))
                                    <td>{{$item->family->person->full_name}}</td>@endif
                                @if(collect($coulmn)->contains('code'))
                                    <td>{{$item->family->code}}</td>@endif
                                @if(collect($coulmn)->contains('expense'))
                                    <td>{{$item->expense?$item->expense->old_name:""}}</td>@endif
                                @if(collect($coulmn)->contains('amount'))
                                    <td>{{$item->amount}}₪</td>@endif
                                    @if(collect($coulmn)->contains('amount_befor'))
                                    <td>{{$item->currency->icon}}  
                                        {{$item->amount_befor}}</td>@endif
                                    
                                @if(collect($coulmn)->contains('discount'))
                                    <td>{{$item->discount}} %</td>@endif
                                @if(collect($coulmn)->contains('months'))
                                    <td>{{implode(",",$item->months->pluck('name_ar')->toArray())}}</td>@endif
                                    @if(collect($coulmn)->contains('year'))
                                    <td>{{$item->expense->year}} </td>@endif
                                @if(collect($coulmn)->contains('SMS'))
                                    <td>
                                        <div class="">
                            <span
                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                <label>

                                    <input type="checkbox" id="sms_{{$item->id}}"
                                           @if(auth()->user()->hasPermissionTo(46))
                                           {{$item->delivery?"checked ":""}} value="{{$item->id}}"
                                           @else
                                           {{$item->delivery?"checked ":" "}}disabled
                                           title="لا تملك صلاحية إبلاغ مستلم"
                                           @endif
                                           value="{{$item->id}}"
                                           onclick="sms(this.id)">
                                    <span></span>
                                </label>
                            </span>
                                        </div>
                                    </td>@endif
                                @if(collect($coulmn)->contains('delivery'))
                                    <td>
                                        <div class="">
                            <span
                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                <label>
                                    <input class="cbActive2" type="checkbox"
                                           @if(auth()->user()->hasPermissionTo(52))
                                           {{$item->delivery?"checked":" "}} value="{{$item->id}}"
                                           @else
                                           {{$item->delivery?"checked":" "}}disabled
                                           title="لا تملك صلاحية تسليم مكفول"
                                           value="{{$item->id}}"
                                           @endif>
                                    <span></span>
                                </label>
                            </span>
                                        </div>
                                    </td>@endif
                                @if(collect($coulmn)->contains('operations'))
                                    <td>
                                        <div class="dropdown dropdown-inline">
                                            <button type="button"
                                                    class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="la la-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                   href="/admin/expenseDetails/sponsor/{{$item->id}}">
                                                    <i class="fa fa-shopping-bag"></i>
                                                    عرض الكفلاء</a>
                                            </div>
                                        </div>
                                    </td>@endif

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table  -->
                <!--begin: Pagination-->
            {{$expense_details->links()}}

            <!--end: Pagination-->
            </div>
        </div>
        <!--end::Portlet-->
    </div>
    <div class="modal fade" id="sms_model" tabindex="-1" role="dialog" aria-labelledby="sms_modelLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sms_modelLabel">إبلاغ مستلم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="sms_form">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">محتوى الرسالة:</label>
                            <textarea class="form-control" id="massage" maxlength="75"></textarea>
                            <span id="count_msg"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary cbActive">إرسال</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('select2')
    <script>


        $("#selUser5").select2({
            multiple: true,
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
        $("#selUser6").select2({
            multiple: true,
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

        var ids_array = [];
        var ids = "";
        $("#check_all").change(function () {

            for (var z = 0; z < $('input[name^="ids"]').length; z++) {
                if ($("#check_all")[0].checked) {
                    $('input[name^="ids"]')[z].setAttribute('checked', 'checked');
                } else {
                    $('input[name^="ids"]')[z].removeAttribute('checked')
                }
                ids_array = [];
                $("input:checkbox[name^='ids']:checked").each(function () {
                    ids_array.push($(this).attr("id"));
                });
            }

            ids = ids_array.join();
            document.getElementById("myIds1").value = ids;
            document.getElementById("myIds2").value = ids;
        });
        $('input[name^="ids"]').change(function () {
            ids_array = [];
            $("input:checkbox[name^='ids']:checked").each(function () {
                ids_array.push($(this).attr("id"));
            });
            ids = ids_array.join();
            document.getElementById("myIds1").value = ids;
            document.getElementById("myIds2").value = ids;
        });
    </script>

    <script>
        $(function () {
            $(".close").click(function () {
                var id = $(this).val();
                var isTrueSet = (this.old_status == 'true');
                $('#sms_' + id).prop("checked", isTrueSet);


            });
            $(".cbActive").click(function () {

                var id = $(this).val();
                if ($(this).val() == "all") {
                    $.ajax({
                        url: "/admin/expenseDetails/sendSMS",
                        data: {
                            _token: '{{ csrf_token() }}',
                            massage: $('#massage').val(),
                            the_type: 'json',
                            the_ids: ids,
                        },
                        success: function (resp) {
                            document.getElementById("the_error").innerHTML = '<div class="alert alert-success alert-dismissible">\n' + resp.message +
                                '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                '            <span aria-hidden="true">&times;</span>\n' +
                                '        </button>\n' +
                                '    </div>';
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            document.getElementById("the_error").innerHTML = '<div class="alert alert-danger alert-dismissible">\n' + jqXHR.responseJSON.message +
                                '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                '            <span aria-hidden="true">&times;</span>\n' +
                                '        </button>\n' +
                                '    </div>';
                        },
                    });
                    $("#sms_model").modal("hide");
                } else {
                    var mythis = $('#sms_' + id);
                    console.log("oka" + id);
                    $.ajax({
                        url: "/admin/expenseDetails/sendSMS",
                        data: {
                            _token: '{{ csrf_token() }}',
                            massage: $('#massage').val(),
                            the_type: 'json',
                            the_ids: id,
                        },
                        success: function (resp) {
                            document.getElementById("the_error").innerHTML = '<div class="alert alert-success alert-dismissible">\n' + resp.message +
                                '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                '            <span aria-hidden="true">&times;</span>\n' +
                                '        </button>\n' +
                                '    </div>';
                            mythis.disabled = true;
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            document.getElementById("the_error").innerHTML = '<div class="alert alert-danger alert-dismissible">\n' + jqXHR.responseJSON.message +
                                '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                '            <span aria-hidden="true">&times;</span>\n' +
                                '        </button>\n' +
                                '    </div>';
                            mythis.prop("checked", false);
                        },
                    });
                    $("#sms_model").modal("hide");
                }

            });

        });
    </script>
    <script>
        $(function () {
            $(".cbActive2").change(function () {

                var id = $(this).val();
                var mythis = this;
                mythis.disabled = true;
                $.ajax({
                    url: "/admin/expenseDetails/delivery",
                    data: {
                        _token: '{{ csrf_token() }}',
                        the_type: 'json',
                        the_ids: id,
                    },

                    success: function (resp) {

                        document.getElementById("the_error").innerHTML = '<div class="alert alert-success alert-dismissible">\n' + resp.message +
                            '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                            '            <span aria-hidden="true">&times;</span>\n' +
                            '        </button>\n' +
                            '    </div>';


                        mythis.disabled = false;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        document.getElementById("the_error").innerHTML = '<div class="alert alert-danger alert-dismissible">\n' + jqXHR.responseJSON.message +
                            '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                            '            <span aria-hidden="true">&times;</span>\n' +
                            '        </button>\n' +
                            '    </div>';
                        mythis.prop("checked", !(mythis.checked));
                        mythis.disabled = false;
                    },
                });
            });

        });
    </script>



    <script>
        function sms(id) {

            var old_status = !($('#' + id).is(':checked'));
            $("#sms_model").modal("show");
            $("#sms_model .cbActive").attr("id", id);
            $("#sms_model .close").attr("old_status", old_status);
            $("#sms_model .cbActive").val($('#' + id).val());
            $("#sms_model .close").val($('#' + id).val());
            return false;

        };
        $('#sms_model').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('New message to ' + recipient)
            modal.find('.modal-body input').val(recipient)
        })
    </script>
    <script>
        function sms_all() {

            $("#sms_model").modal("show");
            $("#sms_model .cbActive").attr("id", "all");
            $("#sms_model .cbActive").val("all");
            //$("#sms_model .close").val($('#' + id).val());
            return false;

        };
    </script>
    //      <script>
    //     $(document).ready(function () {
    //         $('form').submit(function () {
    //             $(this).find(':submit').attr('disabled', 'disabled');
    //             $('#wating').show();
    //         });
    //     });
    // </script>
@endsection