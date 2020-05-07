@extends('layouts.dashboard.app')

@section('pageTitle','إدارة المساعدات الموسمية')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة المساعدات الموسمية')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/season_coupons')
@section('content')

<style>
    a:not([href]):not([tabindex]) {
    color: #0abb87;
    text-decoration: none;
}
    a:not([href]):not([tabindex]):hover {
    color: #fff;
}
</style>

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إدارة المساعدات الموسمية
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <form>
                    <div class="row">
                        <!-- Start col project-->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">المشروع</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="project_id" name="project_id"
                                            onchange="get_seasons()">
                                        <option value=" " selected> اختر مشروعا</option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}"
                                                    @if($project->id==$project_id) selected @endif>{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col project-->
                        
                        <!-- Start col seasons -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">المواسم</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="season_ids" name="season_ids[]">
                                        <option value=" " selected> اختر موسماً</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col seasons-->
                 
                        <!-- Start col type help-->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">نوع المساعدة</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="coupon_type" name="coupon_type">
                                        <option value=" " selected> نوع المساعدة</option>
                                        <option value="1" @if($coupon_type == 1)selected @endif> نقدية</option>
                                        <option value="2" @if($coupon_type=== '2')selected @endif>عينية
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col type help --> 

                        <!-- Start col opinion-->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">رأي الإدارة</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="admin_status_ids" name="admin_status_ids[]">
                                        <option value=" " selected> رأي الإدارة</option>
                                        @foreach($admin_statuses as $admin_status)
                                            <option value="{{$admin_status->id}}"
                                                    @if(in_array($admin_status->id, $admin_status_ids))selected @endif>{{$admin_status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col opinion-->
                        
                        <!-- Start col type -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">جمعيات أم أفراد</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="family_or_institution" name="family_or_institution">
                                        <option value=" " selected> جمعيات وأفراد</option>
                                        <option value="2" @if(old('family_or_institution')==2) selected @endif >
                                            جمعيات
                                        </option>
                                        <option value="1" @if(old('family_or_institution')==1) selected @endif> أفراد
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col person-->
                        
                        <!-- Start col delivery-->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">التسليم</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="delivery_status" name="delivery_status">
                                        <option value=" " selected> التسليم</option>
                                        <option value="1" @if($delivery_status == 1)selected @endif> تم التسليم</option>
                                        <option value="0" @if($delivery_status === '0')selected @endif>لم يتم التسليم
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col delivery-->
                        
                        <!-- Start col place-->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group ">
                                <label class="col-form-label col-lg-12">مكان التسليم</label>
                                <div style="width: 99%;">
                                    <input class="form-control" name="delivery_place" type="text"
                                           value="{{$delivery_place}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col place-->
                        
                        <!-- Start col date form delivery-->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group ">
                                <label class="col-form-label col-lg-12">تاريخ التسليم من</label>
                                <div style="width: 99%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="from_delivery_date" type="text"
                                           value="{{$from_delivery_date}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col date from delivery-->
                        <!-- Start col  date to delivery-->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group ">
                                <label class="col-form-label col-lg-12">تاريخ التسليم إلى</label>
                                <div style="width: 99%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="to_delivery_date" type="text"
                                           value="{{$to_delivery_date}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col date to delivery-->
                        <!-- Start col  date from order-->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group ">
                                <label class="col-form-label col-lg-12">تاريخ تقديم الطلب من</label>
                                <div style="width: 99%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="from_application_date"
                                           type="text"
                                           value="{{$from_application_date}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col  date from order-->
                        <!-- Start col date to order-->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group ">
                                <label class="col-form-label col-lg-12">تاريخ تقديم الطلب إلى</label>
                                <div style="width: 99%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="to_application_date"
                                           type="text"
                                           value="{{$to_application_date}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col  date to order-->
                        <!-- Start col date from done -->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group ">
                                <label class="col-form-label col-lg-12">تاريخ التنفيذ من</label>
                                <div style="width: 99%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="from_execution_date"
                                           type="text"
                                           value="{{$from_execution_date}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col date from done-->
                        <!-- Start col date to done -->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group ">
                                <label class="col-form-label col-lg-12">تاريخ التنفيذ إلى</label>
                                <div style="width: 99%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="to_execution_date" type="text"
                                           value="{{$to_execution_date}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col date to done-->
                        
                        <!-- Start  number from -->
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
                        <!-- End number from -->
                        <!-- Start number to -->
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
                        <!-- End number to -->
                        

                        <!-- Start col تحديد جمعيات -->
                        <div class="col-lg-6 col-md-6 col-sm-12 type3">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">تحديد جمعيات</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="funded_institutions_ids_yes" name="funded_institutions_ids_yes[]"
                                            multiple>
                                        <option value=" " disabled> الجمعية</option>
                                        @foreach($institutions as $institution)
                                            <option value="{{$institution->id}}"
                                                    @if(in_array($institution->id, $funded_institutions_ids_yes)) selected @endif>{{$institution->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Starte col تحديد المكفولين-->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;" id="families_yes">
                                    <label class="col-form-label col-lg-12">تحديد المكفولين
                                    </label>
                                    <select id='selUser5' name="families_yes[]" style='width: 200px;'
                                            multiple>
                                        <option value='  '>- اختر مكفول -</option>
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
                        
                        <!-- Start col استثناء جمعيات-->
                        <div class="col-lg-6 col-md-6 col-sm-12 type3">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">استثناء جمعيات</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="funded_institutions_ids_no" name="funded_institutions_ids_no[]"
                                            multiple>
                                        <option value=" " disabled> الجمعية</option>
                                        @foreach($institutions as $institution)
                                            <option value="{{$institution->id}}"
                                                    @if(in_array($institution->id, $funded_institutions_ids_no)) selected @endif>{{$institution->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Starte col استثناء مكفولين-->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;" id="families_no">
                                    <label class="col-form-label col-lg-12">استثناء مكفولين
                                    </label>

                                    <select id='selUser6' name="families_no[]" style='width: 200px;'
                                            multiple>
                                        <option value='  '>- اختر مكفول -</option>
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

                        <!-- Start col -->
                        <div class="col-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">تحديد الأعمدة المعروضة </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="coulmn" name="coulmn[]" multiple="multiple">
                                        <option value="id"
                                                @if(collect($coulmn)->contains('id'))selected @endif>#
                                        </option>
                                        <option value="select"
                                                @if(collect($coulmn)->contains('select'))selected @endif>تحديد
                                        </option>
                                        <option value="family_or_institution"
                                                @if(collect($coulmn)->contains('family_or_institution'))selected @endif>
                                            المستلم
                                        </option>
                                        <option value="coupon_type"
                                                @if(collect($coulmn)->contains('coupon_type'))selected @endif>
                                            نوع المستلم
                                        </option>
                                        <option value="execution_date"
                                                @if(collect($coulmn)->contains('execution_date'))selected @endif>
                                            تاريخ التنفيذ
                                        </option>
                                        <option value="delivery_date"
                                                @if(collect($coulmn)->contains('delivery_date'))selected @endif>
                                            تاريخ التسليم
                                        </option>
                                        <option value="application_date"
                                                @if(collect($coulmn)->contains('application_date'))selected @endif>
                                            تاريخ الطلب
                                        </option>
                                        <option value="count"
                                                @if(collect($coulmn)->contains('count'))selected @endif>
                                            المقدار
                                        </option>
                                        <option value="amount"
                                                @if(collect($coulmn)->contains('amount'))selected @endif>
                                            المبلغ
                                        </option>
                                        <option value="delivery_status"
                                                @if(collect($coulmn)->contains('delivery_status'))selected @endif>
                                            التسليم
                                        </option>
                                        <option value="admin_status"
                                                @if(collect($coulmn)->contains('admin_status'))selected @endif>
                                            رأي الإدارة
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
                        
                        <!-- Satrt Button Confirm -->
                        <div class="col-12 mt-3">
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
                        
                         <!-- Satrt Button PRINT -->
                        <div class="col-md-4">
                            <div class="form-group ">
                                <button type="submit"
                                        class="btn btn-outline-success  col mr-3" name="theaction"
                                        value="print">طباعة
                                </button>
                            </div>
                        </div>
                         
                         <!-- Satrt Button export -->
                        <div class="col-md-4">
                            <div class="form-group ">
                                <button type="submit"
                                        class="btn btn-outline-success  col mr-3" name="theaction"
                                        value="excel">تصدير
                                </button>
                            </div>
                        </div>
                        <!-- End col export-->
                        
                        <!-- Satrt Button SMS -->
                         <div class="col-md-4">
                            <div class="form-group ">
                                <input type="hidden" name="the_ids" id="myIds1">
                                <a type="submit" class="btn btn-outline-success  col mr-3" formaction="/admin/season_coupons/sendSMS" name="theaction" onclick="sms_all()">ابلاغ رسائل للمحدد SMS</a>
                            </div>
                        </div>
                        <!-- End col -->

                    </div>
                </form>
                <!--<div class="row">-->
                <!--    <form action="/admin/season_coupons/sendSMS">-->
                <!--        <input type="hidden" name="the_ids" id="myIds1">-->
                <!--        <div class="input-field col s12 m3">-->

                <!--            <a-->
                <!--                    class="btn btn-outline-success  col" name="theaction" onclick="sms_all()">ابلاغ رسائل للمحدد-->
                <!--            </a>-->
                <!--        </div>-->
                <!--    </form>-->
                <!--</div>-->
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
                        عرض المساعدات الموسمية
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
                            @if(collect($coulmn)->contains('family_or_institution'))
                                <th style="width: 20%;"> المستلم
                                </th>@endif
                            @if(collect($coulmn)->contains('coupon_type'))
                                <th style="width: 5%;">نوع المستلم
                                </th>@endif
                            @if(collect($coulmn)->contains('execution_date'))
                                <th style="width: 15%">تاريخ التنفيذ
                                </th>@endif
                            @if(collect($coulmn)->contains('delivery_date'))
                                <th style="width: 15%;">تاريخ التسليم
                                </th>@endif
                            @if(collect($coulmn)->contains('application_date'))
                                <th style="width: 15%;">تاريخ الطلب
                                </th>@endif

                            @if(collect($coulmn)->contains('count'))
                                <th style="width: 10%;">المقدار
                                </th>@endif
                            @if(collect($coulmn)->contains('amount'))
                                <th style="width: 5%;">المبلغ
                                </th>@endif
                            @if(collect($coulmn)->contains('delivery_status'))
                                <th style="width: 5%;">التسليم
                                </th>@endif
                            @if(collect($coulmn)->contains('admin_status'))
                                <th style="width: 5%;">رأي الإدارة
                                </th>@endif
                            @if(collect($coulmn)->contains('operations'))
                                <th style="width: 5%;">العمليات
                                </th>@endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($season_coupons as $item)
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
                                @if(collect($coulmn)->contains('family_or_institution'))
                                    <td>{{$item->family_id? $item->family->person->full_name : $item->institution->name}}</td>@endif
                                @if(collect($coulmn)->contains('coupon_type'))
                                    <td>{{$item->family_id? "للأفراد" : "للمؤسسات"}}</td>@endif
                                @if(collect($coulmn)->contains('execution_date'))
                                    <td>{{$item->execution_date?date('d-m-Y', strtotime($item->execution_date)):""}}</td>@endif
                                @if(collect($coulmn)->contains('delivery_date'))
                                    <td>{{$item->delivery_date?date('d-m-Y', strtotime($item->delivery_date)):""}}</td>@endif
                                @if(collect($coulmn)->contains('application_date'))
                                    <td>{{$item->execution_date?date('d-m-Y', strtotime($item->application_date)):""}}</td>@endif
                                <?php
                                $count = "";
                                $z = 0;
                                foreach ($item->coupon_item_types as $coupon_item_types) {
                                    if ($z > 0)
                                        $count = $count . " و";

                                    $count = $count . "" . $coupon_item_types->number . " " . $coupon_item_types->item_type->name . "-" . $coupon_item_types->item_type->item_category->name . "";
                                    $z++;
                                }
                                if ($item->amount_currency)
                                    $amount = $item->amount . "" . $item->amount_currency->icon;
                                else
                                    $amount = " ";
                                ?>
                                @if(collect($coulmn)->contains('count'))
                                    <td>{{$count}}</td>@endif
                                @if(collect($coulmn)->contains('amount'))
                                    <td>{{$amount}}</td>@endif
                                @if(collect($coulmn)->contains('delivery_status'))
                                    <td>
                                        <div class="">
                            <span
                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                <label>

                                    <input type="checkbox" id="delivery_status_{{$item->id}}"
                                           @if(auth()->user()->hasPermissionTo(46))
                                           {{$item->delivery_status?"checked ":""}} value="{{$item->id}}"
                                           @else
                                           {{$item->delivery_status?"checked ":" "}}disabled
                                           title="لا تملك صلاحية تسليم مساعدة"
                                           @endif
                                           value="{{$item->id}}"
                                           onclick="delivery_status(this.id)">
                                    <span></span>
                                </label>
                            </span>
                                        </div>
                                    </td>@endif
                                @if(collect($coulmn)->contains('admin_status'))
                                    <td>
                                        {{ $item->admin_status->name}}
                                        <div class="">
                            <span
                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                <label>

                                    <input type="checkbox" id="admin_status_{{$item->id}}"
                                           @if(auth()->user()->hasPermissionTo(46))
                                           {{$item->admin_status_id==1?"checked ":""}} value="{{$item->id}}"
                                           @else
                                           {{$item->admin_status_id!=1?"checked ":" "}}disabled
                                           title="لا تملك صلاحية موافقة على مساعدة"
                                           @endif
                                           value="{{$item->id}}"
                                           onclick="admin_status(this.id)">
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
                                                <a class="dropdown-item Confirm"
                                                   href="/admin/season_coupons/delete/{{$item->id}}">
                                                    <i class="fa fa-shopping-bag"></i>
                                                    حذف</a>
                                                <a class="dropdown-item"
                                                   href="/admin/season_coupons/{{$item->id}}/edit">
                                                    <i class="fa fa-shopping-bag"></i>
                                                    تعديل</a>
                                                @if(!($item->family_id))
                                                    <a class="dropdown-item"
                                                       href="#">
                                                        <i class="fa fa-shopping-bag"></i>
                                                        عرض المستفيدين</a>
                                                @endif
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
            {{$season_coupons->links()}}

            <!--end: Pagination-->
            </div>
        </div>
        <!--end::Portlet-->
    </div>
    <div class="modal fade" id="delivery_status_model" tabindex="-1" role="dialog"
         aria-labelledby="delivery_status_modelLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delivery_status_modelLabel">تسليم مساعدة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delivery_status_form">
                        <div class="col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">مكان التسليم</label>
                                <div style="width: 95%;">
                                    <input class="form-control" name="delivery_place" id="delivery_place" type="text"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary cbActive">تسليم</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="admin_status_model" tabindex="-1" role="dialog"
         aria-labelledby="admin_status_modelLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="admin_status_modelLabel">رأي الإدارة</h5>
                    <button type="button" class="close2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="admin_status_form">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">رأي الإدارة</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="admin_status_id" name="admin_status_id">
                                        <option value=" " selected> رأي الإدارة</option>
                                        @foreach($admin_statuses as $admin_status)
                                            <option value="{{$admin_status->id}}"
                                            >{{$admin_status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close2" data-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary cbActive2">موافقة</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sms_model" tabindex="-1" role="dialog" aria-labelledby="sms_modelLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sms_modelLabel">إبلاغ مستلم</h5>
                    <button type="button" class="close3" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="sms_form">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">محتوى الرسالة:</label>
                            <textarea class="form-control " id="massage" maxlength="75"></textarea>
                            <span id="count_msg"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close3" data-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary cbActive3">إرسال</button>
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
            $(".close3").click(function () {
                var id = $(this).val();
                var isTrueSet = (this.old_status == 'true');
                $('#sms_' + id).prop("checked", isTrueSet);


            });
            $(".cbActive3").click(function () {

                var id = $(this).val();
                if ($(this).val() == "all") {
                    $.ajax({
                        url: "/admin/season_coupons/sendSMS",
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
        function sms_all() {

            $("#sms_model").modal("show");
            $("#sms_model .cbActive3").attr("id", "all");
            $("#sms_model .cbActive3").val("all");
            //$("#sms_model .close").val($('#' + id).val());
            return false;

        };
    </script>


    <script>
        $(document).ready(function () {

            var project_id = $("[name='project_id']").val();

            $.get("/admin/projects/season_ajax/" + project_id, function (data, status) {
                $("[name='season_ids[]']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="seasons" value=" ">جميع المواسم</option>');

                data.forEach(function (season) {
                    var iselected = checktruefalse2(season.id);
                    $("[name='season_ids[]']")
                        .append($("<option class='seasons'></option>")
                            .attr("value", season.id)
                            .text(season.start_date.slice(0, -3)));

                    $('.seasons[value="' + season.id + '"]')
                        .attr('selected', iselected);

                });
            });
        });

        function get_seasons() {
            var project_id = $("[name='project_id']").val();

            $.get("/admin/projects/season_ajax/" + project_id, function (data, status) {
                $("[name='season_ids[]']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="seasons" value=" ">جميع المواسم</option>');

                data.forEach(function (season) {
                    var iselected = checktruefalse2(season.id);
                    $("[name='season_ids[]']")
                        .append($("<option class='seasons'></option>")
                            .attr("value", season.id)
                            .text(season.start_date.slice(0, -3)));
                    $('.seasons[value="' + season.id + '"]')
                        .attr('selected', iselected);

                });

            });

        }

        function checktruefalse2(id) {
           
            var z = @json($season_ids);
            if (inArray("" + id, z)) {
                return true
            } else
                return false
        }

        function inArray(needle, haystack) {
            var length = haystack.length;
            for (var i = 0; i < length; i++) {
                if (haystack[i] == needle) return true;
            }
            return false;
        }
    </script>

    <script>
        $(function () {
            $(".close").click(function () {
                var id = $(this).val();
                var isTrueSet = (this.old_status == 'true');
                $('#delivery_status_' + id).prop("checked", isTrueSet);


            });
            $(".cbActive").click(function () {

                var id = $(this).val();
                var mythis = $('#delivery_status_' + id);
                console.log("oka" + id);
                console.log("okaنن" + $('#delivery_place').val());
                $.ajax({
                    url: "/admin/season_coupons/delivery",
                    data: {
                        _token: '{{ csrf_token() }}',
                        delivery_date: $('#delivery_date').val(),
                        delivery_place: $('#delivery_place').val(),
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
                $("#delivery_status_model").modal("hide");


            });

        });
    </script>
    <script>
        function delivery_status(id) {

            var old_status = !($('#' + id).is(':checked'));

            $("#delivery_status_model .cbActive").attr("id", id);
            $("#delivery_status_model .close").attr("old_status", old_status);
            $("#delivery_status_model .cbActive").val($('#' + id).val());
            $("#delivery_status_model .close").val($('#' + id).val());
            if (($('#' + id).is(':checked'))) {
                $("#delivery_status_model").modal("show");
                return false;
            } else {

                $("#delivery_status_model .cbActive").click();
            }

        };
        $('#delivery_status_model').on('show.bs.modal', function (event) {
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
        $(function () {
            $(".close2").click(function () {
                var id = $(this).val();
                var isTrueSet = (this.old_status == 'true');
                $('#admin_status_' + id).prop("checked", isTrueSet);


            });
            $(".cbActive2").click(function () {

                var id = $(this).val();
                var mythis = $('#admin_status_' + id);
                console.log("oka" + id);
                $.ajax({
                    url: "/admin/season_coupons/approve",
                    data: {
                        _token: '{{ csrf_token() }}',
                        admin_status_id: $('#admin_status_id').val(),
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
                $("#admin_status_model").modal("hide");


            });

        });
    </script>
    <script>
        function admin_status(id) {

            var old_status = !($('#' + id).is(':checked'));

            $("#admin_status_model .cbActive2").attr("id", id);
            $("#admin_status_model .close2").attr("old_status", old_status);
            $("#admin_status_model .cbActive2").val($('#' + id).val());
            $("#admin_status_model .close2").val($('#' + id).val());
            if (($('#' + id).is(':checked'))) {
                $("#admin_status_model").modal("show");
                return false;
            } else {
                $("#admin_status_model #admin_status_id").val(3);
                $("#admin_status_model .cbActive2").click();
            }
        };
        $('#admin_status_model').on('show.bs.modal', function (event) {
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
        $(document).ready(function () {
            $('form').submit(function () {
                //$(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
@endsection