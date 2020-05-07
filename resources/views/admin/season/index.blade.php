@extends('layouts.dashboard.app')

@section('pageTitle','إدارة المواسم')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('navigation1','الرئيسية')
@section('navigation3','إدارة المواسم')
@section('navigation1_link','/admin/home')
@section('navigation3_link','/admin/seasons')
@section('navigation2','إعدادت عامة')
@section('navigation2_link','/admin/all_settings')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إدارة المواسم
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <form>
                    <div class="row">
                        <!-- Start col project-->
                        <div class="col-12">
                            <div class="form-group">
                                    <label class="col-form-label col-lg-12">المشروع </label>
                                    <select style="width: 94%;" class="form-control kt-select2 select2-multi"
                                            id="project_ids" name="project_ids[]"
                                            multiple="multiple">
                                        <option value=" "> المشروع</option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}"
                                                    @if(in_array($project->id, $project_ids)) selected @endif>{{$project->name}}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <!-- End col -->
                        
                          <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">تاريخ الموسم من</label>
                                <input style="width: 95%;" autocomplete="off" readonly="readonly" class="form-control datepicker" name="from_start_date" type="text" value="{{$from_start_date}}">
                           </div>
                        </div>
                        <!-- End col -->
                        
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">تاريخ الموسم إلى</label>
                                    <input style="width: 95%;" autocomplete="off" readonly="readonly" class="form-control datepicker" name="to_start_date" type="text"
                                           value="{{$to_start_date}}">
                            </div>
                        </div>

                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">من الرقم</label>
                                    <input style="width: 95%;" class="form-control" type="number" name="from_id" value="{{$from_id}}"
                                           placeholder="اختر id" max="{{$max_id}}"
                                           min="{{$min_id}}">
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label col-lg-12">إلى الرقم</label>
                                    <input  style="width: 95%;" class="form-control" type="number" name="to_id" value="{{$to_id}}"
                                           placeholder="اختر id" max="{{$max_id}}"
                                           min="{{$min_id}}">
                            </div>
                        </div>
                        <!-- End col -->

                        <!-- Satrt Button Confirm -->
                        <div class="col-12">
                            <button type="submit"
                                      class="btn btn-success btn-elevate btn-block "name="theaction"
                                        value="search">بحث
                                    <span id="wating" class="" style="display: none">&nbsp;&nbsp;
                                        <span class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                        </span>
                                        <span class="text-primary">&nbsp;&nbsp; الرجاء الانتظار...</span>
                                </span>
                            </button>
                        </div>
                    <!-- End Button Confirm -->

                    </div>
                </form>
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
                        عرض المواسم
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body ">
                <!-- Start Table  -->
                <div class="table-responsive">

                    <table class="table table-bordered table-hover ">
                        <thead>
                        <tr class="text-center">

                            <th style="width: 5%">
                                #
                            </th>
                            <th style="width: 20%;">المشروع
                            </th>
                            <th style="width: 20%;">التاريخ
                            </th>
                            <th style="width: 5%;">العمليات
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($seasons as $item)
                            <tr class="text-center">
                                <td>
                                    {{ $item->id }}</td>
                                <td>{{$item->project->name}}</td>
                                <td>{{$item->start_date?date('m-Y', strtotime($item->start_date)):""}}</td>
                                <td>
                                    <div class="dropdown dropdown-inline">
                                        <button type="button"
                                                class="btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle"
                                                data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="la la-cog"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="/admin/seasons/{{$item->id}}/edit"><i
                                                        class="fa fa-pen"></i>
                                                تعديل
                                            </a>
                                            <a class="dropdown-item" href="/admin/season_coupons?season_ids[]={{$item->id}}"><i
                                                        class="fa fa-pen"></i>
                                                المساعدات الموسمية
                                            </a>
                                            <a class="dropdown-item Confirm"
                                               href="/admin/seasons/delete/{{$item->id}}">
                                                <i class="fa fa-trash"></i>
                                                حذف</a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table  -->
                <!--begin: Pagination-->
            {{$seasons->links()}}

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
        $("[name='from_start_date']").datepicker({
            format: 'yyyy-mm',
            minViewMode: 1,
            orientation: "bottom auto",
            autoclose: true,
            clearBtn: true   
        });
        
        $("[name='to_start_date']").datepicker({
            format: 'yyyy-mm',
            minViewMode: 1,
            orientation: "bottom auto",
            autoclose: true,
            clearBtn: true        
            
        });
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