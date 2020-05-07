@extends('layouts.dashboard.app')

@section('pageTitle','تعديل مستخدم')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة المستخدمين')
@section('navigation3','تعديل مستخدم')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/users')
@section('navigation3_link','/admin/users/'.$user->id.'/edit')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل مستخدم
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form enctype="multipart/form-data"
                      method="post"
                      action="{{ url('admin/users/'.$user->id) }}">
                @csrf
                @method('put')
                <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">اسم الموظف
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" id="first_name" name="first_name" type="text"
                                           value="{{old('first_name')?old('first_name'):$user->first_name}}"
                                           placeholder="اسم الموظف">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">إسم الأب
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" id="second_name" name="second_name" type="text"
                                           value="{{old('second_name')?old('second_name'):$user->second_name}}"
                                           placeholder="إسم الأب">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">إسم الجد
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" id="third_name" name="third_name" type="text"
                                           value="{{old('third_name')?old('third_name'):$user->third_name}}"
                                           placeholder="إسم الجد">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">إسم العائلة
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" id="family_name" name="family_name" type="text"
                                           value="{{old('family_name')?old('family_name'):$user->family_name}}"
                                           placeholder="إسم العائلة">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">إسم المستخدم
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" id="user_name" name="user_name" type="text"
                                           value="{{old('user_name')?old('user_name'):$user->user_name}}"
                                           placeholder="اسم المستخدم">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">البريد الإلكتروني
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" name="email" type="text"
                                           value="{{old('email')?old('email'):$user->email}}"
                                           placeholder="البريد الإلكتروني">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الهوية
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control numbers" type="text" maxlength="9" minlength="9" class="numbers"
                                           name="id_number"
                                           value="{{old('id_number')?old('id_number'):$user->id_number}}"
                                           placeholder="رقم الهوية">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ الميلاد
                                    <span style="color:red;">*</span></label>
                                <input required  class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text" name="date_of_birth"
                                       value="{{old('date_of_birth')?old('date_of_birth'):$user->date_of_birth}}"
                                       style="width: 95%" placeholder="تاريخ الميلاد">
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">تاريخ بدء العمل
                                    <span style="color:red;">*</span></label>
                                <input  required class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text" name="work_start_date"
                                       value="{{old('work_start_date')?old('work_start_date'):$user->work_start_date}}"
                                       style="width: 95%" placeholder="تاريخ بدء العمل">
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الحالة الاجتماعية
                                    <span style="color:red;">*</span></label>
                                <div style="width: 100%;">
                                    <select required  class="form-control kt-select2 select2-multi" name="social_status_id">
                                        <option value="" selected>الحالة الاجتماعية</option>
                                        @foreach($social_statuses->sortBy('name') as $social_status)
                                            <option value="{{$social_status->id}}"
                                                    @if($social_status->id==$user->social_status_id) selected @endif>{{$social_status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الجوال - 1
                                    <span style="color:red;">*</span>
                                </label>
                                <div class="input-group" style="width: 95%;">
                                    <input  required class="form-control numbers"
                                           value="{{ old('mobile_one')?old('mobile_one'):$user->mobile_one }}"
                                           name="mobile_one"
                                           maxlength="10" minlength="9" aria-describedby="basic-addon1"
                                           placeholder="رقم الجوال">
                                    <div class="input-group-prepend"><span class="input-group-text">
																	<span class="fa fa-phone"></span>
																	970+</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الجوال - 2</label>
                                <div class="input-group" style="width: 95%;">
                                    <input class="form-control numbers" value="{{ $user->mobile_two }}"
                                           name="mobile_two"
                                           maxlength="10" minlength="9" aria-describedby="basic-addon1"
                                           placeholder=" رقم الجوال 2">
                                    <div class="input-group-prepend"><span class="input-group-text">
																	<span class="fa fa-phone"></span>
																	970+</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">هاتف أرضي</label>
                                <div class="input-group" style="width: 95%;">
                                    <input class="form-control numbers" name="mobile"
                                           value="{{ $user->mobile }}"
                                           maxlength="9" minlength="7"
                                           placeholder="هاتف أرضي" aria-describedby="basic-addon1">
                                    <div class="input-group-prepend"><span class="input-group-text">
																	<span class="fa fa-phone"></span>
																	970+</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">التخصص الجامعي
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi"
                                            name="university_specialty_id">
                                        <option value="" selected>التخصص الجامعي</option>
                                        @foreach($university_specialties->sortBy('name') as $university_specialty)
                                            <option value="{{$university_specialty->id}}"
                                                    @if($university_specialty->id==$user->university_specialty_id) selected @endif>{{$university_specialty->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">القسم
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi" name="department_id">
                                        <option value="" selected>القسم</option>
                                        @foreach($departments->sortBy('name') as $department)
                                            <option value="{{$department->id}}"
                                                    @if($department->id==$user->department_id) selected @endif>{{$department->name}} {{ !is_null($department->name_tr) ? ' ( ' .$department->name_tr .' )' : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">المحافظة
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi" id="governorate_id"
                                            name="governorate_id" onchange="get_cities()">
                                        <option value="" selected> المحافظة</option>
                                        @foreach($governorates->sortBy('name') as $governorate)
                                            <option value="{{$governorate->id}}"
                                                    @if($user->neighborhood)
                                                    @if($user->neighborhood->city)
                                                    @if($user->neighborhood->city->governorate)
                                                    @if($governorate->id== $user->neighborhood->city->governorate->id) selected @endif
                                                    @endif
                                                    @endif
                                                    @endif>{{$governorate->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">المدينة
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi" id="city_id"
                                            name="city_id" onchange="get_neighborhoods()">
                                        <option value="" selected> المدينة</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الحي
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select  required class="form-control kt-select2 select2-multi" id="neighborhood_id"
                                            name="neighborhood_id">
                                        <option value="" selected>الحي</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">عنوان السكن
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input  required class="form-control" name="address" type="text"
                                           value="{{$user->address}}" placeholder="عنوان السكن">
                                </div>
                            </div>
                        </div>


                    </div>
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
                        <div class=" col-lg-3 col-md-3">
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
                                            onclick="addRow()">اضافة مرفق
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                    </div>
                    <div id="content">

                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-12">
                        <!--<div class="form-group row">-->
                        <!--    <div style="width: 95%;">-->
                        <!--        <input type="submit" class="btn btn-success btn-elevate " value="تعديل">-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                         <button type="submit"
                            class="btn btn-success btn-elevate btn-block ">تعديل
                        <span id="wating" class="" style="display: none">                            &nbsp;&nbsp;
                            <span class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </span>
                            <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                        </span>
                    </button>
                    </div>
                    <!-- End col -->
                    <br/>
                    <!-- Start Row -->
                    <div class="row">

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
                    </div>
                    <!-- End Row -->
                </form>
            </div>
        </div>
        <!--end::Portlet-->
    </div>
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
    <!-- end:: Content -->
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