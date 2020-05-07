@extends('layouts.dashboard.app')

@section('pageTitle','تعديل وحدة')
@section('headerCSS')
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة الوحدات')
@section('navigation3','تعديل الوحدات')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/item_types')
@section('navigation3_link','/admin/item_types/'.$item_type->id.'/edit')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        تعديل وحدة
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body" method="post" action="/admin/item_types/{{$item_type->id}}">
            @csrf

            @method('put')
            <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">اسم الوحدة<span style="color:red;">*</span></label>
                            <input class="form-control " type="text"
                                   name="name"
                                   value="{{$item_type->name}}" required  style="width: 86%">
                        </div>
                    </div>
                    <!-- End col -->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">نوع الصنف
                                <span style="color:red;">*</span></label>
                            <div style="width: 95%;">
                                <select  required class="form-control kt-select2 select2-multi"
                                        name="item_category_id" id="item_category_id">
                                    <option value="" selected>نوع الصنف</option>
                                    @foreach($item_categories->sortBy('name') as $item_category)
                                        <option value="{{$item_category->id}}"
                                                @if($item_category->id==$item_type->item_category_id) selected @endif>{{$item_category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
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