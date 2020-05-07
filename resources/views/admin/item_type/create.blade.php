@extends('layouts.dashboard.app')

@section('pageTitle','إضافة وحدة')
@section('headerCSS')
@endsection

@section('navigation1','الرئيسية')
@section('navigation2','إدارة الوحدات')
@section('navigation3','إضافة وحدة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','/admin/item_types')
@section('navigation3_link','/admin/item_types/create')
@section('content')

    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        اضافة وحدة
                    </h3>
                </div>
            </div>
            <form class="kt-portlet__body" method="post" action="/admin/item_types">
            @csrf
            <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">اسم الوحدة<span style="color:red;">*</span></label>
                            <input class="form-control " type="text"
                                   name="name"
                                   value="{{old('name')}}"  required style="width: 86%">
                        </div>
                    </div>
                    <!-- End col -->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">الصنف
                                <span style="color:red;">*</span></label>
                            <div style="width: 95%;">
                                <select  required class="form-control kt-select2 select2-multi"
                                        name="item_category_id" id="item_category_id"
                                        onchange="item_category_other()">
                                    <option value="" selected>الصنف</option>
                                    <option value="-1" >أخرى</option>
                                    @foreach($item_categories->sortBy('name') as $item_category)
                                        <option value="{{$item_category->id}}"
                                                @if($item_category->id==old("item_category_id")) selected @endif>{{$item_category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 item_category_other" style="display: none">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-12">صنف
                                <span style="color:red;">*</span>
                            </label>
                            <div style="width: 86%">
                                <input  required class="form-control" id="item_category_id_other"
                                       name="item_category_id_other" type="text"
                                       value="{{ old("item_category_id_other")}}"
                                       placeholder="صنف">
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
    <script>
        function item_category_other() {
            if ($('#item_category_id').val() == -1) {
                $('.item_category_other').show();
            } else {
                $('.item_category_other').hide();
                $('#item_category_id_other').val("");
            }
        }
        $(document).ready(function () {
            if ($('#item_category_id').val() == -1) {
                $('.item_category_other').show();
            } else {
                $('.item_category_other').hide();
                $('#item_category_id_other').val("");
            }
        });
        </script>

@endsection