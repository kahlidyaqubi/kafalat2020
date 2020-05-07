@extends('layouts.dashboard.app')

@section('pageTitle','تعديل جمعية')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('new_theme/assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الجمعيات')
@section('navigation3','تعديل جمعية')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/institutions')
@section('navigation3_link','/admin/institutions/'.$institution->id.'/edit')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل جمعية
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form method="post"
                      action="{{ url('admin/institutions/'.$institution->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" name="come_by" value="{{$come_by??""}}">
                    <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">إسم الجمعية
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input class="form-control arabic" id="name" name="name" type="text"
                                           value="{{ old('name')??$institution->name}}" placeholder="إسم الجمعية">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الشخص المسؤول
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input class="form-control" id="responsible_person" name="responsible_person"
                                           type="text"
                                           value="{{ old('responsible_person')??$institution->responsible_person}}"
                                           placeholder="الشخص المسؤول">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الجوال - 1
                                    <span style="color:red;">*</span>
                                </label>
                                <div class="input-group" style="width: 95%;">
                                    <input class="form-control numbers"
                                           value="{{ old('mobile_one')??$institution->mobile_one }}"
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
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الجوال - 2</label>
                                <div class="input-group" style="width: 95%;">
                                    <input class="form-control numbers"
                                           value="{{ old('mobile_two')??$institution->mobile_two }}"
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
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الهاتف</label>
                                <div class="input-group" style="width: 95%;">
                                    <input class="form-control numbers"
                                           value="{{ old('mobile')??$institution->mobile }}" name="mobile"
                                           maxlength="9" minlength="7"
                                           placeholder="الهاتف" aria-describedby="basic-addon1">
                                    <div class="input-group-prepend"><span class="input-group-text">
																	<span class="fa fa-phone"></span>
																	970+</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                                                <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">المحافظة
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi" id="governorate_id"
                                            name="governorate_id" onchange="get_cities()">
                                        <option value=" " selected> المحافظة</option>
                                        @foreach($governorates->sortBy('name') as $governorate)
                                            <option value="{{$governorate->id}}"
                                                    @if(old('governorate_id'))
                                                    {{ $governorate->id == old('governorate_id') ? 'selected':'' }}
                                                    @else
                                                    @if($institution->neighborhood)
                                                    @if($institution->neighborhood->city)
                                                    @if($institution->neighborhood->city->governorate)
                                                    @if($governorate->id== $institution->neighborhood->city->governorate->id) selected @endif
                                                    @endif
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
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">المدينة
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi" id="city_id"
                                            name="city_id" onchange="get_neighborhoods()">
                                        <option value=" " selected> المدينة</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الحي
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi" id="neighborhood_id"
                                            name="neighborhood_id" id="neighborhood_id" onchange="neighborhood_other()">
                                        <option value=" " selected>الحي</option>
                                        <option value="1" class="other" >أخرى</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 neighborhood_other" style="display: none">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">حي آخر
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input class="form-control" id="neighborhood_id_other"
                                           name="neighborhood_id_other" type="text"
                                           value="{{ old("neighborhood_id_other")}}"
                                           placeholder="الحي">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">عنوان السكن
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <input class="form-control" name="address" type="text"
                                           value="{{old('address')??$institution->address}}" placeholder="عنوان السكن">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">جهة الترخيص
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi" name="licensor_id"
                                            id="licensor_id" onchange="licensor_other()">
                                        <option value=" " selected>جهة الترخيص</option>
                                        @foreach($licensors->sortBy('name') as $licensor)
                                            <option value="{{$licensor->id}}"
                                                    @if(old('licensor_id'))
                                                    {{ $licensor->id == old('licensor_id') ? 'selected':'' }}
                                                    @else
                                                    @if($licensor->id==$institution->licensor_id) selected @endif
                                                    @endif>{{$licensor->name}} {{ !is_null($licensor->name_tr) ? ' ( ' .$licensor->name_tr .' )' : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 licensor_other" style="display: none">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">جهة ترخيص آخر
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input class="form-control" id="licensor_id_other"
                                           name="licensor_id_other" type="text"
                                           value="{{ old("licensor_id_other")}}"
                                           placeholder="اسم جهة الترخيص">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الترخيص
                                </label>
                                <div style="width: 95%;">
                                    <input minlength="3" class="form-control" id="licensor_number" name="licensor_number"
                                           type="number"
                                           value="{{ old('licensor_number')??$institution->licensor_number}}"
                                           placeholder="رقم الترخيص">
                                </div>

                            </div>
                        </div>
                        
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">مجال عمل الجمعية
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi"
                                            name="institution_type_id" id="institution_type_id"
                                            onchange="institution_type_other()">
                                        <option value=" " selected>مجال عمل الجمعية</option>
                                        @foreach($institution_types->sortBy('name') as $institution_type)
                                            <option value="{{$institution_type->id}}"
                                                    @if(old('institution_type_id'))
                                                    {{ $institution_type->id == old('institution_type_id') ? 'selected':'' }}
                                                    @else
                                                    @if($institution_type->id==$institution->institution_type_id) selected @endif
                                                    @endif>{{$institution_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 institution_type_other" style="display: none">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">مجال عمل جمعية آخر
                                    <span style="color:red;">*</span>
                                </label>
                                <div style="width: 95%;">
                                    <input class="form-control" id="institution_type_id_other"
                                           name="institution_type_id_other" type="text"
                                           value="{{ old("institution_type_id_other")}}"
                                           placeholder="مجال عمل الجمعية">
                                </div>

                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">فئات الاستهداف
                                    <span style="color:red;">*</span></label>
                                <div style="width: 95%;">
                                    <select class="form-control kt-select2 select2-multi" name="target_types_ids[]"
                                            id="target_types_ids" multiple>
                                        <option value=" " disabled>فئة الاستهداف</option>
                                        @foreach($target_types as $target_type)
                                            <option value="{{$target_type->id}}"
                                                    @if(old('target_types_ids'))
                                                    {{ in_array($target_type->id,old('target_types_ids')) ? 'selected':'' }}
                                                    @else
                                                    @if(collect($institution->target_types->pluck('id')->toArray())->contains($target_type->id))selected @endif
                                                    @endif>{{$target_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                       <div class="col-lg-4 col-md-6 col-12" >
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">فئات أخرى
                                </label>
                                <div style="width: 100%;">
                                    <input style="width: 100%; class="form-control" type="text" 
                                           value="{{old("other_targets")}}" name="other_targets" data-role="tagsinput">
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
                    
                    <!-- Start Row -->
                    <div class="row">

                    @if($institution->institution_media->first())
                        @foreach($institution->institution_media as $media)
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

                                                 no-repeat center center;background-size: contain;"
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
                                                <a href="{{ url('admin/institutions/removeMedia/'.$media->id) }}"
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
    @if($institution->institution_media->first())
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
    <script src="{{asset('new_theme/assets/js/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('.bootstrap-tagsinput input').on('keypress', function (e) {
                if (e.keyCode == 13) {
                    e.keyCode = 188;
                    e.preventDefault();
                }
                ;
            });
        });
    </script>
    <script>
        function institution_type_other() {
            if ($('#institution_type_id').val() == 1) {
                $('.institution_type_other').show();
            } else {
                $('.institution_type_other').hide();
                $('#institution_type_id_other').val("");
            }
        }

        function neighborhood_other() {
            if ($('#neighborhood_id').val() == 1) {
                $('.neighborhood_other').show();
            } else {
                $('.neighborhood_other').hide();
                $('#neighborhood_id_other').val("");
            }
        }

        function licensor_other() {
            if ($('#licensor_id').val() == 1) {
                $('.licensor_other').show();
            } else {
                $('.licensor_other').hide();
                $('#licensor_id_other').val("");
            }
        }

        $(document).ready(function () {
            if ($('#institution_type_id').val() == 1) {
                $('.institution_type_other').show();
            } else {
                $('.institution_type_other').hide();
                $('#institution_type_id_other').val("");
            }
            if ($('#neighborhood_id').val() == 1) {
                $('.neighborhood_other').show();
            } else {
                $('.neighborhood_other').hide();
                $('#neighborhood_id_other').val("");
            }
            if ($('#licensor_id').val() == 1) {
                $('.licensor_other').show();
            } else {
                $('.licensor_other').hide();
                $('#licensor_id_other').val("");
            }
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
            @if($institution->neighborhood)
            if (id == '{{$institution->neighborhood->city_id}}') {
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
                    .end();
                      $("[name='neighborhood_id']").append('<option class="neighborhoods" value=" " selected>جميع الأحياء</option>');
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
                    .end();
                      $("[name='neighborhood_id']").append('<option class="neighborhoods" value=" " selected>جميع الأحياء</option>');
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
            if (id == '{{$institution->neighborhood_id}}') {
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