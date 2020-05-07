@extends('layouts.dashboard.app')

@section('pageTitle','أرشيف استمارة')
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
    </style>

@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الاستمارات')
@section('navigation3','أرشيف استمارة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/families')
@section('navigation3_link','/admin/families/'.$family->id.'/edit')
@section('content')
    @php
        $person = $family->person;
        $wives = $family->wives;
        $members = $family->members;
        $recipient_diseases = $person->diseases->pluck('disease_id')->toArray();
        $family_searcher = $family->searcher->pluck('searcher_id')->toArray();
    @endphp

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        أرشيف استمارة
                        <span style="color: red;">
                                {{ !is_null($person->full_name) ? $person->full_name : $person->first_name .' '. $person->second_name . ' ' . $person->third_name . ' '. $person->family_name }}
                            </span>
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


                                        @php
                                            $ticketTime = strtotime($person->create_at);
                                            $difference = date_diff(new \DateTime($person->created_at), new \DateTime())->format("%d");
                                        @endphp
                                        <form class="kt-form" id="kt_form">
                                            <!--begin: Form Wizard Step 1-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content"
                                                 data-ktwizard-state="current">
                                                <input disabled readonly type="hidden" name="person_id"
                                                       value="{{ $person->id }}">
                                                <!-- Start Row -->
                                                <div class="row">
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">الاسم
                                                                الاول</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control" id="first_name"
                                                                       name="first_name"
                                                                       value="{{ $person->first_name }}"
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
                                                                الاب</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control" id="second_name"
                                                                       name="second_name"
                                                                       placeholder="اسم الاب"
                                                                       value="{{ $person->second_name }}">
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
                                                                الجد</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control" id="third_name"
                                                                       name="third_name"
                                                                       value="{{ $person->third_name }}"
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
                                                                العائلة</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control" id="family_name"
                                                                       name="family_name"
                                                                       value="{{ $person->family_name }}"
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
                                                                الاول بالتركي</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control turkey" id="first_name_tr"
                                                                       name="first_name_tr"
                                                                       value="{{ $person->first_name_tr }}"
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
                                                                الاب بالتركي</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control turkey" id="second_name_tr"
                                                                       name="second_name_tr"
                                                                       value="{{ $person->second_name_tr }}"
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
                                                                الجد بالتركي</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control turkey" id="third_name_tr"
                                                                       name="third_name_tr"
                                                                       value="{{ $person->third_name_tr }}"
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
                                                                العائلة بالتركي</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control turkey" id="family_name_tr"
                                                                       name="family_name_tr"
                                                                       value="{{ $person->family_name_tr }}"
                                                                       placeholder="اسم العائلة بالتركي">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">سنة
                                                                الميلاد</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly 
                                                                       class="form-control numbers" id="date_of_birth"
                                                                       maxlength="4" name="date_of_birth"
                                                                       value="{{ $person->date_of_birth }}"
                                                                       placeholder="سنة الميلاد">
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
                                                                    <option disabled value=" " selected> مكان الميلاد</option>
                                                                    @foreach($countries->sortBy('name') as $country)
                                                                        <option disabled value="{{ $country->id }}" {{ $country->id == $person->date_of_birth_place ? 'selected':'' }}>{{ $country->name }}</option>
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
                                                                    <option disabled value=" " selected> الجنس</option>
                                                                    <option disabled value="M" {{ 'M' == $person->gender ? 'selected':'' }}>
                                                                        ذكر
                                                                    </option>
                                                                    <option disabled value="F" {{ 'F' == $person->gender ? 'selected':'' }}>
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
                                                            <div style="width: 100%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">المعيل</label>
                                                                <select class="form-control "
                                                                        id="breadwinner_id" name="breadwinner_id">
                                                                    <option disabled value=" " selected> المعيل</option>
                                                                    @foreach($relationships->sortBy('name') as $relationship)
                                                                        <option disabled value="{{ $relationship->id }}" {{ (isset($family->breadwinner) && (!is_null($family->breadwinner)) && ($family->breadwinner->status == 0) && ( $relationship->id == 1) ) ? 'selected' : $relationship->id == $family->breadwinner_id ? 'selected':'' }} >{{ $relationship->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if((isset($family->breadwinner) && (!is_null($family->breadwinner)) && ($family->breadwinner->status == 0)))

                                                        <div
                                                                class="col-lg-3 col-md-3 col-xl-3 col-sm-12"
                                                                id="breadwinnerOtherDivEdit">
                                                            <div class="form-group row">
                                                                <label
                                                                        class="col-form-label col-lg-12">المعيل
                                                                </label>
                                                                <div style="width: 95%;">
                                                                    <input disabled readonly type="number"
                                                                           class="form-control"
                                                                           id="breadwinner_other_edit"
                                                                           name="breadwinner_other_edit"
                                                                           value=" {{ $family->breadwinner->name }}"
                                                                           type="text"
                                                                           placeholder="المعيل">
                                                                    <input disabled readonly type="hidden"
                                                                           id="breadwinner_other_id_edit"
                                                                           name="breadwinner_other_id_edit"
                                                                           value="{{ $family->breadwinner->id }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12 d-none"
                                                            id="breadwinnerOtherDiv">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">المعيل
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="number"
                                                                       class="form-control" id="breadwinner_other"
                                                                       name="breadwinner_other"
                                                                       value="{{ (isset($family->breadwinner) && (!is_null($family->breadwinner))) ? $family->breadwinner->name  : '' }}"
                                                                       type="text"
                                                                       placeholder="المعيل">
                                                                <input disabled readonly type="hidden"
                                                                       id="breadwinner_other_id"
                                                                       name="breadwinner_other_id"
                                                                       value="{{   (isset($family->breadwinner) && (!is_null($family->breadwinner))) ? $family->breadwinner->id : '' }}">
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
                                                                    <option disabled value=" " selected> المؤهل العلمي</option>
                                                                    @foreach($qualifications->sortBy('name') as $qualification)
                                                                        <option disabled value="{{ $qualification->id }}" {{ $qualification->id == $person->qualification_id ? 'selected':'' }}>{{ $qualification->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    @if($family->family_project_id == 2)
                                                    <!-- Start col -->
                                                        <div
                                                                class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                            <div class="form-group row">
                                                                <div style="width: 97%;">
                                                                    <label
                                                                            class="col-form-label col-lg-12">مستوى
                                                                        التعليم لليتيم</label>
                                                                    <select class="form-control kt-select2 select2-multi"
                                                                            id="qualification_leverl_id"
                                                                            name="qualification_leverl_id">
                                                                        <option disabled value=" " selected>المستوى التعليمي
                                                                            لليتيم
                                                                        </option>
                                                                        @foreach($qualificationLevels->sortBy('name') as $qualificationLevel)
                                                                            <option disabled value="{{ $qualificationLevel->id }}" {{ $qualificationLevel->id == $person->qualification_level_id ? 'selected':'' }}>{{ $qualificationLevel->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End col -->
                                                    @endif
                                                <!-- Start col -->
                                                    <div
                                                            class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 97%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">نوعية
                                                                    الوثيقة التعليمية</label>
                                                                <select class="form-control "
                                                                        id="id_type_id" name="id_type_id">
                                                                    <option disabled value=" " selected> نوعية الوثيقة
                                                                        التعريفية
                                                                    </option>
                                                                    @foreach($idTypes->sortBy('name') as $id)
                                                                        <option disabled value="{{ $id->id }}"
                                                                                data-count="{{ $id->number }}"
                                                                                type="{{ $id->type }}" {{ $id->id == $person->id_type_id ? 'selected':'' }}>{{ $id->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if(!is_null( $person->id_number))
                                                        <div
                                                                class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                            <div class="form-group row">
                                                                <label
                                                                        class="col-form-label col-lg-12">الوثيقة
                                                                    التعريفية
                                                                </label>
                                                                <div style="width: 95%;">
                                                                    <input disabled readonly class="form-control"
                                                                           id="id_number"
                                                                           name="id_number"
                                                                           value="{{ $person->id_number }}"
                                                                           type="text"
                                                                           placeholder="الوثيقة التعريفية">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div
                                                                class="col-lg-3 col-md-3 col-xl-3 col-sm-12"
                                                                id="idTypeIdDiv">
                                                            <div class="form-group row">
                                                                <label
                                                                        class="col-form-label col-lg-12">الوثيقة
                                                                    التعريفية
                                                                </label>
                                                                <div style="width: 95%;">
                                                                    <input disabled readonly class="form-control"
                                                                           id="id_number"
                                                                           name="id_number"
                                                                           value="{{ $person->id_number }}"
                                                                           type="text"
                                                                           placeholder="الوثيقة التعريفية">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
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
                                                                    <option disabled value=" " selected> الحالة الاجتماعية
                                                                    </option>
                                                                    @foreach($socialStatuses->sortBy('name') as $socialStatus)
                                                                        <option disabled value="{{ $socialStatus->id }}" {{ $socialStatus->id == $person->social_status_id ? 'selected':'' }}>{{ $socialStatus->name }}</option>
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
                                                                    الصحية</label>
                                                                <select class="form-control "
                                                                        id="health_status" name="health_status">
                                                                    <option disabled value=" " selected> الحالة الصحية</option>
                                                                    <option disabled value="1" {{ '1' == $person->health_status ? 'selected':'' }}>
                                                                        مريض
                                                                    </option>
                                                                    <option disabled value="0" {{ '0' == $person->health_status ? 'selected':'' }}>
                                                                        سليم
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    @if($person->health_status == 1)
                                                        <div
                                                                class="col-lg-3 col-md-3 col-xl-3 col-sm-12 d-none"
                                                                id="diseasesDivEdit">
                                                            <div class="form-group row">
                                                                <div style="width: 97%;">
                                                                    <label
                                                                            class="col-form-label col-lg-12">الأمراض
                                                                    </label>
                                                                    <select class="form-control kt-select2 select2-multi"
                                                                            multiple id="family_diseases_edit"
                                                                            name="family_diseases_edit[]">
                                                                        <option disabled value=" " selected> الأمراض</option>
                                                                        @foreach($diseases->sortBy('name') as $disease)
                                                                            <option disabled value="{{ $disease->id }}" {{ isset($recipient_diseases)?in_array($disease->id,$recipient_diseases) ?'selected':'':'' }}>{{ $disease->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
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
                                                                    <option disabled value=" " selected> الأمراض</option>
                                                                    @foreach($diseases->sortBy('name') as $disease)
                                                                        <option disabled value="{{ $disease->id }}">{{ $disease->name }}</option>
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
                                                    <!-- start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">رقم
                                                                الجوال - 1</label>
                                                            <div class="input-group"
                                                                 style="width: 95%;">
                                                                <input disabled readonly 
                                                                       class="form-control numbers"
                                                                       value="{{ $family->mobile_one }}"
                                                                       maxlength="10" minlength="10"
                                                                       id="mobile_one"
                                                                       name="mobile_one"
                                                                       aria-describedby="basic-addon1">
                                                                <div
                                                                        class="input-group-prepend">
																							<span
                                                                                                    class="input-group-text">
																								<span class="fa fa-phone"></span>
																								970+</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">رقم
                                                                الجوال - 2</label>
                                                            <div class="input-group"
                                                                 style="width: 95%;">
                                                                <input disabled readonly
                                                                       class="form-control numbers"
                                                                       id="mobile_two"
                                                                       maxlength="10" minlength="10"
                                                                       value="{{ $family->mobile_two }}"
                                                                       name="mobile_two"
                                                                       aria-describedby="basic-addon1">
                                                                <div
                                                                        class="input-group-prepend">
																							<span
                                                                                                    class="input-group-text">
																								<span class="fa fa-phone"></span>
																								970+</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">رقم
                                                                التيلفون</label>
                                                            <div class="input-group"
                                                                 style="width: 95%;">
                                                                <input disabled readonly 
                                                                       class="form-control numbers"
                                                                       id="telephone"
                                                                       name="telephone" value="{{ $family->telephone }}"
                                                                       maxlength="7" minlength="7"
                                                                       aria-describedby="basic-addon1">
                                                                <div
                                                                        class="input-group-prepend">
																							<span
                                                                                                    class="input-group-text">9708+</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                </div>
                                                <!-- End row -->
                                            </div>
                                            <!--end: Form Wizard registeredp 2-->
                                            <!--begin: Form Wizard Step 3-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content">
                                                <!-- start row -->
                                                <div class="row">
                                                    @if(!is_null($family->previous_income_value))
                                                        <div
                                                                class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
                                                            <div class="form-group row">
                                                                <label
                                                                        class="col-form-label col-lg-12">
                                                                    الدخل الشهري بالشيكل
                                                                    ( سابقاً )
                                                                </label>
                                                                <div style="width: 95%;">
                                                                    <input disabled readonly type="text"
                                                                           class="form-control numbers" name=""
                                                                           disabled
                                                                           maxlength="10"
                                                                           value="{{ $family->previous_income_value }}"
                                                                           placeholder="مجموع الدخل الشهري بالشيكل">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if(!is_null($family->previous_income_coupon))
                                                        <div
                                                                class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
                                                            <div class="form-group row">
                                                                <label
                                                                        class="col-form-label col-lg-12">
                                                                    الدخل الشهري بالشيكل
                                                                    ( سابقاً )
                                                                </label>
                                                                <div style="width: 95%;">
                                                                    <textarea
                                                                            class="form-control" name=""
                                                                            disabled>
                                                                        {{ $family->previous_income_coupon }}
                                                                    </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                @endif
                                                <!-- start col -->
                                                    <div
                                                            class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">مجموع
                                                                الدخل الشهري بالشيكل</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control"
                                                                       id="total_income_value" name="total_income_value"
                                                                       value="{{ $family->total_income_value }}"
                                                                       disabled
                                                                       placeholder="مجموع الدخل الشهري بالشيكل">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- start col -->
                                                    <div
                                                            class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 97%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">حالة
                                                                    العمل</label>
                                                                <select
                                                                        class="form-control "
                                                                        id="work" name="work">
                                                                    <option disabled value=" " selected> الحالة العمل</option>
                                                                    <option disabled value="1" {{ '1' == $person->work ? 'selected':'' }}>
                                                                        يعمل
                                                                    </option>
                                                                    <option disabled value="0" {{ '0' == $person->work ? 'selected':'' }}>
                                                                        لا يعمل
                                                                    </option>
                                                                </select>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <hr style="width: 100%">
                                                    <div class="row {{ $person->work == 1 ?  '' : 'd-none' }}"
                                                         id="workDiv">
                                                        <div class=" col-lg-3 col-md-4">
                                                            <div class="form-group row">
                                                                <label class="col-form-label col-lg-12">جهات
                                                                    الدخل</label>
                                                                <div style="width: 95%;">
                                                                    <select class="form-control" id="job_type_id"
                                                                            name="job_type_id">
                                                                        <option disabled value=" " selected> نوع العمل</option>
                                                                        @foreach($jobTypes->sortBy('name') as $jobType)
                                                                            <option disabled value="{{ $jobType->id }}" {{ $jobType->id == $family->job_type_id ? 'selected':'' }}>{{ $jobType->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End col -->
                                                        <!-- Start col -->
                                                        <div class="col-lg-3 col-md-4">
                                                            <div class="form-group row">
                                                                <label class="col-form-label col-lg-12">قيمة
                                                                    الدخل</label>
                                                                <div style="width: 86%;">
                                                                    <input disabled readonly 
                                                                           class="form-control numbers"
                                                                           id="income_value" name="income_value"
                                                                           value="{{ $family->income_value }}"
                                                                           maxlength="10" placeholder="قيمة الدخل">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End col -->
                                                    </div>
                                                    <hr style="width: 100%">
                                                    <div class="row ">
                                                        @if(isset($family->incomes))
                                                            @foreach($family->incomes as $key => $income)
                                                                <div class=" col-lg-3 col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-form-label col-lg-12">جهات
                                                                            الدخل</label>
                                                                        <div style="width: 95%;">
                                                                            <select class="form-control"
                                                                                    id="income_type_id"
                                                                                    name="income_type_id[]">
                                                                                <option disabled value=" " selected> جهات الدخل
                                                                                </option>
                                                                                @foreach($incomeTypes->sortBy('name') as $incomeType)
                                                                                    <option disabled value="{{ $incomeType->id }}" {{ $incomeType->id == $income->income_type_id ? 'selected':'' }}>{{ $incomeType->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- End col -->
                                                                <!-- Start col -->
                                                                <div class="col-lg-3 col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-form-label col-lg-12">قيمة
                                                                            الدخل</label>
                                                                        <div style="width: 86%;">
                                                                            <input disabled readonly 
                                                                                   class="form-control numbers"
                                                                                   id="income_value"
                                                                                   value="{{ $income->value }}"
                                                                                   name="income_type_value[]"
                                                                                   maxlength="10"
                                                                                   placeholder="قيمة الدخل">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- End col -->
                                                                <!-- Start col -->
                                                                <div class="col-lg-4 col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-form-label col-lg-12">ملاحظات
                                                                            الدخل</label>
                                                                        <div style="width: 86%;">
                                                                            <input disabled readonly type="text"
                                                                                   class="form-control"
                                                                                   id="income_note"
                                                                                   value="{{ $income->note }}"
                                                                                   name="income_note[]"
                                                                                   placeholder="ملاحظات الدخل">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <input disabled readonly type="hidden" name="incomeCount"
                                                                   value="{{ count($family->incomes)  }}">
                                                        @endif
                                                    </div>

                                                    <!-- Start col -->
                                                    <div class="col-lg-2 col-md-2">
                                                        <!-- <label class="col-form-label col-lg-12" style="opacity: 0;">اضافة جهة دخل</label> -->
                                                        <input disabled readonly type="button"
                                                               class="btn btn-success btn-elevate "
                                                               value="اضافة جهة دخل"
                                                               onclick="addRow()">
                                                    </div>
                                                    <!-- End col -->
                                                </div>
                                                <!-- End row -->
                                                <!-- Start row -->
                                                <div id="content">

                                                </div>
                                                <!-- End row -->
                                            </div>
                                            <!--end: Form Wizard Step 3-->
                                            <!--begin: Form Wizard Step 4-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content">
                                                <!-- start row -->
                                                <div class="row">
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">المحافظة</label>
                                                                <select
                                                                        class="form-control "
                                                                        id="governorate_id" name="governorate_id">
                                                                    <option disabled value=" " selected> المحافظة</option>
                                                                    @foreach($governorates->sortBy('name') as $governorate)
                                                                        <option disabled value="{{ $governorate->id }}" {{ $governorate->id == $family->governorate_id ? 'selected':'' }}>{{ $governorate->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">المدينة</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="city_id" name="city_id">
                                                                    <option disabled value=" " selected> المدينة</option>
                                                                    @foreach($cities->sortBy('name') as $city)
                                                                        <option disabled value="{{ $city->id }}" {{ $city->id == $family->city_id ? 'selected':'' }}>{{ $city->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">المنطقة</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="neighborhood_id" name="neighborhood_id">
                                                                    <option disabled value=" " selected> الحي</option>
                                                                    @foreach($neighborhoods->sortBy('name') as $neighborhood)
                                                                        <option disabled value="{{ $neighborhood->id }}" {{ $neighborhood->id == $family->neighborhood_id ? 'selected':'' }}>{{ $neighborhood->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">العنوان</label>
                                                                <input disabled readonly type="text"
                                                                       class="form-control" name="address"
                                                                       value="{{ $family->address }}"
                                                                       placeholder="العنوان">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">نوع
                                                                    السكن</label>
                                                                <select
                                                                        class="form-control kt-select2 select2-multi"
                                                                        id="house_roof_id" name="house_roof_id">
                                                                    <option disabled value=" " selected> نوع السكن</option>
                                                                    @foreach($houseRoofs->sortBy('name') as $houseRoof)
                                                                        <option disabled value="{{ $houseRoof->id }}" {{ $houseRoof->id == $family->house_roof_id ? 'selected':'' }}>{{ $houseRoof->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">ملكية
                                                                    السكن</label>
                                                                <select
                                                                        class="form-control "
                                                                        id="house_ownership_id"
                                                                        name="house_ownership_id">
                                                                    <option disabled value=" " selected> ملكية السكن</option>
                                                                    @foreach($houseOwners->sortBy('name') as $houseOwner)
                                                                        <option disabled value="{{ $houseOwner->id }}" {{ $houseOwner->id == $family->house_ownership_id ? 'selected':'' }}>{{ $houseOwner->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12 {{ $family->house_ownership_id == 2 ? '' : 'd-none' }}"
                                                            id="rentValueDiv">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">قيمة
                                                                    الايجار</label>
                                                                <input disabled readonly 
                                                                       class="form-control numbers" name="rent_value"

                                                                       maxlength="10"
                                                                       value="{{ $family->rent_value }}"
                                                                       placeholder="قيمة الايجار">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">وضع
                                                                    السكن</label>
                                                                <select
                                                                        class="form-control kt-select2 select2-multi"
                                                                        id="house_status_id" name="house_status_id">
                                                                    <option disabled value=" " selected> وضع السكن</option>
                                                                    @foreach($houseStatuses->sortBy('name') as $houseStatus)
                                                                        <option disabled value="{{ $houseStatus->id }}" {{ $houseStatus->id == $family->house_status_id ? 'selected':'' }}>{{ $houseStatus->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">وضع
                                                                    الاثاث</label>
                                                                <select
                                                                        class="form-control kt-select2 select2-multi"
                                                                        id="furniture_status_id"
                                                                        name="furniture_status_id">
                                                                    <option disabled value=" " selected> وضع الاثاث</option>
                                                                    @foreach($furnitureStatuses->sortBy('name') as $furnitureStatus)
                                                                        <option disabled value="{{ $furnitureStatus->id }}" {{ $furnitureStatus->id == $family->furniture_status_id ? 'selected':'' }}>{{ $furnitureStatus->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 90%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">عدد
                                                                    الغرف</label>
                                                                <input disabled readonly type="number"
                                                                       class="form-control" id="room_number"
                                                                       name="room_number"
                                                                       value="{{ $family->room_number }}"
                                                                       placeholder="عدد الغرف">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                </div>
                                                <!-- End row -->
                                            </div>
                                            <!--end: Form Wizard Step 4-->
                                            <!--begin: Form Wizard Step 5-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content">
                                            @php $representative =  isset($family->representative) ? $family->representative : null ;@endphp

                                            <!-- start row -->
                                                <div class="row">
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">صلة
                                                                    القرابة</label>
                                                                <select class="form-control"
                                                                        id="representative_relationship_id"
                                                                        name="representative_relationship_id">
                                                                    <option disabled value=" " selected>صلة القرابة</option>
                                                                    @foreach($relationships->sortBy('name') as $relationship)
                                                                        <option disabled value="{{ $relationship->id }}" {{ (isset($family->representative_relationship) && (!is_null($family->representative_relationship)) && ($family->representative_relationship->status == 0) && ( $relationship->id == 1) ) ? 'selected' : $relationship->id == $family->representative_relationship_id ? 'selected':'' }} >{{ $relationship->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">رقم
                                                                    هوية الوكيل</label>
                                                                <input disabled readonly 
                                                                       class="form-control numbers" id="representative_id"
                                                                       value="{{ !is_null($representative) ? $representative->id_number :null }}"
                                                                       name="representative_id_number" maxlength="9"
                                                                       placeholder="رقم هوية الوكيل">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    @if((isset($family->representative_relationship) && (!is_null($family->representative_relationship)) && ($family->representative_relationship->status == 0)))
                                                        <div
                                                                class="col-lg-4 col-md-4 col-xl-4 col-sm-12"
                                                                id="representativeRelationshipOtherDivEdit">
                                                            <div class="form-group row">
                                                                <div style="width: 95%;">
                                                                    <label
                                                                            class="col-form-label col-lg-12">المعيل</label>
                                                                    <input disabled readonly type="text"
                                                                           class="form-control"
                                                                           id="representative_relationship_other_edit"
                                                                           value="{{ $family->representative_relationship->name }}"
                                                                           name="representative_relationship_other_edit"
                                                                           placeholder="المعيل">
                                                                    <input disabled readonly type="hidden"
                                                                           id="representative_relationship_other_id_edit"
                                                                           name="representative_relationship_other_id_edit"
                                                                           value="{{ $family->representative_relationship->id }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12 d-none"
                                                            id="representativeRelationshipOtherDiv">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">صلة
                                                                    القرابة</label>
                                                                <input disabled readonly type="text"
                                                                       class="form-control"
                                                                       id="representative_relationship_other"
                                                                       value="{{ (isset($family->representative_relationship) && (!is_null($family->representative_relationship))) ? $family->representative_relationship->name  : '' }}"
                                                                       name="representative_relationship_other"
                                                                       placeholder="صلة القرابة">
                                                                <input disabled readonly type="hidden"
                                                                       id="representative_relationship_other_id"
                                                                       name="representative_relationship_other_id"
                                                                       value="{{   (isset($family->representative_relationship) && (!is_null($family->representative_relationship))) ? $family->representative_relationship->id : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    @if((!is_null($representative)) && (!is_null($representative->full_name)))
                                                        <div
                                                                class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                            <div class="form-group row">
                                                                <div style="width: 95%;">
                                                                    <label
                                                                            class="col-form-label col-lg-12">الاسم
                                                                        الكامل
                                                                        للوكيل</label>
                                                                    <input disabled readonly type="text"
                                                                           class="form-control"
                                                                           id="representative_full_name"
                                                                           value="{{  $representative->full_name }}"
                                                                           name="representative_full_name"
                                                                           placeholder="الاسم الكامل للوكيل">
                                                                </div>
                                                            </div>
                                                        </div>
                                                @endif
                                                <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">الاسم
                                                                    الاول للوكيل</label>
                                                                <input disabled readonly type="text"
                                                                       class="form-control"
                                                                       id="representative_first_name"
                                                                       value="{{ !is_null($representative) ? $representative->first_name : null }}"
                                                                       name="representative_first_name"
                                                                       placeholder="الاسم الاول للوكيل">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">اسم
                                                                    الاب للوكيل</label>
                                                                <input disabled readonly type="text"
                                                                       class="form-control"
                                                                       id="representative_second_name"
                                                                       value="{{  !is_null($representative) ? $representative->second_name : null }}"
                                                                       name="representative_second_name"
                                                                       placeholder="اسم الاب للوكيل">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">اسم
                                                                    الجد للوكيل</label>
                                                                <input disabled readonly type="text"
                                                                       class="form-control"
                                                                       id="representative_third_name"
                                                                       value="{{  !is_null($representative) ? $representative->third_name : null }}"
                                                                       name="representative_third_name"
                                                                       placeholder="اسم الجد للوكيل">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">اسم
                                                                    العائلة للوكيل</label>
                                                                <input disabled readonly type="text"
                                                                       class="form-control"
                                                                       id="representative_family_name"
                                                                       value="{{  !is_null($representative) ? $representative->family_name : null }}"
                                                                       name="representative_family_name"
                                                                       placeholder="اسم العائلة للوكيل">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">نوع
                                                                    عمل الوكيل</label>
                                                                <select
                                                                        class="form-control kt-select2 select2-multi"
                                                                        id="representative_job_type_id"
                                                                        name="representative_job_type_id">
                                                                    <option disabled value=" " selected>نوع العمل للوكيل</option>
                                                                    @foreach($jobTypes->sortBy('name') as $jobType)
                                                                        <option disabled value="{{ $jobType->id }}" {{ $jobType->id == $family->representative_job_type_id ? 'selected':'' }}>{{ $jobType->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-8 col-md-8 col-xl-8 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 97%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">سبب
                                                                    الوكالة</label>
                                                                <input disabled readonly type="text"
                                                                       class="form-control" id="representative_reason"
                                                                       name="representative_reason"
                                                                       value="{{ $family->representative_reason }}"
                                                                       placeholder="سبب الوكالة">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                </div>
                                                <!-- End row -->
                                            </div>
                                            <!--end: Form Wizard Step 5-->
                                            <!--begin: Form Wizard Step 6-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content">
                                                <!-- start row -->
                                                <div class="row">
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">تصنيف
                                                                    الحالة</label>
                                                                <select class="form-control "
                                                                        id="family_type_id" name="family_type_id">
                                                                    <option disabled value=" " selected> تصنيف الحالة</option>
                                                                    @foreach($types->sortBy('name') as $type)
                                                                        <option disabled value="{{ $type->id }}" {{ $type->id == $family->family_type_id ? 'selected':'' }}>{{ $type->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12 {{ $family->family_type_id == 7 ? '' : 'd-none' }}"
                                                            id="UNDiv">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12"> الرقم
                                                                الجامعي</label>
                                                            <div style="width: 90%;">
                                                                <input disabled readonly type="number"
                                                                       class="form-control" id="id_university"
                                                                       value="{{ $family->id_university }}"
                                                                       name="id_university"
                                                                       placeholder=" الرقم الجامعي"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">نوع
                                                                    الدراسة</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="study_type_id" name="study_type_id">
                                                                    <option disabled value=" " selected> نوع الدراسة</option>
                                                                    @foreach($studyTypes->sortBy('name') as $studyType)
                                                                        <option disabled value="{{ $studyType->id }}" {{ $studyType->id == $family->study_type_id ? 'selected':'' }}>{{ $studyType->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">جهة
                                                                    الدراسة</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="study_part_id" name="study_part_id">
                                                                    <option disabled value=" " selected> جهة الدراسة</option>
                                                                    @foreach($studyParts->sortBy('name') as $studyPart)
                                                                        <option disabled value="{{ $studyPart->id }}" {{ $studyPart->id == $family->study_part_id ? 'selected':'' }}>{{ $studyPart->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Start col -->
                                                    <!-- End col -->
                                                    <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">المؤسسة
                                                                    التعليمية</label>
                                                                <select class="form-control "
                                                                        id="educational_institution_id"
                                                                        name="educational_institution_id">
                                                                    <option disabled value=" " selected> المؤسسة التعليمية
                                                                    </option>
                                                                    @foreach($educationalInstitutions->sortBy('name') as $educationalInstitution)
                                                                        <option disabled value="{{ $educationalInstitution->id }}" {{ (isset($family->educational_institution) && (!is_null($family->educational_institution)) && ($family->educational_institution->status == 0) && ( $educationalInstitution->id == 1) ) ? 'selected' : $educationalInstitution->id == $family->educational_institution_id ? 'selected':'' }} >{{ $educationalInstitution->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @if((isset($family->educational_institution) && (!is_null($family->educational_institution)) && ($family->educational_institution->status == 0)))
                                                            <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12"
                                                                 id="educationalInstitutionOtherDivEdit">
                                                                <div class="form-group row">
                                                                    <label
                                                                            class="col-form-label col-lg-12">اسم المؤسسة
                                                                        التعليمية</label>
                                                                    <div style="width: 90%;">
                                                                        <input disabled readonly type="text"
                                                                               class="form-control"
                                                                               id="educational_institution_other_edit"
                                                                               value="{{ $family->educational_institution->name }}"
                                                                               name="educational_institution_other_edit">
                                                                        <input disabled readonly type="hidden"
                                                                               id="educational_institution_other_other_id_edit"
                                                                               name="educational_institution_other_id_edit"
                                                                               value="{{ $family->educational_institution->id }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12 d-none"
                                                         id="educationalInstitutionOtherDiv">

                                                        <div class="form-group row ">
                                                            <label
                                                                    class="col-form-label col-lg-12">اسم المؤسسة
                                                                التعليمية</label>
                                                            <div style="width: 90%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control"
                                                                       id="educational_institution_other"
                                                                       value="{{ (isset($family->educational_institution) && (!is_null($family->educational_institution))) ? $family->educational_institution->name  : '' }}"
                                                                       name="educational_institution_other">
                                                                <input disabled readonly type="hidden"
                                                                       id="educational_institution_other_id"
                                                                       name="educational_institution_other_id"
                                                                       value="{{   (isset($family->educational_institution) && (!is_null($family->educational_institution))) ? $family->educational_institution->id : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">المستوى
                                                                    الجامعي</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="study_level_id" name="study_level_id">
                                                                    <option disabled value=" " selected> المستوى الجامعي
                                                                    </option>
                                                                    @foreach($studyLevels->sortBy('name') as $studyLevel)
                                                                        <option disabled value="{{ $studyLevel->id }}" {{ $studyLevel->id == $family->study_level_id ? 'selected':'' }}>{{ $studyLevel->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">التخصص
                                                                    الجامعي</label>
                                                                <select class="form-control "
                                                                        id="university_specialty_id"
                                                                        name="university_specialty_id">
                                                                    <option disabled value=" " selected> التخصص الجامعي
                                                                    </option>
                                                                    @foreach($universitySpecialties->sortBy('name') as $universitySpecialty)
                                                                        <option disabled value="{{ $universitySpecialty->id }}" {{ (isset($family->university_specialty) && (!is_null($family->university_specialty)) && ($family->university_specialty->status == 0) && ( $universitySpecialty->id == 1) ) ? 'selected' : $universitySpecialty->id == $family->university_specialty_id ? 'selected':'' }} >{{ $universitySpecialty->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if((isset($family->university_specialty) && (!is_null($family->university_specialty)) && ($family->university_specialty->status == 0)))
                                                        <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12"
                                                             id="universitySpecialtyDivEdit">
                                                            <div class="form-group row">
                                                                <label
                                                                        class="col-form-label col-lg-12">التخصص
                                                                    الجامعي</label>
                                                                <div style="width: 90%;">
                                                                    <input disabled readonly type="text"
                                                                           class="form-control"
                                                                           id="university_specialty_other_edit"
                                                                           value="{{ $family->university_specialty->name }}"
                                                                           name="university_specialty_other_edit">
                                                                    <input disabled readonly type="hidden"
                                                                           id="university_specialty_other_other_id_edit"
                                                                           name="university_specialty_other_id_edit"
                                                                           value="{{ $family->university_specialty->id }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12 d-none"
                                                         id="universitySpecialtyDiv">
                                                        <div class="form-group row ">
                                                            <label
                                                                    class="col-form-label col-lg-12">التخصص
                                                                الجامعي</label>
                                                            <div style="width: 90%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control"
                                                                       id="university_specialty_other"
                                                                       value="{{ (isset($family->university_specialty) && (!is_null($family->university_specialty))) ? $family->university_specialty->name  : '' }}"
                                                                       name="university_specialty_other">
                                                                <input disabled readonly type="hidden"
                                                                       id="university_specialty_other"
                                                                       name="university_specialty_other_id"
                                                                       value="{{   (isset($family->university_specialty) && (!is_null($family->university_specialty))) ? $family->university_specialty->id : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <label class="col-form-label col-lg-12"> التاريخ المتوقع
                                                                للتخرج</label>
                                                            <input disabled readonly
                                                                   class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                   type="text"
                                                                   id="graduated_date"
                                                                   value="{{ !is_null($family->graduated_date) ? date('Y-m-d', strtotime($family->graduated_date)) : null}}"
                                                                   style="width: 90%">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12"> قيمة الساعة
                                                                الدراسية
                                                            </label>
                                                            <div style="width: 90%;">
                                                                <input disabled readonly type="number"
                                                                       class="form-control" id="study_hour_price"
                                                                       value="{{ $family->study_hour_price }}"
                                                                       name="study_hour_price"
                                                                       placeholder="قيمة الساعة الدراسية">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Start col -->
                                                    <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12 {{ $family->family_type_id == 5 ? '' : 'd-none' }}"
                                                         id="fatherLessDiv">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">سبب وفاة الام
                                                            </label>
                                                            <div style="width: 90%;">
                                                                <input disabled readonly type="number"
                                                                       class="form-control" id="mother_death_reason"
                                                                       value="{{ $family->mother_death_reason }}"
                                                                       name="mother_death_reason"
                                                                       placeholder="سبب وفاة الام">
                                                            </div>
                                                        </div>
                                                        @if(!is_null($family->mother_death_date_old))
                                                            <div class="form-group row">
                                                                <label class="col-form-label col-lg-12"> تاريخ وفاة الام
                                                                    (الارشيف )</label>
                                                                <input disabled readonly
                                                                       class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                       type="text"
                                                                       value="{{ $family->mother_death_date_old }}"
                                                                       style="width: 90%">
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-form-label col-lg-12"> تاريخ وفاة الام
                                                                </label>
                                                                <input disabled readonly
                                                                       class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                       type="text"
                                                                       id="mother_death_date"
                                                                       value="{{ !is_null($family->mother_death_date) ? date('Y-m-d', strtotime($family->mother_death_date)) : null}}"
                                                                       name="mother_death_date"
                                                                       style="width: 90%">
                                                            </div>
                                                        @else
                                                            <div class="form-group row">
                                                                <label class="col-form-label col-lg-12"> تاريخ وفاة الام
                                                                </label>
                                                                <input disabled readonly
                                                                       class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                       type="text"
                                                                       id="mother_death_date"
                                                                       value="{{ !is_null($family->mother_death_date) ? date('Y-m-d', strtotime($family->mother_death_date)) : null}}"
                                                                       name="mother_death_date"
                                                                       style="width: 90%">
                                                            </div>
                                                        @endif
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">سبب وفاة الأب
                                                            </label>
                                                            <div style="width: 90%;">
                                                                <input disabled readonly type="number"
                                                                       class="form-control" id="father_death_reason"
                                                                       value="{{ $family->father_death_reason }}"
                                                                       name="father_death_reason"
                                                                       placeholder="سبب وفاة الأب">
                                                            </div>
                                                        </div>
                                                        @if(!is_null($family->father_death_date_old))
                                                            <div class="form-group row">
                                                                <label class="col-form-label col-lg-12"> تاريخ وفاة الأب
                                                                    (الارشيف )</label>
                                                                <input disabled readonly
                                                                       class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                       type="text"
                                                                       value="{{ $family->father_death_date_old }}"
                                                                       style="width: 90%">
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-form-label col-lg-12"> تاريخ وفاة الأب
                                                                </label>
                                                                <input disabled readonly
                                                                       class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                       type="text"
                                                                       id="father_death_date"
                                                                       value="{{ !is_null($family->father_death_date) ? date('Y-m-d', strtotime($family->father_death_date)) : null}}"
                                                                       name="father_death_date"
                                                                       style="width: 90%">
                                                            </div>
                                                        @else
                                                            <div class="form-group row">
                                                                <label class="col-form-label col-lg-12"> تاريخ وفاة الأب
                                                                </label>
                                                                <input disabled readonly
                                                                       class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                       type="text"
                                                                       id="father_death_date"
                                                                       value="{{ !is_null($family->father_death_date) ? date('Y-m-d', strtotime($family->father_death_date)) : null}}"
                                                                       name="father_death_date"
                                                                       style="width: 90%">
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">تصنيف
                                                                    المشروع</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        name="family_project_id">
                                                                    <option disabled value=" " selected>تصنيف المشروع</option>
                                                                    @foreach($projects->sortBy('name') as $project)
                                                                        <option disabled value="{{ $project->id }}" {{ $project->id == $family->family_project_id ? 'selected':'' }}>{{ $project->name .' '}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">الجهة
                                                                    المرشحة</label>
                                                                <select class="form-control "
                                                                        id="funded_institution_id"
                                                                        name="funded_institution_id">
                                                                    <option disabled value=" " selected>الجهة المرشحة</option>
                                                                    @foreach($fundedInstitutions->sortBy('name') as $fundedInstitution)
                                                                        <option disabled value="{{ $fundedInstitution->id }}" {{ (isset($family->fundedInstitution) && (!is_null($family->fundedInstitution)) && ($family->fundedInstitution->status == 0) && ( $fundedInstitution->id == 1) ) ? 'selected' : $fundedInstitution->id == $family->funded_institution_id ? 'selected':'' }} >{{ $fundedInstitution->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        @if((isset($family->fundedInstitution) && (!is_null($family->fundedInstitution)) && ($family->fundedInstitution->status == 0)))
                                                            <div class="form-group row"
                                                                 id="fundedInstitutionOtherDivEdit">
                                                                <label
                                                                        class="col-form-label col-lg-12"> الجهة المرشحة
                                                                </label>
                                                                <div style="width: 90%;">
                                                                    <input disabled readonly type="text"
                                                                           class="form-control"
                                                                           id="funded_institution_other_edit"
                                                                           value="{{ $family->fundedInstitution->name }}"
                                                                           name="funded_institution_other_edit"
                                                                           placeholder="الجهة المرشحة">
                                                                    <input disabled readonly type="hidden"
                                                                           id="funded_institution_other_id_edit"
                                                                           name="funded_institution_other_id_edit"
                                                                           value="{{ $family->fundedInstitution->id }}">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="form-group row  d-none"
                                                             id="fundedInstitutionOtherDiv">
                                                            <label
                                                                    class="col-form-label col-lg-12"> الجهة المرشحة
                                                            </label>
                                                            <div style="width: 90%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control"
                                                                       id="funded_institution_other"
                                                                       value="{{ (isset($family->fundedInstitution) && (!is_null($family->fundedInstitution))) ? $family->fundedInstitution->name  : '' }}"
                                                                       name="funded_institution_other"
                                                                       placeholder="الجهة المرشحة">
                                                                <input disabled readonly type="hidden"
                                                                       id="funded_institution_other_id"
                                                                       name="funded_institution_other_id"
                                                                       value="{{   (isset($family->fundedInstitution) && (!is_null($family->fundedInstitution))) ? $family->fundedInstitution->id : '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row  d-none" id="fundedInstitutionDiv">
                                                            <label
                                                                    class="col-form-label col-lg-12"> الجهة المرشحة
                                                            </label>
                                                            <div style="width: 90%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control"
                                                                       id="funded_institution_other"
                                                                       name="funded_institution_other"
                                                                       placeholder="الجهة المرشحة">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">تقييم
                                                                    الحالة</label>
                                                                <select
                                                                        class="form-control kt-select2 select2-multi"
                                                                        id="need" name="need">
                                                                    <option disabled value=" " selected>تقييم الحالة</option>
                                                                    <option disabled value="1" {{ '1' == $family->need ? 'selected':'' }}>
                                                                        يحتاج
                                                                    </option>
                                                                    <option disabled value="0" {{ '0' == $family->need ? 'selected':'' }}>
                                                                        لا يحتاج
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">وضع
                                                                    الحالة</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="family_status_id" name="family_status_id">
                                                                    <option disabled value=" " selected>وضع الحالة</option>
                                                                    @foreach($statuses->sortBy('name') as $status)
                                                                        <option disabled value="{{ $status->id }}" {{ $status->id == $family->family_status_id ? 'selected':'' }}>{{ $status->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">الباحث</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="searcher_id" multiple name="searcher_id[]">
                                                                    <option disabled value=" ">الباحث</option>
                                                                    @foreach($users->sortBy('name') as $user)
                                                                        <option disabled value="{{ $user->id }}" {{ isset($family_searcher)?in_array($user->id,$family_searcher) ?'selected':'':'' }}>{{ $user->full_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">مدخل
                                                                الحالة</label>
                                                            <div style="width: 90%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control" id="data_entry_id"
                                                                       name="data_entry_id"
                                                                       placeholder="الادمن"
                                                                       value="{{ auth()->user()->user_name }}"
                                                                       disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">تاريخ
                                                                فتح الاستمارة</label>
                                                            <div style="width: 90%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control" name=""
                                                                       value="{{ date('Y-m-d', strtotime($family->created_at)) }}"
                                                                       placeholder="تاريخ فتح الحالة"
                                                                       disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                        <div class="form-group row">
                                                            <div style="width: 95%;">
                                                                <label
                                                                        class="col-form-label col-lg-12">نوع
                                                                    الزيارة</label>
                                                                <select class="form-control "
                                                                        id="visit_reason_id" name="visit_reason_id">
                                                                    <option disabled value=" " selected> نوع الزيارة</option>
                                                                    @foreach($visitReasons->sortBy('name') as $visit)
                                                                        <option disabled value="{{ $visit->id }}" {{ (isset($family->visit_reason) && (!is_null($family->visit_reason)) && ($family->visit_reason->status == 0) && ( $visit->id == 1) ) ? 'selected' : $visit->id == $family->visit_reason_id ? 'selected':'' }} >{{ $visit->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    @if((isset($family->visit_reason) && (!is_null($family->visit_reason)) && ($family->visit_reason->status == 0)))

                                                        <div class="col-lg-12 col-md-12 col-xl-12 col-sm-12"
                                                             id="visitReasonDivEdit">
                                                            <div class="form-group row">
                                                                <label
                                                                        class="col-form-label col-lg-12"> نوع
                                                                    الزيارة</label>
                                                                <div style="width: 97%;">
                                                                    <input disabled readonly type="text"
                                                                           id="visit_reason_other_edit"
                                                                           value="{{ $family->visit_reason->name }}"
                                                                           name="visit_reason_other_edit">
                                                                    <input disabled readonly type="hidden"
                                                                           id="visit_reason_other_id_edit"
                                                                           name="visit_reason_other_id_edit"
                                                                           value="{{ $family->visit_reason->id }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-lg-12 col-md-12 col-xl-12 col-sm-12 d-none"
                                                         id="visitReasonDiv">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12"> نوع
                                                                الزيارة</label>
                                                            <div style="width: 97%;">
                                                                <input disabled readonly type="text"
                                                                       id="visit_reason_other"
                                                                       name="visit_reason_other">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <div class="col-lg-12 col-md-12 col-xl-12 col-sm-12 {{ ( $family->visit_reason_id == 3 ) ? '' : 'd-none' }}"
                                                         id="visitReasonMissionDiv">
                                                        <div class="form-group row">
                                                            <label class="col-form-label col-lg-12"> تاريخ التكليف
                                                            </label>
                                                            <input disabled readonly
                                                                   class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                   type="text"
                                                                   id="visit_mission_date"
                                                                   value="{{ $family->visit_mission_date }}"
                                                                   name="visit_mission_date"
                                                                   style="width: 90%">
                                                        </div>
                                                    </div>
                                                    <!-- Start col -->
                                                    <div class="col-lg-12 col-md-12 col-xl-12 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">ملاحظات</label>
                                                            <div style="width: 97%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control" id="note" name="note"
                                                                       value="{{ $family->note }}"
                                                                       placeholder="ملاحظات">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-12 col-md-12 col-xl-12 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">ملاحظات
                                                                الباحث</label>
                                                            <div style="width: 97%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control" id="searcher_note"
                                                                       name="searcher_note"
                                                                       value="{{ $family->searcher_note }}"
                                                                       placeholder="ملاحظات الباحث">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-12 col-md-12 col-xl-12 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">ملاحظات
                                                                الباحث بالتركي</label>
                                                            <div style="width: 97%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control" id="note_turkey"
                                                                       name="note_turkey"
                                                                       value="{{ $family->note_turkey }}"
                                                                       placeholder="ملاحظات الباحث بالتركي">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">كود
                                                                الحالة</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="text"
                                                                       class="form-control" id="code" name="code"
                                                                       value="{{ $family->code }}"
                                                                       disabled
                                                                       placeholder="كود الحالة">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">عدد
                                                                الزيارات</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="number"
                                                                       class="form-control" name="visit_date"
                                                                       value="{{ $family->visit_date }}"
                                                                       placeholder="عدد الزيارات">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                </div>
                                                <!-- End row -->
                                            </div>
                                            <!--end: Form Wizard Step 6-->
                                            <!--begin: Form Wizard Step 7-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content">

                                                <!-- start row -->
                                                <div class="row">
                                                    <!-- Start col -->

                                                    <!-- End col -->
                                                </div>
                                                <!-- End row -->
                                                <!-- start row -->
                                                <div class="row">
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">عدد
                                                                الزوجات</label>
                                                            <div style="width: 95%;">
                                                                <input disabled readonly type="number"
                                                                       class="form-control" id="wive_count"
                                                                       name="wive_count"
                                                                       value="{{ $family->wives->count() }}"
                                                                       placeholder="عدد الزوجات">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div
                                                            class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
                                                        <div class="form-group row">
                                                            <label
                                                                    class="col-form-label col-lg-12">عدد
                                                                الافراد</label>
                                                            <div style="width: 100%;">
                                                                <input disabled readonly type="number"
                                                                       class="form-control" id="member_count"
                                                                       name="member_count"
                                                                       value="{{$family->members->count()}}"
                                                                       placeholder="عدد الافراد">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- End col -->
                                                </div>
                                                <!-- End row -->
                                                <hr style="width: 100%">
                                                <!-- Start Row -->
                                                <div class="row">
                                                    <!-- Start Table -->
                                                    <!-- Start Table  -->
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr class="text-center">
                                                            <th>الاسم كامل بالعربية</th>
                                                            <th>رقم الهوية</th>
                                                            <th>صلة القرابة</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="addWiveTbody">
                                                        @if(isset($family->members))
                                                            @foreach($family->members as $member)
                                                                @if(($member->relationship_id == 25) || ($member->relationship_id == 44) || ($member->relationship_id == 45) || ($member->relationship_id == 27)
                                                                          || ($member->relationship_id == 32)  || ($member->relationship_id == 33)  || ($member->relationship_id == 34)  )
                                                                    <tr>
                                                                        @include('admin.family.part.member.addWive',$member)
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                    <!-- End Table  -->
                                                </div>
                                                <!-- End Row -->
                                                <hr style="width: 100%">
                                                <!-- start row -->
                                                <div class="row">
                                                    <!-- Start col -->
                                                    <input disabled readonly id="family_id" name="family_id" hidden
                                                           value="{{ $family->id }}">

                                                    <!-- End col -->
                                                </div>
                                                <!-- End row -->
                                                <!-- Start Row -->
                                                <div class="row">
                                                    <!-- Start Table -->
                                                    <!-- Start Table  -->
                                                    <table class="table table-bordered table-hover" id="member_table">
                                                        <thead>
                                                        <tr class="text-center">
                                                            <th>الاسم بالعربية</th>
                                                            <th>الاسم بالتركية</th>
                                                            <th>سنة الميلاد</th>
                                                            <th>رقم الهوية</th>
                                                            <th>صلة القرابة</th>
                                                            <th>الحالة الدراسية</th>
                                                            <th>الحالة الوظيفية</th>
                                                            <th>الحالة الصحية</th>
                                                            <th>الامراض</th>
                                                            <th>الحالة الاجتماعية</th>
                                                            <th>الحالة (سابقا)</th>
                                                            <th>العمليات</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="addMemberTbody" class="text-center">
                                                        <tr>
                                                            <td>{{ !is_null($person->first_name) ? $person->first_name .' '. $person->family_name : '-' }}</td>
                                                            <td>{{ !is_null($person->first_name_tr) ? $person->first_name_tr : '-' }}</td>
                                                            <td>{{ !is_null($person->date_of_birth) ? $person->date_of_birth : '-' }}</td>
                                                            <td>{{ !is_null($person->id_number) ? $person->id_number : '-' }}</td>
                                                            <td>المكفول</td>
                                                            <td> {{ (isset($person->qualification)) && (!is_null($person->qualification)) ?  $person->qualification->name : '-' }} </td>
                                                            <td>{{ $person->work == 0 ? 'لايعمل' : 'يعمل' }}</td>
                                                            <td>{{ $person->health_status == 0 ? 'سليم' : 'مريض' }}</td>
                                                            <td> {{ (isset($person->social_status)) && (!is_null($person->social_status)) ?  $person->social_status->name : '-' }} </td>
                                                        </tr>
                                                        @if(isset($family->members))
                                                            @foreach($family->members->where('relationship_id' , '!=',14) as $member)
                                                                <tr>
                                                                    @include('admin.family.part.member.addNew',$member)
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                    <!-- End Table -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                            <!--end: Form Wizard Step 7-->
                                            <!--begin: Form Actions -->
                                            <div class="kt-form__actions">
                                                <button
                                                        class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                                        data-ktwizard-type="action-prev"
                                                        style="margin-left: 10px">
                                                    السابق
                                                </button>

                                                <button
                                                        class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                                        data-ktwizard-type="action-next">
                                                    التالي
                                                </button>
                                            </div>

                                        </form>
                                        <!--end: Form Wizard Form-->

                                    </div>
                                    <div
                                            class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper"
                                            style="margin:auto">

                                        <form class="kt-form" style="padding-top:0" data-parsley-validate
                                              method="post"
                                              action="{{ url('admin/families/approve/'.$family->id) }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="kt-form__actions">
                                                    <button class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                                            type="submit">استعادة
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
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
        $('body .next').on('click', function () {
            var step = $('body .current a').attr('href');
            $('#checkStep').val(step);
            document.getElementById("kt_form").submit();
        });

        function addRow() {
            document.querySelector('#content').insertAdjacentHTML(
                'beforeend',
                "" +
                "<!-- Start Row -->\n" +
                "<div class=\"row\">\n" +
                "    <!-- Start col -->\n" +
                "    <div class=\" col-lg-3 col-md-4\">\n" +
                "        <div class=\"form-group row\">\n" +
                "            <label class=\"col-form-label col-lg-12\">جهات الدخل</label>\n" +
                "            <div style=\"width: 95%;\">\n" +
                "                <select class=\"form-control\" id=\"income_type_id\" name=\"income_type_id[]\">\n" +
                "                <option disabled value=\" \" selected>  جهات الدخل" +
                "                </option>" +
                "                @foreach($incomeTypes->sortBy('name') as $incomeType)" +
                "                    <option disabled value=\"{{ $incomeType->id }}\">{{ $incomeType->name }}</option>" +
                "                @endforeach" +
                "            </select>" +
                "            </div>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "    <!-- End col -->\n" +
                "    <!-- Start col -->\n" +
                "    <div class=\"col-lg-3 col-md-4\">\n" +
                "        <div class=\"form-group row\">\n" +
                "            <label class=\"col-form-label col-lg-12\">قيمة الدخل</label>\n" +
                "            <div style=\"width: 86%;\">\n" +
                "                <input disabled readonly type=\"number\"  maxlength=\"10\" class=\"form-control\" name=\"income_type_value[]\" placeholder=\"قيمة الدخل\">\n" +
                "            </div>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "    <!-- End col -->\n" +
                "    <!-- Start col -->\n" +
                "    <div class=\"col-lg-4 col-md-4\">\n" +
                "        <div class=\"form-group row\">\n" +
                "            <label class=\"col-form-label col-lg-12\">ملاحظات الدخل</label>\n" +
                "            <div style=\"width: 86%;\">\n" +
                "                <input disabled readonly type=\"text\" class=\"form-control\" id=\"income_note\" name=\"income_note[]\" placeholder=\"ملاحظات الدخل\">\n" +
                "            </div>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "    <!-- End col -->\n" +
                "\n" +
                "    <!-- Start col -->\n" +
                "    <div class=\"col-md-2\">\n" +
                "        <label class=\"col-form-label col-lg-12\" style=\"opacity: 0;\">حذف</label>\n" +
                "        <input disabled readonly type=\"button\" class=\"btn btn-danger btn-elevate \" value=\"-\" onclick=\"removeRow(this)\">\n" +
                "    </div>\n" +
                "    <!-- End col -->\n" +
                "</div>"
            )
        };

        function removeRow(input) {
            document.getElementById('content').removeChild(input.parentNode.parentNode);
        };
    </script>
    <script>
        $(document).ready(function () {

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

            // $("body").on("keydown", ".income_type_value", function () {


            $("body").on("keydown", "#income_value", function () {
                var sum = 0;

                $('body .income_type_value').each(function (rowindex) {
                    var totalValue = $(this).val();

                    if (isNaN(totalValue)) {
                        $(this).html(sum);
                    } else {
                        sum += Number(totalValue);

                    }

                });

                var incomeValue = $('#income_value').val();

                if (incomeValue != '') {
                    sum += Number(incomeValue);
                }
                $("#total_income_value").attr('value', parseFloat(sum));
            });

            $("body").on("keydown", ".income_type_value", function () {

                var sum = 0;

                $('body .income_type_value').each(function (rowindex) {
                    var totalValue = $(this).val();

                    if (isNaN(totalValue)) {
                        $(this).html(sum);
                    } else {
                        sum += Number(totalValue);

                    }

                });

                var incomeValue = $('#income_value').val();

                if (incomeValue != '') {
                    sum += Number(incomeValue);
                }
                $("#total_income_value").attr('value', parseFloat(sum));
            });

            // $('body .next').on('click',function(){
            //     var step =   $('body .current a').attr('href');
            //     $('#checkStep').val(step);
            //     $( "#wizard-form" ).submit();
            // });

            var url = '{{ url('admin/families/add/getTranslation') }}';

            $("body").on("click", "#idNumberSearchButton", function () {
                var form_action = '{{ url('admin/families/search/idNumber') }}';
                var text = $('#id_number_search').val();
                var family_id = $('#family_id').val();

                if (text != '') {
                    $.ajax({
                        dataType: 'json',
                        type: 'GET',
                        url: form_action,
                        data: {text: text, family_id: family_id}
                    }).done(function (data) {
                        $('#addMemberDiv').empty();
                        $('#addMemberDiv').append(data.html);

                    });
                }
            });


            // show hide health status select
            $('#diseasesDiv').hide();
            $("#member_health_status").change(function () {
                var id = $(this).children(":selected").attr("value");
                if (id == 1) {
                    $('#diseasesDiv').show().removeClass("d-none");
                } else if (id == 0) {
                    $('#diseasesDiv').hide();

                }
            });

            // show hide relations
            $('#member_relationship_div').hide();
            $("#member_relationship_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#member_relationship_div').val('');

                if (id == 1) {
                    $('#member_relationship_div').show().removeClass("d-none");
                } else {
                    $('#member_relationship_div').hide();
                }
            });

            $("#member_first_name_tr").click(function () {
                var name = $('#member_first_name').val();

                if (name != '') {
                    $.ajax({
                        dataType: 'json',
                        type: 'GET',
                        url: url,
                        data: {name: name}
                    }).done(function (transName) {

                        if ((transName == '') || (transName == null)) {
                            $('#member_first_name_tr').css('border-color', 'red');
                        } else {
                            $('#member_first_name_tr').val(transName);
                            $('#member_first_name_tr').css('border-color', 'green');
                        }
                    });

                } else {
                    $('#member_first_name_tr').css('border-color', 'red');
                }
            });

            $('#addMemberButton').click(function (e) {
                e.preventDefault();
                var addMemberUrl = '{{ url('admin/families/addNewMember/'.$family->id) }}';

                var member_social_status_id = $('#member_social_status_id').val();
                var member_health_status = $('#member_health_status').val();
                var member_work = $('#member_work').val();
                var member_qualification_id = $('#member_qualification_id').val();
                var member_relationship_id = $('#member_relationship_id').val();
                var member_id_number = $('#member_id_number').val();
                var member_date_of_birth = $('#member_date_of_birth').val();
                var member_first_name = $('#member_first_name').val();
                var member_first_name_tr = $('#member_first_name_tr').val();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: addMemberUrl,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        member_social_status_id: member_social_status_id,
                        member_health_status: member_health_status,
                        member_work: member_work,
                        member_relationship_id: member_relationship_id,
                        member_qualification_id: member_qualification_id,
                        member_date_of_birth: member_date_of_birth,
                        member_id_number: member_id_number,
                        member_first_name: member_first_name,
                        member_first_name_tr: member_first_name_tr,

                    }
                }).done(function (data) {
                    if (data != 'error') {
                        $('#member_social_status_id').val('');
                        $('#member_health_status').val('');
                        $('#member_work').val('');
                        $('#member_qualification_id').val('');
                        $('#member_relationship_id').val('');
                        $('#member_id_number').val('');
                        $('#member_date_of_birth').val('');
                        $('#member_first_name').val('');
                        $('#member_first_name_tr').val('');
                        $('#addMemberTbody').append(data.html);
                    }
                });
            });

            $('#addWiveButton').click(function (e) {
                e.preventDefault();
                var addMemberUrl = '{{ url('admin/families/addWives/'.$family->id) }}';

                var wive_count = $('#wive_count').val();
                var member_count = $('#member_count').val();
                var wive_relationship_id = $('#wive_relationship_id').val();
                var wive_first_name = $('#wive_first_name').val();
                var wive_second_name = $('#wive_second_name').val();
                var wive_third_name = $('#wive_third_name').val();
                var wive_family_name = $('#wive_family_name').val();
                var wive_id_number = $('#wive_id_number').val();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: addMemberUrl,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        wive_count: wive_count,
                        member_count: member_count,
                        wive_relationship_id: wive_relationship_id,
                        wive_first_name: wive_first_name,
                        wive_third_name: wive_third_name,
                        wive_second_name: wive_second_name,
                        wive_family_name: wive_family_name,
                        wive_id_number: wive_id_number,
                    }
                }).done(function (data) {
                    if (data != 'error') {
                        $('#wive_relationship_id').val();
                        $('#wive_family_name').val('');
                        $('#wive_third_name').val('');
                        $('#wive_second_name').val('');
                        $('#wive_first_name').val('');
                        $('#wive_id_number').val('');
                        $('#addWiveTbody').append(data.html);
                    }
                });
            });

            $(".numbers").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 1632 || e.which > 1641)) {
                    return false;
                }
            });

            // show hide id type input
            $('#idTypeIdDiv').hide();
            $("#id_type_id").change(function () {
                var chracterCount = this.options[this.selectedIndex].getAttribute('data-count');
                var type = this.options[this.selectedIndex].getAttribute('type');

                $('#id_number').val('');
                $('#idTypeIdDiv').show().removeClass("d-none");

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

            // show hide work typ input
            $("#work").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#workDiv').hide('');

                if (id == 1) {
                    $('#workDiv').show().removeClass("d-none");
                }
            });

            // show hide breadwinner
            $("#breadwinner_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#breadwinner_other_edit').val('');
                $('#breadwinner_other_id_edit').val('');
                $('#breadwinner_other_id').val('');
                $('#breadwinner_other').val('');

                if (id == 1) {
                    // $('#breadwinnerOtherDivEdit').show().removeClass("d-none");
                    $('#breadwinnerOtherDiv').show().removeClass("d-none");
                } else {
                    $('#breadwinnerOtherDiv').hide();
                    $('#breadwinnerOtherDivEdit').hide();
                }
            });


            // show hide relations
            $("#representative_relationship_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#representative_relationship_other_edit').val('');
                $('#representative_relationship_other_id_edit').val('');
                $('#representative_relationship_other_id').val('');
                $('#representative_relationship_other').val('');

                if (id == 1) {
                    // $('#breadwinnerOtherDivEdit').show().removeClass("d-none");
                    $('#representativeRelationshipOtherDiv').show().removeClass("d-none");
                } else {
                    $('#representativeRelationshipOtherDiv').hide();
                    $('#representativeRelationshipOtherDivEdit').hide();
                }
            });

            // show hide health status select
            $("#health_status").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#family_diseases_edit').val('');

                if (id == 1) {
                    $('#diseasesDiv').show().removeClass("d-none");
                } else if (id == 0) {
                    $('#diseasesDiv').hide();
                    $('#diseasesDivEdit').hide();

                }
            });

            // show hide health status select
            $("#house_ownership_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                if (id == 2) {
                    $('#rentValueDiv').show().removeClass("d-none");
                } else {
                    $('#rentValueDiv').hide();

                }
            });

            // show hide  educational institution
            $("#educational_institution_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#educational_institution_other_edit').val('');
                $('#educational_institution_other_id_edit').val('');
                $('#educational_institution_other_id').val('');
                $('#educational_institution_other').val('');

                if (id == 1) {
                    $('#educationalInstitutionOtherDiv').show().removeClass("d-none");
                } else {
                    $('#educationalInstitutionOtherDiv').hide();
                    $('#educationalInstitutionOtherDivEdit').hide();

                }
            });

            // show hide university specialty
            $("#university_specialty_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#university_specialty_other_edit').val('');
                $('#university_specialty_other_id_edit').val('');
                $('#university_specialty_other_id').val('');
                $('#university_specialty_other').val('');

                if (id == 1) {
                    $('#universitySpecialtyDiv').show().removeClass("d-none");
                } else {
                    $('#universitySpecialtyDiv').hide();
                    $('#universitySpecialtyDivEdit').hide();

                }
            });

            // show hide funded institution
            $("#funded_institution_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#funded_institution_other_edit').val('');
                $('#funded_institution_other_id_edit').val('');
                $('#funded_institution_other_id').val('');
                $('#funded_institution_other').val('');

                if (id == 1) {
                    $('#fundedInstitutionDiv').show().removeClass("d-none");
                } else {
                    $('#fundedInstitutionDiv').hide();
                    $('#fundedInstitutionOtherDivEdit').hide();

                }
            });

            // show hide visit reason
            $("#visit_reason_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#visit_reason_other_edit').val('');
                $('#visit_reason_other_id_edit').val('');
                $('#visit_reason_other_id').val('');
                $('#visit_reason_other').val('');

                if (id == 1) {
                    $('#visitReasonDiv').show().removeClass("d-none");
                    $('#visitReasonMissionDiv').hide();
                } else if (id == 3) {
                    $('#visitReasonMissionDiv').show().removeClass("d-none");
                } else {
                    $('#visitReasonDiv').hide();
                    $('#visitReasonMissionDiv').hide();
                    $('#visitReasonDivEdit').hide();

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
        var form = $("#example-advanced-form").show().removeClass("d-none");

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


        var form = $(".validation-wizard").show().removeClass("d-none");
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

        // show hide family type
        // $('#UNDivEdit').hide();
        // $('#fatherLessDivEdit').hide();
        $("#family_type_id").change(function () {
            var id = $(this).children(":selected").attr("value");
            if (id == 7) {
                $('#UNDiv').show().removeClass("d-none");
                $('#fatherLessDiv').hide();
            } else if (id == 5) {
                $('#UNDiv').hide();
                $('#fatherLessDiv').show().removeClass("d-none");
            } else {
                $('#UNDiv').hide();
                $('#fatherLessDiv').hide();
            }
        });

        var i = $('incomeCount').val();


        var table = $('#member_table').DataTable({
            responsive: true,
            "processing": true,
            "order": [[2, "asc"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
            },
        });

    </script>
@endsection


