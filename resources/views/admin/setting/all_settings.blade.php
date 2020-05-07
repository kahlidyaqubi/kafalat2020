@extends('layouts.dashboard.app')
@section('pageTitle','إدارة القوائم')
@section('headerCSS')
    <link href="{{asset('new_theme/assets/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
@section('headerJS')@endsection
@section('navigation1','الرئيسية')
@section('navigation2','إدارة النظام')
@section('navigation3','إعدادت عامة')
@section('navigation1_link','/admin/home')
@section('navigation2_link','#')
@section('navigation3_link','/admin/all_settings')
@section('content')
    <div class="col-lg-12 col-xl-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="fa fa-pen icon-padding"></span>
                    <h3 class="kt-portlet__head-title">
                        إعدادت عامة
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- Start Row -->
                <div class="row">
                    <!-- Start col -->
                    <?php
                    $links = auth()->user()->getAllPermissions()->where('in_setting', 1)->where('in_menu', 1)->where('parent_id', 0)->sortBy('title');
                    ?>
                    @foreach($links as $link)
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                            <div class="btn-group show" style="width: 95%">
                                <button type="button" class="btn btn-success dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="true">
                                    {{$link->title}}
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start">
                                    <a class="dropdown-item"
                                       href="{{$link->where('parent_id',$link->id)->first()?$link->where('parent_id',$link->id)->first()->link:'#'}}"
                                    >إدارة</a>
                                    <a class="dropdown-item"
                                       href="{{$link->where('parent_id',$link->id)->first()?$link->where('parent_id',$link->id)->first()->link."/create":'#'}}"
                                    >إضافة</a>
                                </div>
                            </div>
                        </div>
                @endforeach
                <!-- End col -->


                </div>
                <!-- End Row -->
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
@endsection
