@extends('layouts.dashboard.app')

@section('pageTitle','تعديل مشروع')
@section('headerCSS')
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة مشروع')
@section('navigation3','تعديل المشاريع')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/projects')
@section('navigation3_link','/admin/projects/'.$project->id.'/edit')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل مشروع
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body" method="post" action="/admin/projects/{{$project->id}}">
            @csrf

            @method('put')
            <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">اسم المشروع<span style="color:red;">*</span></label>
                            <input class="form-control " type="text"
                                   name="name"
                                   value="{{$project->name}}"  required style="width: 86%">
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End Row -->

                <!-- Satrt Button Confirm -->
                <div class="col-12">
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
                <!-- End Button Confirm -->
            </form>
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