@extends('layouts.dashboard.app')

@section('pageTitle',' تعديل الصفحة الشخصية' . ' '.$user->first_name." ".$user->family_name)
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}">

@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','الملف الشخصي')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/profile/edit')
@section('content')
    <!-- Start Col -->
    <div class="col-lg-3 col-xl-3">
        <div class="kt-portlet kt-portlet--height-fluid-">
            <div class="kt-portlet__head  kt-portlet__head--noborder"></div>
            <div class="kt-portlet__body kt-portlet__body--fit-y">
                <!--begin::Widget -->
                <div class="kt-widget kt-widget--user-profile-1">
                    <div class="kt-widget__head">
                        <div class="kt-widget__media">
                            @if(((!is_null($user->image)) && (!is_null($user->image)) && (($user->image != ''))))
                                <img src="{{ asset($user->image) }}">
                            @else
                                <img src="../../assets/images/users/2.jpg"/>
                            @endif
                        </div>
                        <div class="kt-widget__content">
                            <div class="kt-widget__section">
                                <a class="kt-widget__username">
                                    {{ !is_null($user->user_name) ? $user->user_name : '-' }}
                                    <i class="flaticon2-correct kt-font-success"></i>
                                </a>
                                <span class="kt-widget__subtitle">
															{{ isset($user->department)? '  قسم  ' . $user->department->name : '-' }}
														</span>
                            </div>

                        </div>
                    </div>
                    <div class="kt-widget__body">
                        <div class="kt-widget__content">
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">البريد الالكتروني:</span>
                                <a href="#" class="kt-widget__data">{{ !is_null($user->email) ? $user->email :'-' }}</a>
                            </div>
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">الجوال:</span>
                                <a href="#" class="kt-widget__data">{{ $user->mobile_one }}
                                    @if(!is_null($user->mobile_two))
                                        {{ ' - '. $user->mobile_two }}
                                    @endif</a>
                            </div>
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">تاريخ الميلاد:</span>
                                <span class="kt-widget__data">{{ !is_null($user->date_of_birth) ? date('Y-m-d', strtotime($user->date_of_birth)) : '-' }}</span>
                            </div>
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">رقم الهوية:</span>
                                <span class="kt-widget__data">{{ !is_null($user->id_number) ? $user->id_number : '-' }}</span>
                            </div>
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">الحالة الاجتماعية:</span>
                                <span class="kt-widget__data">{{ isset($user->social_status) ? $user->social_status->name : '-' }}</span>
                            </div>
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">العنوان:</span>
                                <span class="kt-widget__data">{{ isset($user->governorate) ? $user->governorate->name .' - ' : '-' }}
                                    {{ isset($user->neighborhood) ? $user->neighborhood->name .' - ' : '-' }}
                                    {{ $user->address }}</span>
                            </div>
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">تاريخ مباشرة العمل:</span>
                                <span class="kt-widget__data"> {{ !is_null($user->work_start_date) ? date('Y-m-d', strtotime($user->work_start_date)) : '-'}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Widget -->
            </div>
        </div>
    </div>
    <!-- End Col -->
    <!-- Start Col -->
    <div class="col-lg-9 col-xl-9">
        <!--begin:: Widgets/Tasks -->
        <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand"
                        role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab1"
                               role="tab">
                                تعديل الملف الشخصي
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab2" role="tab">
                                حركة المستخدم
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab3" role="tab">
                                تعديل كلمة السر
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab4" role="tab">
                                المرفقات
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <form enctype="multipart/form-data" action="{{ url('admin/profile/update') }}"
                              method="post">
                        @csrf
                        <!-- Start Row -->
                            <div class="row">
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">إسم
                                            الموظف</label>
                                        <div style="width: 95%;">
                                            <input class="form-control" id="first_name" name="first_name" type="text"
                                                   value="{{$user->first_name}}" placeholder="إسم الموظف">
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">إسم الاب</label>
                                        <div style="width: 95%;">
                                            <input class="form-control" id="second_name" name="second_name" type="text"
                                                   value="{{$user->second_name}}" placeholder="إسم الاب">
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">إسم الجد</label>
                                        <div style="width: 95%;">
                                            <input class="form-control" id="third_name" name="third_name" type="text"
                                                   value="{{$user->third_name}}" placeholder="إسم الجد">
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">إسم
                                            العائلة</label>
                                        <div style="width: 95%;">
                                            <input class="form-control" id="family_name" name="family_name" type="text"
                                                   value="{{$user->family_name}}" placeholder="إسم العائلة">
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">إسم
                                            المستخدم
                                            <span style="color:red;">*</span></label>
                                        <div style="width: 95%;">
                                            <input  required class="form-control" id="user_name" type="text" name="user_name"
                                                   value="{{ $user->user_name }}" placeholder="إسم المستخدم">
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">البريد
                                            الإلكتروني
                                            <span style="color:red;">*</span></label>
                                        <div style="width: 95%;">
                                            <input  required class="form-control" id="email" type="email"
                                                   name="email" value="{{$user->email}}"
                                                   placeholder="البريد الإلكتروني">
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">رقم
                                            الهوية</label>
                                        <div style="width: 95%;">
                                            <input class="form-control numbers" id="id_number" maxlength="9"
                                                   name="id_number" value="{{$user->id_number}}"
                                                   placeholder="رقم الهوية">
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">تاريخ
                                            الميلاد</label>
                                        <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                               type="text" id="date_of_birth" name="date_of_birth"
                                               value="{{$user->date_of_birth}}" style="width: 95%">
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">تاريخ بدء
                                            العمل</label>
                                        <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly"
                                               type="text" id="work_start_date" name="work_start_date"
                                               value="{{$user->work_start_date}}" style="width: 95%">
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">الحالة
                                            الاجتماعية</label>
                                        <div style="width: 100%;">
                                            <select
                                                    class="form-control kt-select2 select2-multi"
                                                    name="social_status_id">
                                                <option value=" " selected>الحالة الاجتماعية</option>
                                                @foreach($social_statuses as $social_status)
                                                    <option value="{{$social_status->id}}"
                                                            @if($social_status->id==$user->social_status_id) selected @endif>{{$social_status->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">رقم الجوال -
                                            1
                                            </label>
                                        <div class="input-group" style="width: 95%;">
                                            <input type="text" class="form-control numbers" id="mobile_one"
                                                   value="{{ $user->mobile_one }}"
                                                   name="mobile_one"
                                                   aria-describedby="basic-addon1">
                                            <div class="input-group-prepend"><span
                                                        class="input-group-text">
																			<span class="fa fa-phone"></span>
																			970+
																		</span></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">رقم الجوال -
                                            2</label>
                                        <div class="input-group" style="width: 95%;">
                                            <input type="text" class="form-control numbers" id="mobile_two"
                                                   value="{{ $user->mobile_two }}"
                                                   name="mobile_two"
                                                   aria-describedby="basic-addon1">
                                            <div class="input-group-prepend"><span
                                                        class="input-group-text">
																			<span class="fa fa-phone"></span>
																			970+</span></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">هاتف أرضي
                                        </label>
                                        <div class="input-group" style="width: 95%;">
                                            <input type="text" class="form-control numbers" id="mobile"
                                                   value="{{ $user->mobile}}"
                                                   name="mobile"
                                                   maxlength="9" minlength="8"
                                                   aria-describedby="basic-addon1">
                                            <div class="input-group-prepend"><span
                                                        class="input-group-text">
																			<span class="fa fa-phone"></span>
																			970+</span></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">العنوان</label>
                                        <div style="width: 95%;">
                                            <input type="text" class="form-control" name="address"
                                                   value="{{$user->address}}" placeholder="العنوان">
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">التخصص
                                            الجامعي</label>
                                        <div style="width: 100%;">
                                            <select
                                                    class="form-control kt-select2 select2-multi"
                                                    name="university_specialty_id">
                                                <option value=" " selected>التخصص الجامعي</option>
                                                @foreach(\App\UniversitySpecialty::all() as $item)
                                                    <option value="{{$item->id}}"
                                                            @if($item->id==$user->university_specialty_id) selected @endif>{{$item->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">المحافظة</label>
                                        <div style="width: 100%;">
                                            <select
                                                    class="form-control kt-select2 select2-multi"
                                                    id="governorate_id"
                                                    name="governorate_id" onchange="get_cities()">
                                                <option value=" " selected> المحافظة</option>
                                                @foreach(\App\Governorate::orderBy('name')->get() as $governorate)
                                                    <option value="{{$governorate->id}}"
                                                            @if($governorate->id==old("governorate_id")) selected @endif
                                                            @if($user->neighborhood)
                                                            @if($user->neighborhood->city)
                                                            @if($user->neighborhood->city->governorate)
                                                            @if($governorate->id== $user->neighborhood->city->governorate->id) selected @endif
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
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">المدينة</label>
                                        <div style="width: 100%;">
                                            <select
                                                    class="form-control kt-select2 select2-multi"
                                                    id="city_id"
                                                    name="city_id" onchange="get_neighborhoods()">
                                                <option value=" " selected> المدينة</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">الحي</label>
                                        <div style="width: 100%;">
                                            <select
                                                    class="form-control kt-select2 select2-multi"
                                                    name="neighborhood_id" id="neighborhood_id"
                                                    onchange="neighborhood_other()">
                                                <option value=" " selected>الحي</option>
                                                <option value="1" class="other" >أخرى</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">الصورة
                                            الشخصية</label>
                                        <div class="">
                                            <div class="kt-avatar kt-avatar--outline"
                                                 id="kt_user_avatar">
                                                @if(((!is_null($user->image)) && (!is_null($user->image)) && (($user->image != ''))))
                                                    <div class="kt-avatar__holder"
                                                         style="background-image: url({{ asset($user->image) }})">
                                                    </div>
                                                @else
                                                    <div class="kt-avatar__holder"
                                                         style="background-image: url('../../assets/images/users/2.jpg')">
                                                    </div>
                                                @endif

                                                <label class="kt-avatar__upload"
                                                       data-toggle="kt-tooltip" title=""
                                                       data-original-title="Change avatar">
                                                    <i class="fa fa-pen"></i>
                                                    <input name="image" accept="image/png, image/jpeg, image/jpg"
                                                           type="file">
                                                </label>
                                                <span class="kt-avatar__cancel"
                                                      data-toggle="kt-tooltip" title=""
                                                      data-original-title="Cancel avatar">
																			<i class="fa fa-times"></i>
																		</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <!--<div class="col-md-3">-->
                                <!--    <div class="form-group row">-->
                                <!--        <div style="width: 95%;">-->
                                <!--            <button type="submit"-->
                                <!--                    class="btn btn-success btn-elevate btn-block ">تحديث-->
                                <!--                الملف الشخصي-->
                                <!--            </button>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!-- End col -->
                                                                
                                <!-- Satrt Button Confirm -->
                                <div class="col-12">
                                    <button type="submit"
                                            class="btn btn-success btn-elevate btn-block ">تحديث الملف الشخصي
                                        <span id="wating" class="" style="display: none">                            &nbsp;&nbsp;
                                            <span class="spinner-border text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </span>
                                            <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                                        </span>
                                    </button>
                                </div>
                                <!-- End  Button Confirm -->


                            </div>
                            <!-- Start Row -->
                        </form>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <form>
                            <!-- Start Table  -->
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                <tr class="text-center">
                                    <th class="big-col">التاريخ</th>
                                    <th class="big-col">الوقت</th>
                                    <th class="big-col-400">الحركه</th>
                                    <th class="big-col">نوع الحركه</th>
                                    <th class="big-col">المستخدم</th>
                                    <th class="big-col">عنوان IP</th>
                                    <th class="big-col">بيانات المتصفح</th>
                                    <th>الجهاز</th>
                                </tr>
                                </thead>
                            </table>
                            <!-- End Table  -->
                        </form>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <form method="post" action="{{ url('admin/profile/updatePassword') }}">
                            @csrf
                            <div class="row">
                                <!-- Start col -->
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">كلمة السر
                                            الحالية</label>
                                        <div style="width: 95%;">
                                            <input class="form-control" type="password"
                                                   id="current_password" name="current_password"
                                                   placeholder="كلمة السر الحالية">
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">كلمة السر
                                            الجديدة</label>
                                        <div style="width: 95%;">
                                            <input type="password" class="form-control" id="password" name="password"
                                                   placeholder="كلمة السر الجديدة">
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start col -->
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">تأكيد كلمة
                                            السر</label>
                                        <div style="width: 95%;">
                                            <input type="password" class="form-control" id="password_confirmation"
                                                   name="password_confirmation" placeholder="تأكيد كلمة السر">
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->

                                <!-- Satrt Button Confirm -->
                                <div class="col-12">
                                    <button type="submit"
                                            class="btn btn-success btn-elevate btn-block ">تعديل
                                                كلمة السر
                                        <span id="wating" class="" style="display: none">                            &nbsp;&nbsp;
                                            <span class="spinner-border text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </span>
                                            <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                                        </span>
                                    </button>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab4">

                        <form action="{{ url('admin/profile/addMedia') }}"
                              method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Start col -->
                                <div class=" col-lg-3 col-md-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">نوع المرفق</label>
                                        <div style="width: 90%;">
                                            <select class="form-control" id="file_type_id" name="file_type_id[]">
                                                <option value=" " disabled selected>عنوان المرفق</option>
                                                @foreach(\App\FileType::all() as $file)
                                                    <option value="{{ $file->id }}">{{ $file->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->
                                <!-- Start Col -->
                                <div class="col-lg-3 col-md-3" id="otherFileTypeDiv">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12">مرفقات أخرى</label>
                                        <div style="width: 95%;">
                                            <input type="text" class="form-control" name="file_type_id_other[]"
                                                   placeholder="مرفقات أخرى">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Col -->
                                <!-- Start col -->
                                <div class=" col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label col-lg-12">الملف</label>
                                        <div></div>
                                        <div xclass="custom-file">
                                            <input type="file" xclass="custom-file-input" name="files[]"
                                                   id="customFile">
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
                                                    onclick="addRow()">اضافة مرفق
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- End col -->

                            </div>
                            <div id="content">

                            </div>
                           
                            <!-- Satrt Button Confirm -->
                                <div class="col-12">
                                    <button type="submit"
                                            class="btn btn-success btn-elevate btn-block ">حفظ المرفقات
                                        <span id="wating" class="" style="display: none">                            &nbsp;&nbsp;
                                            <span class="spinner-border text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </span>
                                            <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                                        </span>
                                    </button>
                                </div>
                                <!-- End  Button Confirm -->
                                <br/>
                                
                        </form>
                        <!-- Start Row -->
                        <div class="row">
                            <!-- Start col -->
                        @if($user->user_media->first())
                            @foreach($user->user_media as $media)
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

                                                     no-repeat center center; background-size: contain;"
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
                                                    <a href="{{ url('admin/profile/removeMedia/'.$media->id) }}"
                                                       class="Confirm"><i
                                                                class="fa fa-window-close"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End col -->
                            @endforeach
                        @endif
                        <!-- End col -->
                        </div>
                        <!-- End Row -->

                    </div>
                </div>
            </div>
        </div>
        <!--end:: Widgets/Tasks -->
    </div>
    <!-- End Col -->
    @if($user->user_media->first())
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
    <script src="{{asset('new_theme/assets/js/pages/custom/user/profile.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/new_theme/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
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
            @if($user->neighborhood)
            if (id == '{{$user->neighborhood->city_id}}') {
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
                            .text(neighborhood.name));
                    $('.neighborhoods[value="' + neighborhood.id + '"]')
                        .attr('selected', iselected);
                });
                }
            });
        }

        function checktruefalse2(id) {
            if (id == '{{$user->neighborhood_id}}') {
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
        var url = "{{ url('admin/profile/getLogs') }}";
        var table = $('#table').DataTable({
            responsive: true,
            "processing": true,
            "searching": true,
            "order": [[0, "desc"]],
            "serverSide": true,
            "ajax": url,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
            },
            columns: [
                {data: 'date', name: 'date', width: '5%'},
                {data: 'time', name: 'time', width: '5%'},
                {data: 'message', name: 'message', width: '50%'},
                {data: 'category', name: 'category', width: '25%'},
                {data: 'user', name: 'user', width: '5%'},
                {data: 'ip_address', name: 'ip_address'},
                {data: 'agent', name: 'agent', width: 200},
                {data: 'device', name: 'device'},
            ],
        });
    </script>
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

        function addRow() {
            i++;
            document.querySelector('#content').insertAdjacentHTML(
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
                '        <input type="button" class="btn btn-danger btn-elevate " value="-" onclick="removeRow(this)"/>\n' +
                '    </div>\n' +
                '\n' +
                '</div>'
            );

            showSelect(i);

            function showSelect(i) {
                // show hide file type
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

        function removeRow(input) {
            document.getElementById('content').removeChild(input.parentNode.parentNode);
        };
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


