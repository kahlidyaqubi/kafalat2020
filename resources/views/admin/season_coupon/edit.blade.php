@extends('layouts.dashboard.app')

@section('pageTitle','تعديل مساعدة موسمية')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة المساعدات الموسمية')
@section('navigation3','تعديل مساعدة موسمية')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/season_coupons')
@section('navigation3_link','/admin/season_coupons/'.$season_coupon->id.'/edit')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل مساعدة
                        موسمية {{$family_id? \App\Family::find($family_id)->person->full_name :  \App\Institution::find($institution_id)->name}}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form method="post" action="/admin/season_coupons/{{$season_coupon->id}}"
                      enctype="multipart/form-data"
                >
                    @csrf
                    @method('put')

                    <input type="hidden" name="family_id" value="{{$family_id}}">
                    <input type="hidden" name="institution_id" value="{{$institution_id}}">
                    <!-- Start Row -->
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">المشروع
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select required class="form-control kt-select2 select2-multi" id="governorate_id"
                                            name="project_id" onchange="get_seasons()">
                                        <option value="" selected> المشروع</option>
                                        @foreach($projects->sortBy('name') as $project)
                                            <option value="{{$project->id}}"
                                                    @if(old('project_id'))
                                                    {{ $project->id == old('project_id') ? 'selected':'' }}
                                                    @else
                                                    @if(($season_coupon->season)&&$project->id==$season_coupon->season->project_id) selected @endif
                                                    @endif
                                            >{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الموسم<span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select required class="form-control kt-select2 select2-multi"
                                            name="season_id">
                                        <option value="" selected> الموسم</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رأي الإدارة<span
                                            style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select required class="form-control kt-select2 select2-multi"
                                            name="admin_status_id">
                                        <option value="" selected> رأي الإدارة</option>
                                        @foreach($admin_statuses as $admin_status)
                                            <option value="{{$admin_status->id}}"
                                                    @if(old('admin_status_id'))
                                                    {{ $admin_status->id == old('admin_status_id') ? 'selected':'' }}
                                                    @else
                                                    @if($admin_status->id == $season_coupon->admin_status_id) selected @endif
                                                    @endif>{{$admin_status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ تقديم
                                    الطلب<span style="color:red;">*</span></label>
                                <input required class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text"
                                       name="application_date"
                                       value="{{old('application_date')??$season_coupon->application_date}}"
                                       style="width: 93%">
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ تنفيذ
                                    الفعالية<span style="color:red;">*</span></label>
                                <input required class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text"
                                       name="execution_date"
                                       value="{{old('execution_date')??$season_coupon->execution_date}}"
                                       style="width: 93%">
                            </div>
                        </div>
                        <!-- End col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">سبب المساعدة<span
                                            style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select required class="form-control kt-select2 select2-multi"
                                            name="coupon_reason_id">
                                        <option value="" selected> سبب المساعدة</option>
                                        @foreach($coupon_reasons as $coupon_reason)
                                            <option value="{{$coupon_reason->id}}"
                                                    @if(old('coupon_reason_id'))
                                                    {{ $coupon_reason->id == old('coupon_reason_id') ? 'selected':'' }}
                                                    @else
                                                    @if($coupon_reason->id == $season_coupon->coupon_reason_id) selected @endif
                                                    @endif>{{$coupon_reason->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">حالة التسليم</label>
                                <div style="width: 95%;">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio" name="delivery_status" id="noCheck"
                                                   onclick="javascript:yesnoCheck();"
                                                   @if(!($season_coupon->delivery_status)||($season_coupon->delivery_status == 0))checked
                                                   @endif
                                                   value="0"> لا
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio" name="delivery_status" id="yesCheck"
                                                   onclick="javascript:yesnoCheck();"
                                                   @if($season_coupon->delivery_status == 1)checked @endif
                                                   value="1"> نعم
                                            <span></span>
                                        </label>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        
                        <div class="row" id="input"
                             @if($season_coupon->delivery_status !== 1) style="display: none;" @endif>
                            <div class="form-group col-md-6">
                                <label class="col-form-label col-lg-12">تاريخ التسليم</label>
                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text"
                                       name="delivery_date"
                                       value="{{old('delivery_date')??$season_coupon->delivery_date}}"
                                       >
                            </div>
                            <div class="form-group col-md-6">
                                <label class="col-form-label col-lg-12">مكان التسليم</label>
                                <div style="width: 85%;">
                                    <input type="text" class="form-control" name="delivery_place"
                                           value="{{old('delivery_place')??$season_coupon->delivery_place}}"
                                           placeholder="مكان التسليم">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">نوع المساعدة<span
                                            style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select required class="form-control kt-select2 select2-multi"
                                            id="coupon_type" name="coupon_type" onchange="change_type()">
                                        <option value="" selected>نوع المساعدة</option>

                                        <option value="1" oka="{{$season_coupon->coupon_type}}"
                                                @if(old('coupon_type'))
                                                {{ 1 == old('coupon_type') ? 'selected':'' }}
                                                @else
                                                @if($season_coupon->coupon_type == 1)selected @endif
                                                @endif> نقدية
                                        </option>
                                        <option value="2" oka="{{$season_coupon->coupon_type}}"
                                                @if(old('coupon_type'))
                                                {{ 2 == old('coupon_type') ? 'selected':'' }}
                                                @else
                                                @if($season_coupon->coupon_type == 2)selected @endif
                                                @endif> عينية
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Start col -->
                        <div class="row type1" @if($season_coupon->coupon_type && $season_coupon->coupon_type) @else style="display: none" @endif>
                            <div class="col-lg-4 ">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">قيمة المساعدة<span
                                                style="color:red;">*</span></label>
                                    <div style="width: 85%;">
                                        <input type="number" step="0.00001" class="form-control" name="amount"
                                               value="{{old('amount')??$season_coupon->amount}}"
                                               placeholder="قيمة المساعدة">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 ">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">نوع العملة<span style="color:red;">*</span></label>
                                    <div style="width: 95%;">
                                        <select class="form-control kt-select2 select2-multi"
                                                name="amount_curacy_id">
                                            <option value=" " selected> نوع العملة</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}"
                                                        @if(old('amount_curacy_id'))
                                                        {{ $currency->id == old('amount_curacy_id') ? 'selected':'' }}
                                                        @else
                                                        @if($currency->id==$season_coupon->amount_curacy_id) selected @endif
                                                        @endif>{{$currency->name}}</option>
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

                        <?php  $i = 1?>
                        @if($season_coupon->coupon_item_types->first())
                            @foreach($season_coupon->coupon_item_types as $coupon_item_type)
                                <div class="row type2">
                                    <!-- Start col -->
                                    <div class="col-lg-2">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-12">اختر التصنيف<span
                                                        style="color:red;">*</span></label>
                                            <div style="width: 95%;">
                                                <select class="form-control"
                                                        id="item_categories[{{$i}}]" name="item_categories[{{$i}}]"
                                                        onchange="get_item_types(this)">
                                                    <option value=" " selected>تصنيف الوحدة</option>
                                                    @foreach($item_categories as $item_category)
                                                        <option value="{{ $item_category->id }}"
                                                                @if(old('amount_curacy_id'))
                                                                {{ $item_category->id == old('item_categories')[$i] ? 'selected':'' }}
                                                                @else
                                                                @if($coupon_item_type->item_type->item_category->id == $item_category->id )
                                                                selected
                                                                @endif
                                                                @endif
                                                        >{{ $item_category->name }}</option>
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
                                                <select class="form-control" id="item_types_ids"
                                                        name="item_types_ids[{{$i}}]">
                                                    <option value="{{$coupon_item_type->item_type->id}}"
                                                            selected>{{$coupon_item_type->item_type->name}}</option>
                                                    <option value="-1" class="other">أخرى</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End col -->
                                    <div class="col-lg-2" id="otherItemTypeDiv">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-12">وحدات أخرى<span
                                                        style="color:red;">*</span></label>
                                            <div style="width: 95%;">
                                                <input type="text" class="form-control"
                                                       name="item_types_ids_other[{{$i}}]"
                                                       value="{{old('item_types_ids_other')[$i]}}"
                                                       placeholder="وحدات أخرى">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Start col -->
                                    <div class=" col-lg-2 col-md-2">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-12">سعر الوحدة<span
                                                        style="color:red;">*</span></label>
                                            <div style="width: 86%;">
                                                <input type="number" class="form-control one_amount"
                                                       name="item_types_values[{{$i}}]"
                                                       value="{{$coupon_item_type->value}}"
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
                                                <input type="text" class="form-control the_amount"
                                                       name="item_types_numbers[{{$i}}]"
                                                       value="{{$coupon_item_type->number}}"
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
                            @endforeach

                        @else
                            <div class="row type2" @if($season_coupon->coupon_type && $season_coupon->coupon_type == 2) @else style="display: none" @endif>
                                <!-- Start col -->
                                <div class="col-lg-2">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">اختر التصنيف<span
                                                    style="color:red;">*</span></label>
                                        <div style="width: 95%;">
                                            <select class="form-control"
                                                    id="item_categories[{{$i}}]" name="item_categories[{{$i}}]"
                                                    onchange="get_item_types(this)">
                                                <option value=" " selected>تصنيف الوحدة</option>
                                                @foreach($item_categories as $item_category)
                                                    <option value="{{ $item_category->id }}"
                                                    @if(old('item_categories'))
                                                        {{ $item_category->id == old('item_categories')[$i] ? 'selected':'' }}
                                                            @endif
                                                    >{{ $item_category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class=" col-lg-2">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">الوحدة<span style="color:red;">*</span></label>
                                        <div style="width: 90%;">
                                            <select class="form-control" id="item_types_ids"
                                                    name="item_types_ids[{{$i}}]">
                                                <option value="-1" class="other">أخرى</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <div class="col-lg-2" id="otherItemTypeDiv">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">وحدات أخرى<span
                                                    style="color:red;">*</span></label>
                                        <div style="width: 95%;">
                                            <input type="text" class="form-control" name="item_types_ids_other[{{$i}}]"
                                                   placeholder="وحدات أخرى">
                                        </div>
                                    </div>
                                </div>
                                <!-- Start col -->
                                <div class=" col-lg-2 col-md-2">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">سعر الوحدة<span
                                                    style="color:red;">*</span></label>
                                        <div style="width: 86%;">
                                            <input type="number" class="form-control one_amount"
                                                   name="item_types_values[{{$i}}]"
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
                                            <input type="text" class="form-control the_amount"
                                                   name="item_types_numbers[{{$i}}]"
                                                   placeholder="المقدار" onkeyup="sum_amount()">
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->

                            @if($i == 1)
                                <!-- Start col -->
                                    <div class="col-md-2">
                                        <label class="col-form-label col-lg-12"
                                               style="opacity: 0;">اضافة</label>
                                        <input type="button" class="btn btn-success btn-elevate "
                                               value="اضافة" onclick="addRow()">
                                    </div>
                                    <!-- End col -->
                                @else
                                    <div class=" col-lg-1">
                                        <label class="col-form-label col-lg-12" style="opacity: 0;">حذف</label>
                                        <input type="button" class="btn btn-danger btn-elevate " value="-"
                                               onclick="removeRow(this)"/>
                                    </div>
                                @endif
                                <?php $i++ ?>
                            </div>
                        <?php $i++ ?>
                    @endif
                    <!-- End Row -->
                        <div id="content" class="type2">

                        </div>
                        <div class="row type2" @if($season_coupon->coupon_type && $season_coupon->coupon_type == 2) @else style="display: none" @endif>
                            <div class="col-lg-4 ">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">القيمة الاجمالية</label>
                                    <div style="width: 85%;">
                                        <input type="number" readonly step="0.00001" class="form-control the_type2"
                                               id="the_type2" name="amount"
                                               value="{{old('amount')??$season_coupon->amount}}"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 ">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">نوع العملة<span style="color:red;">*</span></label>
                                    <div style="width: 95%;">
                                        <select class="form-control kt-select2 select2-multi the_type2"
                                                name="amount_curacy_id">
                                            <option value=" " selected> نوع العملة</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}"
                                                        @if(old('amount_curacy_id'))
                                                        {{ $currency->id == old('amount_curacy_id') ? 'selected':'' }}
                                                        @else
                                                        @if($currency->id==$season_coupon->amount_curacy_id) selected @endif
                                                @endif>{{$currency->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr style="width: 100%;">

                        <div class="row">
                            <!-- Start col -->
                            <div class=" col-lg-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">نوع المرفق</label>
                                    <div style="width: 90%;">
                                        <select class="form-control" id="file_type_id" name="file_type_id[]">
                                            <option value=" " selected>عنوان المرفق</option>
                                            @foreach(\App\FileType::all() as $file)
                                                <option value="{{ $file->id }}">{{ $file->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-3 col-md-3" id="otherFileTypeDiv">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">مرفقات أخرى</label>
                                    <div style="width: 95%;">
                                        <input type="text" class="form-control" name="file_type_id_other[]"
                                               placeholder="مرفقات أخرى">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class=" col-lg-4">
                                <div class="form-group">
                                    <label class="col-form-label col-lg-12">الملف</label>
                                    <div></div>
                                    <div xclass="custom-file">
                                        <input type="file" xclass="custom-file-input" name="files[]" id="customFile">
                                        <!--  <label class="custom-file-label" for="customFile">اختر الملف</label>  -->
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12" style="opacity: 0;">اضافة مرفق</label>
                                    <div style="width: 95%;">
                                        <button type="button" class="btn btn-success btn-elevate btn-block "
                                                onclick="addRow2()">اضافة مرفق
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->

                        </div>
                        <div id="content2">

                        </div>
                        <hr style="width: 100%;">
                <!-- Satrt Button Confirm -->
                    <div class="col-12">
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
                <!-- End Button Confirm -->

                    </div>
                    <br/>
                    <div class="row">

                    @if($season_coupon->season_coupon_media->first())
                        @foreach($season_coupon->season_coupon_media as $media)
                            <!-- Start col -->
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <?php
                                    $extintion = pathinfo($media->path, PATHINFO_EXTENSION);
                                    ?>

                                    <div class="box-img"
                                         id="getimage[{{$media->id}}]"
                                         style="background:
                                         @if ($extintion == 'docx' ||$extintion == 'doc')
                                                 url(https://3.bp.blogspot.com/-6iWESimcpPo/WK2gZAYpV5I/AAAAAAAAD70/wj__pSD5IFwWxgyZbyS5hIkGeMNlXg1fgCLcB/s200/Microsoft%2BWord.png)
                                         @elseif ($extintion == 'zip' ||$extintion =='rar')
                                                 url(https://static.vecteezy.com/system/resources/thumbnails/000/364/266/small/File_Formats__28432_29.jpg)
                                         @elseif ($extintion == 'xlsx' ||$extintion =='xlsm'||$extintion =='xltx')
                                                 url(https://static.thenounproject.com/png/150055-200.png)
                                         @elseif ($extintion == 'pdf')
                                                 url(https://img.icons8.com/plasticine/2x/pdf-2.png)
                                         @elseif ($extintion == 'txt')
                                                 url(https://static.vecteezy.com/system/resources/thumbnails/000/362/046/small/File_Formats__28526_29.jpg)
                                         @elseif ($extintion == 'JFIF'||$extintion =='JPEG'||$extintion =='GIF'||$extintion =='BMP'||$extintion =='PNG'||$extintion =='SVG'||$extintion =='JPG'||
                                                  $extintion == 'jfif'||$extintion =='jpeg'||$extintion =='gif'||$extintion =='bmp'||$extintion =='png'||$extintion =='svg'||$extintion =='jpg')
                                                 url({{ asset(str_replace("\\","/",$media->path)) }})
                                         @else
                                                 url(https://www.4me.com/wp-content/uploads/2018/01/4me-icon-attachment.png)

                                         @endif

                                                 no-repeat center center;     background-size: contain;"
                                         geturl="{{ asset(str_replace("\\","/",$media->path)) }}">
                                        <div class="fixed-top-rec">{{$media->fileType->name ?? '-'}}</div>
                                        <div class="overlay-box">
                                            <div class="option-icons">
                                                <a href="{{ asset($media->path) }}"
                                                   @if($extintion == 'JFIF'||$extintion =='JPEG'||$extintion =='GIF'||$extintion =='BMP'||$extintion =='PNG'||$extintion =='SVG'||$extintion =='JPG'||
                                                  $extintion == 'jfif'||$extintion =='jpeg'||$extintion =='gif'||$extintion =='bmp'||$extintion =='png'||$extintion =='svg'||$extintion =='jpg')

                                                   data-toggle="modal"
                                                   data-target="#view-img"
                                                   @endif
                                                   onclick="setimage({{$media->id}})">
                                                    <i class="fa fa-search"></i> </a>
                                                <a href="{{ url('admin/season_coupons/removeMedia/'.$media->id) }}"
                                                   class="Confirm"><i
                                                            class="fa fa-window-close"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                            @endforeach
                        @endif
                    </div>
                </form>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    @if($season_coupon->season_coupon_media->first())
        <div class="modal fade" id="view-img" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box-img"
                             id="setimage">
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-secondary"
                               href="#" id="seturl" target="_blank">تنزيل
                            </a>
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">اغلاق
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->
            <!-- Start Modal -->
            <div class="modal fade" id="delete" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-icon"><i
                                            class="flaticon-questions-circular-button"></i></div>
                                <div class="alert-text">هل انت متأكد من عملية الحذف؟</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">اغلاق
                            </button>
                            <button type="button" class="btn btn-success">نعم</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->

            <!--End::Dashboard 1-->
        </div>
    @endif
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
        $('#otherFileTypeDiv').hide();
        $("#file_type_id").change(function () {
            var id = $(this).children(":selected").attr("value");
            if ((id == 1) || (id == 6)) {
                $('#otherFileTypeDiv').show();
            } else {
                $('#otherFileTypeDiv').hide();

            }
        });
        var i = 1;

        function addRow2() {
            i++;
            document.querySelector('#content2').insertAdjacentHTML(
                'beforeend',
                '<div class="row" id="row' + i + '">\n' +
                '    <div class=" col-lg-3 col-md-3">\n' +
                '        <div class="form-group row">\n' +
                '            <label class="col-form-label col-lg-12">نوع المرفق</label>\n' +
                '            <div style="width: 90%;">\n' +
                '                <select class="form-control"  id="file_type_id_' + i + '"  name="file_type_id[]">\n' +
                '        <option value=" " selected>العنوان</option>' +
                '        @foreach(\App\FileType::all() as $file)' +
                '            <option value="{{ $file->id }}">{{ $file->name }}</option>' +
                '        @endforeach' +
                '                </select>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class="col-lg-3 col-md-3" id="otherFileTypeDiv_' + i + '">\n' +
                '        <div class="form-group row">\n' +
                '            <label class="col-form-label col-lg-12">مرفقات أخرى</label>\n' +
                '            <div style="width: 95%;">\n' +
                '                <input type="text" class="form-control" name="file_type_id_other[]" placeholder="مرفقات أخرى">\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class=" col-lg-3 col-md-3">\n' +
                '        <div class="form-group">\n' +
                '            <label class="col-form-label col-lg-12">الملف</label>\n' +
                '            <div></div>\n' +
                '            <div xclass="custom-file">\n' +
                '                <input type="file" name="files[]" xclass="custom-file-input" id="customFile">\n' +
                '               <!--  <label class="custom-file-label" for="customFile">اختر الملف</label>  -->\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class=" col-lg-3 col-md-3">\n' +
                '        <label class="col-form-label col-lg-12" style="opacity: 0;">حذف</label>\n' +
                '        <input type="button" class="btn btn-danger btn-elevate " value="-" onclick="removeRow2(this)"/>\n' +
                '    </div>\n' +
                '\n' +
                '</div>'
            );

            showSelect(i);

            function showSelect(i) {
                // show hide file type
                console.log('البواب السك');
                console.log('#otherFileTypeDiv_' + i);
                console.log($('#otherFileTypeDiv_' + i));
                $('#otherFileTypeDiv_' + i).hide();
                $("#file_type_id_" + i).change(function () {
                    var id = $(this).children(":selected").attr("value");
                    if ((id == 1) || (id == 6)) {
                        $('#otherFileTypeDiv_' + i).show();
                    } else {
                        $('#otherFileTypeDiv_' + i).hide();

                    }
                });
            }
        };

        function removeRow2(input) {
            document.getElementById('content2').removeChild(input.parentNode.parentNode);
        };
    </script>
    <script>
        $(document).ready(function () {

            var project_id = $("[name='project_id']").val();

            $.get("/admin/projects/season_ajax/" + project_id, function (data, status) {
                $("[name='season_id']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="seasons" value=" " >جميع المواسم</option>');

                data.forEach(function (season) {
                    var iselected = checktruefalse2(season.id);
                    $("[name='season_id']")
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
                $("[name='season_id']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="seasons" value=" ">جميع المواسم</option>');
                data.forEach(function (season) {
                    var iselected = checktruefalse2(season.id);
                    $("[name='season_id']")
                        .append($("<option class='seasons'></option>")
                            .attr("value", season.id)
                            .text(season.start_date.slice(0, -3)));
                    $('.seasons[value="' + season.id + '"]')
                        .attr('selected', iselected);

                });
            });

        }

        function checktruefalse2(id) {

            if (id == '{{$season_coupon->season_id}}') {
                return true;
                console.log('oka');
            } else
                return false;
            console.log('doka')
        }
    </script>

    <script>
        var i = parseInt('{{$season_coupon->item_types->count()}}');

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
        if ($("#coupon_type").val() == '1') {
            $('.type1').show();
            $('.type2').hide();
            $('.the_type2').prop("disabled", true);
        } else if ($("#coupon_type").val() == '2') {
            $('.type2').show();
            $('.type1').hide();
            $('.the_type2').prop("disabled", false);
        }

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
        function setimage(i) {
            console.log('test' + i);
            document.getElementById("setimage").style.cssText = document.getElementById("getimage[" + i + "]").style.cssText;
            //geturl //seturl
            document.getElementById("seturl").href = document.getElementById("getimage[" + i + "]").getAttribute('geturl');

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