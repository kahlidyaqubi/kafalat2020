@extends('layouts.dashboard.app')
@section('pageTitle','إدارة إعدادات البرنامج العامة')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة إعدادات البرنامج العامة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/settings')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        ادارة اعدادت البرنامج العامة
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form enctype="multipart/form-data"
                      action="{{ url('admin/settings/update') }}"
                      method="post">
                @csrf
                {{ method_field('PATCH') }}
                <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">اسم الجمعية</label>
                                <div style="width: 98%;">
                                    <input type="text" class="form-control arabic" id="name" name="name"
                                           value="{{ !is_null($name) ? $name->value : '' }}" placeholder="اسم المؤسسة">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">العنوان</label>
                                <div style="width: 98%;">
                                    <input type="text" class="form-control" id="address" name="address"
                                           value="{{ !is_null($address) ? $address->value : '' }}"
                                           placeholder="العنوان">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الجوال - 1</label>
                                <div class="input-group" style="width: 95%;">
                                    <input type="text" class="form-control numbers"
                                           id="number_one"
                                           value="{{ !is_null($number_one) ? $number_one->value : '' }}"
                                           name="number_one" maxlength="10" minlength="9"
                                           aria-describedby="basic-addon1">
                                    <div class="input-group-prepend"><span class="input-group-text">
																<span class="fa fa-phone"></span>
																970+</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رقم الجوال - 2</label>
                                <div class="input-group" style="width: 95%;">
                                    <input type="text" class="form-control numbers" id="number_two"
                                           value="{{ !is_null($number_two) ? $number_two->value : '' }}"
                                           name="number_two" maxlength="10" minlength="9"
                                           aria-describedby="basic-addon1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">970+</span>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col phon-->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الهاتف</label>
                                <div class="input-group" style="width: 95%;">
                                    <input class="form-control numbers" type="text"  id="phone"
                                           value="{{ !is_null($phone) ? $phone->value : '' }}"
                                           name="phone" maxlength="9" minlength="7"
                                           aria-describedby="basic-addon1" placeholder="الهاتف" >
                                    
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">970+</span>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Start col fax-->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">الفاكس</label>
                                <div class="input-group" style="width: 95%;">
                                    <input class="form-control numbers" type="text"  id="fax"
                                           value="{{ !is_null($fax) ? $fax->value : '' }}"
                                           name="fax" maxlength="9" minlength="7"
                                           aria-describedby="basic-addon1" placeholder="الفاكس" >
                                    
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">970+</span>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col fax -->
                         
                         <!-- Start col old fax -->
                        <!--<div class="col-lg-3 col-md-6 col-sm-12">-->
                        <!--    <div class="form-group row">-->
                        <!--        <label class="col-form-label col-lg-12">الفاكس</label>-->
                        <!--        <div style="width: 95%;">-->
                        <!--            <input class="form-control numbers" id="fax" name="fax"-->
                        <!--                   value="{{ !is_null($fax) ? $fax->value : '' }}"-->
                        <!--                   maxlength="7" minlength="7" placeholder="الفاكس">-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!-- End col old fax-->
                        
                        <!-- Start col old phon-->
                        <!--<div class="col-lg-3 col-md-6 col-sm-12">-->
                        <!--    <div class="form-group row">-->
                        <!--        <label class="col-form-label col-lg-12">الهاتف</label>-->
                        <!--        <div style="width: 95%;">-->
                        <!--            <input class="form-control numbers" id="phone" name="phone"-->
                        <!--                   value="{{ !is_null($phone) ? $phone->value : '' }}" maxlength="10"-->
                        <!--                   placeholder="الهاتف">-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!-- End col old phon-->

                        
                        <!-- Start col email-->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">البريد الالكتروني</label>
                                <div style="width: 95%;">
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ !is_null($email) ? $email->value : '' }}"
                                           placeholder="البريد الالكتروني">
                                </div>
                            </div>
                        </div>
                        <!-- End col email-->


                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رابط الفيس بوك</label>
                                <div style="width: 95%;">
                                    <input type="url" class="form-control" id="facebook" name="facebook"
                                           value="{{ !is_null($facebook) ? $facebook->value : '' }}"
                                           placeholder="رابط الفيس بوك">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رابط اليوتيوب</label>
                                <div style="width: 95%;">
                                    <input type="url" class="form-control" id="youtube" name="youtube"
                                           value="{{ !is_null($youtube) ? $youtube->value : '' }}"
                                           placeholder="رابط اليوتيوب">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رابط التويتر</label>
                                <div style="width: 95%;">
                                    <input type="url" class="form-control" id="twitter" name="twitter"
                                           value="{{ !is_null($twitter) ? $twitter->value : '' }}"
                                           placeholder="رابط التويتر">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">النص الاساسي في الصفحة الترحيبية</label>
                                <div style="width: 99%;">
                                    <input type="text" class="form-control" id="welcomeMainText" name="welcomeMainText"
                                           value="{{ !is_null($welcomeMainText) ? $welcomeMainText->value : '' }}"
                                           placeholder="النص الاساسي في الصفحة الترحيبية">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                         <!-- Start col footer -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">فوتر لوحة التحكم</label>
                                <div style="width: 95%;">
                                    <input type="text" class="form-control" id="footer" name="footer"
                                           value="{{ !is_null($footer) ? $footer->value : '' }}"
                                           placeholder="فوتر لوحة التحكم">
                                </div>
                            </div>
                        </div>
                        <!-- End col footer -->
                        
                        <!-- Start col cookis -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">فترة انتهاء الجلسة (دقائق)</label>
                                <div style="width: 98%;">
                                    <input class="form-control numbers" id="sessionEnd" name="sessionEnd"
                                           maxlength="4"
                                           value="{{ !is_null($sessionEnd) ? $sessionEnd->value : '' }}"
                                           placeholder="فترة انتهاء الجلسة (دقائق)">
                                </div>
                            </div>
                        </div>
                        <!-- End col cookis -->
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12 d-none">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">النص الفرعي في الصفحة الترحيبية</label>
                                <div style="width: 95%;">
                                    <input type="text" class="form-control" id="welcomeSubText" name="welcomeSubText"
                                           value="{{ !is_null($welcomeSubText) ? $welcomeSubText->value : '' }}"
                                           placeholder="النص الفرعي في الصفحة الترحيبية">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12 d-none">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">نص الزر الاساسي في الصفحة الترحيبية</label>
                                <div style="width: 95%;">
                                    <input type="text" class="form-control" id="welcomeReadMoreText"
                                           name="welcomeReadMoreText"
                                           value="{{ !is_null($welcomeReadMoreText) ? $welcomeReadMoreText->value : '' }}"
                                           placeholder="نص الزر الاساسي في الصفحه الترحيبية">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12 d-none">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">رابط الزر الاساسي في الصفحة الترحيبية</label>
                                <div style="width: 95%;">
                                    <input type="url" class="form-control" id="welcomeReadMoreLink"
                                           name="welcomeReadMoreLink"
                                           value="{{ !is_null($welcomeReadMoreLink) ? $welcomeReadMoreLink->value : '' }}"
                                           placeholder="رابط الزر الاساسي في الصفحة الترحيبية">
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">شعار اللوحة(140 * 23)</label>
                                <div class="">
                                    <div class="kt-avatar kt-avatar--outline" id="kt_user_avatar">

                                        @if(((!is_null($logo)) && (!is_null($logo->value)) && (($logo->value != ''))))
                                            <div class="kt-avatar__holder"
                                                 style="background-image: url({{ url($logo->value) }});background-size: contain;
                                                         background-position: center;"></div>
                                        @endif

                                        <label class="kt-avatar__upload" data-toggle="kt-tooltip" title=""
                                               data-original-title="تغيير   الصورة" style="left:100px;">
                                            <i class="fa fa-pen"></i>
                                            <input type="file" name="logo" accept="image/png, image/jpeg, image/jpg">
                                        </label>
                                        <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title=""
                                              data-original-title="الغاء">
																	<i class="fa fa-times"></i>
																</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">شعار صفحة الدخول (380 * 100)</label>
                                <div class="">
                                    <div class="kt-avatar kt-avatar--outline" id="kt_user_avatar1">
                                        @if(((!is_null($welcomeBackground)) && (!is_null($welcomeBackground->value)) && (($welcomeBackground->value != ''))))
                                            <div class="kt-avatar__holder"
                                                 style="background-image: url({{ url($welcomeBackground->value) }});background-size: contain;
                                                         background-position: center;"></div>
                                        @endif
                                        <label class="kt-avatar__upload" data-toggle="kt-tooltip" title=""
                                               data-original-title="تغيير الصورة"  style="left:100px;">
                                            <i class="fa fa-pen"></i>
                                            <input type="file" name="welcomeBackground"
                                                   accept="image/png, image/jpeg, image/jpg">
                                        </label>
                                        <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title=""
                                              data-original-title="الغاء">
																	<i class="fa fa-times"></i>
																</span>
                                    </div>
                                </div>
                            </div>
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
                            class="btn btn-success btn-elevate btn-block ">حفظ
                        <span id="wating" class="" style="display: none">                            &nbsp;&nbsp;
                            <span class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </span>
                            <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                        </span>
                    </button>
                        </div>
                        <!-- End col -->


                    </div>
                    <!-- Start Row -->
                </form>
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
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
@endsection
