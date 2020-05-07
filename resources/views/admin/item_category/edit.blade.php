@extends('layouts.dashboard.app')

@section('pageTitle','تعديل صنف')
@section('headerCSS')
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة الأصناف')
@section('navigation3','تعديل الأصناف')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/item_categories')
@section('navigation3_link','/admin/item_categories/'.$item_category->id.'/edit')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل صنف
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body" method="post" action="/admin/item_categories/{{$item_category->id}}">
            @csrf

            @method('put')
            <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">اسم الصنف<span style="color:red;">*</span></label>
                            <input class="form-control " type="text"
                                   name="name"
                                   value="{{$item_category->name}}"  required style="width: 86%">
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End Row -->

                <!-- Satrt Button Confirm -->
                <div class="col-md-2">
                    <button type="submit"
                            class="btn btn-success btn-elevate btn-block ">حفظ
                    </button>
                </div>
                <!-- End Button Confirm -->
            </form>
        </div>
        <!--end::Portlet-->
    </div>
@endsection

@section('footerJS')

@endsection