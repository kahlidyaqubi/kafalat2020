@extends('layouts.dashboard.app')
@section('pageTitle','إدارة الاستمارات والزيارات')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}">
    <link href="{{ asset('/new_theme/assets/plugins/custom/datatables/dataTables.checkboxes.css') }}">
    <style>
        [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
            opacity: 1;
        }

        #disease_type_div [type="checkbox"]:not(:checked), #disease_type_div [type="checkbox"]:checked {
            opacity: 0 !important;
        }

        .dataTables_filter label {
            display: none !important;
        }
    </style>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الاستمارات والزيارات')

@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/families')

@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">إدارة الاستمارات والزيارات</h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form id="zmain_form">
                    <!-- End Row -->
                    <!-- Start Tabs -->
                    <div class="kt-portlet kt-portlet--tabs">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-toolbar">
                                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right"
                                    role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            معلومات شخصية
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab2" role="tab">
                                            <i class="fa fa-sign" aria-hidden="true"></i>
                                            معلومات العمل
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab3" role="tab">
                                            <i class="fa fa-home" aria-hidden="true"></i>
                                            معلومات السكن
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab4" role="tab">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            الوكيل واليتيم
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab5" role="tab">
                                            <i class="fa fa-file-alt" aria-hidden="true"></i>
                                            معلومات عامة
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab6" role="tab">
                                            <i class="fa fa-users" aria-hidden="true"></i>
                                            افراد الاسرة
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab8" role="tab">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            طالب جامعي
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1" role="tabpanel">
                                    <!-- Start Row -->
                                    <div class="row">
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">الاسم بالعربي</label>
                                                <div style="width: 95%;">
                                                    <input type="text" class="form-control arabic" id="full_name"
                                                           name="full_name"
                                                           value="{{$full_name}}"
                                                           placeholder="الاسم">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">الاسم بالتركي</label>
                                                <div style="width: 95%;">
                                                    <input type="text" class="form-control turkey" name="full_name_tr"
                                                           id="full_name_tr"
                                                           value="{{$full_name_tr??""}}"
                                                           placeholder="الاسم بالتركي">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">اسم العائلة</label>
                                                <div style="width: 95%;">
                                                    <input type="text" class="form-control" name="family_name_tr"
                                                           id="family_name_tr" value="{{$family_name_tr??""}}"
                                                           placeholder="اسم العائلة">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">الجنس</label>
                                                    <select class="form-control " name="gender" id="gender">
                                                        <option value=" " selected>الجنس
                                                        </option>
                                                        <option value="M" @if($gender == 'M')selected @endif>ذكر
                                                        </option>
                                                        <option value="F" @if($gender == 'F')selected @endif>
                                                            انثى
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->

                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">رقم الوثيقة التعريفية</label>
                                                <div style="width: 95%;">
                                                    <input type="number" class="form-control" name="id_number"
                                                           id="id_number" value="{{$id_number??""}}"
                                                           placeholder="رقم الوثيقة التعريفية">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->

                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">كود الحالة</label>
                                                <div style="width: 95%;">
                                                    <input type="text" class="form-control" name="code"
                                                           id="code"
                                                           value="{{$code??""}}"
                                                           placeholder="كود الحالة">
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">الحالة الصحية</label>
                                                    <select class="form-control " id="health_status"
                                                            name="health_status">
                                                        <option value=" " selected> الحالة الصحية</option>
                                                        <option value="1" @if($health_status == 1)selected @endif>
                                                            مريض
                                                        </option>
                                                        <option value="0"
                                                                @if($health_status === '0')selected @endif>سليم
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->

                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">الحالة الوظيفية</label>
                                                    <select class="form-control" name="work" id="work">
                                                        <option value=" ">الحالة الوظيفية</option>
                                                        <option value="1" @if($work == 1)selected @endif> يعمل
                                                        </option>
                                                        <option value="0" @if($work === 0)selected @endif>لا يعمل
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->

                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">سنة الميلاد من</label>
                                                <div style="width: 95%;">
                                                    <input type="text" class="form-control datepicker-custome"
                                                           placeholder="yyyy-mm-dd" readonly="readonly"
                                                           id="from_date_of_birth"
                                                           value="{{$from_date_of_birth??""}}"
                                                           name="from_date_of_birth" type="text"
                                                           style="width: 95%;" autocomplete="off"
                                                           placeholder="-سنة الميلاد الى-">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">سنة الميلاد إلى</label>
                                                <div style="width: 95%;">
                                                    <input type="text" class="form-control datepicker-custome"
                                                           placeholder="yyyy-mm-dd" readonly="readonly"
                                                           id="to_date_of_birth"
                                                           value="{{$to_date_of_birth??""}}"
                                                           name="to_date_of_birth" type="text"
                                                           style="width: 95%;" autocomplete="off"
                                                           placeholder="-سنة الميلاد من-">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">تاريخ الصرفيات من</label>
                                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd"
                                                       readonly="readonly" type="text" autocomplete="off"
                                                       placeholder="-تاريخ الصرفيات من-"
                                                       name="from_recive_date" id="from_recive_date"
                                                       value="{{$from_recive_date??""}}"
                                                       style="width: 90%">
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">تاريخ الصرفيات الى</label>
                                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd"
                                                       readonly="readonly" type="text"
                                                       value="{{$to_recive_date??""}}"
                                                       name="to_recive_date" id="to_recive_date" style="width: 90%"
                                                       autocomplete="off" placeholder="-تاريخ الصرفيات الى-">
                                            </div>
                                        </div>
                                        <!-- End col -->

                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">الحالة الاجتماعية</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            id="social_status_ids" multiple
                                                            name="social_status_ids[]">
                                                        <option value=" " disabled>الحالة الاجتماعية</option>
                                                        @foreach(\App\SocialStatus::orderBy('name')->get() as $social_status)
                                                            <option value="{{ $social_status->id }}"
                                                                    @if(in_array($social_status->id, $social_status_ids)) selected @endif
                                                            >{{ $social_status->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">المؤهل العلمي</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="qualification_ids[]"
                                                            id="qualification_ids" multiple>
                                                        <option value=" " disabled>المؤهل العلمي</option>
                                                        @foreach(\App\Qualification::orderBy('name')->get() as $qualification)
                                                            <option value="{{ $qualification->id }}"
                                                                    @if(in_array($qualification->id, $qualification_ids)) selected @endif
                                                            >{{ $qualification->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">المستوى التعليمي لليتيم</label>
                                                <div style="width: 95%;">
                                                    <select class="form-control kt-select2 select2-multi"
                                                            id="qualification_level_ids"
                                                            name="qualification_level_ids[]" multiple>
                                                        <option value=" " disabled>المستوى التعليمي لليتيم
                                                        </option>
                                                        @foreach(\App\QualificationLevels::get()->sortBy('name') as $qualificationLevel)
                                                            <option value="{{ $qualificationLevel->id }}"
                                                                    @if(in_array($qualificationLevel->id, $qualification_level_ids)) selected @endif

                                                            >{{ $qualificationLevel->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">نوع المرض </label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            multiple id="family_diseases"
                                                            name="family_diseases[]">
                                                        <option value=" " disabled> الأمراض</option>
                                                        @foreach(\App\Disease::get()->sortBy('name') as $disease)
                                                            <option value="{{ $disease->id }}"
                                                                    @if(in_array($disease->id, $family_diseases)) selected @endif
                                                            >{{ $disease->name }}</option>
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
                                                    <label class="col-form-label col-lg-12">تحديد الأعمدة
                                                        المعروضة </label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            id="coulmn" name="coulmn[]" multiple="multiple">
                                                        <option value="#"
                                                                @if(collect($coulmn)->contains('#'))selected @endif>#
                                                        </option>
                                                        <option value="تحديد"
                                                                @if(collect($coulmn)->contains('تحديد'))selected @endif>
                                                            تحديد
                                                        </option>
                                                        <option value="الصورة"
                                                                @if(collect($coulmn)->contains('الصورة'))selected @endif>
                                                            الصورة
                                                        </option>
                                                        <option value="الاسم الكامل"
                                                                @if(collect($coulmn)->contains('الاسم الكامل'))selected @endif>
                                                            الاسم الكامل
                                                        </option>
                                                        <option value="الكود"
                                                                @if(collect($coulmn)->contains('الكود'))selected @endif>
                                                            الكود
                                                        </option>
                                                        <option value="الهوية"
                                                                @if(collect($coulmn)->contains('الهوية'))selected @endif>
                                                            الهوية
                                                        </option>
                                                        <option value="تصنيف الحالة"
                                                                @if(collect($coulmn)->contains('تصنيف الحالة'))selected @endif>
                                                            تصنيف الحالة
                                                        </option>
                                                        <option value="السكن"
                                                                @if(collect($coulmn)->contains('السكن'))selected @endif>
                                                            السكن
                                                        </option>
                                                        <option value="عدد الأفراد"
                                                                @if(collect($coulmn)->contains('عدد الأفراد'))selected @endif>
                                                            عدد الأفراد
                                                        </option>
                                                        <option value="الحالة الدراسية"
                                                                @if(collect($coulmn)->contains('الحالة الدراسية'))selected @endif>
                                                            الحالة الدراسية
                                                        </option>
                                                        <option value="الحالة الوظيفية"
                                                                @if(collect($coulmn)->contains('الحالة الوظيفية'))selected @endif>
                                                            الحالة الوظيفية
                                                        </option>
                                                        <option value="الحالة الاجتماعية"
                                                                @if(collect($coulmn)->contains('الحالة الاجتماعية'))selected @endif>
                                                            الحالة الاجتماعية
                                                        </option>
                                                        <option value="الوضع الصحي"
                                                                @if(collect($coulmn)->contains('الوضع الصحي'))selected @endif>
                                                            الوضع الصحي
                                                        </option>
                                                        <option value="الوكيل"
                                                                @if(collect($coulmn)->contains('الوكيل'))selected @endif>
                                                            الوكيل
                                                        </option>
                                                        <option value="العمليات"
                                                                @if(collect($coulmn)->contains('العمليات'))selected @endif>
                                                            العمليات
                                                        </option>
                                                        <option value="الاسم التركي"
                                                                @if(collect($coulmn)->contains('الاسم التركي'))selected @endif>
                                                            الاسم التركي
                                                        </option>
                                                        <option value="جهة الدخل"
                                                                @if(collect($coulmn)->contains('جهة الدخل'))selected @endif>
                                                            جهة الدخل
                                                        </option>
                                                        <option value="تقييم الحالة"
                                                                @if(collect($coulmn)->contains('تقييم الحالة'))selected @endif>
                                                            تقييم الحالة
                                                        </option>
                                                        <option value="قيمة الساعة الدراسية"
                                                                @if(collect($coulmn)->contains('قيمة الساعة الدراسية'))selected @endif>
                                                            قيمة الساعة الدراسية
                                                        </option>
                                                        <option value="اسم المؤسسة التعليمية"
                                                                @if(collect($coulmn)->contains('اسم المؤسسة التعليمية'))selected @endif>
                                                            اسم المؤسسة التعليمية
                                                        </option>
                                                        <option value="نوع الزيارة"
                                                                @if(collect($coulmn)->contains('نوع الزيارة'))selected @endif>
                                                            نوع الزيارة
                                                        </option>
                                                        <option value="وضع الحالة"
                                                                @if(collect($coulmn)->contains('وضع الحالة'))selected @endif>
                                                            وضع الحالة
                                                        </option>
                                                        <option value="عدد الزيارات"
                                                                @if(collect($coulmn)->contains('عدد الزيارات'))selected @endif>
                                                            عدد الزيارات
                                                        </option>
                                                        <option value="الزيارات الميدانية للباحث"
                                                                @if(collect($coulmn)->contains('الزيارات الميدانية للباحث'))selected @endif>
                                                            الزيارات الميدانية للباحث
                                                        </option>
                                                        <option value="الترجمة"
                                                                @if(collect($coulmn)->contains('الترجمة'))selected @endif>
                                                            الترجمة
                                                        </option>
                                                        <option value="الجهة المرشحة"
                                                                @if(collect($coulmn)->contains('الجهة المرشحة'))selected @endif>
                                                            الجهة المرشحة
                                                        </option>
                                                        <option value="المشروع"
                                                                @if(collect($coulmn)->contains('المشروع'))selected @endif>
                                                            المشروع
                                                        </option>
                                                        <option value="سنة الزيارة"
                                                                @if(collect($coulmn)->contains('سنة الزيارة'))selected @endif>
                                                            سنة الزيارة
                                                        </option>
                                                        <option value="شهر الزيارة"
                                                                @if(collect($coulmn)->contains('شهر الزيارة'))selected @endif>
                                                            شهر الزيارة
                                                        </option>
                                                        <option value="يوم الزيارة"
                                                                @if(collect($coulmn)->contains('يوم الزيارة'))selected @endif>
                                                            يوم الزيارة
                                                        </option>
                                                        <option value="تاريخ الزيارة"
                                                                @if(collect($coulmn)->contains('تاريخ الزيارة'))selected @endif>
                                                            تاريخ الزيارة
                                                        </option>
                                                        <option value="الارسال"
                                                                @if(collect($coulmn)->contains('الارسال'))selected @endif>
                                                            الارسال
                                                        </option>
                                                        <option value="اكتمال البيانات"
                                                                @if(collect($coulmn)->contains('اكتمال البيانات'))selected @endif>
                                                            اكتمال البيانات
                                                        </option>
                                                        <option value="التقييم"
                                                                @if(collect($coulmn)->contains('التقييم'))selected @endif>
                                                            التقييم
                                                        </option>
                                                        <option value="الأمراض"
                                                                @if(collect($coulmn)->contains('الأمراض'))selected @endif>
                                                            الأمراض
                                                        </option>
                                                        <option value="مبلغ الدخل"
                                                                @if(collect($coulmn)->contains('مبلغ الدخل'))selected @endif>
                                                            مبلغ الدخل
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                    </div>
                                    <!-- End Row -->
                                </div>
                                <div class="tab-pane" id="tab2" role="tabpanel">
                                    <!-- Start Row -->
                                    <div class="row">
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">الدخل من</label>
                                                <div style="width: 95%;">
                                                    <input type="number" class="form-control"
                                                           name="from_total_income_value"
                                                           id="from_total_income_value"
                                                           value="{{$from_total_income_value??""}}"
                                                           placeholder="الدخل من">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">الدخل الى</label>
                                                <div style="width: 95%;">
                                                    <input type="number" class="form-control"
                                                           name="to_total_income_value"
                                                           id="to_total_income_value"
                                                           value="{{$to_total_income_value??""}}"
                                                           placeholder="الدخل الى">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">نوع العمل</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="job_type_ids[]" multiple
                                                            id="job_type_ids">
                                                        <option value=" " disabled>نوع العمل</option>
                                                        @foreach(\App\JobType::orderBy('name')->get() as $job_type)
                                                            <option value="{{ $job_type->id }}"
                                                                    @if(in_array($job_type->id, $job_type_ids)) selected @endif
                                                            >{{ $job_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->

                                    </div>
                                    <!-- End Row -->
                                </div>
                                <div class="tab-pane" id="tab3" role="tabpanel">
                                    <!-- Start Row -->
                                    <div class="row">
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">المحافظة</label>
                                                    <select class="form-control " id="governorate_id"
                                                            name="governorate_id" onchange="get_cities()">
                                                        <option value=" " selected> المحافظة</option>
                                                        @foreach(\App\Governorate::all()->sortBy('name') as $governorate)
                                                            <option value="{{$governorate->id}}"
                                                                    @if($governorate->id==$governorate_id) selected @endif>{{$governorate->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">المدينة</label>
                                                    <select class="form-control " id="city_id" name="city_id"
                                                            onchange="get_neighborhoods()">
                                                        <option value=" " selected> المدينة</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">المنطقة</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            id="neighborhood_ids" name="neighborhood_ids[]"
                                                            multiple="multiple">
                                                        <option value=" " disabled>الحي</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->

                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">نوع السكن</label>
                                                    <select class="form-control  kt-select2 select2-multi"
                                                            multiple
                                                            id="house_roof_ids" name="house_roof_ids[]">
                                                        <option value=" " disabled> نوع السكن</option>
                                                        @foreach(\App\HouseRoof::get()->sortBy('name') as $houseRoof)
                                                            <option value="{{ $houseRoof->id }}"
                                                                    @if(in_array($houseRoof->id, $house_roof_ids)) selected @endif
                                                            >{{ $houseRoof->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">ملكية السكن</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="house_ownership_ids[]"
                                                            id="house_ownership_ids"
                                                            multiple>
                                                        <option value=" " disabled>ملكية السكن</option>
                                                        @foreach(\App\HouseOwnership::orderBy('name')->get() as $house_ownership)
                                                            <option value="{{ $house_ownership->id }}"
                                                                    @if(in_array($house_ownership->id, $house_ownership_ids)) selected @endif
                                                            >{{ $house_ownership->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12 ">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">قيمة الإيجار من</label>
                                                <div style="width: 95%;">
                                                    <input type="number" class="form-control" name="from_rent_value"
                                                           id="from_rent_value"
                                                           value="{{$from_rent_value??""}}"
                                                           placeholder="قيمة الإيجار من">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">قيمة الإيجار إلى</label>
                                                <div style="width: 95%;">
                                                    <input type="number" class="form-control" name="to_rent_value"
                                                           id="to_rent_value"
                                                           value="{{$to_rent_value??""}}"
                                                           placeholder=" قيمة الإيجارة إلى">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">وضع السكن</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="house_status_ids[]"
                                                            id="house_status_ids"
                                                            multiple>
                                                        <option value=" " disabled>وضع السكن</option>
                                                        @foreach(\App\HouseStatus::orderBy('name')->get() as $house_status)
                                                            <option value="{{ $house_status->id }}"
                                                                    @if(in_array($house_status->id, $house_status_ids)) selected @endif
                                                            >{{ $house_status->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">وضع الاثاث</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="furniture_status_ids[]"
                                                            id="furniture_status_ids" multiple>
                                                        <option value=" " disabled>وضع الأثاث</option>
                                                        @foreach(\App\FurnitureStatus::orderBy('name')->get() as $furniture_status)
                                                            <option value="{{ $furniture_status->id }}"
                                                                    @if(in_array($furniture_status->id, $furniture_status_ids)) selected @endif
                                                            >{{ $furniture_status->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">عدد الغرف من</label>
                                                <div style="width: 95%;">
                                                    <input type="number" class="form-control" name="from_room_number"
                                                           id="from_room_number"
                                                           placeholder="عدد الغرف من">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">عدد الغرف إلى</label>
                                                <div style="width: 95%;">
                                                    <input type="number" class="form-control" name="to_room_number"
                                                           id="to_room_number"
                                                           placeholder="عدد الغرف إلى">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->

                                    </div>
                                    <!-- End Row -->
                                </div>
                                <div class="tab-pane" id="tab4" role="tabpanel">
                                    <!-- Start Row -->
                                    <div class="row">
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row" style="width: 98%;">
                                                <label class="col-form-label col-lg-12">رقم هوية الوكيل</label>
                                                <div style="width: 98%;">
                                                    <input type="number" class="form-control"
                                                           name="representative_id_number"
                                                           id="representative_id_number"
                                                           value="{{$representative_id_number??""}}"
                                                           placeholder="رقم هوية الوكيل">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row" style="width: 98%;">
                                                <label class="col-form-label col-lg-12">اسم الوكيل</label>
                                                <div style="width: 98%;">
                                                    <input  class="form-control"
                                                           name="representative_full_name"
                                                           id="representative_full_name"
                                                           value="{{$representative_full_name??""}}"
                                                           placeholder="اسم الوكيل">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">نوع عمل الوكيل</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="representative_job_type_ids[]"
                                                            id="representative_job_type_ids" multiple>
                                                        <option value=" " disabled>نوع عمل الوكيل</option>
                                                        @foreach(\App\JobType::orderBy('name')->get() as $jobType)
                                                            <option value="{{ $jobType->id }}"
                                                                    @if(in_array($jobType->id, $representative_job_type_ids)) selected @endif
                                                            >{{ $jobType->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row" style="width: 98%;">
                                                <label class="col-form-label col-lg-12">سبب الوكالة</label>
                                                <div style="width: 98%;">
                                                    <input type="text" class="form-control" name="representative_reason"
                                                           id="representative_reason"
                                                           value="{{$representative_reason??""}}"
                                                           placeholder="سبب الوكالة">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">صلة قرابة الوكيل</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="representative_relationship_ids[]"
                                                            id="representative_relationship_ids"
                                                            multiple>
                                                        <option value=" " disabled>صلة القرابة</option>
                                                        @foreach(\App\Relationship::orderBy('name')->get() as $relationship)
                                                            <option value="{{ $relationship->id }}"
                                                                    @if(in_array($relationship->id, $representative_relationship_ids)) selected @endif
                                                            >{{ $relationship->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">تاريخ وفاة الام</label>
                                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd"
                                                       readonly="readonly" type="text"
                                                       style="width: 90%"
                                                       name="mother_death_date"
                                                       id="mother_death_date"
                                                       value="{{$mother_death_date}}"
                                                >
                                            </div>
                                        </div>
                                        <!-- End col -->

                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">تاريخ وفاة الاب</label>
                                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd"
                                                       readonly="readonly" type="text"
                                                       name="father_death_date"
                                                       id="father_death_date"
                                                       value="{{$father_death_date}}" style="width: 90%">
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">سبب وفاة الاب</label>
                                                    <div style="width: 95%;">
                                                        <input type="text" class="form-control"
                                                               name="father_death_reason"
                                                               id="father_death_reason"
                                                               value="{{$father_death_reason}}"
                                                               placeholder="سبب وفاة الاب">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">سبب وفاة الام</label>
                                                    <div style="width: 95%;">
                                                        <input type="text" class="form-control"
                                                               name="mother_death_reason"
                                                               id="mother_death_reason"
                                                               value="{{$mother_death_reason}}"
                                                               placeholder="سبب وفاة الام">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                    </div>
                                    <!-- End Row -->
                                </div>
                                <div class="tab-pane" id="tab5" role="tabpanel">
                                    <!-- Start Row -->
                                    <div class="row">
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">تصنيف الحالة</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="family_type_ids[]"
                                                            id="family_type_ids" multiple>
                                                        <option value=" " disabled>تصنيف الحالة</option>
                                                        @foreach(\App\FamilyType::orderBy('name')->get() as $family_type)
                                                            <option value="{{ $family_type->id }}"
                                                                    @if(in_array($family_type->id, $family_type_ids)) selected @endif>{{ $family_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row" style="width: 95%;">
                                                <label class="col-form-label col-lg-12">تصنيف المشروع</label>
                                                <select class="form-control kt-select2 select2-multi"
                                                        id="family_project_ids"
                                                        name="family_project_ids[]" multiple>
                                                    <option value=" " disabled>تصنيف المشروع</option>
                                                    @foreach(\App\FamilyProject::orderBy('name')->get() as $family_project)
                                                        <option value="{{ $family_project->id }}"
                                                                @if(in_array($family_project->id, $family_project_ids)) selected @endif
                                                        >{{ $family_project->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row" style="width: 95%;">
                                                <label class="col-form-label col-lg-12">الجهة المرشحة</label>
                                                <select class="form-control kt-select2 select2-multi"
                                                        id="funded_institution_ids"
                                                        name="funded_institution_ids[]" multiple>
                                                    <option value=" " disabled>الجهة المرشحة</option>
                                                    @foreach(\App\FundedInstitution::orderBy('name')->get() as $funded_institution)
                                                        <option value="{{ $funded_institution->id }}"
                                                                @if(in_array($funded_institution->id, $funded_institution_ids)) selected @endif
                                                        >{{ $funded_institution->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">حصول التقييم</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            id="is_evaluted" name="is_evaluted">
                                                        <option value=" " selected>حصول التقييم</option>
                                                        <option value="1" @if($is_evaluted == 1)selected @endif >تم
                                                            التقييم
                                                        </option>
                                                        <option value="2" @if($is_evaluted == 2)selected @endif >لم يتم
                                                            التقييم
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">تقييم الحالة</label>
                                                    <select class="form-control kt-select2 select2-multi" name="need"
                                                            id="need">
                                                        <option value=" " selected>تقييم الحالة
                                                        </option>
                                                        <option value="1" @if($need == 1)selected @endif >يحتاج
                                                        </option>
                                                        <option value="2" @if($need === '0')selected @endif>لا يحتاج
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">حالة الكفالة</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="family_classification_ids[]"
                                                            multiple
                                                            id="family_classification_ids">
                                                        <option value=" " disabled>حالة الكفالة</option>
                                                        @foreach(\App\FamilyClassification::orderBy('name')->get() as $item)
                                                            <option value="{{ $item->name }}"
                                                                    @if(in_array($item->id, $family_classification_ids)) selected @endif
                                                            >{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">الترجمة</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="translation" id="translation">
                                                        <option value=" " selected>الترجمة</option>
                                                        <option value="1" @if($translation == 1)selected @endif>مترجمة
                                                        </option>
                                                        <option value="2" @if($translation == 2)selected @endif>غير
                                                            مترجمة
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">الإرسال</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="is_sent"
                                                            id="is_sent">
                                                        <option value=" " selected>الإرسال</option>
                                                        <option value="1" @if($is_sent == 1)selected @endif>تم الإرسال
                                                        </option>
                                                        <option value="0" @if($is_sent === '0')selected @endif>ليست قيد
                                                            الإرسال
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">اكتمال البيانات</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="complete" id="complete">
                                                        <option value=" " selected>اكتمال البيانات</option>
                                                        <option value="1" @if($complete == 1)selected @endif>مكتملة
                                                        </option>
                                                        <option value="2" @if($complete == 2)selected @endif>منقوصة
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">وضع الحالة</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            id="family_status_ids"
                                                            name="family_status_ids[]"
                                                            multiple>
                                                        <option value=" " disabled>وضع الحالة</option>
                                                        @foreach(\App\FamilyStatus::orderBy('name')->get() as $family_status)
                                                            <option value="{{ $family_status->id }}"
                                                                    @if(in_array($family_status->id, $family_status_ids)) selected @endif
                                                            >{{ $family_status->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->

                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">الباحث</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="searchers[]"
                                                            id="searchers"
                                                            multiple
                                                    >
                                                        <option value=" " disabled>الباحث</option>
                                                        @foreach(\App\User::orderBy('full_name')->get() as $the_user)
                                                            <option value="{{ $the_user->id }}"
                                                                    @if(in_array($the_user->id, $searchers)) selected @endif
                                                            >{{ $the_user->full_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">نوع الزيارة</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="visit_reason_ids[]" multiple
                                                            id="visit_reason_id">
                                                        <option value=" " disabled>نوع الزيارة</option>
                                                        @foreach(\App\VisitReason::orderBy('name')->get() as $visit_reason)
                                                            <option value="{{ $visit_reason->id }}"
                                                                    @if(in_array($visit_reason->id, $visit_reason_ids)) selected @endif
                                                            >{{ $visit_reason->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">تاريخ الزيارة من</label>
                                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd"
                                                       readonly="readonly" type="text"
                                                       id="from_visit_date" style="width: 90%"
                                                       name="from_visit_date"
                                                       value="{{$from_visit_mission_date}}"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12"> تاريخ الزيارة الى</label>
                                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd"
                                                       readonly="readonly" type="text"
                                                       id="to_visit_date"
                                                       name="to_visit_date"
                                                       value="{{$to_visit_mission_date}}"
                                                       style="width: 90%">
                                            </div>
                                        </div>
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">عدد الزيارات من </label>
                                                <div style="width: 95%;">
                                                    <input type="number" class="form-control"
                                                           name="from_visit_count"
                                                           value="{{$from_visit_count}}"
                                                           id="from_visit_count"
                                                           placeholder="عدد الزيارات من">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">عدد الزيارات الى</label>
                                                <div style="width: 95%;">
                                                    <input type="number" class="form-control"

                                                           name="to_visit_count"
                                                           value="{{$to_visit_count}}"
                                                           id="to_visit_count"
                                                           placeholder="عدد الزيارات الى">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                    </div>
                                    <!-- End Row -->
                                </div>
                                <div class="tab-pane" id="tab6" role="tabpanel">
                                    <!-- Start Row -->
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">اسم القريب</label>
                                                <div style="width: 95%;">
                                                    <input type="text" class="form-control" name="members_full_name"
                                                           id="members_full_name"
                                                           value="{{$members_full_name}}"
                                                           placeholder="اسم القريب">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">عدد الافراد من</label>
                                                <div style="width: 95%;">
                                                    <input type="number" class="form-control"
                                                           name="from_members_count"
                                                           id="from_members_count"
                                                           value="{{$from_members_count}}"
                                                           placeholder="عدد الافراد من">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">عدد الافراد الى</label>
                                                <div style="width: 95%;">
                                                    <input type="number" class="form-control"
                                                           name="to_members_count"
                                                           id="to_members_count"
                                                           value="{{$to_members_count}}"
                                                           placeholder="عدد الافراد الى">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">سنة الميلاد من</label>
                                                <div style="width: 95%;">
                                                    <input class="form-control datepicker"
                                                           id="from_members_date_of_birth"
                                                           value="{{ $from_members_date_of_birth }}"
                                                           name="from_members_date_of_birth"
                                                           type="text"
                                                           style="width: 95%;">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">سنة الميلاد إلى</label>
                                                <div style="width: 95%;">
                                                    <input class="form-control datepicker" id="to_members_date_of_birth"
                                                           value="{{ $to_members_date_of_birth }}"
                                                           name="to_members_date_of_birth"
                                                           type="text"
                                                           style="width: 95%;">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">صلة القرابة</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="members_relationship_ids[]"
                                                            multiple
                                                            id="members_relationship_ids">
                                                        <option value=" " disabled>صلة القرابة</option>
                                                        @foreach(\App\Relationship::orderBy('name')->get() as $relationship)
                                                            <option value="{{ $relationship->id }}"
                                                                    @if(in_array($relationship->id, $members_relationship_ids)) selected @endif
                                                            >{{ $relationship->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row" style="width: 95%;">
                                                <label class="col-form-label col-lg-12">الحالة التعليمية</label>
                                                <select class="form-control kt-select2 select2-multi"
                                                        id="members_qualification_level_ids"
                                                        name="members_qualification_level_ids[]"
                                                        multiple>
                                                    <option value=" " disabled>الحالة التعليمية</option>
                                                    @foreach(\App\Qualification::orderBy('name')->get() as $qualification_levels)
                                                        <option value="{{ $qualification_levels->id }}"
                                                                @if(in_array($qualification_levels->id, $members_qualification_level_ids)) selected @endif
                                                        >{{ $qualification_levels->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row" style="width: 95%;">
                                                <label class="col-form-label col-lg-12">الحالة الصحية</label>
                                                <select class="form-control kt-select2 select2-multi"
                                                        name="members_health_status"
                                                        id="members_health_status">
                                                    <option value=" " selected> الحالة الصحية</option>
                                                    <option value="1" {{ '1' == $members_health_status ? 'selected':'' }}>
                                                        مريض
                                                    </option>
                                                    <option value="0" {{ '0' == $members_health_status ? 'selected':'' }}>
                                                        سليم
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row" style="width: 95%;">
                                                <label class="col-form-label col-lg-12">الحالة الاجتماعية</label>
                                                <select class="form-control kt-select2 select2-multi"
                                                        name="members_social_status_ids[]"
                                                        id="members_social_status_ids"
                                                        multiple>
                                                    <option value=" " disabled>الحالة الاجتماعية</option>
                                                    @foreach(\App\SocialStatus::orderBy('name')->get() as $social_status)
                                                        <option value="{{ $social_status->id }}"
                                                                @if(in_array($social_status->id, $members_social_status_ids)) selected @endif
                                                        >{{ $social_status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row" style="width: 95%;">
                                                <label class="col-form-label col-lg-12">الامراض</label>
                                                <select class="form-control kt-select2 select2-multi "
                                                        id="members_disease"
                                                        name="members_disease[]"
                                                        multiple
                                                >
                                                    <option value=" " disabled>المرض</option>
                                                    @foreach(\App\Disease::orderBy('name')->get() as $disease)
                                                        <option value="{{ $disease->id }}"
                                                                @if(in_array($disease->id, $members_disease)) selected @endif
                                                        >{{ $disease->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- End col -->

                                    </div>
                                    <!-- End Row -->
                                </div>
                                <div class="tab-pane" id="tab8" role="tabpanel">
                                    <!-- Start Row -->
                                    <div class="row">
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">الرقم الجامعي</label>
                                                <div style="width: 95%;">
                                                    <input type="number" class="form-control" name="id_university"
                                                           id="id_university"
                                                           value="{{$id_university}}"
                                                           placeholder="الرقم الجامعي">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">المؤسسة التعليمية</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            id="educational_institution_ids"
                                                            name="educational_institution_ids[]"
                                                            multiple>
                                                        <option value=" " disabled>المؤسسة التعليمية</option>
                                                        @foreach(\App\EducationalInstitution::orderBy('name')->get() as $educational_institution)
                                                            <option value="{{ $educational_institution->id }}"
                                                                    @if(in_array($educational_institution->id, $educational_institution_ids)) selected @endif
                                                            >{{ $educational_institution->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">التخصص الجامعي</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="university_specialty_ids[]"
                                                            id="university_specialty_ids" multiple>
                                                        <option value=" " disabled>التخصص الجامعي</option>
                                                        @foreach(\App\UniversitySpecialty::orderBy('name')->get() as $university_specialty)
                                                            <option value="{{ $university_specialty->id }}"
                                                                    @if(in_array($university_specialty->id, $university_specialty_ids)) selected @endif
                                                            >{{ $university_specialty->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">المستوى الجامعي</label>
                                                    <select class="form-control kt-select2 select2-multi"
                                                            name="study_level_ids[]"
                                                            id="study_level_ids" multiple>
                                                        <option value=" " disabled> المستوى الجامعي
                                                        </option>
                                                        @foreach(\App\StudyLevel::orderBy('name')->get() as $studyLevel)
                                                            <option value="{{ $studyLevel->id }}"
                                                                    @if(in_array($studyLevel->id, $study_level_ids)) selected @endif
                                                            >{{ $studyLevel->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">تاريخ التخرج من</label>
                                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd"
                                                       readonly="readonly" type="text"
                                                       name="from_graduated_date"
                                                       id="from_graduated_date"
                                                       value="{{$from_graduated_date}}"
                                                       style="width: 90%">
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-12">تاريخ التخرج إلى</label>
                                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd"
                                                       readonly="readonly" type="text"
                                                       name="to_graduated_date"
                                                       id="to_graduated_date"
                                                       value="{{$to_graduated_date}}"
                                                       style="width: 90%">
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">نوع الدراسة</label>
                                                    <select class="form-control  kt-select2 select2-multi"
                                                            name="study_type_ids[]"
                                                            id="study_type_ids"
                                                            multiple>
                                                        <option value=" " disabled>نوع الدراسة</option>
                                                        @foreach(\App\StudyType::orderBy('name')->get() as $study_type)
                                                            <option value="{{ $study_type->id }}"
                                                                    @if(in_array($study_type->id, $study_type_ids)) selected @endif
                                                            >{{ $study_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <!-- Start col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">قيمة الساعة الدراسية
                                                        من</label>
                                                    <div style="width: 95%;">
                                                        <input type="number" class="form-control"
                                                               id="from_study_hour_price"
                                                               name="from_study_hour_price"
                                                               value="{{$from_study_hour_price}}"
                                                               placeholder="قيمة الساعة الدراسية">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                        <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                            <div class="form-group row">
                                                <div style="width: 97%;">
                                                    <label class="col-form-label col-lg-12">قيمة الساعة الدراسية
                                                        إلى</label>
                                                    <div style="width: 95%;">
                                                        <input type="number" class="form-control"
                                                               id="to_study_hour_price"
                                                               name="to_study_hour_price"
                                                               value="{{$to_study_hour_price}}"
                                                               placeholder="قيمة الساعة الدراسية">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End col -->
                                    </div>
                                    <!-- End Row -->
                                </div>
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
                        
                        
                        <!--<div class="row">-->
                        <!-- Satrt col -->
                        <!--    <div class="col-lg-4 col-md-6 col-12">-->
                        <!--        <div class="form-group row">-->
                        <!--            <div class="btn-group show"  style="width: 99%">-->
                        <!--            <button type="button" class="btn btn-outline-success col mr-3 dropdown-toggle"-->
                        <!--            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">-->
                        <!--                تصدير استمارات الزيارات</button>-->
                        <!--            <div class="dropdown-menu" x-placement="bottom-start">-->
                        <!--                <button class="dropdown-item" type="submit" name="allVisitExcel"><i-->
                        <!--                            class="fa fa-file-excel"-->
                        <!--                            style="color: green"></i>Excel-->
                        <!--                </button>-->
                        <!--                <button class="dropdown-item" type="submit" name="allVisitPDF" href="#"><i-->
                        <!--                            class="fa fa-file-pdf"-->
                        <!--                            style="color: red"></i>Pdf-->
                        <!--                </button>-->
                        <!--                <button class="dropdown-item" type="submit" name="allVisitWord"><i-->
                        <!--                            class="fa fa-file-word"-->
                        <!--                            style="color: blue"></i>Word-->
                        <!--                </button>-->
                        <!--            </div></div></div></div>-->
                        <!--    <div class="col-lg-4 col-md-6 col-12">-->
                        <!--        <div class="form-group row">-->
                        <!--            <div class="btn-group show"style="width: 99%">-->
                        <!--                <button type="button" class="btn btn-outline-success col mr-3 dropdown-toggle"-->
                        <!--                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">-->
                        <!--                    تصدير استمارات الايتام-->
                        <!--                </button>-->
                        <!--                <div class="dropdown-menu" x-placement="bottom-start">-->
                        <!--                    <button class="dropdown-item" type="submit" name="allYTMExcel"><i-->
                        <!--                                class="fa fa-file-excel"-->
                        <!--                                style="color: green"></i>Excel-->
                        <!--                    </button>-->
                        <!--                    <button class="dropdown-item" type="submit" name="allYTMPDF"><i-->
                        <!--                                class="fa fa-file-pdf"-->
                        <!--                                style="color: green"></i>PDF-->
                        <!--                    </button>-->
                        <!--                    <button class="dropdown-item" type="submit" name="allYTMWord"><i-->
                        <!--                                class="fa fa-file-word"-->
                        <!--                                style="color: green"></i>Word-->
                        <!--                    </button>-->
                        <!--                </div>-->
                        <!--            </div>-->

                                    
                        <!--        </div>-->
                        <!--    </div>-->
                            <!-- End col -->
                        <!--    <div class="col-lg-4 col-md-6 col-12">-->
                        <!--        <div class="form-group">-->
                        <!--            <form action="/admin/expenseDetails/sendSMS">-->
                        <!--                <input type="hidden" name="the_ids" id="myIds1">-->
                        <!--                <a style="width: 97%;" class="btn btn-outline-success col text-success " name="theaction"-->
                        <!--                   onclick="sms_all()">ابلاغ رسائل للمحدد-->
                        <!--                </a>-->
                        <!--            </form>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                    <!-- End Tabs -->
                    </div>
                </form>
                <!--end::Portlet-->
                
                <div class="row ">
                <div class="col-lg-8 col-12">
                <form action="{{ url('admin/families/exportFamilies') }}" method="post">
                    @csrf
                    <input type="hidden" name="the_ids" id="myIds1">
                    <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-6">
                            <div class="btn-group show" style="width: 99%">
                                <button type="button" class="btn btn-outline-success dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    تصدير استمارات الزيارات
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start">
                                    <button class="dropdown-item" type="submit" name="allVisitExcel" value="allVisitExcel"><i
                                                class="fa fa-file-excel"
                                                style="color: green"></i>Excel
                                    </button>
                                    <button class="dropdown-item" type="submit" name="allVisitPDF" href="#"><i
                                                class="fa fa-file-pdf"
                                                style="color: red"></i>Pdf
                                    </button>
                                    <button class="dropdown-item" type="submit" name="allVisitWord"><i
                                                class="fa fa-file-word"
                                                style="color: blue"></i>Word
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <div class="col-lg-6">
                            <div class="btn-group show" style="width: 99%">
                                <button type="button" class="btn btn-outline-success dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    تصدير استمارات الايتام
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start">
                                    <button class="dropdown-item" type="submit" name="allYTMExcel"><i
                                                class="fa fa-file-excel"
                                                style="color: green"></i>Excel
                                    </button>
                                    <button class="dropdown-item" type="submit" name="allYTMPDF"><i
                                                class="fa fa-file-pdf"
                                                style="color: green"></i>PDF
                                    </button>
                                    <button class="dropdown-item" type="submit" name="allYTMWord"><i
                                                class="fa fa-file-word"
                                                style="color: green"></i>Word
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->


                    </div>
                </form>
                </div>
                <div class="col-lg-4 col-12">
                    <form action="/admin/expenseDetails/sendSMS" class="col">
                        <input type="hidden" name="the_ids" id="myIds1">
                        <a style="width: 97%;" class="btn btn-outline-success col text-success " name="theaction"
                           onclick="sms_all()">ابلاغ رسائل للمحدد
                        </a>
                    </form>
                </div>

            </div>

            </div>

                <!--begin::Portlet-->

        </div>
        <!--end::Portlet-->
       

        
        <div class="row">
            <div class="col s12" id="the_error">

            </div>
        </div>
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">

            <div class="kt-portlet__body ">
                <!-- Start Table  -->
                <div class="col-lg-12 table-responsive">
                    <table class="table table-bordered table-hover" id="table">
                        <thead>
                        <tr class="text-center">
                            @if(collect($coulmn)->contains('#'))
                                <th>
                                    #
                                </th>
                            @endif
                            @if(collect($coulmn)->contains('تحديد'))
                                <th>
                                    <label class="kt-checkbox">
                                        <input type="checkbox" id="check_all" name="check_all" type="checkbox"
                                               value="1">الكل
                                        <span></span>
                                    </label>
                                </th>@endif
                            @if(collect($coulmn)->contains('الصورة'))
                                <th>الصوره</th>@endif
                            @if(collect($coulmn)->contains('الاسم الكامل'))
                                <th>الاسم كامل</th>@endif
                            @if(collect($coulmn)->contains('الكود'))
                                <th>الكود</th>@endif
                            @if(collect($coulmn)->contains('الهوية'))
                                <th>الهوية</th>@endif
                            @if(collect($coulmn)->contains('تصنيف الحالة'))
                                <th>تصنيف الحالة</th>@endif
                            @if(collect($coulmn)->contains('السكن'))
                                <th>السكن</th>@endif
                            @if(collect($coulmn)->contains('عدد الأفراد'))
                                <th>عدد الافراد</th>@endif
                            @if(collect($coulmn)->contains('الحالة الدراسية'))
                                <th> الحالة الدراسية</th>@endif
                            @if(collect($coulmn)->contains('الحالة الوظيفية'))
                                <th> الحالة الوظيفية</th>@endif
                            @if(collect($coulmn)->contains('الحالة الاجتماعية'))
                                <th> الحالة الاجتماعية</th>@endif
                            @if(collect($coulmn)->contains('الوضع الصحي'))
                                <th> الوضع الصحي</th>@endif
                            @if(collect($coulmn)->contains('الوكيل'))
                                <th>الوكيل</th>@endif
                            @if(collect($coulmn)->contains('الاسم التركي'))
                                <th>الاسم التركي</th>@endif
                            @if(collect($coulmn)->contains('جهة الدخل'))
                                <th>جهة الدخل</th>@endif
                            @if(collect($coulmn)->contains('تقييم الحالة'))
                                <th>تقييم الحالة</th>@endif
                            @if(collect($coulmn)->contains('قيمة الساعة الدراسية'))
                                <th>قيمة الساعة الدراسية</th>@endif
                            @if(collect($coulmn)->contains('اسم المؤسسة التعليمية'))
                                <th>اسم الموسسة التعليمية</th>@endif
                            @if(collect($coulmn)->contains('نوع الزيارة'))
                                <th>نوع الزيارة</th>@endif
                            @if(collect($coulmn)->contains('وضع الحالة'))
                                <th>وضع الحالة</th>@endif
                            @if(collect($coulmn)->contains('عدد الزيارات'))
                                <th>اجمالي عدد الزيارات</th>@endif
                            @if(collect($coulmn)->contains('الزيارات الميدانية للباحث'))
                                <th>الزيارات الميدانية للباحث</th>@endif
                            @if(collect($coulmn)->contains('الترجمة'))
                                <th>الترجمة</th>@endif
                            @if(collect($coulmn)->contains('الجهة المرشحة'))
                                <th>الجهة المرشحة</th>@endif
                            @if(collect($coulmn)->contains('المشروع'))
                                <th> المشروع</th>@endif
                            @if(collect($coulmn)->contains('سنة الزيارة'))
                                <th> سنه الزيارة</th>@endif
                            @if(collect($coulmn)->contains('شهر الزيارة'))
                                <th> شهر الزيارة</th>@endif
                            @if(collect($coulmn)->contains('يوم الزيارة'))
                                <th> يوم الزيارة</th>@endif
                            @if(collect($coulmn)->contains('تاريخ الزيارة'))
                                <th> تاريخ الزيارة</th>@endif
                            @if(collect($coulmn)->contains('الارسال'))
                                <th> الارسال</th>@endif
                            @if(collect($coulmn)->contains('اكتمال البيانات'))
                                <th>اكتمال البيانات</th>@endif
                            @if(collect($coulmn)->contains('التقييم'))
                                <th> التقييم</th>@endif
                            @if(collect($coulmn)->contains('الأمراض'))
                                <th> الامراض</th>@endif
                            @if(collect($coulmn)->contains('مبلغ الدخل'))
                                <th>مبلغ الدخل</th>@endif
                            @if(collect($coulmn)->contains('العمليات'))
                                <th>العمليات</th>@endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($families as $value)
                            <tr>
                                @if(collect($coulmn)->contains('#'))
                                    <td>
                                        {{$value->id}}
                                    </td>
                                @endif
                                @if(collect($coulmn)->contains('تحديد'))
                                    <td>
                                        <div class="">
															<span
                                                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
																<label>
																	<input type="checkbox" id="{{$value->id}}"
                                                                           name="ids[{{$value->id}}]" type="checkbox"
                                                                           value="1">
																	<span></span>
																</label>
															</span>
                                        </div>
                                    </td>@endif
                                @php
                                    $path = '../../assets/images/users/2.jpg';
                                        $images = isset($value->media) ? $value->media : null;
                                        if (!is_null($images)) {
                                            foreach ($images as $image) {
                                                if ($image->file_type_id == 2) {
                                                    $path = asset('uploads/attachments/' . $image->path);
                                                }
                                            }
                                        }
                                @endphp
                                @if(collect($coulmn)->contains('الصورة'))
                                    <td>
                                        <image width='50px' height='50px' src='{{$path}}'/>
                                    </td>@endif
                                @php
                                    $person = $value->person;
                                @endphp
                                @if(collect($coulmn)->contains('الاسم الكامل'))
                                    <td>
                                        {{!is_null($person->full_name) ? $person->full_name : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الكود'))
                                    <td>
                                        {{!is_null($value->code) ? $value->code : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الهوية'))
                                    <td>
                                        {{!is_null($person->id_number) ? $person->id_number : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('تصنيف الحالة'))
                                    <td>
                                        {{isset($value->type) ? $value->type->name : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('السكن'))
                                    <td>
                                        {{isset($value->house_ownership) ? $value->house_ownership->name : '-'}}
                                    </td>@endif
                                @php
                                    $members = isset($value->members) ? $value->members : null;
                                @endphp
                                @if(collect($coulmn)->contains('عدد الأفراد'))
                                    <td>
                                        {{is_null($members) ? count($members) : 0}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الحالة الدراسية'))
                                    <td>
                                        {{isset($person->qualification) ? $person->qualification->name : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الحالة الوظيفية'))
                                    <td>
                                        {{!is_null($person) ? $person->work == 0 ? 'لا يعمل ' : 'يعمل' : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الحالة الاجتماعية'))
                                    <td>
                                        {{isset($person->social_status) ? $person->social_status->name : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الوضع الصحي'))
                                    <td>
                                        {{!is_null($person) ? $person->health_status == 0 ? 'سليم' : 'مريض' : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الوكيل'))
                                    <td>
                                        {{isset($value->representative) ? ($value->representative->full_name) : '-'}}  {{isset($value->breadwinner) ? ($value->breadwinner->name) : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الاسم التركي'))
                                    <td>
                                        {{isset($value->person) ? $value->person->full_name_tr : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('جهة الدخل'))
                                    <td>
                                        {{isset($value->job_type) ? $value->job_type->name : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('تقييم الحالة'))
                                    <td>
                                        {{!is_null($value->need) ? $value->need == 1 ? 'يحتاج' : 'لا يحتاج' : 'لم يتم التقييم'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('قيمة الساعة الدراسية'))
                                    <td>
                                        {{!is_null($value->study_hour_price) ? $value->study_hour_price : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('اسم المؤسسة التعليمية'))
                                    <td>
                                        {{isset($value->educational_institution) ? $value->educational_institution->name : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('نوع الزيارة'))
                                    <td>
                                        {{isset($value->visit_reason) ? $value->visit_reason->name : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('وضع الحالة'))
                                    <td>
                                        {{isset($value->status) ? $value->status->name : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('عدد الزيارات'))
                                    <td>
                                        {{ $value->visit_count }}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الزيارات الميدانية للباحث'))
                                    <td>
                                        @php
                                            $arrayData = [];
                                                            if ((isset($value->searcher)) && (!is_null($value->searcher))) {
                                                                foreach ($value->searcher as $item) {
                                                                    if ((isset($item->searcher)) && (!is_null($item->searcher))) {
                                                                        array_push($arrayData, $item->searcher->full_name);
                                                                    }
                                                                }
                                                            }
                                        @endphp
                                        {{implode(" | ", $arrayData)}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الترجمة'))
                                    <td>
                                        {{!is_null($person->full_name_tr) ? 'مترجمة' : 'غير مترجمة'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الجهة المرشحة'))
                                    <td>
                                        {{isset($value->fundedInstitution) ? $value->fundedInstitution->name : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('المشروع'))
                                    <td>
                                        {{isset($value->project) ? $value->project->name : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('سنة الزيارة'))
                                    <td>
                                        @php
                                            $split = null;
                                                $year = null;
                                                if (!is_null($value->visit_date)) {
                                                    $date = str_replace('.', '/', $value->visit_date);
                                                    $split = explode('/', $date);
                                                    $year = $split[0];
                                                }
                                        @endphp
                                        {{$year}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('شهر الزيارة'))
                                    <td>
                                        @php
                                            $split = null;
                                            $month = null;
                                            if (!is_null($value->visit_date)) {
                                                $date = str_replace('.', '/', $value->visit_date);
                                                $split = explode('/', $date);
                                                if (count($split) > 1) {
                                                    $month = $split[1];
                                                }
                                            }
                                        @endphp
                                        {{$month}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('يوم الزيارة'))
                                    <td>
                                        @php
                                            $split = null;
                                            $day = null;
                                            if (!is_null($value->visit_date)) {
                                                $date = str_replace('.', '/', $value->visit_date);
                                                $split = explode('/', $date);
                                                if (count($split) > 1) {
                                                    $split2 = explode(' ', $split[2]);
                                                    $day = $split2[0];
                                                }
                                            }
                                        @endphp
                                        {{$day}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('تاريخ الزيارة'))
                                    <td>
                                        {{!is_null($value->visit_date) ? str_replace('.', '/', $value->visit_date) : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الارسال'))
                                    <td>
                                        {{$value->is_sent == 1 ? 'تم الإرسال' : 'ليست قيد الإرسال'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('اكتمال البيانات'))
                                    <td>

                                        @if(($value->code) &&($value->family_status_id)
                                        && ($value->family_project_id)
                                        && ($value->neighborhood_id)&& ($value->mobile_one)
                                            && ($value->person->work) &&($value->note_turkey)
                                               &&($value->person->id_number)&& ($value->person->family_name_tr)
                                               &&($value->person->first_name_tr)&&($value->person->date_of_birth)
                                               &&($value->person->qualification_id)&&($value->person->date_of_birth_place)
                                               &&(($value->person->health_status)||($value->person->health_status == 0))
                                         )
                                            مكتملة
                                        @else
                                            منقوصة
                                        @endif
                                    </td>@endif
                                @if(collect($coulmn)->contains('التقييم'))
                                    <td>
                                        {{!is_null($value->note_turkey) ? 'تم التقييم' : 'لم يتم التقييم'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('الأمراض'))
                                    <td>
                                        @php
                                            $arrayData = [];
                                                            if ((isset($value->familyMemberDiseases)) && (!is_null($value->familyMemberDiseases))) {
                                                                foreach ($value->familyMemberDiseases as $item) {
                                                                    if ((isset($item->disease)) && (!is_null($item->disease))) {
                                                                        array_push($arrayData, $item->disease->name);
                                                                    }
                                                                }
                                                            }
                                        @endphp
                                        {{implode(" | ", $arrayData)}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('مبلغ الدخل'))
                                    <td>
                                        {{!is_null($value->income_value) ? $value->income_value : '-'}}
                                    </td>@endif
                                @if(collect($coulmn)->contains('العمليات'))
                                    <td>
                                        @php
                                            $exportType = $value->family_project_id == 2 ? 'ytm' : 'visit';

                                                            $archiveUrl = url('admin/families/archive/' . $value->id);
                                                            $addMemberUrl = url('admin/families/addMember/' . $value->id);
                                                            $updateUrl = url('admin/families/' . $value->id . '/edit');
                                                            $mediaUrl = url('admin/families/' . $value->id . '/addMedia');
                                                            $exportTurkeyUrl = url('admin/families/export/word/' . $exportType . '/' . $value->id);
                                                            $exportExcelUrl = url('admin/families/export/excel/' . $exportType . '/' . $value->id);
                                                            $exportPDFUrl = url('admin/families/export/pdf/' . $exportType . '/' . $value->id);
                                                            $deleteUrl = url('admin/families/delete/' . $value->id);
                                        @endphp

            <div class='dropdown dropdown-inline'>
                <button type='button'
                        class='btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle'
                        data-toggle='dropdown' aria-haspopup='true'
                        aria-expanded='false'>
                    <i class='la la-cog'></i>
                </button>
                <div class='dropdown-menu dropdown-menu-right'>
                    <a class='dropdown-item' href='{{$updateUrl}}'><i
                                class='fa fa-edit'></i>تحديث</a>
                    <a class='dropdown-item' href='{{$archiveUrl}}'><i
                        class='fa fa-archive'></i>الأرشيف</a>
                                    
                    <a class='dropdown-item' href='{{$mediaUrl}}'><i
                        class='fa fa-paperclip'></i>المرفقات</a>
                        
                    <a class='dropdown-item' href='{{$addMemberUrl}}'>
                        <i class='fa fa-user-plus'></i>إضافة أفراد</a>
                    
                    <a class='dropdown-item ' href='{{$exportTurkeyUrl}}'>
                        <i class='fa fa-cloud-upload-alt'></i>تصدير الاستمارة التركية</a>
                       
                    <a class='dropdown-item' href='{{$exportPDFUrl}}'><i
                        class='fa fa-file-pdf'></i>تصدير PDF</a>
                    
                    <a class='dropdown-item' href=' /admin/families/{{$value->id}}/marge'>
                        <i class='fa fa-object-ungroup'></i>دمج مع أسر</a>
                                 
                                
                    <a class='dropdown-item'
                       href='{{url('admin/season_coupons?families_yes[]=' . $value->id)}}'><i
                                class='fa fa-hands-helping'></i>المساعدات الموسمية</a>
                    <a class='dropdown-item'
                       href='{{url('admin/urgent_coupons?families_yes[]=' . $value->id)}}'><i
                                class='fa fa-hands-helping'></i>المساعدات الطارئة</a>
                    <a class='dropdown-item'
                       href='{{url('admin/expenseDetails?families_yes[]=' . $value->id)}}'><i
                                class='fa fa-money-bill-wave-alt'></i>الصرفيات</a>
                    <a class='dropdown-item'
                       href='{{url('admin/sponsors?family_id=' . $value->id)}}'><i
                                class='fa fa-hand-holding-usd'></i>الكفلاء</a>
                    <a class='dropdown-item'
                       href='{{url('admin/calls?family_ids[]=' . $value->id)}}'><i
                                class='fa fa-phone-square'></i>الاتصالات</a>
               <a class='dropdown-item Confirm' href='{{$deleteUrl}}'><i
                                class='fa fa-trash'></i>
                        حذف
                    </a>
                </div>
            </div>
                                    </td>@endif


                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- End Table  -->
                </div>
                {{$families->links()}}
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

@section('footerJS')
    <script src="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('new_theme/assets/plugins/general/js/global/integration/plugins/bootstrap-datepicker.init.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('new_theme/assets/plugins/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js')}}"
            type="text/javascript"></script>

    <script src="{{asset('new_theme/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"
            type="text/javascript"></script>
    <script src="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <script type="text/javascript"
            src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
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
                        url: "/admin/families/sendSMS",
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
                        url: "/admin/families/sendSMS",
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
            document.getElementById("myIds3").value = ids;
        });
        $('input[name^="ids"]').change(function () {
            ids_array = [];
            $("input:checkbox[name^='ids']:checked").each(function () {
                ids_array.push($(this).attr("id"));
            });
            ids = ids_array.join();
            document.getElementById("myIds1").value = ids;
            document.getElementById("myIds2").value = ids;
            document.getElementById("myIds3").value = ids;
        });
    </script>

    <script>
        $("[name='date_of_birth']").datepicker({
            format: 'yyyy',
            minViewMode: 2,
            orientation: "bottom auto"
        });
    </script>
    <script>
        $(document).ready(function () {

            var governorate_id = $("[name='governorate_id']").val();

            $.get("/admin/governorates/cities/" + governorate_id, function (data, status) {
                $("[name='city_id']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="cities" value=" " >جميع المدن</option>');

                data.forEach(function (city) {
                    var iselected = checktruefalse(city.id);
                    $("[name='city_id']")
                        .append($("<option class='cities'></option>")
                            .attr("value", city.id)
                            .text(city.name));

                    $('.cities[value="' + city.id + '"]')
                        .attr('selected', iselected);
                    get_neighborhoods();
                });


            });


        });

        function get_cities() {
            var governorate_id = $("[name='governorate_id']").val();
            $.get("/admin/governorates/cities/" + governorate_id, function (data, status) {
                $("[name='city_id']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="cities" value=" ">جميع المدن</option>');

                data.forEach(function (city) {
                    var iselected = checktruefalse(city.id);
                    $("[name='city_id']")
                        .append($("<option class='cities'></option>")
                            .attr("value", city.id)
                            .text(city.name));
                    $('.cities[value="' + city.id + '"]')
                        .attr('selected', iselected);

                });
            });

        }

        function checktruefalse(id) {
            if (id == '{{$city_id}}') {
                return true
            } else
                return false
        }
    </script>
    <script>
        $(document).ready(function () {

            var city_id = $("[name='city_id']").val();

            $.get("/admin/cities/neighborhoods/" + city_id, function (data, status) {
                if(typeof data=='object'){
                $("[name='neighborhood_ids[]']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="neighborhoods" value=" ">جميع الأحياء</option>');

                data.forEach(function (neighborhood) {
                    var iselected = checktruefalse2(neighborhood.id);
                    $("[name='neighborhood_ids[]']")
                        .append($("<option class='neighborhoods'></option>")
                            .attr("value", neighborhood.id)
                            .text(neighborhood.name));

                    $('.neighborhoods[value="' + neighborhood.id + '"]')
                        .attr('selected', iselected);

                });
                }
            });
        });

        function get_neighborhoods() {
            var city_id = $("[name='city_id']").val();

            $.get("/admin/cities/neighborhoods/" + city_id, function (data, status) {
                if(typeof data=='object'){
                $("[name='neighborhood_ids[]']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="neighborhoods" value=" ">جميع الأحياء</option>');

                data.forEach(function (neighborhood) {
                    var iselected = checktruefalse2(neighborhood.id);
                    $("[name='neighborhood_ids[]']")
                        .append($("<option class='neighborhoods'></option>")
                            .attr("value", neighborhood.id)
                            .text(neighborhood.name));
                    $('.neighborhoods[value="' + neighborhood.id + '"]')
                        .attr('selected', iselected);

                });
}
            });

        }

        function checktruefalse2(id) {

            
var z = @json($neighborhood_ids);
            
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

        jQuery(document).ready(function () {
            var table = $('#table').DataTable({
                // responsive: true,
                processing: true,
                paging: false,
                search: false,
            });
        });

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


