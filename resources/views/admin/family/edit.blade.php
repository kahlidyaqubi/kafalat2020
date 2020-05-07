@extends('layouts.dashboard.app')

@section('pageTitle','تحديث استمارة')
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

        /*mah work*/
        .kt-wizard-v4 .kt-wizard-v4__wrapper .kt-form {
            padding: 5px 0;
        }
    </style>


@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','الاستمارات والزيارات')
@section('navigation3','تحديث استمارة')
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
                        تحديث استمارة
                        <span style="color: red;">
                            {{$person->full_name."/".$person->full_name_tr}}</span>
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
                            @if(!($come_by == "season_coupon" || $family->visit_reason_id == 5))
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
                                                    معلومات الوكيل واليتيم
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
                                                    طالب جامعي
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Step -->
                                    <!-- Start Step -->
                                    <div class="kt-wizard-v4__nav-item" data-ktwizard-type="step">
                                        <div class="kt-wizard-v4__nav-body">
                                            <div class="kt-wizard-v4__nav-number">
                                                8
                                            </div>
                                            <div class="kt-wizard-v4__nav-label">
                                                <div class="kt-wizard-v4__nav-label-title">
                                                    افراد الاسرة
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Step -->
                                @endif
                            </div>
                        </div>

                        <!--end: Form Wizard Nav -->
                        <div class="kt-portlet">
                            <div class="kt-portlet__body kt-portlet__body--fit">
                                <div class="kt-grid">
                                    <div
                                            class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">
                                        <!--begin: Form Wizard Form-->
                                        <form class="kt-form" id="kt_form"
                                              action="{{ url('admin/families',$family->id) }}"
                                              method="post">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="come_by" value="{{$come_by??""}}">
                                            @php
                                                $ticketTime = strtotime($person->create_at);
                                                $difference = date_diff(new \DateTime($person->created_at), new \DateTime())->format("%d");
                                            @endphp
                                            <input id="checkStep" name="checkStep" hidden type="text" value=" "/>
                                            <!--begin: Form Wizard Step 1-->
                                            <div class="kt-wizard-v4__content"
                                                 data-ktwizard-type="step-content"
                                                 data-ktwizard-state="current">
                                                <input type="hidden" name="person_id" value="{{ $person->id }}">
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
                                                                       value="{{old('first_name')??$person->first_name }}"
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
                                                                       placeholder="اسم الاب"
                                                                       value="{{old('second_name')??$person->second_name }}">
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
                                                                       value="{{old('third_name')?? $person->third_name }}"
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
                                                                       value="{{old('family_name')?? $person->family_name }}"
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
                                                                <span style="color:dodgerblue;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="text" required 
                                                                       class="form-control turkey" id="first_name_tr"
                                                                       name="first_name_tr"
                                                                       value="{{old('first_name_tr')?? $person->first_name_tr }}"
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
                                                                <span style="color:dodgerblue;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="text" required 
                                                                       class="form-control turkey" id="second_name_tr"
                                                                       name="second_name_tr"
                                                                       value="{{ old('second_name_tr')??$person->second_name_tr }}"
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
                                                                <span style="color:dodgerblue;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="text" required 
                                                                       class="form-control turkey" id="third_name_tr"
                                                                       name="third_name_tr"
                                                                       value="{{old('third_name_tr')?? $person->third_name_tr }}"
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
                                                                <span style="color:dodgerblue;">*</span>
                                                            </label>
                                                            <div style="width: 95%;">
                                                                <input type="text" required 
                                                                       class="form-control turkey" id="family_name_tr"
                                                                       name="family_name_tr"
                                                                       value="{{ old('family_name_tr')??$person->family_name_tr }}"
                                                                       placeholder="اسم العائلة بالتركي">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    <!-- Start col -->
                                                    <div class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                        <div class="form-group row" style="width:95%">
                                                            <label class="col-form-label col-lg-12">سنة الميلاد
                                                            </label>
                                                            <input  class="form-control datepicker" id="date_of_birth"
                                                                   value="{{old('date_of_birth')?? $person->date_of_birth }}"
                                                                   name="date_of_birth"
                                                                   type="text" style="direction: rtl;" readonly="readonly" autocomplete="off">
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
                                                                    الميلاد
                                                                    <span style="color:dodgerblue;">*</span>
                                                                </label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="date_of_birth_place"
                                                                        name="date_of_birth_place">
                                                                    <option value=" " selected> مكان الميلاد</option>
                                                                    @foreach($countries->sortBy('name') as $country)
                                                                        <option value="{{ $country->id }}"
                                                                        @if(old('date_of_birth_place'))
                                                                            {{ $country->id == old('date_of_birth_place') ? 'selected':'' }}
                                                                                @else
                                                                            {{$country->name == 'فلسطين' ?'selected':''}}
                                                                                    {{ $country->id == $person->date_of_birth_place ? 'selected':'' }}
                                                                                @endif
                                                                        >{{ $country->name."-".$country->name_tr }}</option>
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

                                                                    <option value="M"

                                                                    @if(old('gender'))
                                                                        {{ old('gender') == 'M' ? 'selected':'' }}
                                                                            @else
                                                                        {{ $person->gender == 'M'  ? 'selected':'' }}
                                                                            @endif
                                                                    >
                                                                        ذكر

                                                                    </option>
                                                                    <option value="F"

                                                                    @if(old('gender'))
                                                                        {{ old('gender') == 'F' ? 'selected':'' }}
                                                                            @else
                                                                        {{ $person->gender == 'F' ? 'selected':'' }}
                                                                            @endif>
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
                                                                    <option value=" " selected> المعيل</option>
                                                                    @foreach($relationships->sortBy('name') as $relationship)
                                                                        <option value="{{ $relationship->id }}"
                                                                        @if(old('breadwinner_id'))
                                                                            {{ $relationship->id == old('breadwinner_id') ? 'selected':'' }}
                                                                                @else
                                                                            {{ (isset($family->breadwinner) && (!is_null($family->breadwinner)) && ($family->breadwinner->status == 0) && ( $relationship->id == 1) ) ? 'selected' : $relationship->id == $family->breadwinner_id ? 'selected':'' }}
                                                                                @endif
                                                                        >{{ $relationship->name }}</option>
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
                                                                    <input type="number"
                                                                           class="form-control"
                                                                           id="breadwinner_other_edit"
                                                                           name="breadwinner_other_edit"
                                                                           value=" {{ $family->breadwinner->name }}"
                                                                           type="text"
                                                                           placeholder="المعيل">
                                                                    <input type="hidden" id="breadwinner_other_id_edit"
                                                                           name="breadwinner_other_id_edit"
                                                                           value="{{ old('breadwinner_other_id_edit')??$family->breadwinner->id }}">
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
                                                                <input type="number"
                                                                       class="form-control" id="breadwinner_other"
                                                                       name="breadwinner_other"
                                                                       value="{{ old('breadwinner_other')??(isset($family->breadwinner) && (!is_null($family->breadwinner))) ? $family->breadwinner->name  : '' }}"
                                                                       type="text"
                                                                       placeholder="المعيل">
                                                                <input type="hidden" id="breadwinner_other_id"
                                                                       name="breadwinner_other_id"
                                                                       value="{{  old('breadwinner_other_id')?? (isset($family->breadwinner) && (!is_null($family->breadwinner))) ? $family->breadwinner->id : '' }}">
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
                                                                        @if(old('qualification_id'))
                                                                            {{ $qualification->id == old('qualification_id') ? 'selected':'' }}
                                                                                @else
                                                                            {{ $qualification->id == $person->qualification_id ? 'selected':'' }}
                                                                                @endif
                                                                        >{{ $qualification->name }}</option>
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
                                                                            id="qualification_level_id"
                                                                            name="qualification_level_id">
                                                                        <option value=" " selected>المستوى التعليمي
                                                                            لليتيم
                                                                        </option>
                                                                        @foreach($qualificationLevels->sortBy('name') as $qualificationLevel)
                                                                            <option value="{{ $qualificationLevel->id }}"
                                                                            @if(old('qualification_level_id'))
                                                                                {{ $qualificationLevel->id == old('qualification_level_id') ? 'selected':'' }}
                                                                                    @else
                                                                                {{ $qualificationLevel->id == $person->qualification_level_id ? 'selected':'' }}
                                                                                    @endif
                                                                            >{{ $qualificationLevel->name }}</option>
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
                                                                    الوثيقة التعريفية
                                                                    <span style="color:red;">*</span>
                                                                    <span style="color:dodgerblue;">*</span>
                                                                </label>
                                                                <select class="form-control " required 
                                                                        id="id_type_id" name="id_type_id">
                                                                    <option value="" selected> نوعية الوثيقة
                                                                        التعريفية
                                                                    </option>
                                                                    @foreach($idTypes->sortBy('name') as $id)
                                                                        <option value="{{ $id->id }}"
                                                                                data-count="{{ $id->number }}"
                                                                                type="{{ $id->type }}"
                                                                        @if(old('id_type_id'))
                                                                            {{ $id->id == old('id_type_id') ? 'selected':'' }}
                                                                                @else
                                                                            {{ $id->id == $person->id_type_id ? 'selected':'' }}
                                                                                @endif
                                                                        >{{ $id->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <?php
                                                    $the_id_type=old('id_type_id')??$person->id_type_id;
                                                    ?>
                                                    @if(!is_null( $person->id_number))
                                                   
                                                        <div
                                                                class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                            <div class="form-group row">
                                                                <label
                                                                        class="col-form-label col-lg-12">الوثيقة
                                                                    التعريفية
                                                                    <span style="color:red;">*</span>
                                                                    <span style="color:dodgerblue;">*</span>
                                                                </label>
                                                                <div style="width: 95%;">
                                                                    <input class="form-control numbers" required  id="id_number"
                                                                                               @if($the_id_type == 2)
                                                        ="7"
                                                                    minlength="7"            
                                                                    @else
                                                                    maxlength="9"
                                                                    minlength="9"
                                                                    @endif
                                                                           name="id_number"
                                                                           value="{{ old('id_number')??$person->id_number }}"
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
                                                                    <span style="color:dodgerblue;">*</span>
                                                                </label>
                                                                <div style="width: 95%;">
                                                                    <input class="form-control numbers" id="id_number"
                                                                    @if($the_id_type == 2)
                                                        ="7"
                                                                    minlength="7"            
                                                                    @else
                                                                    maxlength="9"
                                                                    minlength="9"
                                                                    @endif
                                                                           name="id_number"
                                                                           value="{{  old('id_number')??$person->id_number }}"
                                                                           type="text"
                                                                           placeholder="الوثيقة التعريفية">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                <!-- End col -->
                                                    @if($come_by == "urgent_coupon" || $family->visit_reason_id == 10)
                                                        <div
                                                                class="col-lg-3 col-md-3 col-xl-3 col-sm-12">
                                                            <div class="form-group row">
                                                                <label
                                                                        class="col-form-label col-lg-12">كرت المؤن

                                                                </label>
                                                                <div style="width: 95%;">
                                                                    <input class="form-control" id="supplies_card"
                                                                           name="supplies_card"
                                                                           value="{{ old('supplies_card')??$family->supplies_card }}"
                                                                           type="number"
                                                                           placeholder="كرت المؤن">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Start col -->
                                                        <div
                                                                class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                            <div class="form-group row">
                                                                <div style="width: 95%;">
                                                                    <label
                                                                            class="col-form-label col-lg-12">الدولة</label>
                                                                    <select
                                                                            class="form-control "
                                                                            id="country_id" name="country_id">
                                                                        <option value=" " selected> الدولة</option>
                                                                        @foreach(\App\Country::all()->sortBy('name') as $country)
                                                                            <option value="{{$country->id}}"

                                                                                    @if(old('country_id'))
                                                                                    {{ $country->id == old('country_id') ? 'selected':'' }}
                                                                                    @else
                                                                                    @if($country->id== $family->country_id) selected @endif

                                                                                    @endif
                                                                            >{{$country->name}}</option>
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
                                                                        class="col-form-label col-lg-12">الحالة
                                                                    الاجتماعية</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="social_status_id" name="social_status_id">
                                                                    <option value=" " selected> الحالة الاجتماعية
                                                                    </option>
                                                                    @foreach($socialStatuses->sortBy('name') as $socialStatus)
                                                                        <option value="{{ $socialStatus->id }}"
                                                                        @if(old('social_status_id'))
                                                                            {{ $socialStatus->id == old('social_status_id') ? 'selected':'' }}
                                                                                @else
                                                                            {{ $socialStatus->id == $person->social_status_id ? 'selected':'' }}
                                                                                @endif
                                                                        >{{ $socialStatus->name }}</option>
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
                                                                    الصحية
                                                                    <span style="color:dodgerblue;">*</span>
                                                                </label>

                                                                <select class="form-control "
                                                                        id="health_status" name="health_status">
                                                                    <option value=" " selected> الحالة الصحية
                                                                    </option>
                                                                    <option value="1"
                                                                    @if(old('health_status'))
                                                                        {{ '1' == old('health_status') ? 'selected':'' }}
                                                                            @else
                                                                        {{ '1' == $person->health_status ? 'selected':'' }}
                                                                            @endif
                                                                    >
                                                                        مريض
                                                                    </option>
                                                                    <option value="0"
                                                                    @if(old('health_status'))
                                                                        {{ '0' == old('health_status') ? 'selected':'' }}
                                                                            @else
                                                                        {{ '0' == $person->health_status ? 'selected':'' }}
                                                                            @endif
                                                                    >
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
                                                                class="col-lg-3 col-md-3 col-xl-3 col-sm-12 "
                                                                id="diseasesDivEdit">
                                                            <div class="form-group row">
                                                                <div style="width: 97%;">
                                                                    <label
                                                                            class="col-form-label col-lg-12">الأمراض
                                                                    </label>
                                                                    <select class="form-control kt-select2 select2-multi"
                                                                            multiple id="family_diseases_edit"
                                                                            name="family_diseases_edit[]">
                                                                        <option value=" " disabled> الأمراض</option>
                                                                        @foreach($diseases->sortBy('name') as $disease)
                                                                            <option value="{{ $disease->id }}"
                                                                            @if(old('family_diseases_edit'))
                                                                                {{ in_array($disease->id,old('family_diseases_edit')) ? 'selected':'' }}
                                                                                    @else
                                                                                {{ isset($recipient_diseases)?in_array($disease->id,$recipient_diseases) ?'selected':'':'' }}
                                                                                    @endif
                                                                            >{{ $disease->name."-".$disease->name_tr }}</option>
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
                                                                    <option value=" " disabled> الأمراض</option>
                                                                    @foreach($diseases->sortBy('name') as $disease)
                                                                        <option value="{{ $disease->id }}"
                                                                        @if(old('family_diseases'))
                                                                            {{ in_array($disease->id,old('family_diseases')) ? 'selected':'' }}
                                                                                @endif
                                                                        >{{ $disease->name."-".$disease->name_tr}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End col -->
                                                    @if($come_by == "season_coupon" || $family->visit_reason_id == 5)
                                                    <!-- Start col -->
                                                        <div
                                                                class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                            <div class="form-group row">
                                                                <div style="width: 95%;">
                                                                    <label
                                                                            class="col-form-label col-lg-12">المحافظة
                                                                        <span style="color:dodgerblue;">*</span>
                                                                    </label>
                                                                    <select
                                                                            class="form-control "
                                                                            id="governorate_id" name="governorate_id"
                                                                            onchange="get_cities()">
                                                                        <option value=" " selected> المحافظة</option>
                                                                        @foreach($governorates->sortBy('name') as $governorate)
                                                                            <option value="{{$governorate->id}}"

                                                                                    @if(old('governorate_id'))
                                                                                    {{ $governorate->id == old('governorate_id') ? 'selected':'' }}
                                                                                    @else

                                                                                    @if($family->neighborhood)
                                                                                    @if($family->neighborhood->city)
                                                                                    @if($family->neighborhood->city->governorate)
                                                                                    @if($governorate->id== $family->neighborhood->city->governorate->id) selected @endif
                                                                                    @endif
                                                                                    @endif
                                                                                    @endif
                                                                                    @endif
                                                                            >{{$governorate->name."-".$governorate->name_tr}}</option>
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
                                                                            class="col-form-label col-lg-12">المدينة
                                                                        <span style="color:dodgerblue;">*</span>
                                                                    </label>
                                                                    <select class="form-control kt-select2 select2-multi"
                                                                            id="city_id"
                                                                            name="city_id"
                                                                            onchange="get_neighborhoods()">
                                                                        <option value=" " selected> المدينة</option>
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
                                                                            class="col-form-label col-lg-12">المنطقة
                                                                        <span style="color:dodgerblue;">*</span>
                                                                    </label>
                                                                    <select class="form-control kt-select2 select2-multi"
                                                                            id="neighborhood_id"
                                                                            name="neighborhood_id">
                                                                        <option value=" " selected>الحي</option>
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
                                                                    <input type="text"
                                                                           class="form-control" name="address"
                                                                           value="{{ old('address')??$family->address }}"
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
                                                                        <option value=" " selected> نوع السكن</option>
                                                                        @foreach($houseRoofs->sortBy('name') as $houseRoof)
                                                                            <option value="{{ $houseRoof->id }}"
                                                                            @if(old('house_roof_id'))
                                                                                {{ $houseRoof->id == old('house_roof_id') ? 'selected':'' }}
                                                                                    @else
                                                                                {{ $houseRoof->id == $family->house_roof_id ? 'selected':'' }}
                                                                                    @endif
                                                                            >{{ $houseRoof->name }}</option>
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
                                                                        <option value=" " selected> ملكية السكن</option>
                                                                        @foreach($houseOwners->sortBy('name') as $houseOwner)
                                                                            <option value="{{ $houseOwner->id }}"
                                                                            @if(old('house_ownership_id'))
                                                                                {{ $houseOwner->id == old('house_ownership_id') ? 'selected':'' }}
                                                                                    @else
                                                                                {{ $houseOwner->id == $family->house_ownership_id ? 'selected':'' }}
                                                                                    @endif
                                                                            >{{ $houseOwner->name }}</option>
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
                                                                    <input class="form-control numbers" name="rent_value"

                                                                           maxlength="10"
                                                                           value="{{ old('rent_value')??$family->rent_value }}"
                                                                           placeholder="قيمة الايجار">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End col -->
                                                        <div
                                                                class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                            <div class="form-group row">
                                                                <div style="width: 95%;">
                                                                    <label
                                                                            class="col-form-label col-lg-12">نوع
                                                                        الزيارة</label>
                                                                    <select class="form-control kt-select2 select2-multi"
                                                                            id="visit_reason_id" name="visit_reason_id"
                                                                            @if($come_by == "urgent_coupon" ) readonly @endif
                                                                    >
                                                                        @if($come_by == "urgent_coupon")
                                                                            <option value="10"
                                                                                    selected>{{\App\VisitReason::find(10)->name}}</option>
                                                                        @elseif($come_by == "season_coupon")
                                                                            <option value="5"
                                                                                    selected>{{\App\VisitReason::find(5)->name}}</option>
                                                                        @else
                                                                            <option value=" " selected> نوع الزيارة
                                                                            </option>
                                                                            @foreach($visitReasons->sortBy('name') as $visit)
                                                                                <option value="{{ $visit->id }}"
                                                                                @if(old('visit_reason_id'))
                                                                                    {{ $visit->id == old('visit_reason_id') ? 'selected':'' }}
                                                                                        @else
                                                                                    {{ $visit->id == $family->visit_reason_id ? 'selected':'' }}
                                                                                        @endif
                                                                                >{{ $visit->name }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endif
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
                                                                الجوال - 1
                                                                <span style="color:dodgerblue;">*</span>
                                                            </label>
                                                            <div class="input-group"
                                                                 style="width: 95%;">
                                                                <input class="form-control numbers"
                                                                       value="{{ old('mobile_one')??$family->mobile_one }}"
                                                                       maxlength="10" minlength="9"
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
                                                                <input class="form-control numbers"
                                                                       id="mobile_two"
                                                                       maxlength="10" minlength="9"
                                                                       value="{{  old('mobile_two')??$family->mobile_two }}"
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
                                                                <input class="form-control numbers"
                                                                       id="telephone"
                                                                       name="telephone"
                                                                       value="{{ old('telephone')??$family->telephone }}"
                                                                       maxlength="9" minlength="7"
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
                                        @if(!($come_by == "season_coupon" || $family->visit_reason_id == 5))
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
                                                                        <input type="text"
                                                                               class="form-control numbers"
                                                                               name="previous_income_value_o"
                                                                               readonly
                                                                               maxlength="10"
                                                                               value="{{old('previous_income_value_o')?? $family->previous_income_value }}"
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
                                                                            readonly>
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
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="total_income_value"
                                                                           name="total_income_value"
                                                                           value="{{ old('total_income_value')??$family->total_income_value }}"

                                                                           readonly
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
                                                                        العمل
                                                                        <span style="color:dodgerblue;">*</span>
                                                                    </label>
                                                                    <select
                                                                            class="form-control "
                                                                            id="work" name="work">
                                                                        <option value=" " selected> الحالة العمل
                                                                        </option>

                                                                        <option value="1"
                                                                        @if(old('work'))
                                                                            {{ '1' == old('work') ? 'selected':'' }}
                                                                                @else{{ '1' == $person->work ? 'selected':'' }}
                                                                                @endif>
                                                                            يعمل
                                                                        </option>
                                                                        <option value="0"
                                                                        @if(old('work'))
                                                                            {{ '0' == old('work') ? 'selected':'' }}
                                                                                @else  {{ '0' == $person->work ? 'selected':'' }}
                                                                                @endif>
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
                                                            <div class=" col-lg-12">
                                                                <div class="form-group row">
                                                                    <label class="col-form-label col-lg-12">جهات
                                                                        الدخل
                                                                        <span style="color:dodgerblue;">*</span>
                                                                    </label>
                                                                    <div style="width: 95%;">
                                                                        <select class="form-control kt-select2 select2-multi"
                                                                                id="job_type_id"
                                                                                name="job_type_id">
                                                                            <option value=" " selected> نوع العمل
                                                                            </option>
                                                                            @foreach($jobTypes->sortBy('name') as $jobType)
                                                                                <option value="{{ $jobType->id }}"
                                                                                @if(old('job_type_id'))
                                                                                    {{ $jobType->id == old('job_type_id') ? 'selected':'' }}
                                                                                        @else
                                                                                    {{ $jobType->id == $family->job_type_id ? 'selected':'' }}
                                                                                        @endif
                                                                                >{{ $jobType->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End col -->
                                                            <!-- Start col -->
                                                            <div class="col-lg-12">
                                                                <div class="form-group row">
                                                                    <label class="col-form-label col-lg-12">قيمة
                                                                        الدخل</label>
                                                                    <div style="width: 86%;">
                                                                        <input class="form-control numbers"
                                                                               id="income_value" name="income_value"
                                                                               value="{{ old('income_value')??$family->income_value }}"
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
                                                                                    <option value=" " selected> جهات
                                                                                        الدخل
                                                                                    </option>
                                                                                    @foreach($incomeTypes->sortBy('name') as $incomeType)
                                                                                        <option value="{{ $incomeType->id }}"
                                                                                        @if(old('income_type_id'))
                                                                                            {{ $incomeType->id == old('income_type_id') ? 'selected':'' }}
                                                                                                @else
                                                                                            {{ $incomeType->id == $income->income_type_id ? 'selected':'' }}
                                                                                                @endif>{{ $incomeType->name }}</option>
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
                                                                                <input class="form-control numbers income_type_value"
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
                                                                                <input type="text" class="form-control"
                                                                                       id="income_note"
                                                                                       value="{{ $income->note }}"
                                                                                       name="income_note[]"
                                                                                       placeholder="ملاحظات الدخل">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                                <input type="hidden" name="incomeCount"
                                                                       value="{{ old('incomeCount')??count($family->incomes)  }}">
                                                            @endif
                                                        </div>

                                                        <!-- Start col -->
                                                        <div class="col-lg-2 col-md-2">
                                                            <!-- <label class="col-form-label col-lg-12" style="opacity: 0;">اضافة جهة دخل</label> -->
                                                            <input type="button"
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
                                                                            id="governorate_id" name="governorate_id"
                                                                            onchange="get_cities()">
                                                                        <option value=" " selected> المحافظة</option>
                                                                        @foreach($governorates->sortBy('name') as $governorate)
                                                                            <option value="{{$governorate->id}}"
                                                                                    @if(old('governorate_id'))
                                                                                    {{ $governorate->id == old('governorate_id') ? 'selected':'' }}
                                                                                    @else

                                                                                    @if($family->neighborhood)
                                                                                    @if($family->neighborhood->city)
                                                                                    @if($family->neighborhood->city->governorate)
                                                                                    @if($governorate->id== $family->neighborhood->city->governorate->id) selected @endif
                                                                                    @endif
                                                                                    @endif
                                                                                    @endif
                                                                                    @endif
                                                                            >{{$governorate->name}}</option>
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
                                                                            id="city_id"
                                                                            name="city_id"
                                                                            onchange="get_neighborhoods()">
                                                                        <option value=" " selected> المدينة</option>
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
                                                                            id="neighborhood_id"
                                                                            name="neighborhood_id">
                                                                        <option value=" " selected>الحي</option>
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
                                                                    <input type="text"
                                                                           class="form-control" name="address"
                                                                           value="{{ old('address')??$family->address }}"
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
                                                                        <option value=" " selected> نوع السكن</option>
                                                                        @foreach($houseRoofs->sortBy('name') as $houseRoof)
                                                                            <option value="{{ $houseRoof->id }}"
                                                                            @if(old('house_roof_id'))
                                                                                {{ $houseRoof->id == old('house_roof_id') ? 'selected':'' }}
                                                                                    @else
                                                                                {{ $houseRoof->id == $family->house_roof_id ? 'selected':'' }}
                                                                                    @endif >{{ $houseRoof->name }}</option>
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
                                                                        <option value=" " selected> ملكية السكن</option>
                                                                        @foreach($houseOwners->sortBy('name') as $houseOwner)
                                                                            <option value="{{ $houseOwner->id }}"
                                                                            @if(old('house_ownership_id'))
                                                                                {{ $houseRoof->id == old('house_ownership_id') ? 'selected':'' }}
                                                                                    @else
                                                                                {{ $houseOwner->id == $family->house_ownership_id ? 'selected':'' }}
                                                                                    @endif>{{ $houseOwner->name }}</option>
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
                                                                    <input class="form-control numbers" name="rent_value"

                                                                           maxlength="10"
                                                                           value="{{ old('rent_value')??$family->rent_value }}"
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
                                                                        <option value=" " selected> وضع السكن</option>
                                                                        @foreach($houseStatuses->sortBy('name') as $houseStatus)
                                                                            <option value="{{ $houseStatus->id }}"
                                                                            @if(old('house_status_id'))
                                                                                {{ $houseStatus->id == old('house_status_id') ? 'selected':'' }}
                                                                                    @else
                                                                                {{ $houseStatus->id == $family->house_status_id ? 'selected':'' }}
                                                                                    @endif>{{ $houseStatus->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End col -->
                                                    @if(!($come_by == "urgent_coupon" || $family->visit_reason_id == 10))
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
                                                                            <option value=" " selected> وضع الاثاث
                                                                            </option>
                                                                            @foreach($furnitureStatuses->sortBy('name') as $furnitureStatus)
                                                                                <option value="{{ $furnitureStatus->id }}"
                                                                                @if(old('furniture_status_id'))
                                                                                    {{ $furnitureStatus->id == old('furniture_status_id') ? 'selected':'' }}
                                                                                        @else
                                                                                    {{ $furnitureStatus->id == $family->furniture_status_id ? 'selected':'' }}
                                                                                        @endif
                                                                                >{{ $furnitureStatus->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End col -->
                                                    @endif
                                                    <!-- Start col -->
                                                        <div
                                                                class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                            <div class="form-group row">
                                                                <div style="width: 90%;">
                                                                    <label
                                                                            class="col-form-label col-lg-12">عدد
                                                                        الغرف</label>
                                                                    <input type="number"
                                                                           class="form-control" id="room_number"
                                                                           name="room_number"
                                                                           value="{{ old('room_number')??$family->room_number }}"
                                                                           placeholder="عدد الغرف">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End col -->
                                                        <!-- Start col -->
                                                        @if($come_by == "urgent_coupon" || $family->visit_reason_id == 10)
                                                            <div
                                                                    class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                                <div class="form-group row">
                                                                    <div style="width: 90%;">
                                                                        <label
                                                                                class="col-form-label col-lg-12">مساحة
                                                                            المنزل
                                                                        </label>
                                                                        <input type="number"
                                                                               class="form-control" id="home_space"
                                                                               name="home_space"
                                                                               value="{{ old('home_space')??$family->home_space }}"
                                                                               placeholder="مساحة المنزل">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    <!-- End col -->
                                                        <!-------------------------------------------->
                                                        @if($come_by == "urgent_coupon" || $family->visit_reason_id == 10)
                                                        <!-- Start col -->
                                                            <div
                                                                    class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                                <div class="form-group row">
                                                                    <div style="width: 95%;">
                                                                        <label
                                                                                class="col-form-label col-lg-12">الأملاك
                                                                            والعقارات


                                                                        </label>
                                                                        <select class="form-control"
                                                                                id="immovable_id"
                                                                                name="immovable_id">
                                                                            <option value=" " selected>أملاك وعقارات
                                                                            </option>
                                                                            @foreach(\App\Immovable::all()->sortBy('name') as $immovable)
                                                                                <option value="{{ $immovable->id }}"
                                                                                @if(old('immovable_id'))
                                                                                    {{ $immovable->id == old('immovable_id') ? 'selected':'' }}
                                                                                        @else
                                                                                    {{ (isset($family->immovable) && (!is_null($family->immovable)) && ($family->immovable->status == 0) && ( $immovable->id == 1) ) ? 'selected' : $immovable->id == $family->immovable_id ? 'selected':'' }}
                                                                                        @endif>{{ $immovable->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End col -->

                                                            <!-- Start col -->

                                                            @if((isset($family->immovable) && (!is_null($family->immovable)) && ($family->immovable->status == 0)))
                                                                <div
                                                                        class="col-lg-4 col-md-4 col-xl-4 col-sm-12"
                                                                        id="immovableOtherDivEdit">
                                                                    <div class="form-group row">
                                                                        <div style="width: 95%;">
                                                                            <label
                                                                                    class="col-form-label col-lg-12">أملاك
                                                                                وعقارات أخرى</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="immovable_other_edit"
                                                                                   value="{{ old('immovable_other_edit')??$family->immovable->name }}"
                                                                                   name="immovable_other_edit"
                                                                                   placeholder="أملاك وعقارات أخرى">
                                                                            <input type="hidden"
                                                                                   id="immovable_other_id_edit"
                                                                                   name="immovable_other_id_edit"
                                                                                   value="{{ old('immovable_other_id_edit')??$family->immovable->id }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div
                                                                    class="col-lg-4 col-md-4 col-xl-4 col-sm-12 d-none"
                                                                    id="immovableOtherDiv">
                                                                <div class="form-group row">
                                                                    <div style="width: 95%;">
                                                                        <label
                                                                                class="col-form-label col-lg-12">أملاك
                                                                            وعقارات أخرى
                                                                        </label>
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="immovable_other"
                                                                               value="{{ old('immovable_other')??(isset($family->immovable) && (!is_null($family->immovable))) ? $family->immovable->name  : '' }}"
                                                                               name="immovable_other"
                                                                               placeholder="أملاك وعقارات أخرى">
                                                                        <input type="hidden"
                                                                               id="immovable_other_id"
                                                                               name="immovable_other_id"
                                                                               value="{{  old('immovable_other_id')?? (isset($family->immovable) && (!is_null($family->immovable))) ? $family->immovable->id : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End col -->
                                                    @endif
                                                    <!--------------------------------------------->
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
                                                                        القرابة

                                                                    </label>
                                                                    <select class="form-control"
                                                                            id="representative_relationship_id"
                                                                            name="representative_relationship_id">
                                                                        <option value=" " selected>صلة القرابة</option>
                                                                        @foreach($relationships->sortBy('name') as $relationship)
                                                                            <option value="{{ $relationship->id }}"
                                                                            @if(old('representative_relationship_id'))
                                                                                {{ $relationship->id == old('representative_relationship_id') ? 'selected':'' }}
                                                                                    @else
                                                                                {{ (isset($family->representative_relationship) && (!is_null($family->representative_relationship)) && ($family->representative_relationship->status == 0) && ( $relationship->id == 1) ) ? 'selected' : $relationship->id == $family->representative_relationship_id ? 'selected':'' }}
                                                                                    @endif>{{ $relationship->name }}</option>
                                                                        @endforeach
                                                                    </select>
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
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="representative_relationship_other_edit"
                                                                               value="{{  old('representative_relationship_other_edit')??$family->representative_relationship->name }}"
                                                                               name="representative_relationship_other_edit"
                                                                               placeholder="المعيل">
                                                                        <input type="hidden"
                                                                               id="representative_relationship_other_id_edit"
                                                                               name="representative_relationship_other_id_edit"
                                                                               value="{{ old('representative_relationship_other_id_edit')??$family->representative_relationship->id }}">
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
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="representative_relationship_other"
                                                                           value="{{ old('representative_relationship_other')??(isset($family->representative_relationship) && (!is_null($family->representative_relationship))) ? $family->representative_relationship->name  : '' }}"
                                                                           name="representative_relationship_other"
                                                                           placeholder="صلة القرابة">
                                                                    <input type="hidden"
                                                                           id="representative_relationship_other_id"
                                                                           name="representative_relationship_other_id"
                                                                           value="{{   old('representative_relationship_other_id')?? (isset($family->representative_relationship) && (!is_null($family->representative_relationship))) ? $family->representative_relationship->id : '' }}">
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
                                                                    <input class="form-control numbers" id="representative_id"
                                                                           value="{{ old('representative_id_number')??!is_null($representative) ? $representative->id_number :null }}"
                                                                           name="representative_id_number" maxlength="9"
                                                                           placeholder="رقم هوية الوكيل">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End col -->
                                                        <!-- Start col -->
                                                        @if((!is_null($representative)) && (!is_null($representative->full_name)))
                                                           
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
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="representative_first_name"
                                                                           value="{{ old('representative_first_name')?? !is_null($representative) ? $representative->first_name : null }}"
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
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="representative_second_name"
                                                                           value="{{  old('representative_second_name')??!is_null($representative) ? $representative->second_name : null }}"
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
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="representative_third_name"
                                                                           value="{{  old('representative_third_name')??!is_null($representative) ? $representative->third_name : null }}"
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
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="representative_family_name"
                                                                           value="{{  old('representative_family_name')??!is_null($representative) ? $representative->family_name : null }}"
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
                                                                        <option value=" " selected>نوع العمل للوكيل
                                                                        </option>
                                                                        @foreach($jobTypes->sortBy('name') as $jobType)
                                                                            <option value="{{ $jobType->id }}"
                                                                            @if(old('representative_job_type_id'))
                                                                                {{ $jobType->id == old('representative_job_type_id') ? 'selected':'' }}
                                                                                    @else
                                                                                {{ $jobType->id == $family->representative_job_type_id ? 'selected':'' }}
                                                                                    @endif>{{ $jobType->name }}</option>
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
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="representative_reason"
                                                                           name="representative_reason"
                                                                           value="{{ old('representative_reason')??$family->representative_reason }}"
                                                                           placeholder="سبب الوكالة">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End col -->
                                                        <!-- Start col -->
                                                        <div class="row {{ $family->family_type_id == 5 ? '' : 'd-none' }}"
                                                             id="fatherLessDiv">
                                                            <div class="form-group col-md-4">
                                                                <label
                                                                        class="col-form-label col-lg-12">سبب وفاة الام
                                                                </label>
                                                                <div style="width: 90%;">
                                                                    <input type="text"
                                                                           class="form-control" id="mother_death_reason"
                                                                           value="{{ old('mother_death_reason')??$family->mother_death_reason }}"
                                                                           name="mother_death_reason"
                                                                           placeholder="سبب وفاة الام">
                                                                </div>
                                                            </div>
                                                            @if(!is_null($family->mother_death_date_old))
                                                                <div class="form-group col-md-4">
                                                                    <label class="col-form-label col-lg-12"> تاريخ وفاة
                                                                        الام
                                                                        (الارشيف )</label>
                                                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                           type="text"
                                                                           value="{{ $family->mother_death_date_old }}"
                                                                           style="width: 90%">
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label class="col-form-label col-lg-12"> تاريخ وفاة
                                                                        الام
                                                                    </label>
                                                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                           type="text"
                                                                           id="mother_death_date"
                                                                           value="{{old('mother_death_date')?? !is_null($family->mother_death_date) ? date('Y-m-d', strtotime($family->mother_death_date)) : null}}"
                                                                           name="mother_death_date"
                                                                           style="width: 90%">
                                                                </div>
                                                            @else
                                                                <div class="form-group col-md-4">
                                                                    <label class="col-form-label col-lg-12"> تاريخ وفاة
                                                                        الام
                                                                    </label>
                                                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                           type="text"
                                                                           id="mother_death_date"
                                                                           value="{{ old('mother_death_date')??!is_null($family->mother_death_date) ? date('Y-m-d', strtotime($family->mother_death_date)) : null}}"
                                                                           name="mother_death_date"
                                                                           style="width: 90%">
                                                                </div>
                                                            @endif
                                                            <div class="form-group col-md-4">
                                                                <label
                                                                        class="col-form-label col-lg-12">سبب وفاة الأب
                                                                </label>
                                                                <div style="width: 90%;">
                                                                    <input type="text"
                                                                           class="form-control" id="father_death_reason"
                                                                           value="{{ old('father_death_reason')??$family->father_death_reason }}"
                                                                           name="father_death_reason"
                                                                           placeholder="سبب وفاة الأب">
                                                                </div>
                                                            </div>
                                                            @if(!is_null($family->father_death_date_old))
                                                                <div class="form-group col-md-4">
                                                                    <label class="col-form-label col-lg-12"> تاريخ وفاة
                                                                        الأب
                                                                        (الارشيف )</label>
                                                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                           type="text"
                                                                           value="{{ $family->father_death_date_old }}"
                                                                           style="width: 90%">
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label class="col-form-label col-lg-12"> تاريخ وفاة
                                                                        الأب
                                                                    </label>
                                                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                           type="text"
                                                                           id="father_death_date"
                                                                           value="{{ old('father_death_date')??!is_null($family->father_death_date) ? date('Y-m-d', strtotime($family->father_death_date)) : null}}"
                                                                           name="father_death_date"
                                                                           style="width: 90%">
                                                                </div>
                                                            @else
                                                                <div class="form-group col-md-4">
                                                                    <label class="col-form-label col-lg-12"> تاريخ وفاة
                                                                        الأب
                                                                    </label>
                                                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                           type="text"
                                                                           id="father_death_date"
                                                                           value="{{ old('father_death_date')??!is_null($family->father_death_date) ? date('Y-m-d', strtotime($family->father_death_date)) : null}}"
                                                                           name="father_death_date"
                                                                           style="width: 90%">
                                                                </div>
                                                            @endif
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
                                                                    <select class="form-control kt-select2 select2-multi"
                                                                            id="family_type_id" name="family_type_id">
                                                                        <option value=" " selected> تصنيف الحالة
                                                                        </option>
                                                                        @foreach($types->sortBy('name') as $type)
                                                                            <option value="{{ $type->id }}"
                                                                            @if(old('family_type_id'))
                                                                                {{ $type->id == old('family_type_id') ? 'selected':'' }}
                                                                                    @else
                                                                                {{ $type->id == $family->family_type_id ? 'selected':'' }}
                                                                                    @endif>{{ $type->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End col -->

                                                        <!-- Start col -->
                                                        <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                            <div class="form-group row">
                                                                <div style="width: 95%;">
                                                                    <label
                                                                            class="col-form-label col-lg-12">تصنيف
                                                                        المشروع
                                                                        <span style="color:dodgerblue;">*</span>
                                                                    </label>
                                                                    <select class="form-control kt-select2 select2-multi"
                                                                            name="family_project_id">
                                                                        <option value=" " selected>تصنيف المشروع
                                                                        </option>
                                                                        @foreach($projects->sortBy('name') as $project)
                                                                            <option value="{{ $project->id }}"
                                                                            @if(old('family_project_id'))
                                                                                {{ $project->id == old('family_project_id') ? 'selected':'' }}
                                                                                    @else
                                                                                {{ $project->id == $family->family_project_id ? 'selected':'' }}
                                                                                    @endif>{{ $project->name .' '}}</option>
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
                                                                    <select class="form-control kt-select2 select2-multi"
                                                                            id="funded_institution_id"
                                                                            name="funded_institution_id">
                                                                        <option value=" " selected>الجهة المرشحة
                                                                        </option>
                                                                        @foreach($fundedInstitutions->sortBy('name') as $fundedInstitution)
                                                                            <option value="{{ $fundedInstitution->id }}"
                                                                            @if(old('funded_institution_id'))
                                                                                {{ $fundedInstitution->id == old('funded_institution_id') ? 'selected':'' }}
                                                                                    @else
                                                                                {{ (isset($family->fundedInstitution) && (!is_null($family->fundedInstitution)) && ($family->fundedInstitution->status == 0) && ( $fundedInstitution->id == 1) ) ? 'selected' : $fundedInstitution->id == $family->funded_institution_id ? 'selected':'' }}
                                                                                    @endif>{{ $fundedInstitution->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            @if((isset($family->fundedInstitution) && (!is_null($family->fundedInstitution)) && ($family->fundedInstitution->status == 0)))
                                                                <div class="form-group row"
                                                                     id="fundedInstitutionOtherDivEdit">
                                                                    <label
                                                                            class="col-form-label col-lg-12"> الجهة
                                                                        المرشحة
                                                                    </label>
                                                                    <div style="width: 90%;">
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="funded_institution_other_edit"
                                                                               value="{{ old('funded_institution_other_edit')??$family->fundedInstitution->name }}"
                                                                               name="funded_institution_other_edit"
                                                                               placeholder="الجهة المرشحة">
                                                                        <input type="hidden"
                                                                               id="funded_institution_other_id_edit"
                                                                               name="funded_institution_other_id_edit"
                                                                               value="{{ old('funded_institution_other_id_edit')??$family->fundedInstitution->id }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="form-group row  d-none"
                                                                 id="fundedInstitutionOtherDiv">
                                                                <label
                                                                        class="col-form-label col-lg-12"> الجهة المرشحة
                                                                </label>
                                                                <div style="width: 90%;">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="funded_institution_other"
                                                                           value="{{ old('funded_institution_other')??(isset($family->fundedInstitution) && (!is_null($family->fundedInstitution))) ? $family->fundedInstitution->name  : '' }}"
                                                                           name="funded_institution_other"
                                                                           placeholder="الجهة المرشحة">
                                                                    <input type="hidden"
                                                                           id="funded_institution_other_id"
                                                                           name="funded_institution_other_id"
                                                                           value="{{  old('funded_institution_other_id')?? (isset($family->fundedInstitution) && (!is_null($family->fundedInstitution))) ? $family->fundedInstitution->id : '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row  d-none"
                                                                 id="fundedInstitutionDiv">
                                                                <label
                                                                        class="col-form-label col-lg-12"> الجهة المرشحة
                                                                </label>
                                                                <div style="width: 90%;">
                                                                    <input type="text"
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
                                                                        <option value=" " selected>تقييم الحالة</option>

                                                                        <option value="1"
                                                                        @if(old('need'))
                                                                            {{ '1' == old('need') ? 'selected':'' }}
                                                                                @else
                                                                            {{ '1' == $family->need ? 'selected':'' }}
                                                                                @endif>
                                                                            يحتاج
                                                                        </option>
                                                                        <option value="0"
                                                                        @if(old('need'))
                                                                            {{ '0' == old('need') ? 'selected':'' }}
                                                                                @else{{ '0' == $family->need ? 'selected':'' }}
                                                                                @endif>
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
                                                                        الحالة
                                                                        <span style="color:dodgerblue;">*</span>
                                                                    </label>
                                                                    <select class="form-control kt-select2 select2-multi"
                                                                            id="family_status_id"
                                                                            name="family_status_id">
                                                                        <option value=" " selected>وضع الحالة</option>
                                                                        @foreach($statuses->sortBy('name') as $status)
                                                                            <option value="{{ $status->id }}"
                                                                            @if(old('family_status_id'))
                                                                                {{ $status->id == old('family_status_id') ? 'selected':'' }}
                                                                                    @else
                                                                                {{ $status->id == $family->family_status_id ? 'selected':'' }}
                                                                                    @endif>{{ $status->name }}</option>
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
                                                                            id="searcher_id" multiple
                                                                            name="searcher_id[]">
                                                                        <option value=" " disabled>الباحث</option>
                                                                        @foreach($users->sortBy('name') as $user)
                                                                            <option value="{{ $user->id }}"
                                                                            @if(old('searcher_id'))
                                                                                {{ in_array($user->id,old('searcher_id')) ? 'selected':'' }}
                                                                                    @else
                                                                                {{ isset($family_searcher)?in_array($user->id,$family_searcher) ?'selected':'':'' }}
                                                                                    @endif>{{ $user->full_name }}</option>
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
                                                                    <input type="text"
                                                                           class="form-control" id="data_entry_id"
                                                                           name="data_entry_id"
                                                                           placeholder="الادمن"
                                                                           value="{{ old('data_entry_id')??auth()->user()->user_name }}"
                                                                           readonly
                                                                    >
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
                                                                    فتح الاستمارة

                                                                </label>
                                                                <div style="width: 90%;">
                                        <input type="text" class="form-control" name="" value="{{ date('Y-m-d', strtotime($family->created_at)) }}"
                                                                           placeholder="تاريخ فتح الحالة"
                                                                           readonly>
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
                                                                        الزيارة
                                                                        {{$family->visit_reason_id}}
                                                                    </label>
                                                                    <select class="form-control kt-select2 select2-multi"
                                                                            id="visit_reason_id" name="visit_reason_id"
                                                                            @if($come_by == "urgent_coupon" ) readonly @endif
                                                                    >
                                                                        @if($come_by == "urgent_coupon")
                                                                            <option value="10"
                                                                                    selected>{{\App\VisitReason::find(10)->name}}</option>
                                                                        @elseif($come_by == "season_coupon")
                                                                            <option value="5"
                                                                                    selected>{{\App\VisitReason::find(5)->name}}</option>
                                                                        @else
                                                                            <option value=" " selected> نوع
                                                                الزيارة
                                                                            </option>
                                                                            @foreach($visitReasons->sortBy('name') as $visit)
                                                                                <option value="{{ $visit->id }}"
                                                                                @if(old('visit_reason_id'))
                                                                                    {{ $visit->id == old('visit_reason_id') ? 'selected':'' }}
                                                                                        @else
                                                                                        {{ $visit->id == $family->visit_reason_id ? 'selected':'' }}
                                                                                @endif>{{ $visit->name }}</option>
                                                                            @endforeach
                                                                        @endif
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
                                                                        <input type="hidden"
                                                                               id="visit_reason_other_edit"
                                                                               value="{{old('visit_reason_other_edit')?? $family->visit_reason->name }}"
                                                                               name="visit_reason_other_edit">
                                                                        <input type="hidden"
                                                                               id="visit_reason_other_id_edit"
                                                                               name="visit_reason_other_id_edit"
                                                                               value="{{ old('visit_reason_other_id_edit')??$family->visit_reason->id }}">
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
                                                                    <input type="text"
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
                                                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                       type="text"
                                                                       id="visit_mission_date"
                                                                       value="{{ old('visit_mission_date')??$family->visit_mission_date }}"
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

                                                                <textarea class="form-control" id="note" name="note"
                                                                          placeholder="ملاحظات">
                                                                    {{ old('note')??$family->note }}
                                                                </textarea>
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
                                                                <textarea class="form-control" id="searcher_note"
                                                                          name="searcher_note"
                                                                          placeholder="ملاحظات الباحث">
                                                                    {{ old('searcher_note')??$family->searcher_note }}
                                                                </textarea>
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
                                                                    الباحث بالتركي
                                                                    <span style="color:dodgerblue;">*</span>
                                                                </label>
                                                                <div style="width: 97%;">
                                                                    <textarea class="form-control" id="note_turkey"
                                                                              name="note_turkey"
                                                                              placeholder="ملاحظات الباحث بالتركية">
                                                                    {{ old('note_turkey')??$family->note_turkey }}
                                                                </textarea>
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
                                                                    الحالة
                                                                    <span style="color:dodgerblue;">*</span>
                                                                </label>
                                                                <div style="width: 95%;">
                                                                    <input type="text"
                                                                           class="form-control" id="code" name="code"
                                                                           value="{{ old('code')??$family->code }}"

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
                                                                    <input type="number"
                                                                           class="form-control" readonly
                                                                           name="visit_count"
                                                                           value="{{ old('visit_count')??$family->visit_count }}"
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
                                                    <!--طالب -->
                                                    <!-- start row -->
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                            <div class="form-group row">
                                                                <div style="width: 95%;">
                                                                    <label
                                                                            class="col-form-label col-lg-12">جهة
                                                                        الدراسة</label>
                                                                    <select class="form-control kt-select2 select2-multi"
                                                                            id="study_part_id" name="study_part_id">
                                                                        <option value=" " selected> جهة الدراسة</option>
                                                                        @foreach($studyParts->sortBy('name') as $studyPart)
                                                                            <option value="{{ $studyPart->id }}"
                                                                            @if(old('study_part_id'))
                                                                                {{ $studyPart->id == old('study_part_id') ? 'selected':'' }}
                                                                                    @else
                                                                                    {{ $studyPart->id == $family->study_part_id ? 'selected':'' }}
                                                                            @endif>{{ $studyPart->name }}</option>
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
                                                                        <option value=" " selected> المؤسسة التعليمية
                                                                        </option>
                                                                        @foreach($educationalInstitutions->sortBy('name') as $educationalInstitution)
                                                                            <option value="{{ $educationalInstitution->id }}"
                                                                            @if(old('educational_institution_id'))
                                                                                {{ $educationalInstitution->id == old('educational_institution_id') ? 'selected':'' }}
                                                                                    @else
                                                                                    {{ (isset($family->educational_institution) && (!is_null($family->educational_institution)) && ($family->educational_institution->status == 0) && ( $educationalInstitution->id == 1) ) ? 'selected' : $educationalInstitution->id == $family->educational_institution_id ? 'selected':'' }}
                                                                            @endif
                                                                            >{{ $educationalInstitution->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12 d-none"
                                                             id="educationalInstitutionOtherDiv">

                                                            <div class="form-group row ">
                                                                <label
                                                                        class="col-form-label col-lg-12">اسم المؤسسة
                                                                    التعليمية</label>
                                                                <div style="width: 90%;">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="educational_institution_other"
                                                                           value="{{ old('educational_institution_other')??(isset($family->educational_institution) && (!is_null($family->educational_institution))) ? $family->educational_institution->name  : '' }}"
                                                                           name="educational_institution_other">
                                                                    <input type="hidden"
                                                                           id="educational_institution_other_id"
                                                                           name="educational_institution_other_id"
                                                                           value="{{  old('educational_institution_other_id')?? (isset($family->educational_institution) && (!is_null($family->educational_institution))) ? $family->educational_institution->id : '' }}">
                                                                </div>
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
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="educational_institution_other_edit"
                                                                               value="{{ old('educational_institution_other_edit')?? $family->educational_institution->name }}"
                                                                               name="educational_institution_other_edit">
                                                                        <input type="hidden"
                                                                               id="educational_institution_other_other_id_edit"
                                                                               name="educational_institution_other_id_edit"
                                                                               value="{{ old('educational_institution_other_id_edit')??$family->educational_institution->id }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12 UNDiv {{ $family->family_type_id == 7 ? '' : 'd-none' }}">
                                                            <div class="form-group row">
                                                                <label
                                                                        class="col-form-label col-lg-12"> الرقم
                                                                    الجامعي</label>
                                                                <div style="width: 90%;" class="col-lg-12">
                                                                    <input type="number"
                                                                           class="form-control" id="id_university"
                                                                           value="{{ old('id_university')??$family->id_university }}"
                                                                           name="id_university"
                                                                           placeholder=" الرقم الجامعي">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12 UNDiv {{ $family->family_type_id == 7 ? '' : 'd-none' }}">
                                                            <div class="form-group row">
                                                                <label
                                                                        class="col-form-label col-lg-12">نوع
                                                                    الدراسة</label>
                                                                <select class="form-control kt-select2 select2-multi"
                                                                        id="study_type_id" name="study_type_id">
                                                                    <option value=" " selected> نوع الدراسة</option>
                                                                    @foreach($studyTypes->sortBy('name') as $studyType)
                                                                        <option value="{{ $studyType->id }}"
                                                                        @if(old('study_type_id'))
                                                                            {{ $studyType->id == old('study_type_id') ? 'selected':'' }}
                                                                                @else
                                                                                {{ $studyType->id == $family->study_type_id ? 'selected':'' }}
                                                                        @endif>{{ $studyType->name }}</option>
                                                                    @endforeach
                                                                </select>
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
                                                                        <option value=" " selected> المستوى الجامعي
                                                                        </option>
                                                                        @foreach($studyLevels->sortBy('name') as $studyLevel)
                                                                            <option value="{{ $studyLevel->id }}"
                                                                            @if(old('study_level_id'))
                                                                                {{ $studyLevel->id == old('study_level_id') ? 'selected':'' }}
                                                                                    @else
                                                                                    {{ $studyLevel->id == $family->study_level_id ? 'selected':'' }}
                                                                            @endif>{{ $studyLevel->name }}</option>
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
                                                                        <option value=" " selected> التخصص الجامعي
                                                                        </option>
                                                                        @foreach($universitySpecialties->sortBy('name') as $universitySpecialty)
                                                                            <option value="{{ $universitySpecialty->id }}"
                                                                            @if(old('university_specialty_id'))
                                                                                {{ $universitySpecialty->id == old('university_specialty_id') ? 'selected':'' }}
                                                                                    @else
                                                                                    {{ (isset($family->university_specialty) && (!is_null($family->university_specialty)) && ($family->university_specialty->status == 0) && ( $universitySpecialty->id == 1) ) ? 'selected' : $universitySpecialty->id == $family->university_specialty_id ? 'selected':'' }}
                                                                            @endif>{{ $universitySpecialty->name }}</option>
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
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="university_specialty_other_edit"
                                                                               value="{{ old('university_specialty_other_edit')??$family->university_specialty->name }}"
                                                                               name="university_specialty_other_edit">
                                                                        <input type="hidden"
                                                                               id="university_specialty_other_other_id_edit"
                                                                               name="university_specialty_other_id_edit"
                                                                               value="{{ old('university_specialty_other_id_edit')??$family->university_specialty->id }}">
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
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="university_specialty_other"
                                                                           value="{{ old('university_specialty_other')??(isset($family->university_specialty) && (!is_null($family->university_specialty))) ? $family->university_specialty->name  : '' }}"
                                                                           name="university_specialty_other">
                                                                    <input type="hidden" id="university_specialty_other"
                                                                           name="university_specialty_other_id"
                                                                           value="{{   old('university_specialty_other_id')??(isset($family->university_specialty) && (!is_null($family->university_specialty))) ? $family->university_specialty->id : '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                                                            <div class="form-group row">
                                                                <label class="col-form-label col-lg-12"> التاريخ المتوقع
                                                                    للتخرج</label>
                                                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                                                       type="text"
                                                                       id="graduated_date"
                                                                       value="{{ old('graduated_date')??!is_null($family->graduated_date) ? date('Y-m-d', strtotime($family->graduated_date)) : null}}"
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
                                                                    <input type="number"
                                                                           class="form-control" id="study_hour_price"
                                                                           value="{{ old('study_hour_price')??$family->study_hour_price }}"
                                                                           name="study_hour_price"
                                                                           placeholder="قيمة الساعة الدراسية">
                                                                </div>
                                                            </div>
                                                        </div>


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
                                                    @if($come_by == "urgent_coupon" || $family->visit_reason_id == 10)
                                                        <!-- Start col -->
                                                            <div
                                                                    class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
                                                                <div class="form-group row">
                                                                    <label
                                                                            class="col-form-label col-lg-12">عدد
                                                                        طلاب المدارس</label>
                                                                    <div style="width: 95%;">
                                                                        <input type="number"
                                                                               class="form-control"
                                                                               id="number_school_students"
                                                                               name="number_school_students"

                                                                               value="{{ old('number_school_students')??$family->number_school_students }}"
                                                                               placeholder="عدد طلاب المدارس">
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
                                                                        طلاب الجامعة</label>
                                                                    <div style="width: 95%;">
                                                                        <input type="number"
                                                                               class="form-control"
                                                                               id="number_university_students"
                                                                               name="number_university_students"

                                                                               value="{{ old('number_university_students')??$family->number_university_students }}"
                                                                               placeholder="عدد طلاب الجامعة">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End col -->
                                                        @endif

                                                        <div style="margin-bottom: 10px;">
                                                            <button
                                                                    class="btn btn-success btn-elevate"
                                                                    data-toggle="modal"
                                                                    data-target="#add_wife">اضافة
                                                                زوجة
                                                            </button>
                                                        </div>
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
                                                                    <input type="number"
                                                                           class="form-control" id="wive_count"
                                                                           name="wive_count"
                                                                           readonly
                                                                           value="{{ old('wive_count')??$family->wives->count() }}"
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
                                                                    <input type="number"
                                                                           class="form-control" id="member_count"
                                                                           name="member_count"
                                                                           readonly
                                                                           value="{{ old('member_count')??$family->members->count() }}"
                                                                           placeholder=" عدد الافراد">
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
                                                        <input id="family_id" name="family_id" hidden
                                                               value="{{ $family->id }}">
                                                        <div style="margin-bottom: 10px;">
                                                            <button class="btn btn-success btn-elevate btn-block"
                                                                    data-toggle="modal" data-target="#add-user">
                                                                اضافة فرد جديد
                                                            </button>
                                                        </div>
                                                        <!-- End col -->
                                                    </div>
                                                    <!-- End row -->
                                                    <!-- Start Row -->
                                                    <div class="row">
                                                        <!-- Start Table -->
                                                        <!-- Start Table  -->
                                                        <table class="table table-bordered table-hover"
                                                               id="member_table">
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
                                                                <td>

                                                                    @php $arrayData = []; @endphp
                                                                    @if ((isset($person->diseases)) && (!is_null($person->diseases)))
                                                                        @foreach ($person->diseases as $item)
                                                                            @if ((isset($item->disease)) && (!is_null($item->disease)))
                                                                                @php  array_push($arrayData, $item->disease->name); @endphp
                                                                            @endif
                                                                        @endforeach
                                                                    @endif

                                                                    @php echo implode(" | ", $arrayData); @endphp
                                                                </td>
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
                                        @endif
                                        <!--begin: Form Actions -->
                                            <div class="kt-form__actions">
                                                <button
                                                        class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u col-6"
                                                        data-ktwizard-type="action-prev"
                                                        style="margin-left: 10px">
                                                    السابق
                                                </button>

                                                <button
                                                        class="next btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                                        data-ktwizard-type="action-submit" type="submit">
                                                    حفظ
                                                </button>
                                                <button
                                                        class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u col-6"
                                                        data-ktwizard-type="action-next">
                                                    التالي
                                                </button>
                                            </div>


                                            <!--end: Form Actions -->
                                        </form>
                                        <!--end: Form Wizard Form-->
                                    </div>
                                </div>
                                @if(!($come_by))
                                    <div
                                            class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">

                                        <form class="kt-form" style="padding-top:0" data-parsley-validate method="post"
                                              action="{{ url('admin/families/approve/'.$family->id) }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="kt-form__actions w-100">
                                                    <button class="btn btn-primary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u mx-auto mt-3"
                                                            type="submit">إعتماد
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
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
                                               class="form-control arabic"
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
                                               class="form-control turkey"
                                               id="member_first_name_tr"
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
                                                <option value="{{ $socialStatus->id }}">{{ $socialStatus->name }}</option>
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
                                            <option value="1"> يعمل
                                            </option>
                                            <option value="0">لا يعمل
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
                                            الصحية

                                        </label>
                                        <select class="form-control "
                                                id="member_health_status"
                                                name="member_health_status">
                                            <option value=" " selected>
                                                الحالة الصحية
                                            </option>
                                            <option value="1">مريض
                                            </option>
                                            <option value="0">سليم
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12" id="member_diseasesDiv">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الأمراض</label>
                                        <select class="form-control kt-select2 select2-multi"
                                                multiple
                                                id="member_family_diseases"
                                                name="member_family_diseases[]">
                                            <option value=" " disabled>
                                                الأمراض
                                            </option>
                                            @foreach($diseases as $disease)
                                                <option value="{{ $disease->id }}">{{ $disease->name }}</option>
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
                                        <label class="col-form-label col-lg-12">تاريخ
                                            الميلاد</label>
                                        <input class="form-control datepicker"
                                               type="text"
                                               id="member_date_of_birth"
                                               name="member_date_of_birth"
                                               style="width: 95%" readonly="readonly">
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
                                                id="member_date_of_birth_place"
                                                name="member_date_of_birth_place">
                                            <option value=" " selected>
                                                مكان الميلاد
                                            </option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}"
                                                        {{$country->name == 'فلسطين' ?'selected':''}}
                                                        {{ $country->id == $person->date_of_birth_place ? 'selected':'' }}>{{ $country->name }}</option>
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
                                                <option value="{{ $qualification->id }}">{{ $qualification->name }}</option>
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
                                                <option value="{{ $relationship->id }}">{{ $relationship->name }}</option>
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


    <div class="modal fade" id="edit-user" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        تعديل فرد </h5>
                    <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="editMemberForm">
                    @csrf
                    <div class="modal-body">

                        <div class="row">

                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الاسم
                                            الاول بالعربية</label>
                                        <input type="text"
                                               class="form-control arabic"
                                               id="member_first_name_edit"
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
                                               class="form-control turkey"
                                               id="member_first_name_tr_edit"
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
                                               id="member_id_number_edit"
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
                                        <select class="form-control "
                                                id="member_social_status_id_edit"
                                                name="member_social_status_id">
                                            <option value=" " selected>
                                                الحالة الاجتماعية
                                            </option>
                                            @foreach($socialStatuses as $socialStatus)
                                                <option value="{{ $socialStatus->id }}">{{ $socialStatus->name }}</option>
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
                                        <select class="form-control "
                                                name="member_work"
                                                id="member_work_edit">
                                            <option value=" " selected>
                                                الحالة الوظيفية
                                            </option>
                                            <option value="1"> يعمل
                                            </option>
                                            <option value="0">لا يعمل
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
                                            الصحية

                                        </label>
                                        <select class="form-control "
                                                id="member_health_status_edit"
                                                name="member_health_status">
                                            <option value=" " selected>
                                                الحالة الصحية
                                            </option>
                                            <option value="1">مريض
                                            </option>
                                            <option value="0">سليم
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End col -->
                            <!-- Start col -->
                            <div class="col-lg-6 col-md-6 col-sm-12" id="member_diseasesDiv">
                                <div class="form-group row">
                                    <div style="width: 97%;">
                                        <label class="col-form-label col-lg-12">الأمراض</label>
                                        <select class="form-control kt-select2 select2-multi"
                                                multiple
                                                id="member_family_diseases_edit"
                                                name="member_family_diseases[]">
                                            <option value=" " disabled>
                                                الأمراض
                                            </option>
                                            @foreach($diseases as $disease)
                                                <option value="{{ $disease->id }}">{{ $disease->name }}</option>
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
                                        <label class="col-form-label col-lg-12">تاريخ
                                            الميلاد</label>
                                        <input class="form-control datepicker"
                                               type="text"
                                               id="member_date_of_birth_edit"
                                               name="member_date_of_birth"
                                               style="width: 95%" readonly="readonly">
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
                                        <select class="form-control "
                                                id="member_date_of_birth_place_edit"
                                                name="member_date_of_birth_place">
                                            <option value=" " selected>
                                                مكان الميلاد
                                            </option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}"
                                                        {{$country->name == 'فلسطين' ?'selected':''}}
                                                        {{ $country->id == $person->date_of_birth_place ? 'selected':'' }}>{{ $country->name }}</option>
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
                                        <select class="form-control "
                                                name="member_qualification_id"
                                                id="member_qualification_id_edit">
                                            <option value=" " selected>
                                                الحالة التعليمية
                                            </option>
                                            @foreach($qualifications as $qualification)
                                                <option value="{{ $qualification->id }}">{{ $qualification->name }}</option>
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
                                                id="member_relationship_id_edit">
                                            <option value=" " selected>
                                                صلة القرابة
                                            </option>
                                            @foreach($relationships as $relationship)
                                                <option value="{{ $relationship->id }}">{{ $relationship->name }}</option>
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
                                               id="member_relationship_other_edit"
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
                        <button type="submit" id="editMemberButton"
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
                                               class="form-control arabic"
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
                                               class="form-control arabic"
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
                                               class="form-control arabic"
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
                                               class="form-control arabic"
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
                                        <select class="form-control "
                                                name="wive_relationship_id"
                                                id="wive_relationship_id">
                                            <option value=" " selected>
                                                صلة
                                                القرابة
                                            </option>
                                            @foreach($relationships as $relationship)
                                                @if(($relationship->id == 25) || ($relationship->id == 44) || ($relationship->id == 45) || ($relationship->id == 27)
                                                || ($relationship->id == 32)  || ($relationship->id == 33)  || ($relationship->id == 34)  )
                                                    <option value="{{ $relationship->id }}">{{ $relationship->name }}</option>
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
        //editRow
        function editRow(item) {

            var id = item.getAttribute('the_id');

            $.get("/admin/families/person_ajax_id?q=" + id, function (member, status) {

                arr = member.diseases;
                var new_arr = arr.map(function (value, index, array) {

                    return value.id;

                });


                $("#member_first_name_edit").val(member.first_name);
                $("#member_first_name_tr_edit").val(member.first_name_tr);
                $("#member_id_number_edit").val(member.id_number);
                $("#member_social_status_id_edit").val(member.social_status_id);
                $("#member_work_edit").val(member.work);
                $("#member_health_status_edit").val(member.health_status);
                $("#member_family_diseases_edit").val(new_arr).change();
                $("#member_date_of_birth_edit").val(member.date_of_birth);
                $("#member_date_of_birth_place_edit").val(member.date_of_birth_place);
                $("#member_qualification_id_edit").val(member.qualification_id);
                $("#member_relationship_id_edit").val(member.member.relationship_id);
                $("#editMemberButton").val(member.id);

                console.log(new_arr);
                $("#edit-user").modal("show");
            });


            return false;

        };
    </script>

    <script>
        var url = '{{ url('admin/families/add/getTranslation') }}';


        $("#member_first_name_tr").click(function () {
            var name = $('#member_first_name').val();

            if (name != '') {
                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: url,
                    data: {name: name}
                }).done(function (transName) {

                    console.log(transName);
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

        $("#member_first_name_tr_edit").click(function () {
            var name = $('#member_first_name_edit').val();

            if (name != '') {
                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: url,
                    data: {name: name}
                }).done(function (transName) {

                    console.log(transName);
                    if ((transName == '') || (transName == null)) {
                        $('#member_first_name_tr_edit').css('border-color', 'red');
                    } else {
                        $('#member_first_name_tr_edit').val(transName);
                        $('#member_first_name_tr_edit').css('border-color', 'green');
                    }
                });

            } else {
                $('#member_first_name_tr_edit').css('border-color', 'red');
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
    </script>
    <script>
        $("[name='date_of_birth']").datepicker({
            format: 'yyyy',
            minViewMode: 2,
            orientation: "bottom auto",
            autoclose: true,
            clearBtn: true,
        });
    </script>
    <script>
        $("[name='member_date_of_birth']").datepicker({
            format: 'yyyy',
            minViewMode: 2,
            orientation: "bottom auto",
            autoclose: true,
            clearBtn: true,
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
                            .text(city.name+"-"+city.name_tr));
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
                            .text(city.name+"-"+city.name_tr));
                    $('.cities[value="' + city.id + '"]')
                        .attr('selected', iselected);
                });
            });
        }

        function checktruefalse(id) {
            @if($family->neighborhood)
            if (id == '{{$family->neighborhood->city_id}}') {
                return true
            } else
                return false
            @else
                return false
            @endif
        }
    </script>
    <script>
        $(document).ready(function () {
            var city_id = $("[name='city_id']").val();
            $.get("/admin/cities/neighborhoods/" + city_id, function (data, status) {
                if(typeof data=='object'){
                $("[name='neighborhood_id']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="neighborhoods" value=" ">جميع الأحياء</option>');
                data.forEach(function (neighborhood) {
                    var iselected = checktruefalse2(neighborhood.id);
                    $("[name='neighborhood_id']")
                        .append($("<option class='neighborhoods'></option>")
                            .attr("value", neighborhood.id)
                            .text(neighborhood.name+"-"+neighborhood.name_tr));

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
                $("[name='neighborhood_id']")
                    .find('option')
                    .remove()
                    .end()
                    .append('<option class="neighborhoods" value=" ">جميع الأحياء</option>');
                data.forEach(function (neighborhood) {
                    var iselected = checktruefalse2(neighborhood.id);
                    $("[name='neighborhood_id']")
                        .append($("<option class='neighborhoods'></option>")
                            .attr("value", neighborhood.id)
                            .text(neighborhood.name+"-"+neighborhood.name_tr));
                    $('.neighborhoods[value="' + neighborhood.id + '"]')
                        .attr('selected', iselected);
                });
                }
            });
        }

        function checktruefalse2(id) {
            if (id == '{{$family->neighborhood_id}}') {
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
                "                <select class=\"form-control kt-select2 select2-multi\" id=\"income_type_id\" name=\"income_type_id[]\">\n" +
                "                <option value=\" \" selected>  جهات الدخل" +
                "                </option>" +
                "                @foreach($incomeTypes->sortBy('name') as $incomeType)" +
                "                    <option value=\"{{ $incomeType->id }}\">{{ $incomeType->name }}</option>" +
                "                @endforeach" +
                "            </select>" +
                "            </div>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "    <!-- End col -->\n" +
                "    <!-- Start col -->\n" +
                "    <div class=\"col-lg-3 col-md-4\">\n" +
                "        <div class=\"form-group row\">\n" +
                "            <label class=\"col-form-label col-lg-12 \">قيمة الدخل</label>\n" +
                "            <div style=\"width: 86%;\">\n" +
                "                <input type=\"number\"  maxlength=\"10\" class=\"form-control income_type_value\" name=\"income_type_value[]\" placeholder=\"قيمة الدخل\">\n" +
                "            </div>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "    <!-- End col -->\n" +
                "    <!-- Start col -->\n" +
                "    <div class=\"col-lg-4 col-md-4\">\n" +
                "        <div class=\"form-group row\">\n" +
                "            <label class=\"col-form-label col-lg-12\">ملاحظات الدخل</label>\n" +
                "            <div style=\"width: 86%;\">\n" +
                "                <input type=\"text\" class=\"form-control\" id=\"income_note\" name=\"income_note[]\" placeholder=\"ملاحظات الدخل\">\n" +
                "            </div>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "    <!-- End col -->\n" +
                "\n" +
                "    <!-- Start col -->\n" +
                "    <div class=\"col-md-2\">\n" +
                "        <label class=\"col-form-label col-lg-12\" style=\"opacity: 0;\">حذف</label>\n" +
                "        <input type=\"button\" class=\"btn btn-danger btn-elevate \" value=\"-\" onclick=\"removeRow(this)\">\n" +
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


            $("body").on("keyup", "#income_value", function () {
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

            $("body").on("keyup", ".income_type_value", function () {

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
            $('#member_diseasesDiv').hide();
            $("#member_health_status").change(function () {
                var id = $(this).children(":selected").attr("value");
                if (id == 1) {
                    $('#member_diseasesDiv').show().removeClass("d-none");
                } else if (id == 0) {
                    $('#member_diseasesDiv').hide();

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
                var member_family_diseases = $('#member_family_diseases').val();
                var member_id_number = $('#member_id_number').val();
                var member_date_of_birth = $('#member_date_of_birth').val();
                var member_first_name = $('#member_first_name').val();
                var member_date_of_birth_place = $('#member_date_of_birth_place').val();

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

                        member_date_of_birth_place: member_date_of_birth_place,
                        member_relationship_id: member_relationship_id,
                        member_qualification_id: member_qualification_id,
                        member_date_of_birth: member_date_of_birth,
                        member_id_number: member_id_number,
                        member_first_name: member_first_name,
                        member_first_name_tr: member_first_name_tr,
                        member_family_diseases: member_family_diseases,

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


            $('#editMemberButton').click(function (e) {
                e.preventDefault();
                var person_id = this.value;

                var addMemberUrl = '../../../admin/families/editNewMember/' + person_id + '/' + '{{$family->id}}'

                var member_social_status_id = $('#member_social_status_id_edit').val();
                var member_health_status = $('#member_health_status_edit').val();
                var member_work = $('#member_work_edit').val();
                var member_qualification_id = $('#member_qualification_id_edit').val();
                var member_relationship_id = $('#member_relationship_id_edit').val();
                var member_family_diseases = $('#member_family_diseases_edit').val();
                var member_id_number = $('#member_id_number_edit').val();
                var member_date_of_birth = $('#member_date_of_birth_edit').val();
                var member_date_of_birth_place = $('#member_date_of_birth_place_edit').val();
                var member_first_name = $('#member_first_name_edit').val();
                var member_first_name_tr = $('#member_first_name_tr_edit').val();

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
                        member_date_of_birth_place: member_date_of_birth_place,
                        member_first_name: member_first_name,
                        member_first_name_tr: member_first_name_tr,
                        member_family_diseases: member_family_diseases,

                    }
                }).done(function (data) {
                    if (data != 'error') {
                        $('#member_social_status_id_edit').val('');
                        $('#member_health_status_edit').val('');
                        $('#member_work_edit').val('');
                        $('#member_qualification_id_edit').val('');
                        $('#member_relationship_id_edit').val('');
                        $('#member_id_number_edit').val('');
                        $('#member_date_of_birth_edit').val('');
                        $('#member_first_name_edit').val('');
                        $('#member_first_name_tr_edit').val('');
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

            // show hide relations
            $("#immovable_id").change(function () {
                var id = $(this).children(":selected").attr("value");
                $('#immovable_other_edit').val('');
                $('#immovable_other_id_edit').val('');
                $('#immovable_other_id').val('');
                $('#immovable_other').val('');

                if (id == 1) {
                    // $('#breadwinnerOtherDivEdit').show().removeClass("d-none");
                    $('#immovableOtherDiv').show().removeClass("d-none");
                } else {
                    $('#immovableOtherDiv').hide();
                    $('#immovableOtherDivEdit').hide();
                }
            });
            $('#diseasesDiv').hide();
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
                $('.UNDiv').show().removeClass("d-none");
                $('#fatherLessDiv').hide();
            } else if (id == 5) {
                $('.UNDiv').hide();
                $('#fatherLessDiv').show().removeClass("d-none");
            } else {
                $('.UNDiv').hide();
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


