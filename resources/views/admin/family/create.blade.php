@extends('layouts.dashboard.app')

@section('pageTitle','إضافة استمارة')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('new_theme/assets/css/pages/wizard/wizard-4.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{  asset('new_theme/assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{  asset('new_theme/assets/plugins/jquery-steps/steps.css') }}" rel="stylesheet">

    <style media="screen">
        .table th,
        .table td {
            vertical-align: baseline;
        }

        .select2 {
            width: 95% !important
        }

        @media (max-width: 781px) {

            .kt-badge.kt-badge--danger,
            .kt-badge.kt-badge--success {
                background-color: transparent;
                color: #000
            }
        }

        .col-form-label {
            padding: 0;
            padding-bottom: 5px;
        }

        .kt-wizard-v4 .kt-wizard-v4__nav .kt-wizard-v4__nav-items .kt-wizard-v4__nav-item .kt-wizard-v4__nav-body .kt-wizard-v4__nav-number {
            margin-right: 0;
            margin-left: 1rem;
            background-color: #0abb87;
            color: #FFF;
        }

        .kt-wizard-v4 .kt-wizard-v4__nav .kt-wizard-v4__nav-items .kt-wizard-v4__nav-item[data-ktwizard-state="current"] .kt-wizard-v4__nav-body .kt-wizard-v4__nav-number {
            background-color: #0abb87;
            color: #FFF;
        }

        .kt-wizard-v4 .kt-wizard-v4__nav .kt-wizard-v4__nav-items .kt-wizard-v4__nav-item[data-ktwizard-state="current"] .kt-wizard-v4__nav-body .kt-wizard-v4__nav-label .kt-wizard-v4__nav-label-title {
            color: #666
        }

        .kt-wizard-v4__nav-item {
            flex: 1 !important;
        }

        .kt-wizard-v4__nav-label-title {
            font-size: 1rem !important;
        }

        .kt-wizard-v4 .kt-wizard-v4__nav .kt-wizard-v4__nav-items .kt-wizard-v4__nav-item .kt-wizard-v4__nav-body {
            padding: 2rem 0.5rem;
        }

        .kt-wizard-v4 .kt-wizard-v4__wrapper .kt-form {
            width: 90%;
        }
        
        /*mah*/
        /*الهوامش العلوية والسفلية*/
        .kt-wizard-v4 .kt-wizard-v4__wrapper .kt-form {
            padding: 5px 0;
        }
        .kt-wizard-v4 .kt-wizard-v4__wrapper .kt-form .kt-wizard-v4__content {
             padding-bottom: 0; 
             margin-bottom: 0; 
        }
    </style>

