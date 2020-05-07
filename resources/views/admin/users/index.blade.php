@extends('layouts.dashboard.app')

@section('pageTitle','إدارة المستخدمين')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة المستخدمين')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/users')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إدارة المستخدمين
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <form>
                    <div class="row">


                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">بحث من خلال الاسم</label>
                                <div style="width: 95%;">
                                    <input class="form-control" placeholder=" اكتب الاسم  " id="name" name="full_name"
                                           value="{{$full_name}}"
                                           type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">بحث من خلال رقم الهوية</label>
                                <div style="width: 95%;">
                                    <input class="form-control numbers" placeholder=" اكتب الهوية  " id="id_number"
                                           name="id_number"
                                           value="{{$id_number}}" type="text"
                                           maxlength="9"
                                           minlength="9">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">بحث من خلال البريد الإلكتروني</label>
                                <div style="width: 95%;">
                                    <input class="form-control" placeholder=" اكتب الإيميل  " id="email" name="email"
                                           value="{{$email}}"
                                           type="email">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->


                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">بحث من خلال الجوال أو الهاتف</label>
                                <div style="width: 95%;">
                                    <input class="form-control" placeholder=" اكتب الجوال أو الهاتف " id="the_mobile"
                                           name="the_mobile"
                                           value="{{$the_mobile}}"
                                           type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ ميلاد من</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="from_date_of_birth" type="text"
                                           value="{{$from_date_of_birth}}"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ ميلاد إلى</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="to_date_of_birth" type="text"
                                           value="{{$to_date_of_birth}}"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ عمل من</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="from_work_start_date"
                                           value="{{$from_work_start_date}}"
                                           type="text"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12 ">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ عمل إلى</label>
                                <div style="width: 95%;">
                                    <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" name="to_work_start_date" type="text"
                                           value="{{$to_work_start_date}}"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">المحافظة</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="governorate_id" name="governorate_id" onchange="get_cities()">
                                        <option value=" " selected> المحافظة</option>
                                        @foreach($governorates->sortBy('name') as $governorate)
                                            <option value="{{$governorate->id}}"
                                                    @if($governorate->id==$governorate_id) selected @endif>{{$governorate->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">المدينة</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="city_id" name="city_id" onchange="get_neighborhoods()">
                                        <option value=" " selected> المدينة</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">الحي
                                    </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="neighborhood_ids" name="neighborhood_ids[]" multiple="multiple">
                                        <option value=" " disabled>الحي</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">بحث من خلال العنوان</label>
                                <div style="width: 95%;">
                                    <input class="form-control" placeholder=" اكتب العنوان " id="the_address"
                                           name="the_address"
                                           value="{{$the_address}}" type="text">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">القسم
                                    </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="department_ids" name="department_ids[]" multiple="multiple">
                                        <option value=" ">اختر القسم</option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}"
                                                    @if(in_array($department->id, $department_ids)) selected @endif>{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">الحالة
                                        الإجتماعية</label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="social_status_ids" name="social_status_ids[]" multiple="multiple">
                                        <option value=" ">الحالة الاجتماعية</option>
                                        @foreach($social_statuses as $social_status)
                                            <option value="{{$social_status->id}}"
                                                    @if(in_array($social_status->id, $social_status_ids)) selected @endif>{{$social_status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">التخصص الجامعي </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="university_specialty_ids" name="university_specialty_ids[]"
                                            multiple="multiple">
                                        <option value=" "> التخصص الجامعي</option>
                                        @foreach($university_specialties as $university_specialty)
                                            <option value="{{$university_specialty->id}}"
                                                    @if(in_array($university_specialty->id, $university_specialties_ids)) selected @endif>{{$university_specialty->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">من الرقم</label>
                                <div style="width: 95%;">
                                    <input class="form-control" type="number" name="from_id" value="{{$from_id}}"
                                           placeholder="اختر id" max="{{$max_id}}"
                                           min="{{$min_id}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">إلى الرقم</label>
                                <div style="width: 95%;">
                                    <input class="form-control" type="number" name="to_id" value="{{$to_id}}"
                                           placeholder="اختر id" max="{{$max_id}}"
                                           min="{{$min_id}}">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 95%;">
                                    <label class="col-form-label col-lg-12">تحديد الأعمدة المعروضة </label>
                                    <select class="form-control kt-select2 select2-multi"
                                            id="coulmn" name="coulmn[]" multiple="multiple">
                                        <option value="id"
                                                @if(collect($coulmn)->contains('id'))selected @endif>#
                                        </option>
                                        <option value="select"
                                                @if(collect($coulmn)->contains('select'))selected @endif>تحديد
                                        </option>
                                        <option value="image"
                                                @if(collect($coulmn)->contains('image'))selected @endif>
                                            الصورة
                                        </option>
                                        <option value="full_name"
                                                @if(collect($coulmn)->contains('full_name'))selected @endif>
                                            الاسم رباعي
                                        </option>
                                        <option value="departmen"
                                                @if(collect($coulmn)->contains('departmen'))selected @endif>
                                            القسم
                                        </option>
                                        <option value="email"
                                                @if(collect($coulmn)->contains('email'))selected @endif>البريد
                                            الالكتروني
                                        </option>
                                        <option value="id_number"
                                                @if(collect($coulmn)->contains('id_number'))selected @endif>
                                            الهوية
                                        </option>
                                        <option value="address"
                                                @if(collect($coulmn)->contains('address'))selected @endif>
                                            العنوان
                                        </option>
                                        <option value="mobile_one"
                                                @if(collect($coulmn)->contains('mobile_one'))selected @endif>
                                            جوال 1
                                        </option>
                                        <option value="mobile_two"
                                                @if(collect($coulmn)->contains('mobile_two'))selected @endif>
                                            جوال 2
                                        </option>
                                        <option value="mobile"
                                                @if(collect($coulmn)->contains('mobile'))selected @endif>
                                            هاتف أرضي
                                        </option>
                                        <option value="work_start_date"
                                                @if(collect($coulmn)->contains('work_start_date'))selected @endif>
                                            تاريخ بدء العمل
                                        </option>
                                        <option value="social_status"
                                                @if(collect($coulmn)->contains('social_status'))selected @endif>
                                            الحالة الاجتماعية
                                        </option>
                                        <option value="university_specialty"
                                                @if(collect($coulmn)->contains('university_specialty'))selected @endif>
                                            التخصص الجامعي
                                        </option>
                                        <option value="date_of_birth"
                                                @if(collect($coulmn)->contains('date_of_birth'))selected @endif>
                                            تاريخ الميلاد
                                        </option>
                                        <option value="suspend"
                                                @if(collect($coulmn)->contains('suspend'))selected @endif>
                                            فعال
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
                        <!-- Start col -->
                        <div class="col-md-12">
                            <div class="form-group row">
                                <button type="submit"
                                        class="btn btn-success  col mr-3" name="theaction"
                                        value="search">بحث
                                </button>
                                <button type="submit"
                                        class="btn btn-success  col mr-3" name="theaction"
                                        value="print">طباعة
                                </button>
                                <button type="submit"
                                        class="btn btn-success  col mr-3" name="theaction"
                                        value="excel">تصدير
                                </button>
                            </div>
                        </div>
                        <!-- End col -->

                    </div>
                </form>
                <!-- Start Row -->
                <div class="row">
                    <form action="/admin/users/print_group">
                        <input type="hidden" name="the_ids" id="myIds1">
                        <div class="input-field col s12 m3">

                            <button type="submit"
                                    class="btn btn-success  col" name="theaction"
                                    value="print">طباعة صلاحيات المحدد
                            </button>
                        </div>
                    </form>
                    <form action="/admin/users/delete_group">
                        <input type="hidden" name="the_ids" id="myIds2">
                        <button type="submit"
                                class="btn btn-success col" name="theaction"
                                value="delete">حذف المحدد
                        </button>
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
                        عرض المستخدمين
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
                            @if(collect($coulmn)->contains('image'))
                                <th style="width: 5%;">الصوره
                                </th>@endif
                            @if(collect($coulmn)->contains('full_name'))
                                <th style="width: 20%;">الاسم رباعي
                                </th>@endif
                            @if(collect($coulmn)->contains('id_number'))
                                <th style="width: 20%;">رقم الهوية
                                </th>@endif
                            @if(collect($coulmn)->contains('email'))
                                <th style="width: 15%">البريد الإلكتروني
                                </th>@endif
                            @if(collect($coulmn)->contains('address'))
                                <th style="width: 101px;">العنوان
                                </th>@endif
                            @if(collect($coulmn)->contains('mobile_one'))
                                <th style="width: 15%;">جوال1
                                </th>@endif
                            @if(collect($coulmn)->contains('mobile_two'))
                                <th style="width: 15%;">جوال2
                                </th>@endif
                            @if(collect($coulmn)->contains('mobile'))
                                <th style="width: 15%;">هاتف أرض
                                </th>@endif
                            @if(collect($coulmn)->contains('work_start_date'))
                                <th style="width: 15%;">تاريخ بدء العمل
                                </th>@endif
                            @if(collect($coulmn)->contains('departmen'))
                                <th style="width: 5%;">القسم
                                </th>@endif
                            @if(collect($coulmn)->contains('social_status'))
                                <th style="width: 5%;">الحالة الاجتماعية
                                </th>@endif
                            @if(collect($coulmn)->contains('university_specialty'))
                                <th style="width: 5%;">التخصص الجامعي
                                </th>@endif
                            @if(collect($coulmn)->contains('date_of_birth'))
                                <th style="width: 5%;">تاريخ الميلاد
                                </th>@endif
                            @if(collect($coulmn)->contains('suspend'))
                                <th style="width: 5%;">فعال
                                </th>@endif
                            @if(collect($coulmn)->contains('operations'))
                                <th style="width: 10%;">العمليات
                                </th>@endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
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
                                @if(collect($coulmn)->contains('image'))
                                    <td>
                                        @if(((!is_null($item->image)) && (!is_null($item->image)) && (($item->image != ''))))
                                            <img height="30" width="30" alt="user"
                                                 src="{{ asset($item->image) }}">
                                        @else
                                            <img height="30" width="30"
                                                 src="{{asset('new_theme/assets/media/users/default.jpg')}}"
                                                 alt="user">
                                        @endif
                                    </td>@endif
                                @if(collect($coulmn)->contains('full_name'))
                                    <td>{{$item->full_name}}</td>@endif
                                @if(collect($coulmn)->contains('id_number'))
                                    <td>{{$item->id_number}}</td>@endif
                                @if(collect($coulmn)->contains('email'))
                                    <td>{{$item->email}}</td>@endif
                                @if(collect($coulmn)->contains('address'))
                                    <td>@if($item->neighborhood){{$item->neighborhood->name ?? ""}}
                                        /{{$item->neighborhood->city->name ?? ""}}
                                        / {{$item->neighborhood->city->governorate->name ?? ""}}
                                        / @endif {{$item->address}}</td>@endif
                                @if(collect($coulmn)->contains('mobile_one'))
                                    <td>{{$item->mobile_one}}</td>@endif
                                @if(collect($coulmn)->contains('mobile_two'))
                                    <td>{{$item->mobile_two}}</td>@endif
                                @if(collect($coulmn)->contains('mobile'))
                                    <td>{{$item->mobile}}</td>@endif
                                @if(collect($coulmn)->contains('work_start_date'))
                                    <td>{{$item->work_start_date?date('d-m-Y', strtotime($item->work_start_date)):""}}</td>@endif
                                @if(collect($coulmn)->contains('departmen'))
                                    <td>@if($item->department){{$item->department->name}}@endif</td>@endif
                                @if(collect($coulmn)->contains('university_specialty'))
                                    <td>@if($item->university_specialty){{$item->university_specialty->name}}@endif</td>@endif
                                @if(collect($coulmn)->contains('social_status'))
                                    <td>@if($item->social_status){{$item->social_status->name}}@endif</td>@endif
                                @if(collect($coulmn)->contains('date_of_birth'))
                                    <td>{{$item->date_of_birth?date('d-m-Y', strtotime($item->date_of_birth)):""}}</td>@endif
                                @if(collect($coulmn)->contains('suspend'))
                                    <td>
                                        <div class="">
															<span
                                                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
																<label>
																	<input class="cbActive" type="checkbox"
                                                                           @if(auth()->user()->hasPermissionTo(6))
                                                                           {{$item->getAllPermissions()->first()?"checked disabled title='المستخدم_موقف' ":""}} value="{{$item->id}}"
                                                                           @else
                                                                           {{$item->getAllPermissions()->first()?"checked ":""}}disabled
                                                                           title="لا تملك صلاحية ايقاف مستخدم"
                                                                           value="{{$item->id}}"
                                                            @endcan>
																	<span></span>
																</label>
															</span>
                                        </div>
                                    </td>@endif
                                @if(collect($coulmn)->contains('operations'))
                                    <td>
                                        <!-- <button type="button" class="btn btn-danger btn-elevate">حذف</button> -->
                                        <!-- <button type="button" class="btn btn-success btn-elevate ">تعديل</button> -->
                                        <div class="dropdown dropdown-inline">
                                            <button type="button"
                                                    class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="la la-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="/admin/users/{{$item->id}}/edit"><i
                                                            class="fa fa-pen"></i>
                                                    تعديل
                                                </a>
                                                <a class="dropdown-item" href="/admin/users/getLog/{{$item->id}}">
                                                    <i class="fa fa-sign"></i>سجل العمليات</a>
                                                <a class="dropdown-item" href="/admin/users/his_tasks/{{$item->id}}"><i
                                                            class="fa fa-signal"></i>مهام له</a>
                                                <a class="dropdown-item" href="/admin/users/tasks/{{$item->id}}"><i
                                                            class="fa fa-signal"></i>مهام عليه</a>
                                                
                                                <a class="dropdown-item" href="/admin/users/permission/{{$item->id}}">
                                                    <i class="fa fa-shopping-bag"></i>
                                                    صلاحيات</a>
                                                <a class="dropdown-item Confirm" href="/admin/users/delete/{{$item->id}}">
                                                    <i class="fa fa-trash"></i>
                                                    حذف</a>
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
            {{$items->links()}}

            <!--end: Pagination-->
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
            $(".cbActive").change(function () {

                var id = $(this).val();
                var mythis = this;

                $.ajax({
                    url: "/admin/users/suspend/" + id,
                    data: {_token: '{{ csrf_token() }}'},
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
                        mythis.checked = false;
                    },
                });
            });

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
@endsection