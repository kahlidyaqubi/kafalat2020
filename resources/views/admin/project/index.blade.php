@extends('layouts.dashboard.app')

@section('pageTitle','إدارة المشاريع')
@section('headerCSS')
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة المشاريع')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/projects')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إدارة المشاريع
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
                                <label class="col-form-label col-lg-12">اسم المشروع</label>
                                <div style="width: 95%;">
                                    <input class="form-control" placeholder=" اكتب العنوان  " id="name" name="name"
                                           value="{{$name}}"
                                           type="text">
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
                        
                        <!-- Satrt Button Confirm -->
                        <div class="col-12">
                            <button type="submit"
                                    class="btn btn-success btn-elevate btn-block" name="theaction" value="search">بحث
                                <span id="wating" class="" style="display: none">                            &nbsp;&nbsp;
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
                        عرض المشاريع
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
                            <th style="width: 20%;">اسم المشروع
                            </th>
                            <th style="width: 5%;">العمليات
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $item)
                            <tr class="text-center">
                                <td>
                                    {{ $item->id }}</td>
                                <td>{{$item->name}}</td>
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
                                            <a class="dropdown-item" href="/admin/projects/{{$item->id}}/edit"><i
                                                        class="fa fa-pen"></i>
                                                تعديل
                                            </a>
                                            <a class="dropdown-item" href="/admin/season_coupons?project_id={{$item->id}}"><i
                                                        class="fa fa-pen"></i>
                                                المساعدات الموسمية
                                            </a>
                                            <a class="dropdown-item" href="/admin/seasons?project_ids[]={{$item->id}}"><i
                                                        class="fa fa-pen"></i>
                                                المواسم
                                            </a>
                                            <a class="dropdown-item Confirm"
                                               href="/admin/projects/delete/{{$item->id}}">
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
            {{$projects->links()}}

            <!--end: Pagination-->
            </div>
        </div>
        <!--end::Portlet-->
    </div>
@endsection

@section('footerJS')

 <script>
        $(document).ready(function () {
            $('form').submit(function () {
                $(this).find(':submit').attr('disabled', 'disabled');
                $('#wating').show();
            });
        });
    </script>
@endsection