@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','الاستمارات والزيارات')
@section('navigation3','إضافة استمارة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/families')
@section('navigation3_link','/admin/families/create')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        اضافة استمارة
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Wizard -->
                <div class="">
                    <div class="kt-wizard-v4" id="kt_wizard_v4"
                         data-ktwizard-state="step-first">

                        <!--begin: Form Wizard Nav -->
                        <div class="kt-wizard-v4__nav">
                            <div
                                    class="kt-wizard-v4__nav-items kt-wizard-v4__nav-items--clickable">

                                <!--doc: Replace A tag with SPAN tag to disable the step link click -->
                                <!-- Start Step -->
                                <div class="kt-wizard-v4__nav-item" data-ktwizard-type="step"
                                     data-ktwizard-state="current">
                                    <div class="kt-wizard-v4__nav-body">
                                        <div class="kt-wizard-v4__nav-number">
                                            1
                                        </div>
                                        <div class="kt-wizard-v4__nav-label">
                                            <div class="kt-wizard-v4__nav-label-title">
                                                معلومات شخصية
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- End Step -->
                                <!-- Start Step -->
                                <div class="kt-wizard-v4__nav-item" data-ktwizard-type="step">
                                    <div class="kt-wizard-v4__nav-body">
                                        <div class="kt-wizard-v4__nav-number">
                                            2
                                        </div>
                                        <div class="kt-wizard-v4__nav-label">
                                            <div class="kt-wizard-v4__nav-label-title">
                                                معلومات التواصل
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Step -->
                                <!-- Start Step -->
                                <div class="kt-wizard-v4__nav-item" data-ktwizard-type="step">
                                    <div class="kt-wizard-v4__nav-body">
                                        <div class="kt-wizard-v4__nav-number">
                                            3
                                        </div>
                                        <div class="kt-wizard-v4__nav-label">
                                            <div class="kt-wizard-v4__nav-label-title">
                                                معلومات العمل
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Step -->
                                <!-- Start Step -->
                                <div class="kt-wizard-v4__nav-item" data-ktwizard-type="step">
                                    <div class="kt-wizard-v4__nav-body">
                                        <div class="kt-wizard-v4__nav-number">
                                            4
                                        </div>
                                        <div class="kt-wizard-v4__nav-label">
                                            <div class="kt-wizard-v4__nav-label-title">
                                                معلومات السكن
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Step -->
                                <!-- Start Step -->
                                <div class="kt-wizard-v4__nav-item" data-ktwizard-type="step">
                                    <div class="kt-wizard-v4__nav-body">
                                        <div class="kt-wizard-v4__nav-number">
                                            5
                                        </div>
                                        <div class="kt-wizard-v4__nav-label">
                                            <div class="kt-wizard-v4__nav-label-title">
                                                معلومات الوكيل
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Step -->
                                <!-- Start Step -->
                                <div class="kt-wizard-v4__nav-item" data-ktwizard-type="step">
                                    <div class="kt-wizard-v4__nav-body">
                                        <div class="kt-wizard-v4__nav-number">
                                            6
                                        </div>
                                        <div class="kt-wizard-v4__nav-label">
                                            <div class="kt-wizard-v4__nav-label-title">
                                                معلومات عامة
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Step -->
                                <!-- Start Step -->
                                <div class="kt-wizard-v4__nav-item" data-ktwizard-type="step">
                                    <div class="kt-wizard-v4__nav-body">
                                        <div class="kt-wizard-v4__nav-number">
                                            7
                                        </div>
                                        <div class="kt-wizard-v4__nav-label">
                                            <div class="kt-wizard-v4__nav-label-title">
                                                افراد الاسرة
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Step -->
                            </div>
                        </div>

                        <!--end: Form Wizard Nav -->
                        <div class="kt-portlet">
                            <div class="kt-portlet__body kt-portlet__body--fit">
                                <div class="kt-grid">
                                    <div
                                            class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">
                                        <!--begin: Form Wizard Form-->
                                        <form class="kt-form" id="kt_form" action="{{ url('admin/families') }}"
                                              method="post">
                                            @csrf
                                            <input type="hidden" name="come_by" value="{{$come_by??""}}">
                                            <input id="checkStep" name="checkStep" hidden type="text" value=" "/>
                                            <!--begin: Form Wizard Step 1-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content"
                                                 data-ktwizard-state="current">
                                                <!-- Start Row -->
                                                <div class="row">
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">الاسم
                                                                الاول
                                                                <span style="color:red;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="text" required 
                                                                       class="form-control" id="first_name"
                                                                       name="first_name"
                                                                       value="{{old('first_name')}}"
                                                                       placeholder="الاسم الاول">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">اسم
                                                                الاب
                                                                <span style="color:red;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="text" required 
                                                                       class="form-control" id="second_name"
                                                                       name="second_name"
                                                                       value="{{old('second_name')}}"
                                                                       placeholder="اسم الاب">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">اسم
                                                                الجد
                                                                <span style="color:red;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="text" required 
                                                                       class="form-control" id="third_name"
                                                                       name="third_name"
                                                                       value="{{old('third_name')}}"
                                                                       placeholder="اسم الجد">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">اسم
                                                                العائلة
                                                                <span style="color:red;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="text" required 
                                                                       class="form-control" id="family_name"
                                                                       name="family_name"
                                                                       value="{{old('family_name')}}"
                                                                       placeholder="اسم العائلة">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">الاسم
                                                                الاول بالتركي
                                                                <span style="color:red;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="text" required 
                                                                       class="form-control turkey" id="first_name_tr"
                                                                       name="first_name_tr"
                                                                       value="{{old('first_name_tr')}}"
                                                                       placeholder="الاسم الاول بالتركي">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">اسم
                                                                الاب بالتركي
                                                                <span style="color:red;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="text"
                                                                       class="form-control turkey" id="second_name_tr"
                                                                       name="second_name_tr"
                                                                       value="{{old('second_name_tr')}}"
                                                                       placeholder="اسم الاب بالتركي">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">اسم
                                                                الجد بالتركي
                                                                <span style="color:red;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="text" required 
                                                                       class="form-control turkey" id="third_name_tr"
                                                                       name="third_name_tr"
                                                                       value="{{old('third_name_tr')}}"
                                                                       placeholder="اسم الجد بالتركي">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">اسم
                                                                العائلة بالتركي
                                                                <span style="color:red;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="text"
                                                                       class="form-control turkey" id="family_name_tr"
                                                                       name="family_name_tr"
                                                                       value="{{old('family_name_tr')}}"
                                                                       placeholder="اسم العائلة بالتركي">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row" style="width:100%">
                                                            <label class="col-form-label col-lg-12">سنة الميلاد
                                                            </label>
                                                            <input style="direction: rtl;"
                                    placeholder="سنة الميلاد" 
                class="form-control datepicker" id="date_of_birth"
                                                                   value="{{old('date_of_birth')}}"
                                                                   name="date_of_birth" type="text">
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">المعيل</label>
                                                                <select class="form-control "
                                                                        id="breadwinner_id" name="breadwinner_id">
                                                                    <option value=" " selected> المعيل</option>
                                                                    @foreach($relationships->sortBy('name') as $relationship)
                                                                        <option value="{{ $relationship->id }}"
                                                                                {{ $relationship->id == old('breadwinner_id') ? 'selected':'' }}
                                                                        >{{ $relationship->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12"
                                                            id="breadwinnerOtherDiv">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">المعيل
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="number"
                                                                       class="form-control" id="breadwinner_other"
                                                                       name="breadwinner_other" type="text"
                                                                       value="{{old('breadwinner_other')}}"
                                                                       placeholder="المعيل">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">مكان
                                                                    الميلاد</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="date_of_birth_place"
                                                                        name="date_of_birth_place">
                                                                    <option value=" " selected> مكان الميلاد</option>
                                                                    @foreach($countries->sortBy('name') as $country)
                                                                        <option value="{{ $country->id }}"
                                                                                {{ $country->id == old('date_of_birth_place') ? 'selected':'' }}
                                                                                {{$country->name == 'فلسطين' ?'selected':''}}>{{ $country->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 100%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">الجنس</label>
                                                                <select
                                                                        class="form-control kt-select2 select2-multi"
                                                                        id="gender" name="gender">
                                                                    <option value=" " selected> الجنس</option>
                                                                    <option value="M" {{  old('gender') == 'M' ? 'selected':'' }}>
                                                                        ذكر
                                                                    </option>
                                                                    <option value="F" {{ old('gender') == 'F' ? 'selected':'' }}>
                                                                        انثي
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->

                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 97%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">المؤهل
                                                                    العلمي</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="qualification_id" name="qualification_id">
                                                                    <option value=" " selected> المؤهل العلمي</option>
                                                                    @foreach($qualifications->sortBy('name') as $qualification)
                                                                        <option value="{{ $qualification->id }}"
                                                                                {{ $qualification->id == old('qualification_id') ? 'selected':'' }}
                                                                        >{{ $qualification->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->

                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 97%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">الحالة
                                                                    الاجتماعية</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="social_status_id" name="social_status_id">
                                                                    <option value=" " selected> الحالة الاجتماعية
                                                                    </option>
                                                                    @foreach($socialStatuses->sortBy('name') as $socialStatus)
                                                                        <option value="{{ $socialStatus->id }}"
                                                                                {{ $socialStatus->id == old('social_status_id') ? 'selected':'' }}
                                                                        >{{ $socialStatus->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">تصنيف
                                                                    المشروع</label>
                                                                <select class="form-control "
                                                                        name="family_project_id" id="family_project_id">
                                                                    <option value=" " selected>تصنيف المشروع</option>
                                                                    @foreach($projects->sortBy('name') as $project)
                                                                        <option value="{{ $project->id }}"
                                                                                {{ $project->id == old('family_project_id') ? 'selected':'' }}>{{ $project->name .' '}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12"
                                                            id="qualification_levelDiv">
                                                        <div class="form-group row">
                                                            <div style="width: 97%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">مستوى
                                                                    التعليم لليتيم</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="qualification_level_id"
                                                                        name="qualification_level_id">
                                                                    <option value=" " selected>المستوى التعليمي لليتيم
                                                                    </option>
                                                                    @foreach($qualificationLevels->sortBy('name') as $qualificationLevel)
                                                                        <option value="{{ $qualificationLevel->id }}"
                                                                                {{ $qualificationLevel->id == old('qualification_level_id') ? 'selected':'' }}
                                                                        >{{ $qualificationLevel->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 97%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">نوعية
                                                                    الوثيقة التعريفية
                                                                    <span style="color:red;">*</span>
                                                                </label>
                                                                <select class="form-control " required 
                                                                        id="id_type_id" name="id_type_id">
                                                                    <option value="" selected> نوعية الوثيقة
                                                                        التعريفية
                                                                    </option>
                                                                    @foreach($idTypes->sortBy('name') as $id)
                                                                        <option value="{{ $id->id }}"
                                                                                data-count="{{ $id->number }}"
                                                                                {{ $id->id == old('id_type_id') ? 'selected':'' }}
                                                                                type="{{ $id->type }}">{{ $id->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12"
                                                            id="idTypeIdDiv">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">الوثيقة التعريفية
                                                                <span style="color:red;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input class="form-control"  required id="id_number"
                                                                       name="id_number" type="text"
                                                                       value="{{old('id_number')}}"
                                                                       placeholder="الوثيقة التعريفية">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 97%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">الحالة
                                                                    الصحية</label>
                                                                <select class="form-control"
                                                                        id="health_status" name="health_status">
                                                                    <option value=" " selected> الحالة الصحية</option>
                                                                    <option value="1" {{ old('health_status') == "1" ? 'selected':'' }}>
                                                                        مريض
                                                                    </option>
                                                                    <option value="0" {{ old('health_status') === "0" ? 'selected':'' }}>
                                                                        سليم
                                                                    </option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12"
                                                            id="diseasesDiv">
                                                        <div class="form-group row">
                                                            <div style="width: 97%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">الأمراض
                                                                </label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        multiple id="family_diseases"
                                                                        name="family_diseases[]">
                                                                    <option value=" " disabled> الأمراض</option>
                                                                    @foreach($diseases->sortBy('name') as $disease)
                                                                        <option value="{{ $disease->id }}"
                                                                                {{ old('family_diseases')?in_array($disease->id,old('family_diseases')) ?'selected':'':"" }}
                                                                        >{{ $disease->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                            <!--end: Form Wizard Step 1-->
                                            <!--begin: Form Wizard Step 2-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content">
                                                <!-- start row -->
                                                <div class="row">
                                                </div>
                                                <!-- End row -->
                                            </div>
                                            <!--end: Form Wizard registeredp 2-->
                                            <!--begin: Form Wizard Step 3-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content">
                                                <!-- start row -->
                                                <div class="row"></div>
                                                <!-- End row -->
                                            </div>
                                            <!--end: Form Wizard Step 3-->
                                            <!--begin: Form Wizard Step 4-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content">
                                                <!-- start row -->
                                                <div class="row"></div>
                                                <!-- End row -->
                                            </div>
                                            <!--end: Form Wizard Step 4-->
                                            <!--begin: Form Wizard Step 5-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content">
                                                <!-- start row -->
                                                <div class="row"></div>
                                                <!-- End row -->
                                            </div>
                                            <!--end: Form Wizard Step 5-->
                                            <!--begin: Form Wizard Step 6-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content">
                                                <!-- start row -->
                                                <div class="row"></div>
                                                <!-- End row -->
                                            </div>
                                            <!--end: Form Wizard Step 6-->
                                            <!--begin: Form Wizard Step 7-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content">

                                                <!-- start row -->
                                                <div class="row"></div>
                                                <!-- End row -->
                                                <!-- start row -->
                                                <div class="row"></div>
                                                <!-- End row -->
                                                <hr style="width: 100%">
                                                <!-- Start Row -->
                                                <div class="row"></div>
                                                <!-- End Row -->
                                                <hr style="width: 100%">
                                                <!-- start row -->
                                                <div class="row"></div>
                                                <!-- End row -->
                                                <!-- Start Row -->
                                                <div class="row"></div>
                                                <!-- End Row -->
                                            </div>
                                            <!--end: Form Wizard Step 7-->
                                            <!--begin: Form Actions -->
                                            <div class="kt-form__actions">
                                                <button
                                                        class="next btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u col-6"
                                                        href="#previous"
                                                        data-ktwizard-type="action-prev"
                                                        style="margin-left: 10px">
                                                    السابق
                                                </button>
                                                <button
                                                        class=" next btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u col-6"
                                                        href="#next"
                                                        data-ktwizard-type="action-next">
                                                    التالي
                                                </button>
                                            </div>

                                            <!--end: Form Actions -->
                                        </form>

                                        <!--end: Form Wizard Form-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Wizard -->
            </div>
        </div>
        <!--end::Portlet-->
    </div>

    <div class="modal fade" id="add-user" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        اضافة فرد جديد</h5>
                    <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="addMemberForm">
                    @csrf
                    <div class="modal-body">

                        <!-- Start row -->
                        <div class="row">
                            <!-- Start Col -->
                            <div class="col-lg-10 col-md-10">
                                <input type="text" class="form-control numbers"
                                       id="id_number_search"
                                       maxlength="9"
                                       name="id_number_search"

                                       placeholder="بحث عن طريق الهوية">
                            </div>
                            <!-- End Col -->
                            <!-- Start Col -->
                            <div class="col-lg-2 col-md-2">
                                <button type="button"
                                        class="btn btn-success btn-elevate btn-block"
                                        id="idNumberSearchButton">
                                    بحث
                                </button>
                            </div>
                            <!-- End Col -->
                            <div id="addMemberDiv"
                                 class="text-center"></div>
                        </div>
                        <!-- End row -->
                        <hr style="width: 100%">
                        <!-- Start row -->
                        <h6>البحث عن طريق تعبئة البيانات :</h6>

                        <div class="row">

                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الاسم
                                            الاول بالعربية</label>
                                        <input type="text"
                                               class="form-control"
                                               id="member_first_name"
                                               name="member_first_name">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الاسم
                                            الاول بالتركية</label>
                                        <input type="text"
                                               class="form-control"
                                               id="member_second_name"
                                               name="member_first_name_tr">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الهوية</label>
                                        <input class="form-control numbers"
                                               id="member_id_number"
                                               name="member_id_number"
                                               maxlength="9">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الحالة
                                            الاجتماعية</label>
                                        <select class="form-control kt-select2 select2-multi"
                                                id="member_social_status_id"
                                                name="member_social_status_id">
                                            <option value=" " selected>
                                                الحالة الاجتماعية
                                            </option>
                                            @foreach($socialStatuses as $socialStatus)
                                                <option value="{{ $socialStatus->id }}"
                                                        {{ $socialStatus->id == old('member_social_status_id') ? 'selected':'' }}>{{ $socialStatus->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الحالة
                                            الوظيفية</label>
                                        <select class="form-control kt-select2 select2-multi"
                                                name="member_work"
                                                id="member_work">
                                            <option value=" " selected>
                                                الحالة الوظيفية
                                            </option>
                                            <option value="1" {{ old('member_work') == 1 ? 'selected':'' }}> يعمل
                                            </option>
                                            <option value="0" {{ old('member_work') === '0' ? 'selected':'' }}>لا يعمل
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الحالة
                                            الصحية</label>
                                        <select class="form-control "
                                                id="member_health_status"
                                                name="member_health_status">
                                            <option value=" " selected>
                                                الحالة الصحية
                                            </option>
                                            <option value="1" {{ old('member_health_status') === '1' ? 'selected':'' }}>
                                                مريض
                                            </option>
                                            <option value="0" {{ old('member_health_status') === '0' ? 'selected':'' }}>
                                                سليم
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الأمراض</label>
                                        <select class="form-control kt-select2 select2-multi"
                                                multiple
                                                id="member_family_diseases"
                                                name="member_family_diseases[]">
                                            <option value=" " selected>
                                                الأمراض
                                            </option>
                                            @foreach($diseases as $disease)
                                                <option value="{{ $disease->id }}"
                                                        {{old('member_family_diseases')?in_array($disease->id,old('member_family_diseases')) ?'selected':'':''}}
                                                >{{ $disease->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">تاريخ الميلاد</label>
                                        <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" 
                                        placeholder="تاريخ الميلاد"
                                               type="text"
                                               id="member_date_of_birth"
                                               name="member_date_of_birth"
                                               style="width: 95%">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">مكان
                                            الميلاد</label>
                                        <select class="form-control kt-select2 select2-multi"
                                                id="date_of_birth_place"
                                                name="date_of_birth_place">
                                            <option value=" " selected>
                                                مكان الميلاد
                                            </option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{$country->name == 'فلسطين' ?'selected':''}}
                                                        {{ old('date_of_birth_place') === $country->id  ? 'selected':'' }}
                                                >{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الحالة
                                            التعليمية</label>
                                        <select class="form-control kt-select2 select2-multi"
                                                name="member_qualification_id"
                                                id="member_qualification_id">
                                            <option value=" " selected>
                                                الحالة التعليمية
                                            </option>
                                            @foreach($qualifications as $qualification)
                                                <option value="{{ $qualification->id }}"
                                                        {{ old('member_qualification_id') === $qualification->id  ? 'selected':'' }}
                                                >{{ $qualification->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">صلة
                                            القرابة</label>
                                        <select class="form-control "
                                                name="member_relationship_id"
                                                id="member_relationship_id">
                                            <option value=" " selected>
                                                صلة القرابة
                                            </option>
                                            @foreach($relationships as $relationship)
                                                <option value="{{ $relationship->id }}"
                                                        {{ old('member_relationship_id') === $relationship->id  ? 'selected':'' }}
                                                >{{ $relationship->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12"
                                 id="member_relationship_div">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">صلة
                                            قرابة</label>
                                        <input type="text"
                                               class="form-control"
                                               id="member_relationship_other"
                                               name="member_relationship_other"
                                        >
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->

                        </div>
                        <!-- End row -->
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary"
                                data-dismiss="modal">
                            اغلاق
                        </button>
                        <button type="submit" id="addMemberButton"
                                type="button" class="btn btn-success">
                            حفظ
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="add_wife" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        اضافة زوجة جديدة</h5>
                    <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="addWiveForm">
                    @csrf
                    <div class="modal-body">
                        <!-- Start Row -->
                        <div class="row">
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">الاسم
                                        الاول بالعربي</label>
                                    <div style="width: 95%;">
                                        <input type="text"
                                               class="form-control"
                                               id="wive_first_name"
                                               name="wive_first_name"
                                               placeholder="الاسم الاول بالعربي">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">اسم
                                        الاب بالعربي</label>
                                    <div style="width: 95%;">
                                        <input type="text"
                                               class="form-control"
                                               id="wive_second_name"
                                               name="wive_second_name"
                                               placeholder="اسم الاب بالعربي">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">اسم
                                        الجد بالعربي</label>
                                    <div style="width: 95%;">
                                        <input type="text"
                                               class="form-control"
                                               id="wive_third_name"
                                               name="wive_third_name"
                                               placeholder="اسم الجد بالعربي">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">اسم
                                        العائلة بالعربي</label>
                                    <div style="width: 95%;">
                                        <input type="text"
                                               class="form-control"
                                               id="wive_family_name"
                                               name="wive_family_name"
                                               placeholder="اسم العائلة بالعربي">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">الهوية</label>
                                    <div style="width: 95%;">
                                        <input class="form-control numbers"
                                               id="wive_id_number"
                                               name="wive_id_number"
                                               maxlength="9"
                                               placeholder="الهوية">
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-12">صلة
                                        القرابة</label>
                                    <div style="width: 95%;">
                                        <select class="form-control kt-select2 select2-multi"
                                                name="wive_relationship_id"
                                                id="wive_relationship_id">
                                            <option value=" " selected>
                                                صلة
                                                القرابة
                                            </option>
                                            @foreach($relationships as $relationship)
                                                @if(($relationship->id == 25) || ($relationship->id == 44) || ($relationship->id == 45) || ($relationship->id == 27)
                                                || ($relationship->id == 32)  || ($relationship->id == 33)  || ($relationship->id == 34)  )
                                                    <option value="{{ $relationship->id }}"
                                                            {{ $relationship->id == old('wive_relationship_id') ? 'selected':'' }}
                                                    >{{ $relationship->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                        </div>
                        <!-- End Row -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">اغلاق
                        </button>
                        <button type="button" class="btn btn-success"
                                id="addWiveButton">
                            حفظ
                        </button>
                    </div>
                </form>
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
    <script src="{{asset('new_theme/assets/js/pages/custom/wizard/wizard-4.js')}}" type="text/javascript"></script>
    <script src="{{asset('new_theme/assets/plugins/general/jquery-validation/dist/jquery.validate.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('new_theme/assets/plugins/general/jquery-validation/dist/additional-methods.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('new_theme/assets/plugins/general/js/global/integration/plugins/jquery-validation.init.js')}}"
            type="text/javascript"></script>
    <script src="{{  asset('new_theme/assets/plugins/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script>
        $("[name='date_of_birth']").datepicker({
            format: 'yyyy',
            minViewMode: 2,
            // orientation: "bottom auto"
        });
    </script>
    <script>
        $(document).ready(function () {

            $(".numbers").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 1632 || e.which > 1641)) {
                    return false;
                }
            });

            // show hide id type input
            if ('{{!(old('id_number'))}}')
                $('#idTypeIdDiv').hide();

            $("#id_type_id").change(function () {
                var chracterCount = this.options[this.selectedIndex].getAttribute('data-count');
                var type = this.options[this.selectedIndex].getAttribute('type');

                $('#id_number').val('');
                $('#idTypeIdDiv').show();

                if (type == 0) {
                    $('#id_number').addClass('numbers');

                    $(".numbers").keypress(function (e) {
                        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 1632 || e.which > 1641)) {
                            return false;
                        }
                    });


                } else {
                    $('#id_number').removeClass('numbers');
                }

                $('#id_number').attr('maxlength', chracterCount);
                $('#id_number').attr('minlength', chracterCount);

            });


            function arabicInput(event) {
                var value = String.fromCharCode(event.which);
                var pattern = new RegExp(/^[\u0621-\u064A\u0660-\u0669 ]+$/i);
                return pattern.test(value);
            }

            function turkeyInput(event) {
                var value = String.fromCharCode(event.which);
                var pattern = new RegExp(/[a-zåäöığüşöçĞÜŞÖÇİ ]/i);
                return pattern.test(value);
            }

            $('.arabic').bind('keypress', arabicInput);
            $('.turkey').bind('keypress', turkeyInput);

            $('body .next').on('click', function () {
                var step = $('body .current a').attr('href');
                $('#checkStep').val(step);
                document.getElementById("kt_form").submit();
            });


            $(".names").keypress(function (e) {
                $('#names').html($('#first_name').val() + ' ' + $('#second_name').val() + ' ' + $('#third_name').val() + ' ' + $('#family_name').val());
            });


            // show hide work typ input
            $('#workDiv').hide();
            $("#work").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#workDiv').hide('');

                if (id == 1) {
                    $('#workDiv').show();
                }
            });

            // show hide relations
            $('#breadwinnerOtherDiv').hide();
            $("#breadwinner_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#breadwinnerOtherDiv').val('');

                if (id == 1) {
                    $('#breadwinnerOtherDiv').show();
                } else {
                    $('#breadwinnerOtherDiv').hide();
                }
            });

            // show hide representative relationship
            $('#breadwinnerOtherDiv').hide();
            $("#representative_relationship_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#representativeRelationshipOtherDiv').val('');

                if (id == 1) {
                    $('#representativeRelationshipOtherDiv').show();
                } else {
                    $('#representativeRelationshipOtherDiv').hide();
                }
            });

            // show hide health status select
            $('#diseasesDiv').hide();
            $("#health_status").change(function () {
                var id = $(this).children(":selected").attr("value");
                if (id == 1) {
                    $('#diseasesDiv').show();
                } else if (id == 0) {
                    $('#diseasesDiv').hide();

                }
            });

            $('#qualification_levelDiv').hide()
            $("#family_project_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#qualification_level_id').val('');

                if (id == 2) {
                    $('#qualification_levelDiv').show().removeClass("d-none");
                } else {
                    $('#qualification_levelDiv').hide();

                }
            });

            // show hide health status select
            $('#rentValueDiv').hide();
            $("#house_ownership_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                if (id == 2) {
                    $('#rentValueDiv').show();
                } else {
                    $('#rentValueDiv').hide();

                }
            });

            // show hide educational institution other
            $('#educationalInstitutionOtherDiv').hide();
            $("#educational_institution_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                if (id == 1) {
                    $('#educationalInstitutionOtherDiv').show();
                } else {
                    $('#educationalInstitutionOtherDiv').hide();

                }
            });

            // show hide university specialty
            $('#universitySpecialtyDiv').hide();
            $("#university_specialty_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                if (id == 1) {
                    $('#universitySpecialtyDiv').show();
                } else {
                    $('#universitySpecialtyDiv').hide();
                }
            });

            // show hide funded institution
            $('#fundedInstitutionDiv').hide();
            $("#funded_institution_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                if (id == 1) {
                    $('#fundedInstitutionDiv').show();
                } else {
                    $('#fundedInstitutionDiv').hide();
                }
            });
        });

        // Basic Example with form
        var form = $("#example-form");
        form.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.before(error);
            },
            rules: {
                confirm: {
                    equalTo: "#password"
                }
            }
        });

        form.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex) {
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinishing: function (event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                alert("Submitted!");
            }
        });

        // Advance Example
        var form = $("#example-advanced-form").show();

        form.steps({
            headerTag: "h3",
            bodyTag: "fieldset",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex) {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }
                // Forbid next action on "Warning" step if the user is to young
                if (newIndex === 3 && Number($("#age-2").val()) < 18) {
                    return false;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex) {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex) {
                // Used to skip the "Warning" step if the user is old enough.
                if (currentIndex === 2 && Number($("#age-2").val()) >= 18) {
                    form.steps("next");
                }
                // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3) {
                    form.steps("previous");
                }
            },
            onFinishing: function (event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                alert("Submitted!");
            }
        }).validate({
            errorPlacement: function errorPlacement(error, element) {
                element.before(error);
            },
            rules: {
                confirm: {
                    equalTo: "#password-2"
                }
            }
        });

        //Custom design form example
        $(".tab-wizard").steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                finish: "حفظ"
            },
            onFinished: function (event, currentIndex) {
                $('.tab-wizard').submit();
                //    swal("Form Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");

            }
        });


        var form = $(".validation-wizard").show();
        $(".validation-wizard").steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                finish: "حفظ"
            },
            onStepChanging: function (event, currentIndex, newIndex) {
                return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
            },
            onFinishing: function (event, currentIndex) {
                return form.validate().settings.ignore = ":disabled", form.valid()
            },
            onFinished: function (event, currentIndex) {

                swal("Form Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");
            }
        }), $(".validation-wizard").validate({
            ignore: "input[type=hidden]",
            errorClass: "text-danger",
            successClass: "text-success",
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass)
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass(errorClass)
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element)
            },
            rules: {
                email: {
                    email: !0
                }
            }
        });
    </script>
    <script>
        var url = '{{ url('admin/families/add/getTranslation') }}';


        $("#first_name_tr").click(function () {
            var name = $('#first_name').val();

            if (name != '') {
                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: url,
                    data: {name: name}
                }).done(function (transName) {

                    console.log(transName);
                    if ((transName == '') || (transName == null)) {
                        $('#first_name_tr').css('border-color', 'red');
                    } else {
                        $('#first_name_tr').val(transName);
                        $('#first_name_tr').css('border-color', 'green');
                    }
                });

            } else {
                $('#first_name_tr').css('border-color', 'red');
            }
        });

        $("#second_name_tr").click(function () {
            var name = $('#second_name').val();

            if (name != '') {

                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: url,
                    data: {name: name}
                }).done(function (transName) {

                    if ((transName == '') || (transName == null)) {
                        $('#second_name_tr').css('border-color', 'red');
                    } else {
                        $('#second_name_tr').val(transName);
                        $('#second_name_tr').css('border-color', 'green');
                    }
                });

            } else {
                $('#second_name_tr').css('border-color', 'red');
            }
        });

        $("#third_name_tr").click(function () {
            var name = $('#third_name').val();

            if (name != '') {

                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: url,
                    data: {name: name}
                }).done(function (transName) {

                    if ((transName == '') || (transName == null)) {
                        $('#third_name_tr').css('border-color', 'red');
                    } else {
                        $('#third_name_tr').val(transName);
                        $('#third_name_tr').css('border-color', 'green');
                    }
                });

            } else {
                $('#third_name_tr').css('border-color', 'red');
            }
        });

        $("#family_name_tr").click(function () {
            var name = $('#family_name').val();

            if (name != '') {

                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: url,
                    data: {name: name}
                }).done(function (transName) {

                    if (transName == '') {
                        $('#family_name_tr').css('border-color', 'red');
                    } else {
                        $('#family_name_tr').val(transName);
                        $('#family_name_tr').css('border-color', 'green');
                    }
                });

            } else {
                $('#family_name_tr').css('border-color', 'red');
            }
        });

    </script>
    <script>
        // show hide family type
        $('#UNDiv').hide();
        $('#fatherLessDiv').hide();
        $("#person_type_id").change(function () {
            var id = $(this).children(":selected").attr("value");
            if (id == 7) {
                $('#UNDiv').show();
                $('#fatherLessDiv').hide();
            } else if (id == 5) {
                $('#UNDiv').hide();
                $('#fatherLessDiv').show();
            } else {
                $('#UNDiv').hide();
                $('#fatherLessDiv').hide();
            }
        });
        var i = 1;

        $('#addIncomeTypeButton').click(function () {
            i++;
            $('#addIncomeType').append('<div class="row m-p" id="row' + i + '">' +
                '    <div class="col m3 s12">' +
                '        <div class="input-field col s12">' +
                '            <select id="income_type_id" name="income_type_id[]">' +
                '                <option value=" " selected>  جهات الدخل' +
                '                </option>' +
                '                @foreach($incomeTypes as $incomeType)' +
                '                    <option value="{{ $incomeType->id }}">{{ $incomeType->name }}</option>' +
                '                @endforeach' +
                '            </select>' +
                '            <label for="income_type_id"> جهات الدخل' +
                '            </label>' +
                '        </div>' +
                '    </div>' +
                '' +
                '    <div class="col m3 s12">' +
                '        <div class="input-field col s12">' +
                '            <input id="income_value"  style="text-align: left" name="income_type_value[]"' +
                '                   type="text" class="numbers" maxlength="10">' +
                '            <label for="income_value" class="">قيمة الدخل' +
                '            </label>' +
                '        </div>' +
                '    </div>' +

                '    <div class="col m4 s12">' +
                '        <div class="input-field col s12">' +
                '            <input id="income_note" name="income_note[]"' +
                '                   type="text">' +
                '            <label for="income_note" class="">ملاحظات الدخل' +
                '            </label>' +
                '        </div>' +
                '    </div>' +

                '    <div class="col m2 s12">' +
                '        <div class="input-field col s12">' +
                '  <button type="button" id="' + i + '" class="btn btn-small delete-row-btn">' +
                '           <i class="ti-close" aria-hidden="true">' +
                '          </i>' +
                '  </button>' +
                '</div>' +
                '</div>');

            $(".numbers").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 1632 || e.which > 1641)) {
                    return false;
                }
            });

            $('select').formSelect();
        });


        $(document).on('click', '.delete-row-btn', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });


    </script>
@endsection


