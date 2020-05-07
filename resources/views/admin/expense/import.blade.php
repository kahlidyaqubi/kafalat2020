@extends('layouts.dashboard.app')

@section('pageTitle','استيراد ملف الصرفية')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة الصرفيات')
@section('navigation3','استيراد ملف الصرفية')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/expenses')
@section('navigation3_link','/admin/importExcel')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        استيراد الصرفيات
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="col-md-12">
                    <ul>
                        <li><a href="/divisin">اذهب لتقسيم ملف الصرفية</a></li>
                    </ul>
                    <a class='button btn btn-success'href='{{ asset('word_templates/expense.xlsx') }}'><i class="fa fa-cloud-download-alt"></i>تصدير
                        نماذج الصرفيات المسموح</a>
                          
                         <!--<i class="fa fa-cloud-upload-alt"></i>-->
                </div>
                <div class="row"><div class="col"><hr></div></div>
                <div id="required-error"></div>
                <form method="post" data-parsley-validate action="{{ url('admin/expenses/importExcel') }}"
                      enctype="multipart/form-data">
                @csrf
                <!-- Start Row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">الملف<span style="color:red;">*</span></label>
                                    <input  class="form-control " type="file"
                                       name="excel_file"
                                       accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                       style="width: 99%" required>                      

                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">نوع المشروع<span style="color:red;">*</span></label>
                                    <select  class="form-control kt-select2 select2-multi"
                                            id="family_project_id" name="family_project_id" required>
                                        <option value=" " selected>نوع المشروع</option>
                                        @foreach($family_projects as $family_project)
                                            <option value="{{$family_project->id}}"
                                                    @if($family_project->id==old("family_project_id")) selected @endif>{{$family_project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12">السنة<span style="color:red;">*</span></label>
                                    <select  class="form-control kt-select2 select2-multi"
                                            id="year" name="year" required>
                                        <option value=" " selected >السنة</option>
                                        @for($i=2025;$i>=2006;$i--)
                                            <option value="{{$i}}" @if($i==old("year")) selected @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div style="width: 99%;">
                                    <label class="col-form-label col-lg-12"><span style="color:red;">*</span>عدد الأشهر</label>
                                    <select  class="form-control kt-select2 select2-multi"
                                            id="mounth_count" name="mounth_count" required>
                                        <option value=" " selected>عدد الأشهر</option>
                                        @for($i=1;$i<=4;$i++)
                                            <option value="{{$i}}"
                                                    @if($i==old("mounth_count")) selected @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Start col -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">تاريخ الاستلام<span style="color:red;">*</span></label>
                                <input class="form-control datepicker-custome" placeholder="yyyy-mm-dd" readonly="readonly" type="text" 
                                       id="recive_date" name="recive_date" value="{{ old("recive_date")}}"
                                       style="width: 99%" required>
                            </div>
                        </div>
                        <!-- End col -->

                    </div>
                    <!-- End Row -->

                <!-- Satrt Button Confirm -->
                <div class="col-12">
                    <div class="form-group row">
                        <button type="submit"
                              class="btn btn-success btn-elevate btn-block ">التالي
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
            $("[name='recive_date']").datepicker({
                format: 'yyyy-mm-dd',
                orientation: "top auto",
                autoclose: true,
                clearBtn: true,
                    todayBtn: "linked",


            });
        </script>
    
    // <script>
                 
    //     $(document).ready(function () {
    //         $('form').submit(function () {
    //             $(this).find(':submit').attr('disabled', 'disabled');
    //             $('#wating').show();
    //         });
    //     });
    // </script>
@endsection